<form action="<?=base_url( 'validateRegistration' )?>" class="register--form" method="post">

    <h1>We're glad that you decided to join us!</h1>
    <h2>All you need to do now is fill the form below and press the button!</h2>

    <div class="register--section">
        <label>Username:<br />
            <span class="register--grayed">Others will use it to invite you so choose carefully!<span />
        </label><br />
        <input type="text" name="register--username" class="register--input" value="<?=isset($setUsername) ? $setUsername : ''?>" required/><br />
        <?=isset($usernameTooShort) ? $usernameTooShort : ''?>
        <?=isset($usernameTooLong) ? $usernameTooLong : ''?>
    </div>

    <div class="register--section">
        <label>Email address:</label><br />
        <input type="email" name="register--email" class="register--input" value="<?=isset($setEmail) ? $setEmail : ''?>" required/><br />
        <?=isset($emailFormatInvalid) ? $emailFormatInvalid : ''?>
        <?=isset($emailTooLong) ? $emailTooLong : ''?>
        <?=isset($emailRepeated) ? $emailRepeated : ''?>
    </div>

    <div class="register--section">
        <label>Password:</label><br />
        <input type="password" name="register--password" class="register--input" value="<?=isset($setPassword) ? $setPassword : ''?>" required/><br />
        <?=isset($passwordTooShort) ? $passwordTooShort : ''?>
        <?=isset($passwordTooLong) ? $passwordTooLong : ''?>
    </div>

    <div class="register--section">
        <label>Repeat password:</label><br />
        <input type="password" name="register--password__repetition" class="register--input" value="<?=isset($setPasswordRepetition) ? $setPasswordRepetition : ''?>" required/><br />
        <?=isset($passwordRepetitionNotMatching) ? $passwordRepetitionNotMatching : ''?>
    </div>

    <div class="register--section">
        <label><br />
            <input type="checkbox" name="register--TOS" <?=isset($setTOS) ? $setTOS : ''?> required/>
            I accept the <a href="<?=base_url( 'TOS' )?>" target="_blank">Terms of Service</a> of RPG Session-Hub.
            <?=isset($termsOfServiceDenied) ? $termsOfServiceDenied : ''?>
        </label><br />
    </div>

    <input type="submit" class="btn btn-info" value="Create an account" />

</form>

<div class="session--hub">
    <a href="<?=base_url()?>" role="button" class="btn btn-primary">Return <- </a>
</div>
