$(function () {
    var service_booking_id = $("#service_booking_id").val();
    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            Func.LinkTo("./?page=" + PAGE + "&search=" + $("#search").val());
        }
    });
    $(".btn-del").click(function () {
        var data = JSON.parse($(this).closest("tr").attr("data-json"));
        var service_booking_id = data.service_booking_id;
        Del(service_booking_id)
    });
    function Del(service_booking_id) {
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-danger">"ลบข้อมูล"</span> ใช่หรือไม่ ?',
            confirmButtonText: '<i class="fas fa-trash me-2"></i> ยืนยันการลบ',
            cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            callback: function (rs) {
                if (rs) {
                    var formData = new FormData();
                    formData.append("service_booking_id", service_booking_id);
                    Func.ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/del.php",
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Func.HideLoading();
                            if (res.status == 'no') {
                                Func.ShowAlert({
                                    html: res.message,
                                    type: "error",
                                    callback: function () {
                                        Func.Reload();
                                    }
                                });
                            } else {
                                Func.Reload();
                            }
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
            },
        });
    }
    $(".btn-view").click(function () {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        var popup;
        var $title = $(`
            <div>
                <i class="fa-solid fa-user-check me-1"></i> รายละเอียดข้อมูลผู้ขอใช้บริการ
            </div>
        `);
        var $contents = $(`<div></div>`);
        Func.ShowLoading();
        $.post("pages/" + PAGE + "/api/get-detail.php", {
            service_booking_id: data.service_booking_id
        }, function (html) {
            Func.HideLoading();
            $contents.html(html);
            $(window).trigger('resize');
        }).fail(function () {
            Func.HideLoading();
        });
        var $footer = $(`
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-danger btn-del"><i class="fas fa-trash me-1"></i> ลบข้อมูล</button>
                </div>
                <div class="col text-end">
                    <button class="btn btn-light btn-cancel"><i class="fas fa-times me-1"></i> ปิดหน้าจอ</button>
                </div>
            </div>
        `);
        $footer.find('.btn-del').click(function (event) {
            Del(data.service_booking_id);
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        popup = new jBox('Modal', {
            title: $title,
            content: $contents,
            footer: $footer,
            width: "800px",
            height: "auto",
            draggable: 'title',
            overlay: true,
            zIndex: 101,  // default=10000
            onOpen: function () {
                // เมื่อเปิด Popup
            },
            onClose: function () {
                setTimeout(function () {
                    popup.destroy();
                }, 100);
            }
        });
        popup.open();
    });
    $("body").on("click", ".image", function () {
        var $images_section = $(this).closest(".images-section");
        var src = $(this).attr("src");
        var index = 0;
        var images = [];
        $.each($images_section.find(".image"), function (i, v) {
            images.push($(this).attr("src"));
            if (src == $(this).attr("src")) index = i;
        });
        // console.log(images)
        Func.ShowGalleryImage(index, images);
    });


    $("#btn-update-process").click(function () {
        var random_id = Func.GenerateRandom(10);
        var popup;
        var $title = $(`
            <div>
                <i class="fa-solid fa-clock-rotate-left me-1"></i> บันทึกผลการดำเนินงาน
            </div>
        `);
        var $contents = $(`
            <div>
                <form>
                    <input type="submit" class="d-none">
                    <input type="hidden" name="random_id" value="`+ random_id + `">
                    <input type="hidden" name="service_booking_id" value="`+ service_booking_id + `">
                    <div class="mb-3">
                        <label for="timeline_desc" class="form-label">
                            รายละเอียดการดำเนินงาน <span class="text-danger">*</span>
                        </label>
                        <textarea class="form-control" id="timeline_desc" name="timeline_desc" rows="5" required></textarea>
                    </div>
                    <div class="row mb-3 images-section"></div>
                </form>
            </div>
        `);
        var $footer = $(`
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-light me-2 btn-image"><i class="fas fa-images me-1"></i> แนปรูปภาพ</button>
                    <button class="btn btn-info me-2 btn-submit"><i class="fas fa-clock-rotate-left me-1"></i> บันทึกผลการดำเนินงาน</button>
                </div>
                <div class="col text-end">
                    <button class="btn btn-light btn-cancel"><i class="fas fa-times me-1"></i> ปิดหน้าจอ</button>
                </div>
            </div>
        `);
        function AddImage(files, idx) {
            var l = $contents.find(".images-section .image").length;
            if (l >= 4 || files.length == idx) {
                Func.HideLoading();
                return;
            }
            var $img = $(`
                <div class="col-3 position-relative">
                    <img src="" alt="Image" class="image">
                    <a href="Javascript:" class="btn-del-image">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            `);
            Func.GetBase64AndResize(files[idx], 1000, 1000, function (base64) {
                $.post("pages/" + PAGE + "/api/image-temp-add.php", {
                    random_id: random_id,
                    base64: base64
                }, function (res) {
                    if (res.status == "ok") {
                        $img.find("img").attr("src", res.image);
                        $contents.find(".images-section").append($img);
                        $(window).trigger("resize");
                    }
                    AddImage(files, ++idx);
                }, "JSON").fail(function () {
                    AddImage(files, ++idx);
                });
            });
        }
        $footer.find('.btn-image').click(function (event) {
            var l = $contents.find(".images-section .image").length;
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
        $contents.find("form").submit(function (e) {
            e.preventDefault();
            Func.ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/update-process.php",
                dataType: "JSON",
                data: Func.GetFormData($contents.find("form")),
                contentType: false,
                processData: false,
                success: function (res) {
                    Func.HideLoading();
                    if (res.status == 'no') {
                        Func.ShowAlert({
                            html: res.message,
                            type: "error",
                            callback: function () {
                                Func.Reload();
                            }
                        });
                    } else {
                        Func.Reload();
                    }
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
        $footer.find('.btn-submit').click(function (event) {
            $contents.find("[type=submit]").trigger("click");
        });
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        $contents.on("click", ".btn-del-image", function (e) {
            var $i = $(this).closest("div");
            var src = $i.find("img").attr("src");
            var arr = src.split("/");
            var filename = arr[arr.length - 1];
            Func.ShowConfirm({
                html: "ลบรูปนี้ไหม ?",
                callback: function (rs) {
                    if (rs) {
                        Func.ShowLoading("กำลังลบรูปภาพ");
                        $.post("pages/" + PAGE + "/api/image-temp-del.php", {
                            random_id: random_id,
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
        popup = new jBox('Modal', {
            title: $title,
            content: $contents,
            footer: $footer,
            width: "800px",
            height: "auto",
            draggable: 'title',
            overlay: true,
            zIndex: 101,  // default=10000
            onOpen: function () { },
            onClose: function () {
                setTimeout(function () {
                    popup.destroy();
                }, 100);
            }
        });
        popup.open();
    });
    $("#btn-update-complete").click(function () {
        Func.ShowConfirm({
            html: 'คุณต้องการบันทึก <span class="text-success">"ดำเนินการเสร็จแล้ว"</span> ใช่หรือไม่ ?',
            confirmButtonText: '<i class="fas fa-circle-check me-2"></i> ยืนยันดำเนินการเสร็จแล้ว',
            cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            callback: function (rs) {
                if (rs) {
                    var formData = new FormData();
                    formData.append("service_booking_id", service_booking_id);
                    Func.ShowLoading();
                    $.ajax({
                        type: "POST",
                        url: "pages/" + PAGE + "/api/update-complete.php",
                        dataType: "JSON",
                        data: formData,
                        contentType: false,
                        processData: false,
                        success: function (res) {
                            Func.HideLoading();
                            if (res.status == 'no') {
                                Func.ShowAlert({
                                    html: res.message,
                                    type: "error",
                                    callback: function () {
                                        Func.Reload();
                                    }
                                });
                            } else {
                                Func.Reload();
                            }
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
            },
        });
    });
});