<?php
    include_once("../config/all.php");

    // ลบ temp ของ service_booking
    $now = new DateTime();
    $now->modify('-10 minutes');        // ลบ 10 นาที
    $date = $now->format('Y-m-d H:i:s');
    $datas = $DB->QueryObj("SELECT * FROM service_booking_image_temp WHERE add_when <= '".$date."' ");
    foreach($datas as $data) {
        $random_id = $data["random_id"];
        $dir = "../files/service_booking_temp/".$random_id."/";
        $options = array(
            "dir"   => $dir
        );
        Func::RemoveDir($options);
        $DB->QueryDelete("service_booking_image_temp", "random_id='".$DB->Escape($random_id)."' ");
        // echo "ลบแล้วโฟลเดอร์ ".$dir." <br>";
    }
    // END ลบ temp ของ service_booking


    $PAGE = $_GET['page'] ?? 'index';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1" />
    <title>ตานีแก้จน</title>
    <meta name="description" content="ตานีแก้จน">
    <meta name="keywords" content="ตานีแก้จน" />
    <link rel="icon" href="../images/favicon.png" />
    <script>
    var VERSION = "<?php echo $VERSION; ?>";
    </script>
    <!-- jquery -->
    <script src="../assets/jquery/jquery-3.7.1.min.js"></script>
    <!-- bootstrap -->
    <link href="../assets/bootstrap-5.3.7/css/bootstrap.min.css" rel="stylesheet">
    <script src="../assets/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
    <!-- font-awesome -->
    <link href="../assets/fontawesome-free-7.0.0/css/all.min.css" rel="stylesheet">
    <!-- sweetalert2 -->
    <script src="../assets/sweetalert2/sweetalert.min.js"></script>
    <!-- fancybox -->
    <script src="../assets/fancybox/fancybox.umd.js"></script>
    <link rel="stylesheet" href="../assets/fancybox/fancybox.css" />
    <!-- moment -->
    <script src="../assets/moment/moment.js"></script>
    <script src="../assets/moment/locale/th.js"></script>
    <!-- jBox -->
    <link href="../assets/jBox-1.3.3/jBox.all.min.css" rel="stylesheet">
    <script src="../assets/jBox-1.3.3/jBox.all.min.js"></script>
    <!-- autocomplete -->
    <link href="../assets/jquery-autocomplete/jquery.auto-complete.css" rel="stylesheet" />
    <script src="../assets/jquery-autocomplete/jquery.auto-complete.min.js"></script>
    <!-- cropperjs -->
    <link href="../assets/cropperjs/cropper.min.css" rel="stylesheet" />
    <script src="../assets/cropperjs/cropper.min.js"></script>
    <!-- liff -->
    <script src="https://static.line-scdn.net/liff/edge/2.1/liff.js"></script>
    <!-- func -->
    <script src="../assets/func.js?version=<?php echo $VERSION; ?>"></script>
    <!-- index -->
    <link href="assets/index.css?version=<?php echo $VERSION; ?>" rel="stylesheet" />
    <script src="assets/index.js?version=<?php echo $VERSION; ?>"></script>
    <?php
        if( $MODE=="production" ) {
            echo '<script src="assets/myliff-prod.js?version='.$VERSION.'"></script>';
        } else {
            echo '<script src="assets/myliff-dev.js?version='.$VERSION.'"></script>';
        }
    ?>
</head>

<body>
    <input type="hidden" id="PAGE" value="profile">
    <div id="main" style="display:none;"></div>
    <div id="loading"
        style="display:none;z-index:7700;position:fixed;top:50%;left:50%;-webkit-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);transform:translate(-50%,-50%);">
        <div class="spinner-border text-primary"></div>
    </div>
</body>

</html>