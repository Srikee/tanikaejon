var Func = {
    ToggleInputNumber: function (ctrl, digit) {
        if ($(ctrl).val() != "") $(ctrl).val(($(ctrl).val() * 1).toFixed(digit));
        if ($(ctrl).val() == "") $(ctrl).val(($(ctrl).val() * 1).toFixed(digit));
        $(ctrl).inputmask({
            'alias': 'numeric',
            'groupSeparator': ',',
            'autoGroup': true,
            'digits': digit,
            //'digitsOptional': false, 
            'prefix': '',
            'placeholder': '0'
        });
    },
    ToggleSelect: function (ctrl) {
        $(ctrl).select2({
            theme: 'bootstrap4',
        });
    },
    ToggleDatepicker: function (ctrl) {
        ctrl.datepicker({
            language: 'th-th',
            format: 'dd/mm/yyyy',
            autoclose: true
        });
        ctrl.inputmask("9{2}/9{2}/9{4}");
        // ctrl.inputmask("datetime", {
        //     inputFormat: "dd/mm/yyyy"
        // });
    },
    ToggleDatepickerRange: function (ctrl1, ctrl2) {
        var date1 = ctrl1.datepicker({
            language: 'th-th',
            format: 'dd/mm/yyyy',
            autoclose: true,
        }).on('show', function (e) {
            date1.datepicker("setEndDate", date2.val());
        });
        var date2 = ctrl2.datepicker({
            language: 'th-th',
            format: 'dd/mm/yyyy',
            autoclose: true,
        }).on('show', function (e) {
            date2.datepicker("setStartDate", date1.val());
        });
        ctrl1.inputmask("9{2}/9{2}/9{4}");
        ctrl2.inputmask("9{2}/9{2}/9{4}");
        $('.datepicker').css("display", "none");
    },
    ToggleTooltip: function (ctrl) {
        ctrl.tooltip();
        // const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]')
        // const tooltipList = [...tooltipTriggerList].map(tooltipTriggerEl => new bootstrap.Tooltip(tooltipTriggerEl))
    },
    ShowPDF: function (url) {
        var CheckUrl = function (url) {
            var a = url.split('https://');
            if (a.length == 2) return url;
            a = url.split('/');
            if (a[0] == '') return url;
            var path = location.href;
            a = path.split("/");
            var url2 = '';
            for (var i = 0; i < a.length - 1; i++) {
                url2 += a[i] + "/";
            }
            url = url2 + url;
            return url;
        }
        url = CheckUrl(url);
        console.log(url);
        var href = '/template/assets/pdfjs/web/viewer.html?file=' + encodeURIComponent(url);
        $.fancybox.open({
            href: href,
            type: 'iframe',
            maxWidth: 1000,
            maxHeight: 700,
            fitToView: false,
            width: '100%',
            height: '100%',
            autoSize: false,
            closeClick: false,
            openEffect: 'none',
            closeEffect: 'none'
        });
    },
    DateTh: function (date, time) {
        if (date == null) return date;
        // if (time == null) time = null;
        var x = moment(date);
        var y = x.format("YYYY") * 1 + 543;
        var result = x.format("DD/MM/") + y;
        if (time) result += " " + x.format("HH:mm");
        return result;
    },
    DateEn: function (date, time) {
        if (date == null) return date;
        // if (time == null) time = null;
        var arr = date.split(" ");
        var date = arr[0];
        var arr2 = date.split("/");
        var result = (arr2[2] * 1 - 543) + "-" + arr2[1] + "-" + arr2[0];
        if (time && arr.length == 2) {
            var time = arr[1];
            result += " " + time;
        }
        return result;
    },
    ToNum: function (num, digit) {
        if (!digit) digit = 2;
        num = num + "";
        num = num.replace(" %", "");
        num = num.replace(/,/g, "");
        return (num * 1).toFixed(digit);
    },
    ShowAlert: function (option) {
        if (typeof option === 'string' || option instanceof String) {
            option = {
                html: option
            };
        }
        option.title = option.title || 'แจ้งข้อความ';
        option.html = option.html || 'ระบุข้อความ';
        option.type = option.type || 'info'; // success, error, warning, info, question
        option.confirmButtonColor = option.confirmButtonColor || '#3085d6';
        option.confirmButtonText = option.confirmButtonText || '<i class="fa fa-check"></i> ตกลง';
        option.allowOutsideClick = option.allowOutsideClick || false;
        option.allowEscapeKey = option.allowEscapeKey || false;
        option.callback = option.callback || function () { };
        swal(option).then(function (result) {
            option.callback(true);
        });
    },
    ShowConfirm: function (option) {
        if (typeof option === 'string' || option instanceof String) {
            option = {
                html: option
            };
        }
        option.title = option.title || 'คำยืนยัน ?';
        option.html = option.html || 'ระบุข้อความ';
        option.type = option.type || 'question'; // success, error, warning, info, question
        option.showCancelButton = option.showCancelButton || true;
        option.confirmButtonColor = option.confirmButtonColor || '#3085d6';
        option.cancelButtonColor = option.cancelButtonColor || '#d33';
        option.confirmButtonText = option.confirmButtonText || '<i class="fa fa-check"></i> ตกลง';
        option.cancelButtonText = option.cancelButtonText || '<i class="fa fa-times"></i> ยกเลิก';
        option.allowOutsideClick = option.allowOutsideClick || false;
        option.allowEscapeKey = option.allowEscapeKey || false;
        option.callback = option.callback || function () { };
        swal(option).then(function (result) {
            option.callback(true);
        }, function (dismiss) {
            option.callback(false);
        });
    },
    POPUP: {
        close: function () { }
    },
    ShowLoading: function (text) {
        if (!text) text = 'กำลังประมวลผล...';
        Func.POPUP = new jBox('Modal', {
            title: '<span class="font-weight-bold">' + text + '</span>',
            content: '\
                <div class="progress" style="height: 30px;">\
                    <div class="progress-bar progress-bar-striped progress-bar-animated" role="progressbar" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100" style="width: 100%;"></div>\
                </div>\
                ',
            width: "500px",
            height: "60px",
            addClass: 'popup-loading',
            overlayClass: 'popup-loading-overlay',
            draggable: false,
            overlay: true,
            closeOnClick: false,
            closeButton: false,
            zIndex: 999999, // default=10000
            onClose: function () {
                setTimeout(function () {
                    Func.POPUP.destroy();
                }, 200);
            }
        });
        Func.POPUP.open();
    },
    HideLoading: function () {
        Func.POPUP.close();
    },
    SetCookie: function (cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays * 24 * 60 * 60 * 1000));
        var expires = "expires=" + d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    },
    GetCookie: function (cname) {
        var name = cname + "=";
        var ca = document.cookie.split(';');
        for (var i = 0; i < ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    },
    Back: function () {
        history.back();
    },
    Reload: function () {
        location.reload();
    },
    LinkTo: function (url) {
        location.href = url;
    },
    AjaxResponse: function (res) {
        if (res.message && res.message != '') {
            Func.ShowAlert({
                html: res.message,
                type: res.type,
                callback: function () {
                    if (!res.url || res.url == '') { }
                    else if (res.url == 'reload') Func.Reload();
                    else if (res.url == 'back') Func.Back();
                    else Func.LinkTo(res.url);
                }
            });
        } else {
            if (!res.url || res.url == '') { }
            else if (res.url == 'reload') Func.Reload();
            else if (res.url == 'back') Func.Back();
            else Func.LinkTo(res.url);
        }
    },
    AcceptImplode: function (type) {
        var str = "";
        for (var i = 0; i < type.length; i++) {
            str += "." + type[i];
            if (i < type.length - 1) {
                str = str + ", ";
            }
        }
        return str;
    },
    FileChange: function (allow_types, allow_size, ctrl, to, df, cb) {
        if (!df) df = "";
        var input = $(ctrl)[0];
        if (input.files && input.files[0]) {
            var name = input.files[0].name;
            var size = input.files[0].size;
            var type = input.files[0].type; // "image/jpeg" | image/png | image/gif | image/pjpeg
            var arr = name.split(".");
            var fType = (arr[arr.length - 1]).toLowerCase();  // "jpeg" | png | gif | pjpeg
            if (arr.length < 2 || ($.inArray(fType, allow_types) == -1)) {
                Func.ShowAlert({
                    html: "รูปแบบไม่รองรับ รองรับเฉพาะ " + Func.AcceptImplode(allow_types) + " เท่านั้น",
                    type: "error",
                    callback: function () {
                        $(ctrl).val('');
                        if (to) $(to).attr('src', df);
                        if (cb) cb(false);
                    }
                });
                return;
            }
            if (size > allow_size * 1024 * 1024) {
                Func.ShowAlert({
                    html: "ขนาดของไฟล์ที่คุณเลือกเท่ากับ " + (size / 1024 / 1024).toFixed(2) + " MB ซึ่งสูงกว่าที่กำหนด กรุณาเลือกไฟล์ที่ไม่เกิน " + allow_size + " MB",
                    type: "error",
                    callback: function () {
                        $(ctrl).val('');
                        if (to) $(to).attr('src', df);
                        if (cb) cb(false);
                    }
                });
                return;
            }
            if (to) {
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(to).attr('src', e.target.result);
                    if (cb) cb(true);
                };
                reader.readAsDataURL(input.files[0]);
            } else {
                if (cb) cb(true);
            }
        } else {
            Func.ShowAlert({
                html: "รูปแบบไม่รองรับ รองรับเฉพาะ " + Func.AcceptImplode(allow_types) + " เท่านั้น",
                type: "error",
                callback: function () {
                    $(ctrl).val('');
                    $(to).attr('src', df);
                    if (cb) cb(false);
                }
            });
        }
    },
    GoToByScroll: function (id, speed) {
        if (!speed) speed = 'slow';
        $('html,body').animate({
            scrollTop: $(id).offset().top
        }, speed);
    },
    CopyClipboard: function (string) {
        var temp = document.createElement('textarea');
        temp.value = string;
        temp.selectionStart = 0;
        temp.selectionEnd = temp.value.length;
        var s = temp.style;
        s.position = 'fixed';
        s.left = '-100%';
        document.body.appendChild(temp);
        temp.focus();
        var result = document.execCommand('copy');
        temp.blur();
        document.body.removeChild(temp);
        return result;
    },
    NumberFormat: function (x, digit) {
        if (x == null) return '';
        if (digit) x = x.toFixed(digit);
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    },
    SubmitPostData: function (url, data, target = "_self") {
        var $form = $("<form target='" + target + "'></form>");
        $form.attr("method", "post");
        $form.attr({
            'method': 'post',
            'action': url
        });
        $.each(data, function (i, v) {
            var $input = $("<input type='hidden'>");
            $input.attr({
                'name': i,
                'value': v
            });
            $form.append($input);
        });
        $form.appendTo('body');
        $form.submit();
    },
    GetFormData: function (form_id) {
        var formData = new FormData();
        var x = $(form_id).serializeArray();
        for (var i = 0; i < x.length; i++) {
            formData.append(x[i].name, x[i].value);
        }
        x = $(form_id).find("[type=file][name]");
        for (var i = 0; i < x.length; i++) {
            var name = $(x[i]).attr('name');
            var value = x[i].files[0];
            if (value) {
                formData.append(name, value);
            }
        }
        return formData;
    },
    GetUrlParameter: function (name) {
        name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
        var regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
        var results = regex.exec(location.search);
        return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
    },
    NL2BR: function (str, is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '<br />' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    },
    ShowToast: function (data, delay) {
        if (!delay) delay = 2000;
        var $html = $("\
            <div class='toast'\
                style='position: fixed; bottom: 20px; right: 20px; background-color: #1a252f; color: #fff; box-shadow: 0 0px 10px rgb(0 0 0);z-index: 10000;'>\
                <div class='toast-body pl-4 pr-4'>\
                    Hello, world! This is a toast message.\
                </div>\
            </div>\
        ");
        $html.find(".toast-body").html(data);
        $html.appendTo("body");
        $html.toast({
            delay: delay
        });
        $html.toast('show');
        setTimeout(function () {
            $html.remove();
        }, delay + 1000);
    },
    GetBase64AndResize: function (file, max_width, max_height, callback) {
        // กรณีไม่ย่อภาพ
        // var reader = new FileReader();
        // reader.onload = function(e) {
        //     callback(e.target.result);
        // };
        // reader.readAsDataURL(file);
        // กรณีย่อภาพ
        var reader = new FileReader();
        reader.onload = function (e) {
            var image = new Image();
            image.onload = function () {
                /***** หาค่าความกว้างความสูงหลังย่อภาพ *****/
                var width = image.width;
                var height = image.height;
                if (width > max_width && height > max_height) {
                    if (width > height) {
                        if (width > max_width) {
                            height *= max_width / width;
                            width = max_width;
                        }
                    } else {
                        if (height > max_height) {
                            width *= max_height / height;
                            height = max_height;
                        }
                    }
                }
                /***** จบหาค่าความกว้างความสูงหลังย่อภาพ *****/
                var canvas = document.createElement('canvas');
                ctx = canvas.getContext('2d');
                canvas.width = width;
                canvas.height = height;
                ctx.drawImage(image, 0, 0, width, height);
                callback(canvas.toDataURL());
            };
            image.src = e.target.result;
        };
        reader.readAsDataURL(file);
    },
    SelectCropImage: function (aspectRatio, callback, width = "700px", height = "100%") {
        $input = $('<input type="file" accept="image/*">');
        $input.change(function (event) {
            var popup;
            var $title = $(`
                <div class="fa-solid fa-crop-simple mr-1"></i> ตัดภาพ
                </div>
            `);
            var $contents = $(`
                <div>
                    <img src="" class="w-100">
                </div>
            `);
            var $footer = $(`
                <div class="row">
                    <div class="col-auto pe-0">
                        <button class="btn btn-light border me-1 btn-rotate-right"><i class="fas fa-rotate-right"></i></button>
                        <button class="btn btn-light border btn-rotate-left"><i class="fas fa-rotate-left"></i></button>
                    </div>
                    <div class="col ps-0 text-end">
                        <button class="btn btn-success me-1 btn-submit"><i class="fa-solid fa-check me-1"></i> ยืนยัน</button>
                        <button class="btn btn-light border btn-cancel"><i class="fas fa-times me-1"></i> ปิดหน้าจอ</button>
                    </div>
                </div>
            `);
            var cropper;
            $footer.find('.btn-submit').click(function (event) {
                const canvas = cropper.getCroppedCanvas();
                if (canvas) {
                    var base64 = canvas.toDataURL('image/png');
                    if (callback) callback(base64);
                }
                popup.close();
            });
            $footer.find('.btn-cancel').click(function (event) {
                popup.close();
            });
            $footer.find('.btn-rotate-left').click(function (event) {
                cropper.rotate(-90);
            });
            $footer.find('.btn-rotate-right').click(function (event) {
                cropper.rotate(90);
            });
            var file = event.target.files[0];
            Func.GetBase64AndResize(file, 1000, 1000, function (base64) {
                // console.log(base64);
                $contents.find("img").attr("src", base64);
                cropper = new Cropper($contents.find("img")[0], {
                    // aspectRatio: 4 / 3, // กำหนดอัตราส่วนของ crop (ปรับตามต้องการ)
                    aspectRatio: aspectRatio,
                    viewMode: 2,
                });
            });
            popup = new jBox('Modal', {
                title: $title,
                content: $contents,
                footer: $footer,
                width: width,
                height: height,
                draggable: 'title',
                overlay: true,
                zIndex: 10001, // default=10000
                closeButton: false,
                closeOnClick: false,
                onOpen: function () { },
                onClose: function () {
                    setTimeout(function () {
                        popup.destroy();
                    }, 100);
                }
            });
            popup.open();
        });
        $input.trigger('click');
    },
    SelectImage: function (callback) {
        $input = $('<input type="file" accept="image/*">');
        $input.bind("change", function (event) {
            var file = event.target.files[0];
            Func.GetBase64AndResize(file, 1000, 1000, function (base64) {
                callback(base64);
            });
        });
        $input.click();
    },
    ShowImage: function (src, caption) {
        var option = [{
            src: src,
            caption: caption,
            type: "image",
        }];
        var fcb = new Fancybox(option);
    },
    ShowGalleryImage: function (index, images) {
        var option = [];
        for (var i = 0; i < images.length; i++) {
            option.push({
                src: images[i],
                caption: i + 1,
                type: "image",
            });
        }
        var fcb = new Fancybox(option, {
            startIndex: index
        });
    },
    FormatPhoneNumber: function (input) {
        if (input === null || input === undefined) return "";
        // แปลงเป็นสตริง แล้วตัดช่องว่างรอบๆ
        let s = String(input).trim();
        // เก็บเฉพาะตัวเลขและเครื่องหมาย + (ถ้ามี)
        s = s.replace(/[^\d+]/g, "");
        // ถ้ามีเครื่องหมาย + ไว้ข้างหน้า ให้ตัด +
        if (s.startsWith("+")) s = s.slice(1);
        // ถ้าเป็นรูปแบบ country code ของไทย (66xxxx...) ให้แปลงเป็น 0xxxx...
        if (s.startsWith("66")) {
            s = "0" + s.slice(2);
        }
        // เอาเฉพาะตัวเลขจริงๆ ออกมา
        const digits = s.replace(/\D/g, "");
        // กรณีปกติของมือถือไทยคือ 10 หลัก เริ่มด้วย 0 -> format 3-3-4
        if (digits.length === 10 && digits[0] === "0") {
            return digits.replace(/(\d{3})(\d{3})(\d{4})/, "$1-$2-$3");
        }
        // กรณีพิเศษ: ถ้ามีความยาวมากกว่า 4 หลัก ให้แบ่งเป็นกลุ่ม (จากต้นเป็นกลุ่ม 1-3-3... แล้วต่อท้ายด้วย 4 หลักสุดท้าย)
        if (digits.length > 4) {
            const last4 = digits.slice(-4);
            const rest = digits.slice(0, -4);
            // แบ่ง rest เป็นกลุ่มละ 3 ตัว
            const parts = rest.match(/.{1,3}/g) || [];
            return parts.join("-") + (parts.length ? "-" : "") + last4;
        }
        // ถ้าน้อยกว่าหรือเท่ากับ 4 ให้คืนเป็นตัวเลขล้วน (หรือเปลี่ยนตามต้องการ)
        return digits;
    }
};