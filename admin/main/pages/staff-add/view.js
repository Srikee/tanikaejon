$(function () {
    $('[show-password]').click(function () {
        var id = $(this).attr("show-password");
        var type = $("#" + id).attr("type");
        if (type == "password") {
            $("#" + id).attr("type", "text");
        } else {
            $("#" + id).attr("type", "password");
        }
        $(this).toggleClass("fa-eye fa-eye-slash");
    });
    $("#formdata").submit(function (e) {
        e.preventDefault();
        var password1 = $('#password1').val().trim();
        var password2 = $('#password2').val().trim();
        if (password1 != password2) {
            Func.ShowAlert({
                html: "ยืนยันรหัสผ่านไม่ถูกต้อง",
                type: "error",
                callback: function () {
                    $('#password2').focus().select();
                }
            });
            return;
        }
        Func.ShowLoading();
        $.ajax({
            type: "POST",
            url: "pages/" + PAGE + "/api/add.php",
            dataType: "JSON",
            data: Func.GetFormData('#formdata'),
            contentType: false,
            processData: false,
            success: function (res) {
                Func.HideLoading();
                Func.ShowAlert({
                    html: res.message,
                    type: (res.status == "ok") ? "success" : "error",
                    callback: function () {
                        if (res.status == "ok") {
                            Func.LinkTo("./?page=staff");
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
