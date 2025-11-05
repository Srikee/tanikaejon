$(function () {
    $("title").html("ติดตามผล");
    $(".subtext").click(function (e) {
        var service_booking_timeline_id = $(this).attr("data-id");
        var files = JSON.parse($(this).attr("data-json"));
        var images = [];
        $.each(files, function (i, v) {
            images.push("../files/service_booking_timeline/" + service_booking_timeline_id + "/" + v);
        });
        Func.ShowGalleryImage(0, images);
    });
    if (document.referrer !== "") { $(".backbutton").show(); } else { $(".backbutton").hide(); }
});