
<?php

if(!class_exists('KD_Slider_Post_Type')){// we get the option to overwrite the class if it doesn't exist
    class KD_Slider_Post_Type{
            function __construct()
            {
                // Action Hooks
                add_action('init', array($this, 'create_post_type') );
                add_action('add_meta_boxes', array($this, 'add_meta_boxes') );
                add_action('save_post', array($this, 'save_post'), 10, 2 );
                add_filter('manage_kd-slider_posts_columns', array($this, 'kd_slider_cpt_columns'));
                add_action('manage_kd-slider_posts_custom_column', array($this, 'kd_slider_custom_columns'), 10, 2);
                add_filter('manage_edit-kd-slider_sortable_columns', array($this, 'kd_slider_sortable_columns'));
            }

            public function create_post_type(){//this is the callback function of the hook function= method 
            
                register_post_type(
                    'kd-slider',
                    array(
                        'label' => esc_html__( 'Slider', 'kd-slider' ),
                        'description'   => esc_html__( 'Sliders', 'kd-slider' ),
                        'labels' => array(
                            'name'  => esc_html__( 'Sliders', 'kd-slider' ),
                            'singular_name' => esc_html__( 'Slider', 'kd-slider' ),
                        ),
                        'public'    => true,
                        'supports'  => array( 'title', 'editor', 'thumbnail' ),
                        'hierarchical'  => false,
                        'show_ui'   => true,
                        'show_in_menu'  => true,
                        'menu_position' => 10,
                        'show_in_admin_bar' => true,
                        'show_in_nav_menus' => true,
                        'can_export'    => true,
                        'has_archive'   => true,
                        'exclude_from_search'   => false,
                        'publicly_queryable'    => true,
                        'show_in_rest'  => true,
                        'menu_icon' => 'dashicons-slides',
                        //'register_meta_box_cb'  =>  array( $this, 'add_meta_boxes' )
                    )
                );
            }

            // Add metadata to admin dashboard
            public function kd_slider_cpt_columns($columns){
                $columns['kd_slider_link_text'] = esc_html('Link Text', 'kd-slider');
                $columns['kd_slider_link_url'] = esc_html('Link URL', 'kd-slider');
                return $columns;
            }

            // Fill up column data
            public function kd_slider_custom_columns($column, $post_id){
                switch($column){
                    case 'kd_slider_link_text':
                        echo esc_html(get_post_meta( $post_id, 'kd_slider_link_text', true));
                    break;
                    case 'kd_slider_link_url':
                        echo esc_html(get_post_meta( $post_id, 'kd_slider_link_url', true));
                    break;
                }
            }

            // Sort columns
            public function kd_slider_sortable_columns($columns){
                $columns['kd_slider_link_text'] = 'kd_slider_link_text';
                return $columns;
            }

            //https://developer.wordpress.org/reference/functions/add_meta_box/
            // Metabox for link url and link text
            public function add_meta_boxes() {
                add_meta_box(
                    'kd_slider_meta_box',
                    'Link Options',
                    array( $this, 'add_inner_meta_boxes'),
                    'kd-slider',
                    'normal',
                    'high'
                );
            }
            public function add_inner_meta_boxes($post){
                require_once( KD_SLIDER_PATH . 'views/kd-slider_metabox.php');
            }

            // FORM and Validation
            public function save_post( $post_id ){
                // Make sure we receive inputs from specific form
                if( isset( $_POST['kd_slider_nonce'] ) ){
                    if( ! wp_verify_nonce( $_POST['kd_slider_nonce'], 'kd_slider_nonce' ) ){
                        return;
                    }
                }
                // Auto save content by wp
                if( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ){
                    return;
                }
                // Make sure only current user have access
                if( isset( $_POST['post_type'] ) && $_POST['post_type'] === 'kd-slider' ){
                    if( ! current_user_can( 'edit_page', $post_id ) ){
                        return;
                    }elseif( ! current_user_can( 'edit_post', $post_id ) ){
                        return;
                    }
                }
    
                if( isset( $_POST['action'] ) && $_POST['action'] == 'editpost' ){
                    $old_link_text = get_post_meta( $post_id, 'kd_slider_link_text', true );
                    $new_link_text = $_POST['kd_slider_link_text'];
                    $old_link_url = get_post_meta( $post_id, 'kd_slider_link_url', true );
                    $new_link_url = $_POST['kd_slider_link_url'];
    
                    if( empty( $new_link_text )){
                        update_post_meta( $post_id, 'kd_slider_link_text', 'Add some text' );
                    }else{
                        update_post_meta( $post_id, 'kd_slider_link_text', sanitize_text_field( $new_link_text ), $old_link_text );
                    }
    
                    if( empty( $new_link_url )){
                        update_post_meta( $post_id, 'kd_slider_link_url', '#' );
                    }else{
                        update_post_meta( $post_id, 'kd_slider_link_url', sanitize_text_field( $new_link_url ), $old_link_url );
                    }
                }
            }
    }
}