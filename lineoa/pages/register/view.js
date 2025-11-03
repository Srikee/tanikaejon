$(function () {
    $("title").html("แบบฟอร์มลงทะเบียน");
    $("#formdata").submit(function (e) {
        e.preventDefault();
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
});