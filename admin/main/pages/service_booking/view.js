$(function () {
    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            Func.LinkTo("./?page=" + PAGE + "&search=" + $("#search").val());
        }
    });
    $(".btn-del").click(function () {
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        var service_booking_id = data.service_booking_id;
        Del(service_booking_id)
    });
    function Del(service_booking_id) {
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-danger">"ลบข้อมูล"</span> ใช่หรือไม่ ?',
            confirmButtonText: '<i class="fas fa-trash me-2"></i> ยืนยันการลบ',
            cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            callback: function (rs) {
                if (rs) {
                    var formData = new FormData();
                    formData.append("service_booking_id", service_booking_id);
                    Func.ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/del.php",
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Func.HideLoading();
                            if (res.status == 'no') {
                                Func.ShowAlert({
                                    html: res.message,
                                    type: "error",
                                    callback: function () {
                                        Func.Reload();
                                    }
                                });
                            } else {
                                Func.Reload();
                            }
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
            },
        });
    }
    $("body").on("click", ".image", function () {
        var src = $(this).attr("src");
        var index = 0;
        var images = [];
        $.each($("body .image"), function (i, v) {
            images.push($(this).attr("src"));
            if (src == $(this).attr("src")) index = i;
        });
        // console.log(images)
        Func.ShowGalleryImage(index, images);
    });
});