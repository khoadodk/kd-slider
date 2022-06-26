<?php

if( ! function_exists('kd_slider_options')){
    function kd_slider_options() {
        // Check if bullet option is checked, return true or false
        $show_bullets = isset( KD_Slider_Settings::$options['kd_slider_bullets']) && KD_Slider_Settings::$options['kd_slider_bullets'] == 1 ? true : false ;

        // Enqueue flexslider script to the option
        wp_enqueue_script('kd-slider-options-js', KD_SLIDER_URL .'vendor/flexslider/flexslider.js', array('jquery'), KD_SLIDER_VERSION, true);
        
        // Accept PHP array and creates a JavaScript object
        wp_localize_script('kd-slider-options-js', 'SLIDER_OPTIONS', array(
            'controlNav' => $show_bullets
        ));
    }
}