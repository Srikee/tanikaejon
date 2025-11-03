$(function () {
    $("title").html("เปลี่ยนรหัสผ่าน");
    $("#formdata").submit(function (e) {
        e.preventDefault();
        let password1 = $("#password1").val().trim();
        let password2 = $("#password2").val().trim();
        let password3 = $("#password3").val().trim();
        if (password1 == "") {
            Func.ShowAlert({
                html: "กรุณาระบุรหัสผ่านเดิม",
                type: "error",
                callback: function () { $("#password1").focus(); }
            });
            return;
        }
        if (password2 == "") {
            Func.ShowAlert({
                html: "กรุณาระบุรหัสผ่านใหม่",
                type: "error",
                callback: function () { $("#password2").focus(); }
            });
            return;
        }
        if (password2 != password3) {
            Func.ShowAlert({
                html: "ยืนยันรหัสผ่านไม่ถูกต้อง",
                type: "error",
                callback: function () { $("#password3").focus(); }
            });
            return;
        }
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-success">"ยืนยันการเปลี่ยนรหัสผ่าน"</span> ใช่หรือไม่ ?',
            type: "question",
            confirmButtonText: '<i class="fa-solid fa-pen me-1"></i> ยืนยันการเปลี่ยนรหัสผ่าน',
            confirmButtonColor: '#198754',
            cancelButtonText: '<i class="fa fa-times me-1"></i> ยกเลิก',
            cancelButtonColor: '#727272',
            callback: function (rs) {
                if (!rs) return;
                Func.ShowLoading();
                $.ajax({
                    type: "POST",
                    url: "pages/changepass/api/changepass.php",
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