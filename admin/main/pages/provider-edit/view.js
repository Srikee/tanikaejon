$(function () {
    var DATA = JSON.parse($("#data").val());
    LoadProvince($("#province_id"), DATA.province_id);
    LoadAmphur($("#amphur_id"), DATA.province_id, DATA.amphur_id);
    LoadTambol($("#tambol_id"), DATA.amphur_id, DATA.tambol_id);
    $("#province_id").change(function () {
        var province_id = $(this).val();
        if (province_id != "") {
            LoadAmphur($("#amphur_id"), province_id);
            $("#tambol_id").html('<option value="">เลือกตำบล</option>');
        } else {
            $("#amphur_id").html('<option value="">เลือกอำเภอ</option>');
            $("#tambol_id").html('<option value="">เลือกตำบล</option>');
        }
    });
    $("#amphur_id").change(function () {
        var amphur_id = $(this).val();
        if (amphur_id != "") {
            LoadTambol($("#tambol_id"), amphur_id);
        } else {
            $("#tambol_id").html('<option value="">เลือกตำบล</option>');
        }
    });
    $("#tambol_id").change(function () {
        var data = JSON.parse($(this).find("option:selected").attr("data-json"));
        $("#zipcode").val(data.zipcode);
    });
    $("#zipcode").val(DATA.zipcode);
    $("#btn-select-image").click(function () {
        Func.SelectCropImage(1 / 1, function (base64) {
            // console.log(base64);
            $("#base64").val(base64);
            $("#image").attr("src", base64);
        });
    });
    $("#formdata").submit(function (e) {
        e.preventDefault();
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
                        if (res.status == "ok") {
                            Func.LinkTo("./?page=provider");
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
    $("body").on("click", ".profile", function () {
        var src = $(this).attr("src");
        Func.ShowImage(src);
    });
});
