$(function () {
    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            Func.LinkTo("./?page=" + PAGE + "&search=" + $("#search").val());
        }
    });
    function Del(customer_id) {
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-danger">"ลบข้อมูล"</span> ใช่หรือไม่ ?',
            confirmButtonText: '<i class="fas fa-trash me-2"></i> ยืนยันการลบ',
            cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            callback: function (rs) {
                if (rs) {
                    var formData = new FormData();
                    formData.append("customer_id", customer_id);
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
    function Approve(customer_id) {
        Func.ShowConfirm({
            html: 'คุณต้องการ <span class="text-success">"อนุมัติ"</span> ใช่หรือไม่ ?',
            confirmButtonText: '<i class="fas fa-check me-2"></i> ยืนยันการอนุมัติ',
            cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
            confirmButtonColor: '#198754',
            cancelButtonColor: '#6c757d',
            callback: function (rs) {
                if (rs) {
                    var formData = new FormData();
                    formData.append("customer_id", customer_id);
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
    $(".btn-check-data").click(function () {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        var popup;
        var $title = $(`
            <div>
                <i class="fa-solid fa-user-check me-1"></i> ตรวจสอบข้อมูลลูกค้าใหม่
            </div>
        `);
        var $contents = $(`
            <div>
                <div class="row">
                    <div class="col-md-auto mb-4">
                        <div class="customer-image">
                            <img id="pictureUrl" src="../../images/favicon.png?v=`+ VERSION + `" alt="Profile">
                        </div>
                    </div>
                    <div class="col-md">
                        <table class="table table-hover table-borderless">
                            <tr>
                                <td style="width:120px;">วันที่ลงทะเบียน</td>
                                <td id="add_when">AAAA</td>
                            </tr>
                            <tr>
                                <td>ชื่อ-นามสกุล</td>
                                <td id="fullname">AAAA XXXX</td>
                            </tr>
                            <tr>
                                <td>ที่อยู่</td>
                                <td id="address"></td>
                            </tr>
                            <tr>
                                <td>เบอร์มือถือ</td>
                                <td id="phone"></td>
                            </tr>
                            <tr>
                                <td>อาชีพ</td>
                                <td id="occupation_name"></td>
                            </tr>
                            <tr>
                                <td>ชื่อไลน์</td>
                                <td id="displayName"></td>
                            </tr>
                            <tr>
                                <td>รหัส userId</td>
                                <td id="userId"></td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        `);
        $contents.find("#add_when").html(Func.DateTh(data.add_when) + " น.");
        $contents.find("#fullname").html(data.customer_name + " " + data.customer_sname);
        $contents.find("#address").html(data.address);
        $contents.find("#phone").html(Func.FormatPhoneNumber(data.phone));
        $contents.find("#occupation_name").html(data.occupation_name);
        $contents.find("#displayName").html(data.displayName);
        $contents.find("#userId").html(data.userId);
        if (data.pictureUrl != "") $contents.find("#pictureUrl").attr("src", data.pictureUrl);
        var $footer = $(`
            <div class="row">
                <div class="col-auto">
                    <button class="btn btn-danger btn-del"><i class="fas fa-trash me-1"></i> ลบข้อมูล</button>
                </div>
                <div class="col text-end">
                    <button class="btn btn-success me-2 btn-submit"><i class="fa-solid fa-check me-1"></i> อนุมัติ</button>
                    <button class="btn btn-light btn-cancel"><i class="fas fa-times me-1"></i> ปิดหน้าจอ</button>
                </div>
            </div>
        `);
        $footer.find('.btn-del').click(function (event) {
            Del(data.customer_id);
        });
        $footer.find('.btn-submit').click(function (event) {
            Approve(data.customer_id);
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
            zIndex: 201,  // default=10000
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
    $("body").on("click", "#pictureUrl", function () {
        var src = $(this).attr("src");
        Func.ShowImage(src, "Profile");
    });
});