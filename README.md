# Secure-API-Shield
Enterprise-Grade WordPress Plugin:A plugin that allows users to create secure, token-based API endpoints for their WordPress site, allowing external apps to fetch data safely.
=== Secure API Shield ===
Contributors: yourname
Tags: api, security, authentication, rest-api, rate-limiting
Requires at least: 5.8
Tested up to: 6.4
Requires PHP: 7.4
Stable tag: 1.0.0
License: GPLv2 or later
License URI: https://www.gnu.org/licenses/gpl-2.0.html

Enterprise-grade API security plugin with token-based authentication, rate limiting, and React-powered admin dashboard.

== Description ==

Secure API Shield provides enterprise-level security for WordPress REST API endpoints. Create secure, token-based API keys to allow external applications to safely access your WordPress data.

**Key Features:**

* **Secure Token-Based Authentication**: Generate unique API keys with encrypted secrets
* **Advanced Rate Limiting**: Prevent abuse with configurable request limits
* **Granular Permissions**: Control exactly what each API key can access
* **Usage Monitoring**: Track all API requests with detailed logging
* **Modern Admin Dashboard**: React-powered interface for easy management
* **AES-256 Encryption**: Military-grade encryption for API secrets
* **IP-Based Protection**: Additional security layer with IP tracking
* **Automatic Cleanup**: Scheduled cleanup of old logs and rate limit data

**Perfect For:**

* Mobile app developers
* Third-party integrations
* Headless WordPress setups
* Multi-platform content distribution
* Custom API implementations

**Security Features:**

* HMAC signature validation
* Encrypted secret storage
* Brute force protection via rate limiting
* Request logging and monitoring
* Configurable expiration dates
* Instant key revocation

== Installation ==

1. Upload the plugin files to `/wp-content/plugins/secure-api-shield/`
2. Activate the plugin through the 'Plugins' screen in WordPress
3. Navigate to 'API Shield' in the admin menu
4. Create your first API key
5. Use the API key and secret in your application

== Frequently Asked Questions ==

= How do I create an API key? =

1. Go to API Shield > API Keys in your WordPress admin
2. Click "Create New Key"
3. Enter a name and configure permissions
4. Save and securely store your API key and secret

= How do I use the API key in my application? =

Include the credentials as headers in your HTTP requests:

```
X-API-Key: your_api_key_here
X-API-Secret: your_api_secret_here
```

= What endpoints are available? =

* GET /wp-json/sas/v1/data/posts - Fetch posts
* GET /wp-json/sas/v1/data/users - Fetch users
* GET /wp-json/sas/v1/data/custom - Fetch custom data

= Can I add custom endpoints? =

Yes! Use the `sas_custom_data` filter to add your own data:

```php
add_filter('sas_custom_data', function($data, $request, $key_data) {
    $data['my_data'] = array('value' => 'Hello');
    return $data;
}, 10, 3);
```

= How does rate limiting work? =

Each API key has a configurable rate limit (default: 100 requests/hour). When the limit is reached, requests return a 429 status code with a `Retry-After` header.

= Is the API secret stored securely? =

Yes! API secrets are hashed using Argon2ID and encrypted using AES-256-CBC with WordPress authentication salts.

= Can I see who's using my API? =

Absolutely! The Usage Logs section shows detailed information about every API request including timestamp, endpoint, IP address, and response status.

== Screenshots ==

1. Dashboard overview with statistics
2. API key management interface
3. Create new API key with permissions
4. Usage logs and monitoring
5. Settings and configuration

== Changelog ==

= 1.0.0 =
* Initial release
* Token-based authentication
* Rate limiting functionality
* Usage logging
* React admin dashboard
* AES-256 encryption
* Configurable permissions

== Upgrade Notice ==

= 1.0.0 =
Initial release of Secure API Shield.

== Developer Documentation ==

**Creating API Keys Programmatically:**

```php
$api_manager = SAS_API_Manager::get_instance();
$result = $api_manager->create_api_key(
    $user_id,
    'My API Key',
    array('read_posts', 'read_users'),
    100, // rate limit
    30   // expires in days
);
```

**Custom Endpoints:**

```php
add_filter('sas_custom_data', function($data, $request, $key_data) {
    // Add your custom data
    $data['custom'] = get_custom_data();
    return $data;
}, 10, 3);
```

**Rate Limit Customization:**

```php
// Change default rate limit
add_filter('sas_default_rate_limit', function($limit) {
    return 200; // 200 requests per hour
});

// Change rate limit window
add_filter('sas_rate_limit_window', function($window) {
    return 7200; // 2 hours in seconds
});
```

For more information, visit the Documentation page in the plugin settings.

== Privacy Policy ==

Secure API Shield logs API requests including IP addresses and user agents for security monitoring. This data is stored in your WordPress database and can be configured to auto-delete after a specified retention period.

No data is sent to external services. All processing occurs on your WordPress installation.
