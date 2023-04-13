<?php

    /**
     * Depends on the Update URI that is stated in the main plugin file header.
     * 
     * https://nickgreen.info/add-autoupdates-to-your-wordpress-plugin-thats-hosted-on-github-using-update_plugins_hostname/
     */
    add_filter('update_plugins_github.com', 'financeServiceIoUpdater', 10, 4);

    function financeServiceIoUpdater( $update, array $plugin_data, string $plugin_file, $locales )
    {
        $githubApiUrl = 'https://api.github.com/repos/Leads-Clinic/wordpress-plugin-financeserviceio/releases/latest';

        $transientKey = md5($githubApiUrl);

        if( $plugin_file == 'wordpress-plugin-financeserviceio/financeserviceio.php' && empty($update) ) {

            // Check if we have the github response in the cache already.
            // We want to protect the Github API and not call more than every 12 hrs.
            $releasePackage = get_transient($transientKey);

            if( $releasePackage == false ) {

                $resp = wp_remote_get($githubApiUrl, [
                    'sslverify' => false,
                    'headers' => ['Content-Type: application/json'],                
                    'user-agent' => 'Mozilla/5.0 (Macintosh; Intel Mac OS X 10_15_7) AppleWebKit/605.1.15 (KHTML, like Gecko) Version/16.2 Safari/605.1.15'
                ]);        
                $respCode = wp_remote_retrieve_response_code($resp);            

                if( !is_wp_error($resp) && $respCode >= 200 && $respCode <= 300 ) {

                    $releasePackage = json_decode( wp_remote_retrieve_body($resp), true );

                    set_transient($transientKey, $releasePackage, 3600 * 12);

                }

            }

            // Check if there is a reason to update this plugin
            if( is_array($releasePackage) && array_key_exists('tag_name', $releasePackage) ) {
                
                $currentVersion = ltrim($plugin_data['Version'], 'v');
                $latestVersion = ltrim($releasePackage['tag_name'], 'v');            
            
                $updateAvailable = version_compare($currentVersion, $latestVersion, '<');

                if( $updateAvailable ){

                    return [
                        'slug' => $plugin_data['TextDomain'],
                        'version' => $latestVersion,
                        'url' => $releasePackage['html_url'],
                        'package' => $releasePackage['zipball_url'],
                        'autoupdate' => true
                    ];

                }   
                
            }         
            
            return false; 

        } else {

            return $update;

        }

    }