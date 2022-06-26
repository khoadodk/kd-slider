jQuery(window).load(function() {
    jQuery('.flexslider').flexslider({
        animation: 'slide',
        touch: true,
        directionNav: true, 
        smoothHeight: true,
        controlNav: SLIDER_OPTIONS.controlNav
    });
});