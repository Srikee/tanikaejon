$(function () {
    $("title").html("แบบฟอร์มลงทะเบียน");
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
        Func.ShowLoading();
        $.ajax({
            type: "POST",
            url: "pages/register/api/register.php",
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
                            Func.Back();
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
    });
    $(".profile-image").click(function () {
        var src = $(this).find("img").attr("src");
        Func.ShowImage(src, "Profile");
    });
});