$(function () {
    $("title").html("โปรดเข้าสู่ระบบ");
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
            html: 'คุณต้องการ <span class="text-danger">"ส่งข้อมูล"</span> ใช่หรือไม่ ?',
            type: "question",
            confirmButtonText: '<i class="fa-solid fa-envelope me-1"></i> ส่งข้อมูล',
            confirmButtonColor: '#2b8f42ff',
            cancelButtonText: '<i class="fa fa-times me-1"></i> ยกเลิก',
            cancelButtonColor: '#727272',
            callback: function (rs) {
                if (!rs) return;
                Func.ShowLoading("กำลังส่งข้อมูล...");
                $.ajax({
                    type: "POST",
                    url: "pages/forgot/api/forgot.php",
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
});