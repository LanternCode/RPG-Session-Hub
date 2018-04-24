<?php $this->load->helper('quote_helper'); ?>
<div class="session--hub">
    <p>[<a href="<?=base_url('index.php/logout')?>">Swap sessions</a>]</p><br>

    <?php if($admin){?>

        <p>[<a href="#" onclick="reveal_panel_modules()">Enable/Disable modules</a>]</p><br>

        <div id="editmodulesform">
            <form action="<?=base_url('index.php/session/edit/modules')?>" method="POST">
                <h3>Modules eligible for activation:</h3><br><br>

                <label>
                    <input type="checkbox" id="randomquote" name="quotemodule" />Random quote
                </label><br>
                <label>
                    <input type="checkbox" id="randomquoteall" name="quotemoduleall" disabled
                    />     Allow every participants to add new quotes.
                </label><br><br>

                <label>
                    <input type="checkbox" id="randomquote" name="quotemodule" />Godly dice (rolls either 1 or 20)
                </label><br>
                <label>
                    <input type="checkbox" id="randomquoteall" name="quotemoduleall" disabled
                    />     Allow every participants to use it.
                </label><br><br>

                <input type="submit" value="Save changes" /><br><br>
            </form>
        </div>

        <p>[<a href="#" onclick="reveal_panel_name()">Add players</a>]</p><br>

        <div id="addplayersform">
            <form action="<?=base_url('index.php/session/edit/newuser')?>" method="POST">
                <label>New user's name:</label><br>
                <input type="text" name="add_user_name" required /><br><br>
                <label>New user's avatar link:</label><br>
                <input type="text" name="add_user_avatar" /><br><br>
                <input type="submit" value="Add new user" /><br><br>
            </form>
        </div>

        <p>[<a href="<?=base_url('index.php/logout')?>">Remove players</a>]</p><br>
        <p>[<a href="<?=base_url('index.php/logout')?>">Change dices</a>]</p><br>
        <p>[<a href="<?=base_url('index.php/logout')?>">Edit player names & avatars</a>]</p><br>

    <?php } ?>

    <?php if(isset($session->quotes) && $session->quotes){ ?>
        <p>Random quote: <?=Get_daily_quote()?></p><br><br>
    <?php } ?>

    <p>The participants of the session: </p><br>

    <div class="row">
        <?php for($i = 0; $i < $session->participants; ++$i){?>
            <div class="col">
                <?php if($participants[$i]->avatar != "0") { ?>
                    <img class="hub--avatar" src="<?=$participants[$i]->avatar?>"/><br>
                <?php } ?>
                <?=$participants[$i]->name?>
            </div>
        <?php } ?>
   </div><br>


    <form class="roll--form padded" method="POST" action="<?=base_url('index.php/roll')?>">
        <?php if(!isset($_SESSION['who'])){ ?>
        <label>Who rolls:</label><br>
        <select name="who">
            <?php for($i = 0; $i < $session->participants; ++$i){?>
            <option value="<?=$participants[$i]->name?>"><?=$participants[$i]->name?></option>
            <?php } ?>
        </select><br><br><?php } ?>

        <?php for($i = 0; $i < 7; ++$i){
            $val = (($i == 0) ? 'K4 ' : (($i == 1) ? 'K6 ' : (($i == 2) ? 'K8 ' :
            (($i == 3) ? 'K10 ' : (($i == 4) ? 'K12 ' : (($i == 5) ? 'K20 ' : (($i == 6) ? 'K100 ' : 0)))))));

            if($dices[$i]){ ?>
            <label><input type="radio" name="dice" value="<?=$val?>" checked/><?=$val?></label>
        <?php }} ?> <br>

        <label>Rolls for:</label><br><br>
        <input type="text" name="comment"><br>
        <label><input type="checkbox" name="double"> Double roll</input></label><br><br>
        <input type="submit" class="btn btn-info" value="ROLL THE DICE!">
    </form><br><br>

    <h3>Recent rolls: </h3>

    <div class="lastrolls">

        <iframe src="<?=base_url('index.php/listrolls')?>"></iframe>

    </div>

</div>
<footer class="session--copyright--box">
    <p class="session--copyright">iLeanbox 2018 &copy; All rights reserved.</p>
</footer>
<script type="text/javascript">
    function reveal_panel_name()
    {
        if(document.getElementById('addplayersform').style.display == 'block')
        document.getElementById('addplayersform').style.display = 'none';
        else document.getElementById('addplayersform').style.display = 'block';
    }

    function reveal_panel_modules()
    {
        if(document.getElementById('editmodulesform').style.display == 'block')
        document.getElementById('editmodulesform').style.display = 'none';
        else document.getElementById('editmodulesform').style.display = 'block';
    }

</script>
