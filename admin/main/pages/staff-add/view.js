$(function () {
    $("#formdata").submit(function (e) {
        e.preventDefault();
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
