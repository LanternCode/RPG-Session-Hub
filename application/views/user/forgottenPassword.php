<div class="forgottenPassword--grid">
    <h2 class="forgottenPassword--grid--h2">Reset Password</h2>
    <div class="forgottenPassword--grid--form">
        <div class="forgottenPassword--grid--errorSpan">
            <?php if( isset( $actionNotification ) && $actionNotification ) {
                    echo '<span class="universal--errorMessage">' . $actionNotification . '</span>';
            } ?>
        </div>
        <form method="POST" action="<?=base_url( 'forgottenPassword' )?>">
            <label>Email address:</label><br />
            <input type="email" name="email" /><br /><br />
            <input class="btn btn-info" type="submit" value="Reset Password" />
        </form>
    </div>
    <div class="forgottenPassword--grid--return">
        <a href="<?=base_url()?>">
            <button class="btn btn-primary"><- Back to Homepage</button>
        </a>
    </div>
</div>
