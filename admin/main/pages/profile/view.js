$(function () {
    $("#btn-select-image").click(function () {
        Func.SelectCropImage(1 / 1, function (base64) {
            // console.log(base64);
            $("#base64").val(base64);
            $("#image").attr("src", base64);
            Func.ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/edit.php",
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
                            Func.Reload();
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
    $("body").on("click", ".profile", function () {
        var src = $(this).attr("src");
        Func.ShowImage(src);
    });
});
