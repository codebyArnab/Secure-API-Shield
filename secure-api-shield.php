<?php
/**
 * Plugin Name: Secure API Shield
 * Plugin URI: https://example.com/secure-api-shield
 * Description: Enterprise-grade API security plugin with token-based authentication, rate limiting, and React-powered admin dashboard
 * Version: 1.0.0
 * Author: Your Name
 * Author URI: https://example.com
 * License: GPL v2 or later
 * Text Domain: secure-api-shield
 * Domain Path: /languages
 */

// Exit if accessed directly
if (!defined('ABSPATH')) {
    exit;
}

// Define plugin constants
define('SAS_VERSION', '1.0.0');
define('SAS_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('SAS_PLUGIN_URL', plugin_dir_url(__FILE__));
define('SAS_PLUGIN_BASENAME', plugin_basename(__FILE__));

/**
 * Main Plugin Class
 */
class Secure_API_Shield {
    
    private static $instance = null;
    
    /**
     * Get singleton instance
     */
    public static function get_instance() {
        if (null === self::$instance) {
            self::$instance = new self();
        }
        return self::$instance;
    }
    
    /**
     * Constructor
     */
    private function __construct() {
        $this->load_dependencies();
        $this->define_hooks();
    }
    
    /**
     * Load required files
     */
    private function load_dependencies() {
        require_once SAS_PLUGIN_DIR . 'includes/class-activator.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-deactivator.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-database.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-encryption.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-api-manager.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-rate-limiter.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-api-endpoint.php';
        require_once SAS_PLUGIN_DIR . 'includes/class-admin.php';
    }
    
    /**
     * Define WordPress hooks
     */
    private function define_hooks() {
        // Activation and deactivation
        register_activation_hook(__FILE__, array('SAS_Activator', 'activate'));
        register_deactivation_hook(__FILE__, array('SAS_Deactivator', 'deactivate'));
        
        // Initialize components
        add_action('plugins_loaded', array($this, 'init'));
        add_action('rest_api_init', array($this, 'register_api_routes'));
    }
    
    /**
     * Initialize plugin components
     */
    public function init() {
        // Initialize admin interface
        if (is_admin()) {
            SAS_Admin::get_instance();
        }
        
        // Initialize API endpoint
        SAS_API_Endpoint::get_instance();
    }
    
    /**
     * Register REST API routes
     */
    public function register_api_routes() {
        SAS_API_Endpoint::register_routes();
    }
}

/**
 * Initialize the plugin
 */
function secure_api_shield() {
    return Secure_API_Shield::get_instance();
}

// Start the plugin
secure_api_shield();
