<?php

if(! class_exists('KD_Slider_Shortcode')){
    class KD_Slider_Shortcode{
        public function __construct()
        {
            add_shortcode('kd_slider', array($this, 'add_shortcode'));
        }

        public function add_shortcode($atts = array(), $content = null, $tag = ''){
            $atts = array_change_key_case((array) $atts, CASE_LOWER);

            extract(shortcode_atts(
                array(
                    'id' => '',
                    'orderby' => 'date'
                ),
                $atts,
                $tag
            ));
            // Turn a string into elements of an array. id='43,321' => [43, 321]
            if(!empty($id)){
                $id = array_map('absint', explode(',', $id));
            }
            // Insert a customized code into HTML element
            ob_start();
            require( KD_SLIDER_PATH . 'views/kd-slider_shortcode.php');
            wp_enqueue_script('kd-slider-main-jq');
            wp_enqueue_script('kd-slider-options-js');
            wp_enqueue_style('kd-slider-main-css');
            wp_enqueue_style('kd-slider-style-css');
            return ob_get_clean();
        }
    }
}