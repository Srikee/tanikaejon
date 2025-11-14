<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $provider_id = $_POST["provider_id"] ?? "";

    if( $DB->QueryHaving("service_booking", "provider_id", $provider_id) ) {
        echo json_encode(array(
            "status"=>false,
            "message"=>"ไม่สามารถลบได้ เนื่องจากข้อมูลนี้ถูกใช้งานแล้ว"
        ));
        exit();
    }

    $sql = "SELECT * FROM provider WHERE provider_id='".$DB->Escape($provider_id)."' ";
    $provider = $DB->QueryFirst($sql);
    if( $provider==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่พบข้อมูล'
        ));
        exit();
    }

    if( $DB->QueryDelete("provider", "provider_id='".$DB->Escape($provider_id)."' ") ) {
        $dir = $SERVER_ROOT."../files/provider/";
        $options = array(
            "dir"       => $dir,
            "fileName"  => $provider["image"],
        );
        $removed = Func::RemoveFile($options);
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ลบข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    