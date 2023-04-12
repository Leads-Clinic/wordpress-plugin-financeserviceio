<?php

    require_once( plugin_dir_path(__FILE__) . 'frontpage.php');

    /**
     * Hook into the admin interface and add a sub-menu under the
     * tools menu point. 
     */
    add_action('admin_menu', 'financeServiceIoAdminNavigation');

    function financeServiceIoAdminNavigation()
    {
        add_submenu_page(
            'tools.php',
            'Finance Service Io',
            'Finance Service Io',
            'manage_options',
            'finance-service-io',
            'financeServiceIoAdminFrontpage',
            'dashicons-plugins-checked'
        );
    }

