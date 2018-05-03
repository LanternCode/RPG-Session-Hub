<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?>

<div class="homepage--logo">
    <h1 class="homepage--logo__brand"><span class="homepage--logo__session">Session-</span>Hub's Administration panel</h1>
    <h3>Found yourself here by mistake? Press <a href="<?=base_url()?>" role="button" class="btn btn-primary">Here</a> to go back.</h3>
</div>

<div class="homepage--body">
    <div class="homepage--login__form">

        <form method="POST" action="<?=base_url('index.php/adminkey')?>">
            <label>Identificator:</label><br>
            <input type="text" name="adminid" required><br><br>

            <label>Key:</label><br>
            <input type="password" name="adminkey" required><br><br>

            <input type="submit" class="btn btn-primary" value="Sign in">
            <br>
        </form>
    </div>
</div>
<footer>
    <p class="foot">iLeanbox 2018 &copy; All rights reserved.</p>
</footer>
