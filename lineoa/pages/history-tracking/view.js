$(function () {
    $("title").html("ติดตามผล");
    $("#btn-logout").click(function (e) {
        e.preventDefault();
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-danger">"ออกจากระบบ"</span> ใช่หรือไม่ ?',
            type: "question",
            confirmButtonText: '<i class="fa-solid fa-right-from-bracket me-1"></i> ออกจากระบบ',
            confirmButtonColor: '#b93737',
            cancelButtonText: '<i class="fa fa-times me-1"></i> ยกเลิก',
            cancelButtonColor: '#727272',
            callback: function (rs) {
                if (!rs) return;
                Func.ShowLoading();
                $.ajax({
                    type: "POST",
                    url: "pages/profile/api/logout.php",
                    dataType: "JSON",
                    // data: Func.GetFormData($("#formdata")), // ดึงข้อมูลภายใน #formdata ที่มี Tag name
                    contentType: false,
                    processData: false,
                    success: function (res) {
                        Func.HideLoading();
                        Func.ShowAlert({
                            html: res.message,
                            type: (res.status == "ok") ? "success" : "error",
                            callback: function () {
                                if (res.status == "ok") {
                                    Func.Reload();
                                }
                            }
                        });
                    },
                    error: function () {
                        Func.HideLoading();
                        Func.ShowAlert({
                            html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                            type: "error",
                            callback: function () {
                                Func.Reload();
                            }
                        });
                    }
                });
            }
        });
    });
    $(".images-section").on("click", ".image", function () {
        var src = $(this).attr("src");
        var index = 0;
        var images = [];
        $.each($(".images-section .image"), function (i, v) {
            images.push($(this).attr("src"));
            if (src == $(this).attr("src")) index = i;
        });
        Func.ShowGalleryImage(index, images);
    });
    if (document.referrer !== "") { $(".backbutton").show(); } else { $(".backbutton").hide(); }
});