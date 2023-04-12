<?php 
/**
 * FinanceServiceIo (Leads Clinic Oy)
 *
 * @wordpress-plugin
 * Plugin Name: FinanceServiceIo (Leads Clinic Oy)
 * Plugin URI: https://leadsclinic.com
 * Description: Set up the Leads Clinic Oy whitelabel with easy using this wordpress plugin.
 * Version: 1.0.0
 * Requires PHP: 7.2
 * Author: Leads Clinic Oy
 * Author URI: https://leadsclinic.com
 * Text Domain: financeserviceio
 * License: GPL v2 or later
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Update URI: https://financeservice.io
 */

/**
 * If logged in as admin on the interface initialize the interface.
 * Everything related to the admin interface is in the /admin folder.
 * 
 * /admin/index.php is the admin frontpage. The menu point will be under tools
 */
if( is_admin() ) {

    require_once(WP_PLUGIN_DIR . '/wordpress-plugin-financeserviceio/admin/index.php');

    add_action('admin_menu', function(){

        add_submenu_page('tools.php', 'Finance Service Io', 'FinanceServiceIo', 'manage_options', 'financeserviceio', 'financeServiceIoAdminInit', 'dashicons-plugins-checked');

    });

}

/**
 * Inject global FinanceServiceIo script tag in the header
 * 
 * Takes the whitelabel token from the admin interface options.
 * Takes tracking default values from the options page as well.
 */
add_action('wp_head', function(){

    $token = get_option('financeserviceio_token');

    if( !empty($token) ) {
    
        $trackingDefaultsJson = get_option('financeserviceio_tracking_defaults', "{}");    

        echo '
            <script type="text/javascript">
                (function(i,c,f,o,n,e)
                    {i.financeServiceIo||(i.financeServiceIo=function(){
                    financeServiceIo.queue.push(arguments)},financeServiceIo.queue=[],
                    financeServiceIo.push=financeServiceIo,e=c.createElement(f),e.src=o,
                    e.async=!0,n=c.getElementsByTagName(f)[0],n.parentNode.insertBefore(e,n))
                })(window,document,"script","https://tags.financeservice.io/main/main.min.js");                     
                
                financeServiceIo("init", "'. trim($token) .'");     
                financeServiceIo("setTrackingDefaults", '. $trackingDefaultsJson . ');
            </script>
        ';

    }

});

/**
 * Add a wordpress shortcode to insert a div that will show the form
 * 
 */
add_shortcode('financeserviceio', function($atts = [], $content = '', $tag = ''){

    $atts = array_change_key_case( (array)$atts, CASE_LOWER);
    


});