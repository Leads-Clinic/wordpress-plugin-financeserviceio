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

            $settings['token'] = sanitize_text_field($_POST['token']);

            foreach( $trackingDefaultFieldNames as $parameter ) {

                $requestVariable = "trackingDefault-{$parameter}";

                if( in_array($_POST[$requestVariable], [null, ''], true) ) { // Do not use 'empty' since it returns true for 0 (zero)
                    unset($settings['trackingDefaults'][$parameter]);
                    continue;
                }
                
                $settings['trackingDefaults'][$parameter] = sanitize_text_field($_POST[$requestVariable]); 
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

            <div class="wrap" style="max-width: 1024px;">
                <h1><?= get_admin_page_title(); ?></h1>
                                                       
                <form method="POST" action="<?php echo admin_url('/tools.php?page=finance-service-io&save=1'); ?>">                    
                    <?php wp_nonce_field('financeServiceIo'); ?>
                    
                    <table class="form-table" role="presentation">
                        <tbody>
                            <tr>
                                <th colspan="2">
                                    <h3>General settings</h3>
                                    <p class="description">The Finance Service Io plugin will help you quickly set-up a whitelabel solution with Leads Clinic Oy. The plugin is a wrapper around the financeServiceIo Javascript tag that you can also implement manually. It does primarily two things: 1) tracks clicks on your website to report on KPIs such as conversion rate 2) renders a full loan application on your website for you to monitize your webtraffic.</p>
                                    <p class="description">Use the following shortcode on a page or post to render a form: <code>[financeServiceIo form="FORM TOKEN HERE"]</code></p>
                                </th>
                            </tr>
                            <tr>
                                <th scope="row">
                                    <label for="token">Whitelabel Token</label>
                                </th>
                                <td>
                                    <input name="token" id="token" type="text" value="<?php echo esc_html($settings['token']); ?>" class="regular-text">
                                </td>
                            </tr>
                            <tr>
                                <th colspan="2">
                                    <h3>Tracking Defaults</h3>
                                    <p class="description">Tracking default values are only used in case they are not present in the URL. Leave the field empty to omit a default value.</p>
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