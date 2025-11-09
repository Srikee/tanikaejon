$(function () {
    $.each($("[data-datepicker]"), function (i, v) {
        Func.ToggleDatepicker($(this));
    });
    $.each($("[data-phone]"), function (i, v) {
        Func.TogglePhone($(this));
    });
    $.each($("[data-phone-home]"), function (i, v) {
        Func.TogglePhoneHome($(this));
    });
    $.each($("[data-select]"), function (i, v) {
        Func.ToggleSelect($(this));
    });
    $.each($("[data-input-number]"), function (i, v) {
        var digit = $(this).attr("data-input-number") || 2;
        Func.ToggleInputNumber($(this), digit);
    });
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
});

function LoadProvince($ctrlProvince, province_id = "", root = "../../") {
    $ctrlProvince.html('<option value="">เลือกจังหวัด</option>');
    $.ajax({
        type: "POST",
        url: root + "api/th-province-get.php",
        dataType: "JSON",
        success: function (res) {
            if (res.status == "ok") {
                $.each(res.data, function (i, item) {
                    var $option = $('<option>', {
                        value: item.province_id,
                        text: item.province_name_thai
                    });
                    $ctrlProvince.append($option);
                });
                if (province_id != "") {
                    $ctrlProvince.val(province_id);
                }
            }
        },
        error: function () { }
    });
}
function LoadAmphur($ctrlAmphure, province_id, amphur_id = "", root = "../../") {
    $ctrlAmphure.html('<option value="">เลือกอำเภอ</option>');
    $.ajax({
        type: "POST",
        url: root + "api/th-amphur-get.php",
        dataType: "JSON",
        data: {
            province_id: province_id
        },
        success: function (res) {
            if (res.status == "ok") {
                $.each(res.data, function (i, item) {
                    var $option = $('<option>', {
                        value: item.amphur_id,
                        text: item.amphur_name_thai
                    });
                    $ctrlAmphure.append($option);
                });
                if (amphur_id != "") {
                    $ctrlAmphure.val(amphur_id);
                }
            }
        },
        error: function () { }
    });
}
function LoadTambol($ctrTabol, amphur_id, tambol_id = "", root = "../../") {
    $ctrTabol.html('<option value="">เลือกตำบล</option>');
    $.ajax({
        type: "POST",
        url: root + "api/th-tambol-get.php",
        dataType: "JSON",
        data: {
            amphur_id: amphur_id
        },
        success: function (res) {
            if (res.status == "ok") {
                $.each(res.data, function (i, item) {
                    var $option = $('<option>', {
                        value: item.tambol_id,
                        text: item.tambol_name_thai
                    });
                    $option.attr("data-json", JSON.stringify(item));
                    $ctrTabol.append($option);
                });
                if (tambol_id != "") {
                    $ctrTabol.val(tambol_id);
                }
            }
        },
        error: function () { }
    });
}