<?php
    include_once("../../../../config/all.php");
    
    $userId = $_SESSION['customer']['user_line']['userId'];
    $customer_id = $_SESSION['customer']['data']['customer_id'];
    $sql = "SELECT * FROM customer WHERE customer_id='".$DB->Escape($customer_id)."' ";
    $customer = $DB->QueryFirst($sql);
    if( $customer==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลลูกค้า"
        ));
        exit();
    }
    $rs = $DB->QueryDelete("user_line", "customer_id='".$DB->Escape($customer_id)."' AND userId='".$DB->Escape($userId)."' ");
    if($rs) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ออกจากระบบเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }