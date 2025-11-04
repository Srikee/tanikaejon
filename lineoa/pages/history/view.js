$(function () {
    $("title").html("ประวัติการใช้บริการ");

    function GetService() {
        $("#service").html("");
        Func.ShowLoading("กำลังโหลดข้อมูล...");
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
                Func.HideLoading();
                $("#service").html(html);
            },
            error: function () {
                Func.HideLoading();
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
});