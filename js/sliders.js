$(document).ready(function () {
    // Mobile nav menu hamburger slider
    $(".nav-hamburger-menu").on("click", function(){
        $(".nav-hamburger-container").removeClass("hidden");
        $(".nav-hamburger-container").addClass("show");
    });

    $(".nav-hamburger-close").on("click", function(){
        $(".nav-hamburger-container").addClass("hidden");
        $(".nav-hamburger-container").removeClass("show");

    });


    // Logout link slider
    $(".user").hover(function(){
        $('.logout').removeClass("hidden");
        $(".logout").addClass("show-logout");

    });

});