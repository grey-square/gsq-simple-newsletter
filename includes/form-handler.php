<?php
function simple_newsletter_handle_submission() {
    if (isset($_POST['simple_newsletter_submit'])) {
        // Verify nonce for security
        if (!isset($_POST['simple_newsletter_nonce']) || !wp_verify_nonce($_POST['simple_newsletter_nonce'], 'simple_newsletter_action')) {
            wp_die('Security check failed');
        }

        // Sanitize and validate input
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $email = isset($_POST['email']) ? sanitize_email($_POST['email']) : '';

        if (!is_email($email)) {
            return new WP_Error('invalid_email', 'Please enter a valid email address');
        }

        // Store in database
        $result = simple_newsletter_store_subscriber($name, $email);

        if ($result === false) {
            return new WP_Error('db_error', 'Could not save your subscription');
        }

        // Success - you could also send an email confirmation here
        wp_redirect(site_url('/newsletter-success'));
        exit;
    }
    return false;
}

// Hook into init to process the form
add_action('init', 'simple_newsletter_handle_submission');