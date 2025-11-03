$(function () {
    $("title").html("โปรดเข้าสู่ระบบ");
    $("#formdata").submit(function (e) {
        e.preventDefault();
        Func.ShowLoading("กำลังเข้าสู่ระบบ...");
        $.post("pages/forgot/api/forgot.php", {
            username: $("#username").val(),
            password: $("#password").val(),
            userId: USER["userId"],
            displayName: USER["displayName"],
            email: USER["email"],
            pictureUrl: USER["pictureUrl"],
        }, function (res) {
            Func.HideLoading();
            if (res.status == "ok") {
                location.reload();
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
                type: "error"
            });
        });
    });
});