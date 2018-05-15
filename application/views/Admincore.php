<h1>Welcome, <?=$admin->rank?> <?=$admin->name?>!</h1>

<a role="button" class="btn btn-primary" href="#" onclick="admin_panel()">Browse Tickets</a>

<a role="button" class="btn btn-danger" href="<?=base_url('index.php/logout')?>">Logout</a><br><br>

<div id="browsetickets" style="display: none;">
    <?php foreach($tickets as $ticket){
        echo('Topic: '.$ticket->title.'<br><br>');
        echo('Message: '.$ticket->message.'<br><br><hr><br><br>');
    } ?>
</div>

<script>

function admin_panel()
{
    if(document.getElementById('browsetickets').style.display == 'none')
        document.getElementById('browsetickets').style.display = 'block';
    else document.getElementById('browsetickets').style.display = 'none';
}

</script>
