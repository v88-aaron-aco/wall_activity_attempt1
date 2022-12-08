
<?php $this->load->view('partials/header', $header) ?>
<main>
    <h1>Sign up</h1>
    <form action="signup_user" method="post">
    <input type="hidden" name="<?=$csrf['name'];?>" value="<?=$csrf['hash'];?>">
        <label for="firstname">First Name: </label>
        <input type="text" name="firstname">
        <label for="lastname">Last Name: </label>
        <input type="text" name="lastname">
        <label for="email">Email Address: </label>
        <input type="email" name="email">
        <label for="password">Password:</label>
        <input type="password" name="password">
        <label for="password_confirmation">Confirm Password:</label>
        <input type="password" name="password_confirmation">
        <input type="submit" value="Sign up">
    </form>
</main>

<?php $this->load->view('partials/footer') ?>