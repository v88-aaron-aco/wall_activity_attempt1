
<?php $this->load->view('partials/header', $header) ?>
<main>
    <h1>Sign in</h1>
    <form action="/signin_user" method="post">
        <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <label for="email">Email Address: </label>
        <input type="email" name="email">
        <label for="password">Password:</label>
        <input type="password" name="password">
        <input type="submit" value="Sign in">
        <a href="/signup">Register</a>
    </form>
</main>

<?php $this->load->view('partials/footer') ?>