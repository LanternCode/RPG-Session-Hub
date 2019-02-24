<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="homepage--logo">
    <h2>Welcome to the</h2><h1 class="homepage--logo__brand">RPG <span class="homepage--logo__session">Session-</span>Hub!</h1>
</div>

<?php if( isset( $invalidCredentials ) && $invalidCredentials ) {

    echo "<h4 class='homepage--error'>Entered credentials were incorrect.</h4>";

} else if ( isset( $userHasRegistered ) && $userHasRegistered ) {

    echo "<h4 class='homepage--registered'>Your account was created! You can log in now!</h4>";

} else if ( isset( $sessionExpired ) && $sessionExpired ) {

    echo "<h4 class='homepage--error'>You were inactive for too long, please log in again.</h4>";

} ?>

<div class="homepage--body">
    <div class="homepage--login__form">
        <form method="POST" action="<?=base_url( 'userSpace' )?>">

            <label>Email:</label><br />
            <input type="email" name="account--signin--email" required><br /><br />

            <label>Password:</label>
            <input type="password" name="account--signin--password" autocomplete="off" required><br /><br />

            <input type="submit" class="btn btn-primary" value="Log in"><br />
        </form>
        or
        <br /><a href="<?=base_url( 'newAccount' )?>" role="button" class="btn btn-primary">Create your account!</a>
        <br /><a href="<?=base_url( 'forgottenPassword' )?>">Password forgotten?</a>
    </div>
</div>
