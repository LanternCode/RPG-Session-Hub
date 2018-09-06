<?php defined('BASEPATH') OR exit('No direct script access allowed');
$this->load->helper('quote_helper'); ?>

<div class="session--hub"><br>

    <?php
        $quote_checked = (isset($session->quotes) && $session->quotes) ? " checked='checked'" : '';
        $quote_checked_all = (isset($session->quotes_all) && $session->quotes_all) ? " checked='checked'" : '';
        $dice_checked = (isset($session->goddice) && $session->goddice) ? " checked='checked'" : '';
        $dice_checked_all = (isset($session->goddice_all) && $session->goddice_all) ? " checked='checked'" : '';

        if(isset($_SESSION['admin']) && $_SESSION['admin']){

            $quote_checked_all_disabled = ($quote_checked) ? '' : 'disabled';
            $dice_checked_all_disabled = ($dice_checked) ? '' : 'disabled';
            ?>

            <a role="button" class="btn btn-primary" href="#" onclick="reveal_panel(1)">Session Settings</a>

            <div class="dropdown">
                <a role="button" class="btn btn-primary" href="#">Player Settings</a>
                <div class="dropdown-content">
                    <a role="button" class="btn btn-success" href="#" onclick="reveal_panel(2)">Add Players</a>
                    <a role="button" class="btn btn-success" href="#" onclick="reveal_panel(3)">Remove Players</a>
                    <a role="button" class="btn btn-success" href="#" onclick="reveal_panel(4)">Change Players' names and avatars</a>
                </div>
            </div>

            <a role="button" class="btn btn-primary" href="#" onclick="reveal_panel(5)">Dice Settings</a>
            <a href="#" role="button" class="btn btn-primary" onclick="reveal_panel(6)">Contact Session-Hub's support</a>
            <a role="button" class="btn btn-info" href="<?=base_url('index.php/session/changewiev')?>">Switch to user's view</a><?php

        }

        if(isset($_SESSION['admin']) && $_SESSION['admin'] == 0){ ?>
            <a class="btn btn-info" role="button" href="<?=base_url('index.php/session/adminwiev')?>">Switch to admin's view</a><?php
        } ?>

        <a role="button" class="btn btn-warning" href="<?=base_url('index.php/logout')?>">Logout</a>

        <?php if(isset($_SESSION['admin']) && $_SESSION['admin']){ ?>

        <div id="editdices">

            <h2>Dices</h2><br>
            <h6>Checkmark means that the selected dice is active.</h6><br>
            <form method="POST" action="<?=base_url('index.php/session/edit/dices')?>">
                <?php
                    $k0 = ($dices[0]) ? 'checked' : '';
                    $k1 = ($dices[1]) ? 'checked' : '';
                    $k2 = ($dices[2]) ? 'checked' : '';
                    $k3 = ($dices[3]) ? 'checked' : '';
                    $k4 = ($dices[4]) ? 'checked' : '';
                    $k5 = ($dices[5]) ? 'checked' : '';
                    $k6 = ($dices[6]) ? 'checked' : '';
                ?>
                <label><input type="checkbox" name="k4" <?=$k0?> />K4</label><br>
                <label><input type="checkbox" name="k6" <?=$k1?> />K6</label><br>
                <label><input type="checkbox" name="k8" <?=$k2?> />K8</label><br>
                <label><input type="checkbox" name="k10" <?=$k3?> />K10</label><br>
                <label><input type="checkbox" name="k12" <?=$k4?> />K12</label><br>
                <label><input type="checkbox" name="k20" <?=$k5?> />K20</label><br>
                <label><input type="checkbox" name="k100" <?=$k6?> />K100</label><br><br>
                <input type="submit" value="Save changes"><br><br>
            </form>

        </div>
        <div id="editmodulesform">
            <form action="<?=base_url('index.php/session/edit/modules')?>" method="POST">
                <h3>Modules eligible for activation:</h3><br><br>

                <label>
                    <input type="checkbox" id="randomquote" name="quotemodule" onchange="module_quote_checkbox()"<?=$quote_checked?> /> Random quote
                </label><br>
                <label>
                    <input type="checkbox" id="randomquoteall" name="quotemoduleall"<?=$quote_checked_all?> <?=$quote_checked_all_disabled?>/> Allow every participants to add new quotes.
                </label><br><br>

                <label>
                    <input type="checkbox" id="goddice" name="dicemodule"<?=$dice_checked?> onchange="module_dice_checkbox()" /> Godly dice (rolls either 1 or 20)
                </label><br>
                <label>
                    <input type="checkbox" id="goddiceall" name="dicemoduleall"<?=$dice_checked_all?> <?=$dice_checked_all_disabled?>/> Allow every participants to use it.
                </label><br><br>

                <input type="submit" value="Save changes" /><br><br>
            </form>
        </div>
        <div id="addplayersform">

            <h2>Add Players</h2><br>
            <form action="<?=base_url('index.php/session/edit/newuser')?>" method="POST">
                <label>New user's name:</label><br>
                <input type="text" name="add_user_name" required /><br><br>

                <label>New user's avatar link:</label><br>
                <input type="text" name="add_user_avatar" /><br><br>

                <input type="submit" value="Add new user" /><br><br>
            </form>
        </div>
        <div id="changenames">

            <?php for($i = 0; $i < $session->participants; ++$i){ ?>
                <form method="POST" action="<?=base_url('index.php/session/edit/name')?>">
                    <h2><?=$participants[$i]->name?></h2><br><br>

                    <label>New name:</label><br>
                    <input type="text" name="new_name" /><br><br>

                    <label>New avatar:</label><br>
                    <input type="text" name="new_avatar" /><br><br>

                    <input type="hidden" name="p_id" value="<?=$participants[$i]->p_id?>">
                    <input type="submit" value="Save changes" /><br><br>

                    <div class="session--admin__editname"></div>
                </form>
            <?php } ?>

        </div>
        <div id="removeplayers">

            <h2>User list</h2>
            <?php for($i = 0; $i < $session->participants; ++$i){
                $gm = $participants[$i]->rank;
                $href = ($gm) ? '#' : base_url("index.php/session/edit/removeuser?id=".$participants[$i]->p_id);
                $button_color = ($gm) ? 'btn-info' : 'btn-danger';
                $message = ($gm) ? 'GM' : 'Remove'; ?>
            <div class="session--admin__remove">
                <?=$participants[$i]->name?>
                <a href="<?=$href?>"
                    role="button" class="btn <?=$button_color?>"><?=$message?></a>
            </div>
            <?php } ?>

        </div>
        <div id="contactsupport">

                <form method="POST" action="<?=base_url('index.php/session/sendticket')?>">
                    <h2>Tell us what's bothering you by sending us a message:</h2><br><br>

                    <label>Message title:</label><br>
                    <input type="text" name="ticket_title" required /><br><br>

                    <label>Message:</label><br>
                    <textarea rows="4" cols="50" name="ticket_content" required></textarea><br><br>

                    <input type="submit" value="Submit the message" /><br><br>
                </form>

        </div>

    <?php }

    if(isset($session->quotes) && $session->quotes){ ?>
        <br><br><p>Random quote: <?=Get_daily_quote()?></p>
    <?php } ?>

    <br><br>
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
        <?php }}

        if($dice_checked && ($dice_checked_all || $_SESSION['admin'])) {
            echo('<label><input type="radio" name="dice" value="god" />Godly Dice</label><br>');
        }else{ echo('<br>'); } ?>

        <label>Rolls for:</label><br><br>
        <input type="text" name="comment"><br>
        <label><input type="checkbox" name="double"> Double roll</input></label><br><br>
        <input type="submit" class="btn btn-info" value="ROLL THE DICE!">
    </form><br>

    <p>The participants of the session: </p><br><br>

    <div class="row">
        <?php for($i = 0; $i < $session->participants; ++$i){?>
            <div class="col">
                <?php if($participants[$i]->avatar != "0") { ?>
                    <img class="hub--avatar" src="<?=$participants[$i]->avatar?>"/><br>
                <?php } ?>
                <?=$participants[$i]->name?>
            </div>
        <?php } ?>
   </div>

    <h3>Recent rolls: </h3>

    <div class="lastrolls">
        <iframe src="<?=base_url('index.php/listrolls')?>"></iframe>
    </div><br>

    <?php if($quote_checked && ($quote_checked_all || $_SESSION['admin'])){ ?>

        <h2>Insert quote:</h2><br>
        <form method="POST" action="<?=base_url('index.php/session/edit/addquote')?>">
            <label>Quote to add:</label>
            <input type="text" name="add_quote" required /><br>
            <input type="submit" value="Add quote!" />
        </form><br><br>

    <?php } ?>

