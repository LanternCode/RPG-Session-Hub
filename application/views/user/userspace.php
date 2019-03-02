<div class="userspace--header">
    <h1 class="userspace--header__h1">Welcome, <?=$_SESSION['username']?></h1>
    <h2 class="userspace--header__h2">#<?=$_SESSION['userTag']?></h2>
</div>

<nav class="userspace--navigation">
    <ol>
        <?php //<li class="userspace--navigation--item"><a href="#">My sessions</a></li> ?>
        <?php // <li class="userspace--navigation--item"><a href="#">Account settings</a></li> ?>
        <?php // <li class="userspace--navigation--item"><a href="#">Customize this user space</a></li> ?>
        <li class="userspace--navigation--item"><a href="<?=base_url( 'contact' )?>" target="_blank">Contact RPG Session-Hub's staff</a></li>
        <li class="userspace--navigation--item__last"><a href="<?=base_url( 'logout' )?>">Logout</a></li>
    </ol>
</nav>

<hr>
    <p class="userspace--createPrompt">
        Do you want to create your own session? <a href="<?=base_url( 'createSession' )?>">Click here!</a>
    </p>
<hr>

<?php if( isset( $myInvitations ) && count( $myInvitations ) > 0 ): ?>
    <h2 class="userspace--mysessions">Received invitations:</h2>
    <div class="userspace--sessions">
        <table class="userspace--sessions">
            <tr>
                <th class="userspace--sessions--header__item">Session's Name</th>
                <?php // <th class="userspace--sessions--header__item">Format</th> ?>
                <th class="userspace--sessions--header__item">Game Master</th>
                <th class="userspace--sessions--header__item">Player count</th>
                <th class="userspace--sessions--header__item">ACCEPT Invitation</th>
                <th class="userspace--sessions--header__item">REJECT Invitation</th>
            </tr>
            <?php
            $iterator = 0;
            foreach($myInvitations as $invitation): ?>
                <tr>
                    <td><?=$invitation->name?></td>
                    <?php //<td>Custom</td> ?>
                    <td><?=$invitation->gmName?></td>
                    <td><?=$invitation->participants?></td>
                    <td>
                        <a href="<?=base_url( 'userSpace/acceptInvitation?i=' . $invitation->sessionId )?>" role="button"
                            class="btn btn-success">Accept</a>
                    </td>
                    <td>
                        <a href="<?=base_url( 'userSpace/rejectInvitation?i=' . $invitation->sessionId )?>" role="button"
                            class="btn btn-danger">Reject</a>
                    </td>
                    <?php //<td>(No perms!)</td> ?>
                </tr>
            <?php
            $iterator++;
            endforeach; ?>
        </table>
    </div>
<?php endif; ?>

<h2 class="userspace--mysessions">My RPG sessions:</h2>

<?php if( isset( $userSessions ) && count( $userSessions ) > 0): ?>
    <div class="userspace--sessions">
        <table class="userspace--sessions">
            <tr>
                <th class="userspace--sessions--header__item">Session's Name</th>
                <?php // <th class="userspace--sessions--header__item">Format</th> ?>
                <th class="userspace--sessions--header__item">Game Master</th>
                <th class="userspace--sessions--header__item">Player count</th>
                <th class="userspace--sessions--header__item">Join the session</th>
                <?php // <th class="userspace--sessions--header__item">Manage the session</th> ?>
            </tr>
            <?php
            $iterator = 0;
            foreach($userSessions as $session): ?>
                <tr>
                    <td><?=$session->name?></td>
                    <?php //<td>Custom</td> ?>
                    <td><?=$gamemasters[ $iterator ]?></td>
                    <td><?=$session->participants?></td>
                    <td>
                        <a href="<?=base_url( 'userSpace/session?s=' . $session->id )?>" role="button"
                            class="btn btn-success">Join!</button>
                    </td>
                    <?php //<td>(No perms!)</td> ?>
                </tr>
            <?php
            $iterator++;
            endforeach; ?>
        </table>
    </div>
<?php else: ?>
    <h6 class="userspace--sessions--msg__nosessions">You are not a member of any sessions yet.</h6>
<?php endif; ?>
