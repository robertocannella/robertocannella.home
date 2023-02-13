<?php

/*
*  Plugin Name: PayPal Integration
*  Version: 0.0.1
*  Author: Roberto Cannella
*  Author URI: https://www.robertocannella.com
*/

if( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

class PayPalIntegrationPlugin
{
    function __construct()
    {
        add_action('activate_rc-paypal-integration/rc-paypal-integration.php', array($this, 'onActivate'));
        add_action('wp_enqueue_scripts', array($this, 'loadAssets'));
        add_filter('template_include', array($this, 'loadTemplate'), 99);

    }

    function onActivate() {
        require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    }
    function loadAssets() {

        if (is_page('paypal-tool')) {
            wp_enqueue_style('paypal-tool-css', plugin_dir_url(__FILE__) . 'paypal.css');
            wp_enqueue_script('rc-paypal-main-js',plugin_dir_url(__FILE__) . '/build/index.js');
            wp_localize_script('rc-paypal-main-js','rcPluginSiteData', [
                'siteUrl' => get_site_url(),
                'nonceX' => wp_create_nonce('wp_rest')
            ]);
            echo "<div class='paypal-box' id='paypal-box'></div>";
        }
    }
    function loadTemplate($template) {
        if (is_page('paypal-tool')) {
            return plugin_dir_path(__FILE__) . 'inc/template-paypal.php';
        }
        return $template;
    }
}

$payPalIntegration = new PayPalIntegrationPlugin();
