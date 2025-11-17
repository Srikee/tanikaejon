<?php
    include_once("../../../../config/all.php");

    $userId = @$_SESSION["customer"]["user_line"]["userId"];
    $displayName = @$_SESSION["customer"]["user_line"]["displayName"];
    $pictureUrl = @$_SESSION["customer"]["user_line"]["pictureUrl"];
    if( $userId=="" || $displayName=="" ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบบัญชี Line ของคุณ"
        ));
        exit();
    }

    $sql = "
        SELECT * 
        FROM staff 
        WHERE status='1'
            AND username!='admin'
        ORDER BY phone ASC
        LIMIT 5
    ";
    $staff = $DB->QueryObj($sql);
    $a = '';
    foreach( $staff as $key=>$value ) {
        $phone = $value["phone"];
        if( $phone=="" ) continue;
        $a = '
            <a href="tel:'.$phone.'" type="button" class="btn btn-lg btn-outline-success w-100 mb-3">
                <i class="fa-solid fa-phone me-1"></i> '.Func::FormatPhoneNumber($phone).'
            </a>
        ';
    }
?>
<div>
    <?php echo $a; ?>
    <button type="button" class="btn btn-lg btn-outline-danger w-100 btn-cancel">
        <i class="fa-solid fa-times me-1"></i> ปิด
    </button>
</div>