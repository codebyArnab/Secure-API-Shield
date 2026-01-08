<?php
/**
 * Uninstall Script
 * Fired when the plugin is uninstalled
 */

// Exit if accessed directly or not in uninstall context
if (!defined('WP_UNINSTALL_PLUGIN')) {
    exit;
}

/**
 * Delete all plugin data
 */
function sas_uninstall() {
    global $wpdb;
    
    // Delete custom tables
    $tables = array(
        $wpdb->prefix . 'sas_api_keys',
        $wpdb->prefix . 'sas_usage_logs',
        $wpdb->prefix . 'sas_rate_limits'
    );
    
    foreach ($tables as $table) {
        $wpdb->query("DROP TABLE IF EXISTS $table");
    }
    
    // Delete all plugin options
    $options = array(
        'sas_default_rate_limit',
        'sas_rate_limit_window',
        'sas_enable_logging',
        'sas_log_retention_days',
        'sas_encryption_method',
        'sas_version'
    );
    
    foreach ($options as $option) {
        delete_option($option);
    }
    
    // Delete transients
    $wpdb->query(
        "DELETE FROM {$wpdb->options} 
        WHERE option_name LIKE '_transient_sas_%' 
        OR option_name LIKE '_transient_timeout_sas_%'"
    );
    
    // Clear scheduled events
    wp_clear_scheduled_hook('sas_cleanup_logs');
    wp_clear_scheduled_hook('sas_cleanup_rate_limits');
}

// Run uninstall
sas_uninstall();
