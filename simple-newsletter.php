<?php
/*
Plugin Name: Simple Newsletter (GSQ)
Description: A simple newsletter subscription plugin
Version: 1.0
Author: Dzinaishe Mpini
*/

// Security check
defined('ABSPATH') or die('No script kiddies please!');

// Include other files
require_once plugin_dir_path(__FILE__) . 'includes/database.php';
require_once plugin_dir_path(__FILE__) . 'includes/form-handler.php';
require_once plugin_dir_path(__FILE__) . 'includes/shortcode.php';

// Activation/deactivation hooks
register_activation_hook(__FILE__, 'simple_newsletter_activate');
register_deactivation_hook(__FILE__, 'simple_newsletter_deactivate');

function simple_newsletter_activate() {
    // Create database table on activation
    simple_newsletter_create_table();
}

function simple_newsletter_deactivate() {
    // Cleanup if needed
}

// Add admin menu
add_action('admin_menu', 'simple_newsletter_admin_menu');

function simple_newsletter_admin_menu() {
    add_menu_page(
        'Newsletter Subscribers',     // Page title
        'GSQ Newsletter',                 // Menu title
        'manage_options',             // Capability
        'simple-newsletter',          // Menu slug
        'simple_newsletter_admin_page', // Callback
        'dashicons-email-alt2',       // Icon
        26                            // Position
    );
}


function simple_newsletter_admin_page() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';

    $subscribers = $wpdb->get_results("SELECT * FROM $table_name ORDER BY subscribed_at DESC");
    ?>
    <div class="wrap">
        <h1>Newsletter Subscribers</h1>
        <table class="widefat fixed striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Subscribed At</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($subscribers): ?>
                    <?php foreach ($subscribers as $subscriber): ?>
                        <tr>
                            <td><?php echo esc_html($subscriber->id); ?></td>
                            <td><?php echo esc_html($subscriber->name); ?></td>
                            <td><?php echo esc_html($subscriber->email); ?></td>
                            <td><?php echo esc_html($subscriber->subscribed_at); ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="4">No subscribers found.</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <?php
}
