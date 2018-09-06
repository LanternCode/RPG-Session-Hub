<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="homepage--logo">
    <h2>Welcome to the</h2><h1 class="homepage--logo__brand"><span class="homepage--logo__session">Session-</span>Hub!</h1>
</div>

<?php if( isset( $invalid_session_key ) && $invalid_session_key ) {

    echo "<h4 class='homepage--error'>Please enter a valid identificator!</h4>";

} ?>

<div class="homepage--body">
    <div class="homepage--login__form">
        <p>Session identificator: </p><br>

        <form method="POST" action="<?=base_url( 'key' )?>">
            <input type="text" name="code" required><br /><br />
            <input type="submit" class="btn btn-primary" value="Connect to session"><br />
        </form>
        or
        <br><a href="<?=base_url( 'createSession' )?>" role="button" class="btn btn-primary">Create your own session!</a>
    </div>
</div>
