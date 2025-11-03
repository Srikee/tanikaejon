$(function () {
    $("title").html("โปรดเข้าสู่ระบบ");
    $("#formdata").submit(function (e) {
        e.preventDefault();
        Func.ShowLoading("กำลังเข้าสู่ระบบ...");
        $.post("pages/login/api/login.php", {
            phone: $("#phone").val(),
            password: $("#password").val(),
        }, function (res) {
            Func.HideLoading();
            if (res.status == "ok") {
                Func.Reload();
            } else {
                Func.ShowAlert({
                    html: res.message,
                    type: "error"
                });
            }
        }, 'JSON').fail(function (err) {
            Func.HideLoading();
            Func.ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error",
                callback: function () {
                    Func.Reload();
                }
            });
        });
    });
});