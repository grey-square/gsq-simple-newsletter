<?php
function simple_newsletter_form_shortcode($atts) {
    // Process any form submission
    $submission_result = simple_newsletter_handle_submission();

    // Start output buffering
    ob_start();

    // Display success/error messages
    if (is_wp_error($submission_result)) {
        echo '<div class="newsletter-error">' . $submission_result->get_error_message() . '</div>';
    } elseif ($submission_result === true) {
        echo '<div class="newsletter-success">Thank you for subscribing!</div>';
    }

    // Output the form
    ?>
    <form id="contact" action="<?php echo esc_url($_SERVER['REQUEST_URI']); ?>" method="POST">
        <?php wp_nonce_field('simple_newsletter_action', 'simple_newsletter_nonce'); ?>
        <div class="row">
            <div class="col-lg-12">
                <h2>Subscribe to our newsletter and stay updated</h2>
            </div>
            <div class="col-lg-6">
                <fieldset>
                    <input name="name" type="text" id="name" placeholder="YOUR NAME...*" required>
                </fieldset>
            </div>
            <div class="col-lg-6">
                <fieldset>
                    <input name="email" type="email" id="email" placeholder="YOUR EMAIL..." required>
                </fieldset>
            </div>
            <div class="col-lg-12">
                <fieldset>
                    <button type="submit" name="simple_newsletter_submit" id="form-submit" class="button">Subscribe</button>
                </fieldset>
            </div>
        </div>
    </form>
    <?php

    // Return the buffered content
    return ob_get_clean();
}

add_shortcode('newsletter_form', 'simple_newsletter_form_shortcode');