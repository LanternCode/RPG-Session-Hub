<form class="contact--form" method="POST" action="<?=base_url( 'contact/sendTicket' )?>">
    <h2 class="contact--form--header">Tell us what is bothering you by sending us a message:</h2>
    <br /><br />

    <?php
        if( isset( $ticketSuccess ) && $ticketSuccess ): ?>
            <h4 class='homepage--registered'>Your ticket was submitted! We shall respond within 48 hours.</h4>
    <?php
        elseif( isset( $ticketSuccess ) && $ticketSuccess == false ): ?>
            <h4 class='homepage--error'>Something went wrong. Please try again.</h4>
    <?php
        endif;

    if( !$email ): ?>
        <label class="contact--form--item">My Email address:</label>
        <input class="" type="email" name="ticket_email" required /><br /><br /><br />
    <?php endif; ?>

    <label class="contact--form--item">Message title:</label>
    <input class="" type="text" name="ticket_title" required /><br /><br /><br />

    <label class="contact--form--item">Message:</label>
    <textarea class="" rows="4" cols="50" name="ticket_content" required></textarea>
    <br /><br />

    <input class="btn btn-success" role="button" type="submit" value="Submit the message" /><br /><br />
</form>

<div class="session--hub">
    <button role="button" class="btn btn-info tos--button" onclick="window.open('', '_self', ''); window.close();">Close</button>
</div>
