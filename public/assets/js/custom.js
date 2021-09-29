$(function () {
    'use strict';
    // ______________LOADER
    $("#global-loader").fadeOut(2000);

    $(window).on("scroll", function (e) {
        if ($(this).scrollTop() > 150) {
            $('.back-to-top').addClass('fade-in');
        } else {
            $('.back-to-top').removeClass('fade-in');
        }
    });

    $(".back-to-top").on("click", function (e) {
        $("html, body").animate({
            scrollTop: 0
        }, 600);
        return false;
    });
});