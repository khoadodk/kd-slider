<h3><?php echo (!empty($content)) ? esc_html($content ) : esc_html(KD_Slider_Settings::$options['kd_slider_title']); ?></h3>
<div class="kd-slider flexslider">
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
                        <li>
                            <?php the_post_thumbnail('full', array('class'=> 'img-fluid' )) ?>
                            <div class="kd-container">
                                <div class="slider-details-container">
                                    <div class="wrapper">
                                        <div class="slider-title">
                                            <h2><?php the_title() ?></h2>
                                        </div>
                                        <div class="slider-description">
                                            <div class="subtitle"><?php the_content() ?></div>
                                            <a href="<?php echo esc_attr($button_url) ?>" class="link"><?php echo esc_html($button_text) ?></a>
                                        </div>
                                    </div>
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