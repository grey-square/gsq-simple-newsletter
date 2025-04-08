<?php
function simple_newsletter_create_table() {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        id mediumint(9) NOT NULL AUTO_INCREMENT,
        name varchar(100) NOT NULL,
        email varchar(100) NOT NULL,
        subscribed_at datetime DEFAULT CURRENT_TIMESTAMP NOT NULL,
        PRIMARY KEY (id),
        UNIQUE KEY email (email)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}

function simple_newsletter_store_subscriber($name, $email) {
    global $wpdb;
    $table_name = $wpdb->prefix . 'newsletter_subscribers';
    
    return $wpdb->insert(
        $table_name,
        array(
            'name' => sanitize_text_field($name),
            'email' => sanitize_email($email)
        ),
        array('%s', '%s')
    );
}