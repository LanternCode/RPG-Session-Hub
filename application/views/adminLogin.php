<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="homepage--logo">
    <h1 class="homepage--logo__brand"><span class="homepage--logo__session">Session-</span>Hub's Administration panel</h1>
    <h3>Found yourself here by mistake? Press <a href="<?=base_url()?>" role="button" class="btn btn-primary">Here</a> to go back.</h3>
</div>

<?=isset($incorrectCredentialsError) ? "<h4 class='create--error'>Given credentials weren't correct.</h4><br />" : NULL?>

<div class="homepage--body">
    <div class="homepage--login__form">
        <form method="POST" action="<?=base_url( 'index.php/adminValidate' )?>">
            <label>Login:</label><br />
            <input type="text" name="admin--login" autocomplete="off"><br /><br />

            <label>Password:</label><br />
            <input type="password" name="admin--password" autocomplete="off"><br /><br />

            <input type="submit" class="btn btn-primary" value="Sign in">
            <br />
        </form>
    </div>
</div>
