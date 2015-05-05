(jQuery)(function($) {
    /* ================ MAIN NAVIGATION ================ */

    (function() {
        $(" #nav ul ").css({
            display: "none"
        }); // Opera Fix
        $(" #nav li").hover(function() {
            $(this).find('ul:first').css({
                visibility: "visible",
                display: "none"
            }).fadeIn(300);
        }, function() {
            $(this).find('ul:first').css({
                display: "none"
            });
        });
    })();

    $(function() {
        $('#dl-menu').dlmenu({
            animationClasses: {
                classin: 'dl-animate-in-2',
                classout: 'dl-animate-out-2'
            }
        });
    });

    /* ================ STATIC HEADER ================ */

    var window_y;
    var header_height;
    var scroll_position;


    (function() {
        window_y = 0;
        header_height = $("#header-wrapper").height();
        scroll_position = parseInt(header_height, 10);
        window_y = $(document).scrollTop();
        if ((window_y > 0) && !(is_touch_device())) {
            set_static_header(1);
        }
    })(window_y, header_height, scroll_position);

    function set_static_header(position) {

        if (PiElvyre.staticHeader != '1')
            return;

        if (position > 0) {
            if (!($("#header-wrapper").hasClass("static"))) {
                $("#header-wrapper").addClass("static");

                // check if admin bar is enabled and 
                // add top margin to push header down
                if ($('body').hasClass('admin-bar')) {
                    var adminBar = $('#wpadminbar').height();
                    $("#header-wrapper").css("margin-top", adminBar + "px");
                }

                // calculate header height
                header_height = $("#header-wrapper").height();

                // check if user is on homepage
                if ($('body').hasClass('homepage')) {
                    $('.rs-wrapper').css("margin-top", header_height + "px");
                } else {
                    $("#page-title").eq(0).css("margin-top", header_height + "px");
                }
            }

        } else {
            if (($("#header-wrapper").hasClass("static"))) {

                // remove static class
                $("#header-wrapper").removeClass("static");

                // remove top margin
                if ($('body').hasClass('admin-bar')) {
                    $("#header-wrapper").css("margin-top", "0px");
                }

                // check if user is on homepage
                if ($('body').hasClass('homepage')) {
                    $('.rs-wrapper').css("margin-top", "");
                } else {
                    $("#page-title").eq(0).css("margin-top", "");
                }
                $("#header-wrapper").css("top", 0);
            }
        }

    }

    $(window).scroll(function(event) {
        if (!is_touch_device() && $(window).scrollTop() > 0) {
            set_static_header(1);
        } else {
            set_static_header(0);
        }

    });


    /* ========== MAIN SEARCH ======== */
    $('#header').on('click', '#search', function(e) {
        e.preventDefault();

        $(this).find('#m_search').fadeIn().focus();
    });

    $('#m_search').focusout(function(e) {
        $(e.target).fadeOut();
    });

    (function() {

        /* ================ PLACEHOLDER PLUGIN ================ */
        $('input[placeholder], textarea[placeholder]').placeholder();
    })();

    /* ================ SCROLL TO TOP ================ */

    $(window).scroll(function() {
        if ($(this).scrollTop() > 100) {
            $('.scroll-up').fadeIn();
        } else {
            $('.scroll-up').fadeOut();
        }
    });

    $('.scroll-up').click(function() {
        $("html, body").animate({
            scrollTop: 0
        }, 600, function() {
            set_static_header(0);
        });
        return false;
    });


    // NEWSLETTER FORM AJAX SUBMIT
    $('.newsletter .submit').on('click', function(event) {
        event.preventDefault();
        var email = $(this).siblings('.email').val();
        var form_data = new Array({'Email': email});
        $.ajax({
            type: 'POST',
            url: "contact.php",
            data: ({'action': 'newsletter', 'form_data': form_data})
        }).done(function(data) {
            alert(data);
        });
    });


    // function to check is user is on touch device
    if (!is_touch_device()) {
        if (PiElvyre.parallax == '1') {
            // ANIMATION FOR CONTENT
            $.stellar({
                horizontalOffset: 0,
                horizontalScrolling: false
            });
        }


        /* ================ ANIMATED CONTENT ================ */
        if ($(".animated")[0]) {
            jQuery('.animated').css('opacity', '0');
        }

        $('.triggerAnimation').waypoint(function() {
            var animation = $(this).attr('data-animate');
            $(this).css('opacity', '');
            $(this).addClass("animated " + animation);

        },
                {
                    offset: '80%',
                    triggerOnce: true
                }
        );

    }

    // function to check is user is on touch device
    function is_touch_device() {
        return Modernizr.touch;
    }
});

// retina test
(function() {

    // check if device pixel ratio cookie is set
    if (!PiFrameworkFunctions.readCookie('elv_device_pixel_ratio')
            && 'devicePixelRatio' in window
            && window.devicePixelRatio > 1
            && PiElvyre.retina == '1') {

        // create cookie
        PiFrameworkFunctions.createCookie('elv_device_pixel_ratio', '2', 7);

        // reload the page
        window.location.reload();

    } else if (PiFrameworkFunctions.readCookie('elv_device_pixel_ratio') && window.devicePixelRatio == 1) {
       
        // remove the cookie
        PiFrameworkFunctions.eraseCookie('elv_device_pixel_ratio');
        
        // reload the page
        window.location.reload();
    }
})();

// This function is called from content-audio.php
function pi_audio_post_init(encodedUrls, swfPath) {
    jQuery("#jquery_jplayer_1").jPlayer({
        ready: function() {
            jQuery(this).jPlayer("setMedia", encodedUrls);
        },
        swfPath: swfPath,
        supplied: "m4a, oga",
        wmode: "window"
    });
}

// This function is called from content-gallery.php
function pi_gallery_post_slider(manualAdvance, pauseTime) {
    jQuery('.blog-slider').nivoSlider({
        controlNav: false,
        manualAdvance: manualAdvance,
        pauseTime: pauseTime
    });
}