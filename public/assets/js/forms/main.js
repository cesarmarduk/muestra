/*----------------------------------------------
*
* [Main Scripts]
*
* Theme    : Leverage
* Version  : 1.1.0
* Author   : Codings
* Support  : adm.codings@gmail.com
* 
----------------------------------------------*/

/*----------------------------------------------

[ALL CONTENTS]

1. Preloader
2. Responsive Menu
3. Navigation 
4. Slides 
5. Sign and Register Form
6. Multi-Step Form 
7. Simple Form
8. Recaptcha

----------------------------------------------*/

/*----------------------------------------------
4. Slides
----------------------------------------------*/

jQuery(function ($) {

    setTimeout(function() {
        $('.no-slider .left').addClass('init');
        $('.no-slider .right').addClass('init');
    }, 1200)

    var animation = function(slider) {

        let image = $(slider + ' .swiper-slide-active img');
        let title = $(slider + ' .title');
        let description = $(slider + ' .description');
        let btn = $(slider + ' .btn');
        let nav = $(slider + ' nav');

        image.toggleClass('aos-animate');
        title.toggleClass('aos-animate');
        description.toggleClass('aos-animate');
        btn.toggleClass('aos-animate');
        nav.toggleClass('aos-animate');

        setTimeout(function() {
            image.toggleClass('aos-animate');
            title.toggleClass('aos-animate');
            description.toggleClass('aos-animate');
            btn.toggleClass('aos-animate');
            nav.toggleClass('aos-animate');

            AOS.refresh();

        }, 100)

        if ($('.full-slider').hasClass('animation')) {

            $('.full-slider .left').addClass('off');
            $('.full-slider .left').removeClass('init');
            $('.full-slider .right').addClass('off');
            $('.full-slider .right').removeClass('init');

            setTimeout(function() {
                $('.full-slider .left').removeClass('off');
                $('.full-slider .right').removeClass('off');
            }, 200)

            setTimeout(function() {
                $('.full-slider .left').addClass('init');
                $('.full-slider .right').addClass('init');
            }, 1000)

        } else {
            $('.full-slider .left').addClass('init');
            $('.full-slider .right').addClass('init');
        }
    }

    var fullSlider = new Swiper('.full-slider', {

        autoplay: {
            delay: 10000,
        },
        loop: false,
        slidesPerView: 1,
        spaceBetween: 0,
        navigation: false,
        pagination: {
            el: '.full-slider .swiper-pagination',
            clickable: true
        },
        keyboard: {
            enabled: true,
            onlyInViewport: false
        },
        on: {
            init: function() {
                animation('.full-slider');
                let pagination = $('.full-slider .swiper-pagination');
                pagination.hide();

                setTimeout(function() {
                    pagination.show();
                }, 2000)

            },
            slideChange: function() {
                animation('.full-slider')
            }
        }
    })

    $('.mid-slider').each(function() {

        if($(this).data('perview')) {
            var midPerView = $(this).data('perview');
        } else {
            midPerView = 3;
        }

        var midSlider = new Swiper(this, {

            autoplay: false,
            loop: true,
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                767: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                1023: {
                    slidesPerView: midPerView,
                    spaceBetween: 30
                }
            },
            pagination: {
                el: '.mid-slider .swiper-pagination',
                clickable: true
            }
        })
    })

    $('.mid-slider-simple').each(function() {

        if($(this).data('perview')) {
            var midSimplePerView = $(this).data('perview');
        } else {
            midSimplePerView = 3;
        }

        var midSliderSimple = new Swiper(this, {

            autoplay: false,
            loop: false,
            centerInsufficientSlides: true,
            slidesPerView: 1,
            spaceBetween: 30,
            breakpoints: {
                767: {
                    slidesPerView: 2,
                    spaceBetween: 30
                },
                1023: {
                    slidesPerView: midSimplePerView,
                    spaceBetween: 30
                }
            },
            pagination: {
                el: '.mid-slider-simple .swiper-pagination',
                clickable: true
            }
        })
    })

    var minSlider = new Swiper('.min-slider', {
        autoplay: {
            delay: 5000,
        },
        loop: false,
        centerInsufficientSlides: true,
        slidesPerView: 2,
        spaceBetween: 15,
        breakpoints: {
            424: {
                slidesPerView: 2,
                spaceBetween: 15
            },
            767: {
                slidesPerView: 3,
                spaceBetween: 15
            },
            1023: {
                slidesPerView: 4,
                spaceBetween: 15
            },
            1199: {
                slidesPerView: 5,
                spaceBetween: 15
            }
        },
        pagination: false,
    })

    var noSlider = new Swiper('.no-slider', {

        autoplay: false,
        loop: false,
        keyboard: false,
        grabCursor: false,
        allowTouchMove: false,
        on: {
            init: function() {
                animation('.no-slider')
            }
        }
    })
})