</div>
<footer class="session--copyright--box">
    <p class="session--copyright">iLeanbox 2018 &copy; All rights reserved.</p>
</footer>
<script type="text/javascript">

    var active = 0;
    var active_num = 0;

    function reveal_panel(panel_number)
    {
        if(active == 1 && active_num == panel_number)
        {
            active = 0;
            panel_number = 0;
        }

        let panel1 = (panel_number == 1) ? 'block' : 'none';
        let panel2 = (panel_number == 2) ? 'block' : 'none';
        let panel3 = (panel_number == 3) ? 'block' : 'none';
        let panel4 = (panel_number == 4) ? 'block' : 'none';
        let panel5 = (panel_number == 5) ? 'block' : 'none';
        let panel6 = (panel_number == 6) ? 'block' : 'none';

        document.getElementById('editmodulesform').style.display = panel1;
        document.getElementById('addplayersform').style.display = panel2;
        document.getElementById('removeplayers').style.display = panel3;
        document.getElementById('changenames').style.display = panel4;
        document.getElementById('editdices').style.display = panel5;
        document.getElementById('contactsupport').style.display = panel6;

        if(panel_number != 0) active = 1;
        active_num = panel_number;
    }

    function module_quote_checkbox()
    {
        if(document.getElementById('randomquote').checked == 1)
            document.getElementById('randomquoteall').disabled = 0;
        else {
            document.getElementById('randomquoteall').disabled = 1;
            document.getElementById('randomquoteall').checked = 0;
        }
    }

    function module_dice_checkbox()
    {
        if(document.getElementById('goddice').checked == 1)
            document.getElementById('goddiceall').disabled = 0;
        else {
            document.getElementById('goddiceall').disabled = 1;
            document.getElementById('goddiceall').checked = 0;
        }
    }
</script>
