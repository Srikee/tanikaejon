$(function () {
    $(".ks-toggle-menu").click(function () {
        $("body").toggleClass("ks-hide-menu");
    });
    $(".btn-open-submenu").click(function () {
        $(this).next(".ks-submenu").slideToggle(100);
        $(this).find(".ks-menu-icon-sub").toggleClass("fa-angle-right fa-angle-down");
    });
})