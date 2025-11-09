<?php
    include_once("../../../../config/all.php");

    $phone = trim($_POST['phone'] ?? "");
    if(  $phone == "" || strlen($phone) != 10 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
        ));
        exit();
    }
    $userId = @$_SESSION["customer"]["user_line"]["userId"];
    $displayName = @$_SESSION["customer"]["user_line"]["displayName"];
    $pictureUrl = @$_SESSION["customer"]["user_line"]["pictureUrl"];
    
    $sql = "
        SELECT * FROM customer 
        WHERE phone='".$DB->Escape($phone)."'
    ";
    $customer = $DB->QueryFirst($sql);
    if( $customer==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลเบอร์มือถือ หรือเบอร์มือถือนี้ยังไม่เคยลงทะเบียน"
        ));
        exit();
    }
    $forgot_id = $DB->QueryMaxId("forgot", "forgot_id");
    $rs = $DB->QueryInsert("forgot", [
        "forgot_id"=>$forgot_id,
        "phone"=>$phone,
        "status"=>"1",
        "customer_id"=>$customer["customer_id"],
        "userId"=>$userId,
        "displayName"=>$displayName,
        "pictureUrl"=>$pictureUrl,
        "add_by"=>$displayName,
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$displayName,
        "edit_when"=>date("Y-m-d H:i:s")
    ]);
    if($rs) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ส่งข้อมูลเรียบร้อย รอเจ้าหน้าตรวจสอบและติดต่อกลับภายใน 24 ชั่วโมง"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }

    