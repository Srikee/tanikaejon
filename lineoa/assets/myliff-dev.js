function ShowLoading() {
    $("#loading").fadeIn("fast");
}
function HideLoading(time) {
    time = time || 100;
    setTimeout(function () {
        $("#loading").fadeOut("fast");
    }, time);
}
function Initial(callback) {
    function RunApp() {
        $.post("api/login.php", {
            user_line: {
                userId: "developer",
                displayName: "Demo",
                pictureUrl: "",
            }
        }, function (res) {
            HideLoading(0);
            if (res.status == "ok") {
                callback("ok", res.data);
            } else {
                callback("no", null);
            }
        }, 'json').fail(function (err) {
            alert("Error API Login.");
            HideLoading(0);
        });
    }
    ShowLoading();
    RunApp();
}
$(function () {
    Initial(function (status, customer) {
        var page_no_login = ["index", "register", "forgot"];
        var p = Func.GetUrlParameter("page") || "index";
        if (status == "no") {
            if ($.inArray(p, page_no_login) == -1) {
                p = "login";
            }
        } else {
            if (customer.status == "1") {
                if ($.inArray(p, ["changepass", "changeprofile"]) == -1) {
                    p = "profile-pending";
                }
            }
        }
        var href = location.href;
        var arr = href.split(p);
        var d = new Date();
        $("#main").load("pages/" + p + "/view.php?t=" + d.getTime() + arr[1], function () {
            $("body").append(`
                <script>
                    var PAGE = "`+ p + `";
                </script>
            `);
            $("body").append('<link href="pages/' + p + '/view.css?t=' + d.getTime() + '" rel="stylesheet">');
            $("body").append('<script src="pages/' + p + '/view.js?t=' + d.getTime() + '"></>');
        });
        // $("#main").load("pages/" + p + "/view.php?v=" + VERSION + arr[1], function () {
        //     $("body").append(`
        //         <script>
        //             var PAGE = "`+ p + `";
        //         </script>
        //     `);
        //     $("body").append('<link href="pages/' + p + '/view.css?v=' + VERSION + '" rel="stylesheet">');
        //     $("body").append('<script src="pages/' + p + '/view.js?v=' + VERSION + '"></>');
        // });
        $("#main").fadeIn("fast");
    });
});
