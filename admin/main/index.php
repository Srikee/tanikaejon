<?php 
    include_once('../config/all.php');

    if( ChkLogin()==false ) {
        Func::LinkTo("../login");
        exit();
    }

    $PAGE = $_GET["page"] ?? 'index';
?>
<!DOCTYPE html>
<html translate="no">

<head>
    <?php include_once('../master/script.php'); ?>
    <script>
    var VERSION = "<?php echo $DB->Escape($VERSION, "display"); ?>";
    var PAGE = "<?php echo $DB->Escape($PAGE, "display"); ?>";
    </script>
</head>

<body>
    <?php include_once('../master/navbar.php'); ?>
    <?php include_once('menu.php'); ?>


    <?php
        // echo 'pages/'.$PAGE.'/view.php';
        if( !file_exists('pages/'.$PAGE.'/view.php') ) $PAGE = '404';
        echo '<link rel="stylesheet" href="pages/'.$PAGE.'/view.css?v='.$VERSION.'">';
        echo '<script src="pages/'.$PAGE.'/view.js?v='.$VERSION.'"></script>';
        include_once('pages/'.$PAGE.'/view.php');
    ?>


    <?php include_once('../master/footer.php'); ?>
</body>

</html>