<?php

    /**
     * Inject global FinanceServiceIo script tag in the header
     * 
     * Takes the whitelabel token from the admin interface options.
     * Takes tracking default values from the options page as well.
     */
    add_action('wp_head', 'financeServiceIoScriptInjector');
    
    function financeServiceIoScriptInjector()
    {
        $settings = get_option('financeServiceIo', []);
                
        if( !empty($settings['token']) ) {
        
            $trackingDefaultsJson = empty($settings['trackingDefaults']) ? "{}" : json_encode($settings['trackingDefaults'], JSON_FORCE_OBJECT);

            echo '
                <script type="text/javascript">
                    (function(i,c,f,o,n,e)
                        {i.financeServiceIo||(i.financeServiceIo=function(){
                        financeServiceIo.queue.push(arguments)},financeServiceIo.queue=[],
                        financeServiceIo.push=financeServiceIo,e=c.createElement(f),e.src=o,
                        e.async=!0,n=c.getElementsByTagName(f)[0],n.parentNode.insertBefore(e,n))
                    })(window,document,"script","https://tags.financeservice.io/main/main.min.js");                     
                    
                    financeServiceIo("init", "'. trim($settings['token']) .'");     
                    financeServiceIo("setTrackingDefaults", '. $trackingDefaultsJson . ');
                </script>
            ';

        }

    }
