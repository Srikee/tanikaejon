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
    $("#btn-provider-call").click(function (e) {
        var phone = $(this).attr("data-phone");
        var popup;
        var $contents = $(`
            <div>
                <a href="tel:`+ phone + `" type="button" class="btn btn-lg btn-outline-success w-100">` + phone + `</a>
                <button type="button" class="btn btn-lg btn-outline-danger w-100 btn-cancel">ปิด</button>
            </div>
        `);
        $contents.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        popup = new jBox('Modal', {
            content: $contents,
            width: "300px",
            height: "auto",
            draggable: 'title',
            overlay: true,
            zIndex: 201,  // default=10000
            addClass: 'provider-popup',
            onOpen: function () { },
            closeButton: false,
            onClose: function () {
                setTimeout(function () {
                    popup.destroy();
                }, 100);
            }
        });
        popup.open();
    });
    if (document.referrer !== "") { $(".backbutton").show(); } else { $(".backbutton").hide(); }
});