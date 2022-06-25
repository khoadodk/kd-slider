<?php 

if( ! class_exists( 'KD_Slider_Settings' )){
    class KD_Slider_Settings{
        // Docs: https://developer.wordpress.org/plugins/settings/options-api/
        public static $options;

        public function __construct(){
            self::$options = get_option( 'kd_slider_options' );
            add_action( 'admin_init', array( $this, 'admin_init') );
        }

        public function admin_init(){
            // Docs: https://developer.wordpress.org/reference/functions/register_setting/
            register_setting( 'kd_slider_group', 'kd_slider_options', array( $this, 'kd_slider_validate' ) );

            add_settings_section(
                'kd_slider_main_section',
                'How does it work?',
                null,
                'kd_slider_page1'
            );

            add_settings_section(
                'kd_slider_second_section',
                'Other Plugin Options',
                null,
                'kd_slider_page2'
            );

            add_settings_field(
                'kd_slider_shortcode',
                'Shortcode',
                array( $this, 'kd_slider_shortcode_callback' ),
                'kd_slider_page1',
                'kd_slider_main_section'
            );

            add_settings_field(
                'kd_slider_title',
                'Slider Title',
                array( $this, 'kd_slider_title_callback' ),
                'kd_slider_page2',
                'kd_slider_second_section',
                array(
                    'label_for' => 'kd_slider_title'
                )
            );

            add_settings_field(
                'kd_slider_bullets',
                'Display Bullets',
                array( $this, 'kd_slider_bullets_callback' ),
                'kd_slider_page2',
                'kd_slider_second_section',
                array(
                    'label_for' => 'kd_slider_bullets'
                )
            );

            add_settings_field(
                'kd_slider_style',
                'Slider Style',
                array( $this, 'kd_slider_style_callback' ),
                'kd_slider_page2',
                'kd_slider_second_section',
                array(
                    'items' => array(
                        'style-1',
                        'style-2'
                    ),
                    'label_for' => 'kd_slider_style'
                )
                
            );
        }

        public function kd_slider_shortcode_callback(){
            ?>
            <span>Use the shortcode [kd_slider] to display the slider in any page/post/widget</span>
            <?php
        }

        public function kd_slider_title_callback( $args ){
            ?>
                <input 
                type="text" 
                name="kd_slider_options[kd_slider_title]" 
                id="kd_slider_title"
                value="<?php echo isset( self::$options['kd_slider_title'] ) ? esc_attr( self::$options['kd_slider_title'] ) : ''; ?>"
                >
            <?php
        }
        
        public function kd_slider_bullets_callback( $args ){
            ?>
                <input 
                    type="checkbox"
                    name="kd_slider_options[kd_slider_bullets]"
                    id="kd_slider_bullets"
                    value="1"
                    <?php 
                        if( isset( self::$options['kd_slider_bullets'] ) ){
                            checked( "1", self::$options['kd_slider_bullets'], true );
                        }    
                    ?>
                />
                <label for="kd_slider_bullets">Whether to display bullets or not</label>
                
            <?php
        }

        public function kd_slider_style_callback( $args ){
            ?>
            <select 
                id="kd_slider_style" 
                name="kd_slider_options[kd_slider_style]">
                <?php 
                foreach( $args['items'] as $item ):
                ?>
                    <option value="<?php echo esc_attr( $item ); ?>" 
                        <?php 
                        isset( self::$options['kd_slider_style'] ) ? selected( $item, self::$options['kd_slider_style'], true ) : ''; 
                        ?>
                    >
                        <?php echo esc_html( ucfirst( $item ) ); ?>
                    </option>                
                <?php endforeach; ?>
            </select>
            <?php
        }

        public function kd_slider_validate( $input ){
            $new_input = array();
            foreach( $input as $key => $value ){
                switch ($key){
                    case 'kd_slider_title':
                        if( empty( $value )){
                            add_settings_error( 'kd_slider_options', 'kd_slider_message', 'The title field can not be left empty', 'error' );
                            $value = 'Please, type some text';
                        }
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                    default:
                        $new_input[$key] = sanitize_text_field( $value );
                    break;
                }
            }
            return $new_input;
        }

    }
}

