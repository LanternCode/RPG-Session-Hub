<h1>Welcome, <?=$admin->rank?> <?=$admin->name?>!</h1>

<a role="button" class="btn btn-primary" onclick="admin_panel()" href="#">Browse Tickets</a><br><br>

<div id="browsetickets">
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
