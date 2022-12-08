<?php $this->load->view('partials/header', $header) ?>
<main>
    <h1>Welcome back, <?= $user['first_name']; ?> <?= $user['last_name']; ?></h1>
    <a href="signout">Sign-out</a>
    <form action="createMessage" method="post">
        <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
        <textarea name="message" id="message" cols="30" rows="10" placeholder="Write a message."></textarea>
        <input type="submit" value="Post">
    </form>
    <?php foreach ($messages as $message) { ?>
        <h2><?= $message['first_name']; ?> <?= $message['last_name']; ?> - <?= date("F jS Y", strtotime($message['created_at'])); ?></h2>
        <p><?= $message['message'] ?></p>
        <!-- delete message  -->
        <?php
        if ($this->session->userdata('id') == $message['user_id']) {
        ?>
            <form action="deleteMessage" method="post">
                <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
                <input type="hidden" name="message_id" value="<?= $message['id']; ?>">
                <input type="submit" value="Delete">
            </form>
        <?php
        }
        ?>

        <!-- end delete message -->
        <?php foreach ($message['comments'] as $comment) { ?>
            <h3><?= $comment['first_name']; ?> <?= $comment['last_name']; ?> - <?= date("F jS Y", strtotime($comment['created_at'])); ?></h3>
            <p><?= $comment['comment'] ?></p>
            <!-- delete comment  -->
            <?php
            if ($this->session->userdata('id') == $comment['user_id']) {
            ?>
                <form action="deleteComment" method="post">
                    <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
                    <input type="hidden" name="comment_id" value="<?= $comment['id']; ?>">
                    <input type="submit" value="Delete">
                </form>
            <?php
            }
            ?>

            <!-- end delete comment  -->
        <?php } ?>
        <form action="createComment" method="post">
            <input type="hidden" name="<?= $csrf['name']; ?>" value="<?= $csrf['hash']; ?>">
            <input type="hidden" name="message_id" value="<?= $message['id']; ?>">
            <textarea name="comment" id="comment" cols="30" rows="10" placeholder="Write a comment"></textarea>
            <input type="submit" value="Post">
        </form>
    <?php } ?>
</main>
<?php $this->load->view('partials/footer') ?>