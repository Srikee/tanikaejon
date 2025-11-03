<?php
    include_once("../../../../config/all.php");
    $customer_name = trim($_POST['customer_name'] ?? "");
    $customer_sname = trim($_POST['customer_sname'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $address = trim($_POST['address'] ?? "");
    $tambol_id = trim($_POST['tambol_id'] ?? "");
    $amphur_id = trim($_POST['amphur_id'] ?? "");
    $province_id = trim($_POST['province_id'] ?? "");
    $zipcode = trim($_POST['zipcode'] ?? "");
    $occupation_id = trim($_POST['occupation_id'] ?? "");
    $userId = @$_SESSION["customer"]["user_line"]["userId"];
    $displayName = @$_SESSION["customer"]["user_line"]["displayName"];
    $pictureUrl = @$_SESSION["customer"]["user_line"]["pictureUrl"];
    if(  $customer_name == "" ||
        $customer_sname == "" ||
        $phone == "" ||
        $address == "" ||
        $tambol_id == "" ||
        $amphur_id == "" ||
        $province_id == "" ||
        $zipcode == "" ||
        $occupation_id == "" ||
        strlen($phone) != 10
    ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
        ));
        exit();
    }
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
    $sql = "SELECT * FROM customer WHERE phone='".$DB->Escape($phone)."' AND customer_id!='".$DB->Escape($customer_id)."' ";
    $num = $DB->QueryNumRow($sql);
    if( $num!=0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เบอร์มือถือ ".$phone." เคยลงทะเบียนแล้ว กรุณาใช้เบอร์อื่นลงทะเบียน"
        ));
        exit();
    }
    $rs = $DB->QueryUpdate("customer", [
        "customer_name"=>$customer_name,
        "customer_sname"=>$customer_sname,
        "phone"=>$phone,
        "address"=>$address,
        "tambol_id"=>$tambol_id,
        "amphur_id"=>$amphur_id,
        "province_id"=>$province_id,
        "zipcode"=>$zipcode,
        "occupation_id"=>$occupation_id,
        "edit_by"=>$customer_name." ".$customer_sname,
        "edit_when"=>date("Y-m-d H:i:s")
    ], "customer_id='".$DB->Escape($customer_id)."' ");
    if($rs) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"แก้ไขโปรไฟล์เรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }