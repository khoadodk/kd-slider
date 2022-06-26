<div class="wrap">
    <h1><?php echo esc_html( get_admin_page_title() ); ?></h1>

    <!-- Check for active tab -->
    <?php
        $active_tab = isset($_GET['tab']) ? $_GET['tab'] : 'main_options';
    ?>

    <h2 class="nav-tab-wrapper">
        <a href="?page=kd_slider_admin&tab=main_options" class="nav-tab <?php $active_tab == 'main_options' ? 'nav-tab-active' : '' ?>">Main Options</a>
        <a href="?page=kd_slider_admin&tab=additional_options" class="nav-tab <?php $active_tab == 'additional_options' ? 'nav-tab-active' : '' ?>">Additional Options</a>
    </h2>


    <form action="options.php" method="post">
    <?php 
        if($active_tab == 'main_options') {
            settings_fields( 'kd_slider_group' ); // var from class.kd-slider-settings.php
            do_settings_sections( 'kd_slider_page1' ); // var from class.kd-slider-settings.php
        }else {
            settings_fields( 'kd_slider_group' ); // var from class.kd-slider-settings.php
            do_settings_sections( 'kd_slider_page2' ); // var from class.kd-slider-settings.php
        }
        
        submit_button( 'Save Settings' );
    ?>
    </form>
</div>