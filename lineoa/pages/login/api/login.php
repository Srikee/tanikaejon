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

    $phone = trim($_POST['phone'] ?? "");
    $password = trim($_POST['password'] ?? "");
    if(  $phone == "" ||
        $password == ""
    ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
        ));
        exit();
    }
    
    $sql = "
        SELECT * 
        FROM customer 
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

    if( $customer["password"]!=Func::Encrypt($password) ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"รหัสผ่านไม่ถูกต้อง"
        ));
        exit();
    }

    $customer_id = $customer["customer_id"];
    $customer_name = $customer["customer_name"];
    $customer_sname = $customer["customer_sname"];

    $DB->QueryUpdate("customer", [
        "is_login"=>"2",
        "userId"=>"",
        "displayName"=>"",
        "pictureUrl"=>"",
        "edit_by"=>$customer_name." ".$customer_sname,
        "edit_when"=>date("Y-m-d H:i:s")
    ], " userId='".$userId."' ");

    $rs = $DB->QueryUpdate("customer", [
        "is_login"=>"1",
        "userId"=>$userId,
        "displayName"=>$displayName,
        "pictureUrl"=>$pictureUrl,
        "edit_by"=>$customer_name." ".$customer_sname,
        "edit_when"=>date("Y-m-d H:i:s")
    ], " customer_id='".$customer_id."' ");
    if($rs) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"เข้าสู่ระบบสำเร้จ"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }