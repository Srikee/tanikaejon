$(function () {
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
    function Approve(service_booking_id) {
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-success">"รับเรื่อง"</span> ใช่หรือไม่ ?',
            confirmButtonText: '<i class="fas fa-handshake me-2"></i> รับเรื่อง',
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
                        url: "pages/" + PAGE + "/api/approve.php",
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
                                Func.LinkTo("./?page=service_booking-detail&service_booking_id=" + service_booking_id);
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
                    <button class="btn btn-success btn-approve"><i class="fas fa-handshake me-1"></i> รับเรื่อง</button>
                    <button class="btn btn-light btn-cancel"><i class="fas fa-times me-1"></i> ปิดหน้าจอ</button>
                </div>
            </div>
        `);
        $contents.on("submit", "form", function (e) {
            e.preventDefault();
            Func.ShowLoading();
            $.ajax({
                type: "POST",
                url: "pages/" + PAGE + "/api/approve.php",
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
                        Func.LinkTo("./?page=service_booking-detail&service_booking_id=" + data.service_booking_id);
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
        $footer.find('.btn-del').click(function (event) {
            Del(data.service_booking_id);
        });
        $footer.find('.btn-approve').click(function (event) {
            $contents.find("#btn-submit").trigger("click");
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
            onOpen: function () { },
            onClose: function () {
                setTimeout(function () {
                    popup.destroy();
                }, 100);
            }
        });
        popup.open();
    });
    $("body").on("click", ".image", function () {
        var src = $(this).attr("src");
        var index = 0;
        var images = [];
        $.each($("body .image"), function (i, v) {
            images.push($(this).attr("src"));
            if (src == $(this).attr("src")) index = i;
        });
        // console.log(images)
        Func.ShowGalleryImage(index, images);
    });
});