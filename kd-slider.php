<?php
/**
 * Plugin Name: KD Slider
 * Plugin URI: https://www.wordpress.org/kd-slider
 * Description: My custom slider
 * Version: 1.0
 * Requires at least: 5.0
 * Author: Khoa Do
 * Author URI: https://khoado.dev
 * License: GPL v2 or later
 * Text Domain: kd-slider
 */

 /*
This program is free software; you can redistribute it and/or
modify it under the terms of the GNU General Public License
as published by the Free Software Foundation; either version 2
of the License, or (at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.

Copyright 2005-2015 Automattic, Inc.
*/

// Make sure we don't expose any info if called directly
if(! defined ('ABSPATH')){
    exit;
}
// Where you put your new functions within the class
if(!class_exists ('KD_Slider')){
    class KD_Slider{
           function __construct()
           {
               $this->define_constants(); 

                // Bring functions.php in
                require_once( KD_SLIDER_PATH . 'functions/functions.php');

                // Add menu to admin bar
                add_action('admin_menu', array($this, 'add_menu'));

                // Custom Post for slider
               require_once( KD_SLIDER_PATH . 'post-types/class.kd-slider-cpt.php' );// 
               $KD_Slider_Post_Type = new KD_Slider_Post_Type();

                // Admin dashboard setting for slider
               require_once( KD_SLIDER_PATH . 'class.kd-slider-settings.php' );
                $KD_Slider_Settings = new KD_Slider_Settings();

                // Slider shortcode
               require_once( KD_SLIDER_PATH . 'shortcodes/class.kd-slider-shortcode.php' );
               $KD_Slider_Shortcode = new KD_Slider_Shortcode();

                //  Enqueue Scripts
                add_action('wp_enqueue_scripts', array($this, 'register_scripts'), 999);
           }

           //define a constant variable that contains the plugin dir path
           public function define_constants(){
              define ('KD_SLIDER_PATH',plugin_dir_path( __FILE__)) ; 
              define ('KD_SLIDER_URL',plugin_dir_url( __FILE__)) ; 
              define ('KD_SLIDER_VERSION','1.0.0') ; 
           }

           public static function activate(){
                update_option('rewrite_rules',''); // deleting values in the fields
           }

           public static function deactivate(){
                flush_rewrite_rules(); // like saving permalinks .
                unregister_post_type('kd-slider');
           }

           public static function uninstall(){
                delete_option('kd_slider_options');

                $posts = get_posts(
                    array (
                        'post_type' => 'kd-slider',
                        'number_posts' => -1,
                        'post_status' => 'any'
                    )
                );

                foreach($posts as $post){
                    wp_delete_post($post -> ID, true);
                }
           }
           
           public function add_menu() {
            // https://developer.wordpress.org/reference/functions/add_menu_page/
            add_menu_page(
                'KD Slider Options',
                'KD Slider',
                'manage_options',
                'kd_slider_admin',
                array($this, 'kd_slider_settings_page'),
                'dashicons-slides'
            );
            // https://developer.wordpress.org/reference/functions/add_submenu_page/
            add_submenu_page(
                'kd_slider_admin',
                'Add New Slide',
                'Add New Slide',
                'manage_options',
                'post-new.php?post_type=kd-slider',
                null,
                null
            );
           }

           public function kd_slider_settings_page(){
                // Check current user's permission 
                if( ! current_user_can( 'manage_options' ) ){
                    return;
                }
                // Error message
                if( isset( $_GET['settings-updated'] ) ){
                    add_settings_error( 'kd_slider_options', 'kd_slider_message', 'Settings Saved', 'success' );
                }
                settings_errors( 'kd_slider_options' );
                
                require( KD_SLIDER_PATH . 'views/settings-page.php');
           }

           public function register_scripts(){
            wp_register_script('kd-slider-main-jq', KD_SLIDER_URL .'vendor/flexslider/jquery.flexslider-min.js', array('jquery'), KD_SLIDER_VERSION, true);
            wp_register_style('kd-slider-main-css', KD_SLIDER_URL .'vendor/flexslider/flexslider.css', array(), KD_SLIDER_VERSION, 'all');
            wp_register_style('kd-slider-style-css', KD_SLIDER_URL .'assets/css/frontend.css', array(), KD_SLIDER_VERSION, 'all');
        }
    }
}

if( class_exists( 'KD_Slider' ) ){
   register_activation_hook( __FILE__, array( 'KD_Slider', 'activate' ) );
   register_deactivation_hook( __FILE__, array( 'KD_Slider', 'deactivate' ) );
   register_uninstall_hook( __FILE__, array( 'KD_Slider', 'uninstall' ) );

   $kd_slider = new KD_Slider();
} 