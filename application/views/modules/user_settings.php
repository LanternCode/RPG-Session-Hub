<nav class="menu" id="menu_container">
    <h3>Hello,</h3>
    <h2><?=$_SESSION['username']?>!</h2><br>

    <h3>Status: Default</h3>
    (<a class="link--upgrade" href="">Upgrade</a>)
    <br><br>

    <h2>Settings</h2>
    <br>
    <h3>Change Password</h3>

    <form action="" method="POST">
            <input type="password" name="oldpass" placeholder="Old Password" required><br>
            <input type="password" name="newpass" placeholder="New Password" required><br>

        <input type="submit" value="Submit">
    </form>

    <br><br>

    <label><input type="checkbox" id="public_checkbox" disabled>Public Room</label> (Turn <a href="<?=base_url('User/Public')?>"><?=($_SESSION['public'] == 1) ? 'Off' : 'On'?></a>) <br>
    <label><input type="checkbox" id="maintenance_checkbox" disabled>Maintenance Mode</label> (Turn <a href="<?=base_url('User/Maintenance')?>"><?=($_SESSION['maintenance'] == 1) ? 'Off' : 'On'?></a>)

    <br><br>

    <form action="" method="POST">
        <input type="submit" value="DELETE ACCOUNT" id="deletion_button">
    </form><br>

    <a class="link--upgrade" href="<?=base_url('User/Logout')?>">Logout</a>


</nav>

<script defer>

var public_room = <?=$_SESSION['public']?>;
var maintenance = <?=$_SESSION['maintenance']?>;
var deletion = <?=$_SESSION['deletion']?>;

if(public_room) document.getElementById('public_checkbox').checked = 1;
if(maintenance) document.getElementById('maintenance_checkbox').checked = 1;
if(deletion) document.getElementById('deletion_button').value = 'Pending deletion.';

</script>
