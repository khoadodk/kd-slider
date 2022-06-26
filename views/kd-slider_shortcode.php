<!-- <h3><?php echo (!empty($content)) ? esc_html($content ) : esc_html(KD_Slider_Settings::$options['kd_slider_title']); ?></h3> -->
<div class="kd-slider flexslider <?php echo (isset(KD_SLIDER_SETTINGS::$options['kd_slider_style'])) ? esc_attr(KD_SLIDER_SETTINGS::$options['kd_slider_style']) : 'style-1' ?>">
    <ul class="slides">

        <?php 
            $my_query = new WP_Query(array(
                'post_type' => 'kd-slider',
                'post_status' => 'publish',
                'post__in' => $id,
                'orderby' => $orderby
            ));

            if($my_query-> have_posts()){
                while ($my_query->have_posts()){
                    $my_query->the_post();

                    // Docs: https://developer.wordpress.org/reference/functions/get_post_meta/
                    $button_text = get_post_meta(get_the_ID(), 'kd_slider_link_text', true);
                    $button_url = get_post_meta(get_the_ID(), 'kd_slider_link_url', true);
                    ?>
                        <li class="container">
                            <?php 
                                if(has_post_thumbnail()){
                                    the_post_thumbnail('full', array('class'=> 'img-fluid' ));
                                }else {
                                    echo "<img src='" .KD_SLIDER_URL . "assets/images/default.jpg' class='img-fluid' />";
                                }
                            ?>
                            
                            <div class="wrapper">
                                <div class="slider-title">
                                    <h2><?php the_title() ?></h2>
                                </div>
                                <div class="slider-description">
                                    <div class="subtitle"><?php the_content() ?></div>
                                    <a href="<?php echo esc_attr($button_url) ?>" class="link"><?php echo esc_html($button_text) ?></a>
                                </div>
                            </div>
                            
                        </li>
                    <?php
                }
            }
        ?>
        <?php wp_reset_postdata() ?>
    </ul>
</div>