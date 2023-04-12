<?php

    function financeServiceIoAdminFrontpage()
    {       
        $settings = get_option('financeServiceIo', []);

        // The fields for which the default tracking values is allowed to be set.
        // For now we cannot allow others fields that those supported by the old system
        $trackingDefaultFieldNames = [
            'pubid',
            'pubidsub1',
            'pubidsub2',
            'pubidsub3',
            'pubidsub4',
            'pubidsub5',
            'pubid_reference'
        ];
        
        // Handle POST request when data is updated. 
        // After successfully saving then redirect back without the &save=1 
        // parameter in the URL.
        if( $_GET['save'] == 1 && isset($_POST) && current_user_can('manage_options') && check_admin_referer('financeServiceIo') ) {    

            $settings['token'] = trim($_POST['token']);

            foreach( $trackingDefaultFieldNames as $parameter ) {

                $requestVariable = "trackingDefault-{$parameter}";

                if( in_array($_POST[$requestVariable], [null, ''], true) ) {
                    unset($settings['trackingDefaults'][$parameter]);
                    continue;
                }
                
                $settings['trackingDefaults'][$parameter] = trim($_POST[$requestVariable]);                
            }
            
            update_option("financeServiceIo", $settings);            

            wp_redirect( admin_url('/tools.php?page=finance-service-io') );
            exit;

        }

        // Generate array of HTMl fields to set the trackingDefaults settings
        $trackingDefaultFields = [];

        foreach( $trackingDefaultFieldNames as $parameter ) {

            $trackingDefaultFields[$parameter] = "
                <tr>
                    <th scope='row'>
                        <label for='trackingDefault-{$parameter}'><i>". ucfirst($parameter) ."</i> Default</label>
                    </th>
                    <td>
                        <input name='trackingDefault-{$parameter}' id='trackingDefault-{$parameter}' value='". esc_html($settings['trackingDefaults'][$parameter]) ."' type='text' class='regular-text' />
                    </td>
                </tr>
            ";
        
        }
        
        ?>

            <div class="wrap">
                <h1><?= get_admin_page_title(); ?></h1>
                           
                <form method="POST" action="<?php echo admin_url('/tools.php?page=finance-service-io&save=1'); ?>">
                    
                    <?php wp_nonce_field('financeServiceIo'); ?>

                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th scope="row">
                                    <label for="token">Whitelabel Token</label>
                                </th>
                                <td>
                                    <input name="token" id="token" type="text" value="<?php echo esc_html($settings['token']); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th colspan=2>
                                    <h3>Tracking Defaults</h3>
                                    <p class="description">Tracking default values are only used in case they are not present in the URL.</p>
                                </th>
                            </tr>
                            <?php echo implode('', $trackingDefaultFields); ?>
                        </tbody>
                    </table>

                    <?php submit_button(); ?>
                </form>
            </div>

        <?php
    }