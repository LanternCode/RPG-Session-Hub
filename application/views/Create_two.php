<div class="session--hub">
    <h3>Great! Now add the users that will be taking part in the session.</h3><br>
    <h4>Give an username for each of the users and an avatar if you want.</h4><br><br>

    <form action="<?=base_url('SessionCreator2')?>" method="POST">

    <?php
    if(!isset($participants)){
        if(isset($_SESSION['participants'])){
             $participants = $_SESSION['participants'];
         }else{
             session_unset();
             session_destroy();
             redirect(base_url());
         }
     }

    if(isset($p_count_error) && $p_count_error) $iterate_once = 1;
    for($i = 0; $i < $participants; ++$i)
    {
        if($i == 0){
            ?>
                <label>Gamemaster:</label><br>
                <input type="text" name="participant_<?=$i?>" placeholder="Name" required /><br>
                <?php if(isset($error_mail)) {
                echo("<h4 class='create--error'>The gamemaster has to have a name!</h4>");} ?>
                <input type="text" name="participant_<?=$i?>_avatar" placeholder="Avatar URL"/><br><br>
            <?php
        }else{

            ?>
                <label>Participant <?=($i+1)?>:</label><br>
                <input type="text" name="participant_<?=$i?>" placeholder="Name" /><br>
                <?php if(isset($iterate_once) && $iterate_once) {
                $iterate_once = 0;
                echo("<h4 class='create--error'>Enter at least one player!</h4>");} ?>
                <input type="text" name="participant_<?=$i?>_avatar" placeholder="Avatar URL"/><br><br>
            <?php
        }
    }
    ?>

    <p>Now enable the dices that you will be using during the session.</p><br>
    <p>Simply check the checkbox and the dice will be permanently added!</p><br>
    <p>K represents the number that can be rolled between 1 and K.</p><br><br>

    <label><input type="checkbox" name="k4" />K4</label><br>
    <label><input type="checkbox" name="k6" />K6</label><br>
    <label><input type="checkbox" name="k8" />K8</label><br>
    <label><input type="checkbox" name="k10" />K10</label><br>
    <label><input type="checkbox" name="k12" />K12</label><br>
    <label><input type="checkbox" name="k20" checked />K20</label><br>
    <label><input type="checkbox" name="k100" />K100</label><br><br>

    <p>Now the last step, please give your e-mail address.</p><br>
    <p>It's necessary to generate identificators.</p><br>
    <p>Don't worry, you can hold an unlimited amount of sessions on one address.</p>
    <!-- <p>It's necessary to retrieve the identificators if you lose them!</p><br>
    <p>You'll instantly receive two identificators on your email address.</p><br>
    <p>Make sure to give the user key to the participants!</p><br><br> -->

    <label>E-mail address:</label><br>
    <input type="email" name="session_host" required><br>
    <?php if(isset($error_mail)) {
    echo("<h4 class='create--error'>Give correct email address!</h4>");} ?>
    <br><br>
    <input type="hidden" name="pcount" value="<?=$participants?>">

    <input type="submit" role="button" class="btn btn-info" value="Submit" />
</div>
<footer class="session--copyright--box">
    <p class="session--copyright">iLeanbox 2018 &copy; All rights reserved.</p>
</footer>
