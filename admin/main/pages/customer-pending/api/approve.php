<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $customer_id = trim( $_POST["customer_id"] ?? "" );

    $sql = "
        SELECT
            c.*
        FROM customer c
        WHERE c.customer_id='".$DB->Escape($customer_id)."'
    ";
    $customer = $DB->QueryFirst($sql);
    if( $customer==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลลูกค้า"
        ));
        exit();
    }

    $rs = $DB->QueryUpdate("customer", [
        "status"=>"2",
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "customer_id='".$DB->Escape($customer_id)."' ");
    if( $rs ) {
        
        $userId = $customer["userId"];
        SentMessageToLine($userId, "บัญชีของคุณได้รับการอนุมัติแล้ว");

        echo json_encode(array(
            "status"=>"ok",
            "message"=>"อนุมัติเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    