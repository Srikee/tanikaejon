$(function () {
    $("title").html("รายละเอียดบริการ");

    // function GetService() {
    //     // $("#service").html("");
    //     ShowLoading();
    //     $.ajax({
    //         type: "POST",
    //         url: "pages/service/api/service.php",
    //         // dataType: "JSON",
    //         data: {
    //             search: $("#search").val()
    //         },
    //         // contentType: false,
    //         // processData: false,
    //         success: function (html) {
    //             HideLoading();
    //             $("#service").html(html);
    //         },
    //         error: function () {
    //             HideLoading();
    //             Func.ShowAlert({
    //                 html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
    //                 type: "error",
    //                 callback: function () { }
    //             });
    //         }
    //     });
    // }
    // GetService();
    // $("#search").keyup(function () {
    //     GetService();
    // });
    $(".images-section").on("click", ".image", function () {
        var src = $(this).attr("src");
        var index = 0;
        var images = [];
        $.each($(this).closest(".images-section").find(".image"), function (i, v) {
            images.push($(this).attr("src"));
            if (src == $(this).attr("src")) index = i;
        });
        Func.ShowGalleryImage(index, images);
    });
    if (document.referrer !== "") { $(".backbutton").show(); } else { $(".backbutton").hide(); }
});