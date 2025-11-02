$(function () {
    $("title").html("แบบฟอร์มลงทะเบียน");
    $("#btn-submit").attr("disabled", "disabled");
    $("#check-pdpa").click(function () {
        var check = $(this).prop("checked");
        if (check) {
            $("#btn-submit").removeAttr("disabled");
        } else {
            $("#btn-submit").attr("disabled", "disabled");
        }
    });
    $("#formdata").submit(function (e) {
        e.preventDefault();
        // ShowLoading();
        Func.ShowAlert({
            html: "AAAA",
            type: "error"
        });
        return;
        $.post("pages/login/api/login.php", {
            username: $("#username").val(),
            password: $("#password").val(),
            userId: USER["userId"],
            displayName: USER["displayName"],
            email: USER["email"],
            pictureUrl: USER["pictureUrl"],
        }, function (res) {
            HideLoading();
            if (res.status == "ok") {
                location.reload();
            } else {
                Func.ShowAlert({
                    html: res.message,
                    type: "error"
                });
            }
        }, 'JSON').fail(function (err) {
            HideLoading();
            Func.ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error"
            });
        });
    });
});