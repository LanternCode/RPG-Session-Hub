<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="homepage--logo">
    <h2>Welcome to the</h2><h1 class="homepage--logo__brand"><span class="homepage--logo__session">Session-</span>Hub!</h1>
</div>

<div class="homepage--body">
    <div class="homepage--login__form">
        <p>Session identificator: </p><br>

        <form method="POST" action="<?=base_url('key')?>">
            <input type="text" name="code" required><br><br>
            <input type="submit" class="btn btn-primary" value="Connect to session">
            <br>
        </form>
        or
            <br>
            <a href="<?=base_url('new')?>" role="button" class="btn btn-primary">Create your own session</a>
    </div>
</div>
<footer>
    <p class="foot">iLeanbox 2018 &copy; All rights reserved.</p>
</footer>
