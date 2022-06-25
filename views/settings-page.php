<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>
    <form action="options.php" method="post">
    <?php 
        settings_fields( 'kd_slider_group' ); // var from class.kd-slider-settings.php
        do_settings_sections( 'kd_slider_page1' ); // var from class.kd-slider-settings.php
        do_settings_sections( 'kd_slider_page2' ); // var from class.kd-slider-settings.php
        submit_button( 'Save Settings' );
    ?>
    </form>
</div>