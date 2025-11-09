$(function () {
    $("#search").keyup(function (e) {
        if (e.keyCode == 13) {
            Func.LinkTo("./?page=" + PAGE + "&search=" + $("#search").val());
        }
    });
    $(".btn-view").click(function () {
        var data = JSON.parse($(this).closest("[data-json]").attr("data-json"));
        var popup;
        var $title = $(`
            <div>
                <i class="fa-solid fa-user-check me-1"></i> รายละเอียดข้อมูลผู้แจ้งลืมรหัสผ่าน
            </div>
        `);
        var $contents = $(`
            <div>
                <form class="row">
                    <input type="submit" id="btn-submit" class="d-none">
                    <input type="hidden" name="forgot_id" id="forgot_id">
                    <input type="hidden" name="customer_id" id="customer_id">
                    <div class="col-md-auto mb-4">
                        <div class="customer-image">
                            <img id="pictureUrl" src="../../images/favicon.png" alt="Profile">
                        </div>
                    </div>
                    <div class="col-md">
                        <table class="table">
                            <tr>
                                <td style="width:120px;">วันที่แจัง</td>
                                <td id="add_when">AAAA</td>
                            </tr>
                            <tr>
                                <td>ชื่อ-นามสกุล</td>
                                <td id="fullname" colspan="2">AAAA XXXX</td>
                            </tr>
                            <tr>
                                <td>ที่อยู่</td>
                                <td id="address" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>เบอร์มือถือ</td>
                                <td id="phone" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>อาชีพ</td>
                                <td id="occupation_name" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>ชื่อไลน์</td>
                                <td id="displayName" colspan="2"></td>
                            </tr>
                            <tr>
                                <td>รหัส userId</td>
                                <td id="userId" colspan="2"></td>
                            </tr>
                            <tr>
                                <td valign="middle"></td>
                                <td>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="checkbox" id="changepass" name="changepass" value="Y" checked>
                                        <label class="form-check-label" for="changepass">เปลี่ยนรหัสผ่าน</label>
                                    </div>
                                </td>
                            </tr>
                            <tr class="password">
                                <td valign="middle">รหัสผ่านใหม่</td>
                                <td>
                                    <div class="form-inner">
                                        <input type="password" class="form-control" name="password1" id="password1" required>
                                        <i class="fa-solid fa-eye inner-button" show-password="password1"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr class="password">
                                <td valign="middle">ยืนยันรหัสผ่าน</td>
                                <td>
                                    <div class="form-inner">
                                        <input type="password" class="form-control" name="password2" id="password2" required>
                                        <i class="fa-solid fa-eye inner-button" show-password="password2"></i>
                                    </div>
                                </td>
                            </tr>
                            <tr>
                                <td valign="middle">สถานะ</td>
                                <td>
                                    <select name="status" id="status" class="form-control">
                                        <option value="1">รอตรวจสอบ</option>
                                        <option value="2">ตรวจสอบแล้ว</option>
                                        <option value="3">ยกเลิก</option>
                                    </select>
                                </td>
                            </tr>
                        </table>
                    </div>
                </form>
            </div>
        `);
        $contents.find("#add_when").html(Func.DateTh(data.add_when) + " น.");
        $contents.find("#forgot_id").val(data.forgot_id);
        $contents.find("#customer_id").val(data.customer_id);
        $contents.find("#fullname").html(data.customer_name + " " + data.customer_sname);
        $contents.find("#address").html(data.address);
        $contents.find("#phone").html(Func.FormatPhoneNumber(data.phone));
        $contents.find("#occupation_name").html(data.occupation_name);
        $contents.find("#displayName").html(data.displayName);
        $contents.find("#userId").html(data.userId);
        $contents.find("#status").val(data.status);
        if (data.pictureUrl != "") $contents.find("#pictureUrl").attr("src", data.pictureUrl);
        var $footer = $(`
            <div class="row">
                <div class="col text-end">
                    <button type="button" class="btn btn-primary btn-submit me-2">
                        <i class="fas fa-check me-1"></i> ยืนยันการบันทึก
                    </button>
                    <button class="btn btn-light btn-cancel">
                        <i class="fas fa-times me-1"></i> ปิดหน้าจอ
                    </button>
                </div>
            </div>
        `);
        $footer.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        $footer.find('.btn-submit').click(function (event) {
            $contents.find('#btn-submit').trigger("click");
        });
        $contents.find('[show-password]').click(function () {
            var id = $(this).attr("show-password");
            var type = $("#" + id).attr("type");
            if (type == "password") {
                $("#" + id).attr("type", "text");
            } else {
                $("#" + id).attr("type", "password");
            }
            $(this).toggleClass("fa-eye fa-eye-slash");
        });
        $contents.find('#changepass').change(function (event) {
            var changepass = $(this).prop("checked");
            if (changepass) {
                $contents.find(".password").show();
                $contents.find("#password1, #password2").attr("required", "required");
            } else {
                $contents.find(".password").hide();
                $contents.find("#password1, #password2").removeAttr("required");
            }
        });
        $contents.find('form').submit(function (event) {
            event.preventDefault();
            var changepass = $contents.find('#changepass').prop("checked");
            var password1 = $contents.find('#password1').val().trim();
            var password2 = $contents.find('#password2').val().trim();
            if (changepass) {
                if (password1 != password2) {
                    Func.ShowAlert({
                        html: "ยืนยันรหัสผ่านไม่ถูกต้อง",
                        type: "error",
                        callback: function () {
                            $contents.find('#password2').focus().select();
                        }
                    });
                    return;
                }
            }
            Func.ShowConfirm({
                html: 'คุณต้องการ <span class="text-primary">"บันทึก"</span> ใช่หรือไม่ ?',
                confirmButtonText: '<i class="fas fa-key me-2"></i> ยืนยันการบันทึก',
                cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
                confirmButtonColor: '#0d6efd',
                cancelButtonColor: '#6c757d',
                callback: function (rs) {
                    if (rs) {
                        Func.ShowLoading();
                        $.ajax({
                            type: "POST",
                            url: "pages/" + PAGE + "/api/edit.php",
                            dataType: "JSON",
                            data: Func.GetFormData($contents.find('form')),
                            contentType: false,
                            processData: false,
                            success: function (res) {
                                Func.HideLoading();
                                Func.ShowAlert({
                                    html: res.message,
                                    type: (res.status == 'ok') ? "success" : "error",
                                    callback: function () {
                                        if (res.status == 'ok') Func.Reload();
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
                },
            });
        });
        popup = new jBox('Modal', {
            title: $title,
            content: $contents,
            footer: $footer,
            width: "1000px",
            height: "auto",
            draggable: 'title',
            overlay: true,
            zIndex: 201,  // default=10000
            onOpen: function () { },
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