<?php 
/**
 * FinanceServiceIo
 *
 * @wordpress-plugin
 * Plugin Name: FinanceServiceIo
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