$(function () {
    $("title").html("บริการของเรา");
    $("#formdata").submit(function (e) {
        let phone = $("#phone").val().trim();
        if (phone == "" || phone.length != 10) {
            Func.ShowAlert({
                html: "กรุณาระบุเบอร์มือถือให้ถูกต้อง",
                type: "error",
                callback: function () { $("#phone").focus(); }
            });
            return;
        }
        e.preventDefault();
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-success">"ยืนยันการส่งข้อมูล"</span> ใช่หรือไม่ ?',
            type: "question",
            confirmButtonText: '<i class="fas fa-envelope me-1"></i> ยืนยันการส่งข้อมูล',
            confirmButtonColor: '#198754',
            cancelButtonText: '<i class="fa fa-times me-1"></i> ยกเลิก',
            cancelButtonColor: '#727272',
            callback: function (rs) {
                if (!rs) return;
                Func.ShowLoading();
                $.ajax({
                    type: "POST",
                    url: "pages/service_booking-add/api/service_booking-add.php",
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
                                    Func.LinkTo("./?page=history-detail&service_booking_id=" + res.service_booking_id);
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
            }
        });
    });
    $("#btn-submit").click(function () {
        $("#form-submit").trigger("click");
    });
    $("#btn-image").click(function () {
        var l = $(".images-section .image").length;
        if (l >= 4) {
            Func.ShowAlert({
                html: "คุณแนปรูปภาพเต็มจำนวนแล้ว",
                type: 'error'
            });
            return;
        }
        var $input = $('<input type="file" accept="image/*" class="d-none" multiple>');
        $input.bind("change", function () {
            Func.ShowLoading("กำลังอัพโหลดรูปภาพ");
            AddImage($(this)[0].files, 0);
        });
        $input.appendTo("body");
        $input.click();
    });
    function AddImage(files, idx) {
        var l = $(".images-section .image").length;
        if (l >= 4 || files.length == idx) {
            Func.HideLoading();
            return;
        }
        var $img = $(`
            <div class="col-6">
                <img src="" alt="Image" class="image">
                <a href="Javascript:" class="btn-del-image">
                    <i class="fas fa-times"></i>
                </a>
            </div>
        `);
        Func.GetBase64AndResize(files[idx], 1000, 1000, function (base64) {
            $.post("pages/service_booking-add/api/image-temp-add.php", {
                random_id: $("#random_id").val(),
                base64: base64
            }, function (res) {
                if (res.status == "ok") {
                    $img.find("img").attr("src", res.image);
                    $img.appendTo(".images-section");
                }
                AddImage(files, ++idx);
            }, "JSON").fail(function () {
                AddImage(files, ++idx);
            });
        });
    }
    $(".images-section").on("click", ".image", function () {
        var src = $(this).attr("src");
        var index = 0;
        var images = [];
        $.each($(".images-section .image"), function (i, v) {
            images.push($(this).attr("src"));
            if (src == $(this).attr("src")) index = i;
        });
        Func.ShowGalleryImage(index, images);
    });
    $(".images-section").on("click", ".btn-del-image", function (e) {
        e.preventDefault();
        var $i = $(this).closest(".col-6");
        var src = $i.find("img").attr("src");
        var arr = src.split("/");
        var filename = arr[arr.length - 1];
        Func.ShowConfirm({
            html: "ลบรูปนี้ไหม ?",
            callback: function (rs) {
                if (rs) {
                    Func.ShowLoading("กำลังลบรูปภาพ");
                    $.post("pages/service_booking-add/api/image-temp-del.php", {
                        random_id: $("#random_id").val(),
                        filename: filename
                    }, function (res) {
                        Func.HideLoading();
                        if (res.status == "ok") {
                            $i.remove();
                        }
                    }, "JSON").fail(function () {
                        Func.HideLoading();
                        Func.ShowAlert({
                            html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                            type: "error",
                            callback: function () { }
                        });
                    });
                }
            }
        });
    });
    if (document.referrer !== "") { $(".backbutton").show(); } else { $(".backbutton").hide(); }
});