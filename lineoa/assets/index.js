$(function () {
    var href = window.location.href;
    window.history.replaceState({}, '', href);
});