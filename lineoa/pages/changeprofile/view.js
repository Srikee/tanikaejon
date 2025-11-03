$(function () {
    $("title").html("แก้ไขโปรไฟล์ของฉัน");
    $("#formdata").submit(function (e) {
        e.preventDefault();
        let phone = $("#phone").val().trim();
        if (phone == "" || phone.length != 10) {
            Func.ShowAlert({
                html: "กรุณาระบุเบอร์มือถือให้ถูกต้อง",
                type: "error",
                callback: function () { $("#phone").focus(); }
            });
            return;
        }
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-success">"ยืนยันการเปลี่ยนโปรไฟล์"</span> ใช่หรือไม่ ?',
            type: "question",
            confirmButtonText: '<i class="fa-solid fa-pen me-1"></i> ยืนยันการเปลี่ยนโปรไฟล์',
            confirmButtonColor: '#198754',
            cancelButtonText: '<i class="fa fa-times me-1"></i> ยกเลิก',
            cancelButtonColor: '#727272',
            callback: function (rs) {
                if (!rs) return;
                Func.ShowLoading();
                $.ajax({
                    type: "POST",
                    url: "pages/changeprofile/api/changeprofile.php",
                    dataType: "JSON",
                    data: Func.GetFormData($("#formdata")), // ดึงข้อมูลภายใน #formdata ที่มี Tag name
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
    $(".profile-image").click(function () {
        var src = $(this).find("img").attr("src");
        Func.ShowImage(src, "Profile");
    });
});