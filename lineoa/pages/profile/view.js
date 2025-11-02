$(function () {
    $("title").html("โปรไฟล์ของฉัน");
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
        ShowLoading();
        $.post("pages/login/login.php", {
            username: $("#username").val(),
            password: $("#password").val(),
            userId: USER["userId"],
            displayName: USER["displayName"],
            email: USER["email"],
            pictureUrl: USER["pictureUrl"],
        }, function (res) {
            HideLoading();
            if (res.status) {
                location.reload();
                // ShowAlert({
                //     html: res.message,
                //     type: "success",
                //     callback: function () {
                //         location.reload();
                //     }
                // });
            } else {
                ShowAlert({
                    html: res.message,
                    type: "error"
                });
            }
        }, 'JSON').fail(function (err) {
            HideLoading();
            ShowAlert({
                html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                type: "error"
            });
        });
    });
});