/*----------------------------------------------
6. Multi-Step Form
----------------------------------------------*/

$(function() {
    'use strict';

    var current_fs, next_fs, previous_fs;
    var left, opacity, scale;
    var animating;

    function next(button, group, show, hide) {

        $(document).on('click', button, function () {
            animating = true;

            current_fs = $(this).parents().eq(1);
            next_fs = $(this).parents().eq(1).next();
            $('.multi-step-form .progressbar li').eq($('fieldset').index(next_fs)).addClass('active');
            next_fs.show();

            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {
                    scale = 1 - (1 - now) * 0.2;
                    left = (now * 50) + '%';
                    opacity = 1 - now;

                    current_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'position': 'absolute'
                    })

                    next_fs.css({
                        'left': left,
                        'opacity': opacity
                    })
                },
                duration: 600,
                complete: function () {
                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            })

            $(hide).hide();
            $(show).show();
        })
    }   

    // Progressbar
    $('.multi-step-form .progressbar li').first().addClass('active');

    $('.multi-step-form .progressbar li').each(function(index) {
        $('.multi-step-form').attr('data-steps', (index+1));
    })

    // Step Image [ID]
    $('.multi-step-form .step-image').each(function(index) {
        $(this).attr('id', 'step-image-'+(index+1));

        if(index) {
            $('#step-image-2, #step-image-3, #step-image-4').hide(); 
        }
    })

    // Step Title [ID]
    $('.multi-step-form .step-title').each(function(index) {
        $(this).attr('id', 'step-title-'+(index+1));

        if(index) {
            $('#step-title-2, #step-title-3').hide(); 
        }
    })

    // Step Group [ID]
    $('.multi-step-form .step-group').each(function(index) {
        $(this).attr('id', 'step-group-'+(index+1));
    })

    // Step Next [ID]
    $('.multi-step-form .step-next').each(function(index) {
        $(this).attr('id', 'step-next-'+(index+1));
    })
    
    // Step Prev [ID]
    $('.multi-step-form .step-prev').each(function(index) {
        $(this).attr('id', 'step-prev-'+(index+2));
    })

    next('#step-next-1', '#step-group-1', '#step-image-2, #step-title-2', '#step-image-1, #step-title-1');
    next('#step-next-2', '#step-group-2', '#step-image-3, #step-title-3', '#step-image-2, #step-title-2');
    next('#step-next-3', '#step-group-3', '#step-image-4', '#step-image-3');

    function prev(button, show, hide) {

        $(document).on('click', button, function () {

            if (animating) return false;
            animating = true;

            current_fs = $(this).parents().eq(1);
            previous_fs = $(this).parents().eq(1).prev();

            $('.multi-step-form .progressbar li').eq($('fieldset').index(current_fs)).removeClass('active');

            previous_fs.show();
            current_fs.animate({
                opacity: 0
            }, {
                step: function (now, mx) {

                    scale = 0.8 + (1 - now) * 0.2;
                    left = ((1 - now) * 50) + '%';
                    opacity = 1 - now;

                    current_fs.css({
                        'left': left
                    })

                    previous_fs.css({
                        'transform': 'scale(' + scale + ')',
                        'opacity': opacity
                    })
                },
                duration: 600,
                complete: function () {

                    current_fs.hide();
                    animating = false;
                },
                easing: 'easeInOutBack'
            })

            $(hide).hide();
            $(show).show();

            if (button == '#step-prev-3') {
                $('.multi-step-form .progressbar').removeClass('complete');
            }
        })
    }

    prev('#step-prev-2', '#step-image-1, #step-title-1', '#step-image-2, #step-title-2');
    prev('#step-prev-3', '#step-image-2, #step-title-2', '#step-image-3, #step-title-3');
});