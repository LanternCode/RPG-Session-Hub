<div class="create--finished--div">

    <h1>Congratulations!</h1><br />

    <h2>Your RPG Session, <?=$_SESSION['session_name']?>, is now live!</h2><br /><br />

    <h3 role="button">
        <a class="btn btn-success" href="<?=base_url( 'userSpace/session?s=' . $session_id )?>">You can nagivate directly to it by pressing me,</a>
    </h3><br /><br />

    <h3 role="button">
        <a class="btn btn-info" href="<?=base_url( 'userSpace' )?>">Or go to your Userspace by pressing ME!</a>
    </h3>

</div>
