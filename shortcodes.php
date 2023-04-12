<?php

    /**
     * Will destribute the shortcode actions. All shortcodes
     * are named financeServiceIo and the attributes decides
     * the actions we are going to take and replace the shortcode with.
     */
    add_shortcode('financeServiceIo', 'financeServiceIoShortcode');

    function financeServiceIoShortcode( $atts = [], $content = '', $tag = '' )
    {
        if( isset($atts['form']) ) {

            return "<div data-financeserviceio-form='{$atts['form']}'></div>";
            
        }
    }