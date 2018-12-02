<div class="session--hub">
    <h3>Great! Now add the users that will be taking part in the session.</h3><br />

    <h4>Give each user a name, an avatar link (not necessary) and provide their Email address.</h4><br /><br />

    <form action="<?=base_url( 'createSession/stepThree' )?>" method="POST">

    <?php
    if( !isset( $participants ) )
    {
        if( isset( $_SESSION['participants'] ) )
        {
             $participants = $_SESSION['participants'];
        }
        else
        {
             redirect( base_url( 'sessionExpired' ) );
        }
    }

    if( isset( $p_count_error ) && $p_count_error ) $iterate_once = 1; ?>

    <label>Gamemaster:</label><br />
    <input type="text" name="gamemasterName" placeholder="Name" required /><br />
    <?php
        if( isset( $error_mail ) )
        {
            echo "<h4 class='create--error'>The gamemaster has to have a name!</h4>";
        }
    ?>
    <input type="text" name="gamemasterAvatarURL" placeholder="Avatar URL"/><br /><br />

    <?php for( $i = 0; $i < $participants-1; ++$i ){ ?>

                <label>Participant <?=($i+1)?>:</label><br />
                <input type="email" name="participant_<?=$i?>" placeholder="Email Address"/><br />
                <?php
                    if( isset( $iterate_once ) && $iterate_once )
                    {
                        $iterate_once = 0;
                        echo "<h4 class='create--error'>Enter at least one player!</h4>";
                    }
                ?>

                <input type="text" name="participant_<?=$i?>_ign" placeholder="In-Game Name"/><br />

                <input type="text" name="participant_<?=$i?>_avatar" placeholder="Avatar URL"/><br /><br />

    <?php } ?>

    <p>Now enable the dices that you will be using during the session.</p><br />
    <p>Simply check the checkbox and the dice will be added!</p><br />
    <p>If you're unsure, better check all of them. You can change this later.</p><br />
    <p>K represents the number that can be rolled between 1 and K.</p><br /><br />

    <label><input type="checkbox" name="k4" />K4</label><br />
    <label><input type="checkbox" name="k6" />K6</label><br />
    <label><input type="checkbox" name="k8" />K8</label><br />
    <label><input type="checkbox" name="k10" />K10</label><br />
    <label><input type="checkbox" name="k12" />K12</label><br />
    <label><input type="checkbox" name="k20" checked />K20</label><br />
    <label><input type="checkbox" name="k100" />K100</label><br /><br />

    <input type="submit" role="button" class="btn btn-info" value="Submit" />

</div>
