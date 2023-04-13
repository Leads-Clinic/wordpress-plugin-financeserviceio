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
     * Update URI: https://github.com/Leads-Clinic/wordpress-plugin-financeserviceio
     */

    require_once( plugin_dir_path(__FILE__) . 'shortcodes.php');
    require_once( plugin_dir_path(__FILE__) . 'injector.php');    
    
    if( is_admin() ) {
        
        require_once( plugin_dir_path(__FILE__) . 'admin/index.php');
        require_once( plugin_dir_path(__FILE__) . 'updater.php');
        require_once( plugin_dir_path(__FILE__) . 'cleanup.php');
        
    }
