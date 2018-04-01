<div class="session--hub">
    <h1>Wonderful!</h1><br>
    <h2>This is the last part where you create session identificators.</h2><br>
    <h3>Simply input a word into the gap and that sentence will be the identificator.</h3><br>
    <h3>As a gamemaster you'll have a separate identificator displayed in the summary.</h3><br><br>

    <label>USER session identificator:</label><br>

    <form method="POST" action="<?=base_url('Summary')?>">
        <input type="text" value="<?=$_SESSION['session_user_id']?>" disabled>
        <input type="text" name="user_id" required /><br>
        <?php if(isset($id_error)) {echo("<h4 class='create--error'>Give a user identificator!</h4>");} ?>
        <br>
        <input type="submit" class="btn btn-info" value="Create session!" />
    </form>
</div>
<footer class="session--copyright--box">
    <p class="session--copyright">iLeanbox 2018 &copy; All rights reserved.</p>
</footer>
