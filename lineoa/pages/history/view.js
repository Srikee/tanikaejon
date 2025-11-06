$(function () {
    $("title").html("ประวัติการใช้บริการ");

    function GetService() {
        $("#history").html("");
        ShowLoading();
        $.ajax({
            type: "POST",
            url: "pages/history/api/history.php",
            // dataType: "JSON",
            data: {
                search: $("#search").val()
            },
            // contentType: false,
            // processData: false,
            success: function (html) {
                HideLoading();
                $("#history").html(html);
            },
            error: function () {
                HideLoading();
                Func.ShowAlert({
                    html: "ไม่สามารถติดต่อเครื่องแม่ข่ายได้",
                    type: "error",
                    callback: function () { }
                });
            }
        });
    }
    GetService();
    $("#search").keyup(function () {
        GetService();
    });
    if (document.referrer !== "") { $(".backbutton").show(); } else { $(".backbutton").hide(); }
});