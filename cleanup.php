<?php

    /**
     * Uninstall is when the plugin is deactivated AND deleted.
     * 
     * The plugin should not run arbitrary code outside of functions, when registering the
     * uninstall hook. In order to run using the hook, the plugin will have to be included,
     * which means that any code laying outside of a function will be run during the uninstallation process.
     * The plugin should not hinder the uninstallation process.
     * 
     * https://developer.wordpress.org/plugins/plugin-basics/uninstall-methods/
     */
    register_uninstall_hook(__DIR__ . 'financeserviceio.php', 'financeServiceIoUninstall');

    function financeServiceIoUninstall()
    {
        if( current_user_can('manage_options') ) {
            delete_option('financeServiceIo');
        }
    }