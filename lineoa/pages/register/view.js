$(function () {
    $("title").html("แบบฟอร์มลงทะเบียน");
    $("#formdata").submit(function (e) {
        e.preventDefault();
        let tambol_id = $("#tambol_id").val().trim();
        let amphur_id = $("#amphur_id").val().trim();
        let province_id = $("#province_id").val().trim();
        if (tambol_id == "" || amphur_id == "" || province_id == "") {
            Func.ShowAlert({
                html: "กรุณาระบุตำบล/อำเภอ/จังหวัด",
                type: "error",
                callback: function () { $("#th_address").focus(); }
            });
            return;
        }
        let phone = $("#phone").val().trim();
        if (phone == "" || phone.length != 10) {
            Func.ShowAlert({
                html: "กรุณาระบุเบอร์มือถือให้ถูกต้อง",
                type: "error",
                callback: function () { $("#phone").focus(); }
            });
            return;
        }
        Func.ShowLoading();
        $.ajax({
            type: "POST",
            url: "pages/register/api/register.php",
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
                            Func.Back();
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
    $(".profile-image").click(function () {
        var src = $(this).find("img").attr("src");
        Func.ShowImage(src, "Profile");
    });
    $("#th_address").click(function () {
        var popup;
        var $title = $(`
            <div>
                <div class="row">
                    <div class="col d-flex align-items-center">
                        <i class="fa-solid fa-search me-1"></i> ค้นหา ตำบล/อำเภอ/จังหวัด
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-lg btn-danger btn-cancel"><i class="fas fa-times me-1"></i> ปิด</button>
                    </div>
                </div>
                <input type="text" class="form-control form-control-lg mt-3" id="search" placeholder="พิมพ์คำที่ต้องการค้นหา...">
                <span class="form-text text-danger">
                    * พิมพ์ชื่อ ตำบล/อำเภอ/จังหวัด/รหัสไปรษณีย์ และเลือกรายการ
                </span>
            </div>
        `);
        var $contents = $(`
            <div>
                <div class="list-group"></div>
            </div>
        `);
        $title.find('.btn-cancel').click(function (event) {
            popup.close();
        });
        var SearchAddress = function (search) {
            $.post("pages/changeprofile/api/search-address.php", {
                search: search
            }, function (html) {
                $contents.find(".list-group").html(html);
            });
        }
        var th_address = $("#th_address").val();
        th_address = th_address.replace("ต.", "");
        th_address = th_address.replace("อ.", "");
        th_address = th_address.replace("จ.", "");
        SearchAddress(th_address);
        $title.on("keyup", "#search", function () {
            SearchAddress($title.find("#search").val());
        });
        $contents.on("click", "[data-json]", function () {
            let data = JSON.parse($(this).attr("data-json"));
            // console.log(data);
            $("#th_address").val("ต." + data.tambol_name_thai + " อ." + data.amphur_name_thai + " จ." + data.province_name_thai + "");
            $("#tambol_id").val(data.tambol_id);
            $("#amphur_id").val(data.amphur_id);
            $("#province_id").val(data.province_id);
            $("#zipcode").val(data.zipcode);
            popup.close();
        });
        popup = new jBox('Modal', {
            title: $title,
            content: $contents,
            // footer: $footer,
            width: "500px",
            height: "100%",
            closeButton: false,
            draggable: false,
            overlay: true,
            zIndex: 10001,  // default=10000
            onOpen: function () {
                setTimeout(() => {
                    $title.find("#search").focus();
                }, 200);
            },
            onClose: function () {
                setTimeout(() => {
                    popup.destroy();
                }, 200);
            }
        });
        popup.open();
    });
});