<div class="resetPassword--grid">
    <h2 class="resetPassword--grid--h2">Reset Password</h2>
    <div class="resetPassword--grid--form">
        <div class="resetPassword--grid--errorSpan">
            <?php if( isset( $errorMessage ) ) {
                    echo '<span class="universal--errorMessage">' . $errorMessage . '</span>';
            } ?>
        </div>
        <form method="POST" action="<?=base_url( 'forgottenPassword/reset' )?>">

            <label>Enter new password:</label><br />
            <input type="password" name="newPassword" required />
            <br /><br />
            <label>Repeat the newly entered password:</label><br />
            <input type="password" name="newPasswordRepeated" required />
            <br /><br />
            <input class="btn btn-info" type="submit" value="Reset Password" />

        </form>
    </div>
    <div class="resetPassword--grid--return">
        <a href="<?=base_url()?>">
            <button class="btn btn-primary"><- Back to Homepage</button>
        </a>
    </div>
</div>
