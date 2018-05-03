<div class="session--hub">
    <h1>Session Hub allows everyone to create their custom session!</h1>
    <h2>Join the millions of online users right now!</h2>
    <br><br>

        <form action="<?=base_url('SessionCreator')?>" method="POST">
            <label>Session name:</label><br>
            <input type="text" name="session_name" required /><br>
            <?php if(isset($error_name) && $error_name){
            echo("<h4 class='create--error'>Enter the session's name!</h4>"); }?>
            <br>

            <label>Participant count (including the game master!): </label><br>
            <input type="text" name="participant_count" required /><br>
            <?php if(isset($error_participant_count_too_small) && $error_participant_count_too_small){
            echo("<h4 class='create--error'>The smallest participant count is 2.</h4>"); } ?>
            <?php if(isset($error_participant_count_too_high) && $error_participant_count_too_high){
            echo("<h4 class='create--error'>The highest participant count is 24.</h4>"); } ?>
            <br>

            <!--
            <label>Session type:</label><br>
            <label>
                <input type="radio" name="session_type" value="1" checked /> Basic
            </label>
            <br>
            <label>
                <input type="radio" name="session_type" value="2" /> Protected
                <div class="create--tooltip" title="You will receive help from the SessionHub support
if asked, however, you will also have to confirm your e-mail address
and confirm each administrative action by pressing a special
link send to that email.">(?)</div>
            </label>
            <br><br>
            -->

            <input type="submit" class="btn btn-info" value="Create session!" />

        </form><br><br>

        <p>Or... Pressed wrong?</p><br>
        <a href="<?=base_url()?>" role="button" class="btn btn-info">Go Back</a>
</div>
