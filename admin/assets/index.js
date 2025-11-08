$(function () {
    var href = window.location.href;
    window.history.replaceState({}, '', href);

    $(".ks-toggle-menu").click(function () {
        $("body").toggleClass("ks-hide-menu");
    });
    $(".btn-open-submenu").click(function () {
        $(this).next(".ks-submenu").slideToggle(100);
        $(this).find(".ks-menu-icon-sub").toggleClass("fa-angle-right fa-angle-down");
    });
    const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
    const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl));
})