<?php
    include_once("../../../../config/all.php");
    $customer_name = trim($_POST['customer_name'] ?? "");
    $customer_sname = trim($_POST['customer_sname'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $password1 = trim($_POST['password1'] ?? "");
    $password2 = trim($_POST['password2'] ?? "");
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
        $password1 == "" ||
        $password2 == "" ||
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
    if( $password1 != $password2 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ยืนยันรหัสผ่านไม่ถูกต้อง"
        ));
        exit();
    }

    $sql = "SELECT * FROM customer WHERE phone='".$DB->Escape($phone)."' ";
    $customer = $DB->QueryFirst($sql);
    if( $customer!=null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เบอร์มือถือ ".$phone." เคยลงทะเบียนแล้ว กรุณาใช้เบอร์อื่นลงทะเบียน"
        ));
        exit();
    }
    $customer_id = $DB->QueryMaxId("customer", "customer_id");
    $rs = $DB->QueryInsert("customer", [
        "customer_id"=>$customer_id,
        "customer_name"=>$customer_name,
        "customer_sname"=>$customer_sname,
        "phone"=>$phone,
        "password"=>Func::Encrypt($password2),
        "address"=>$address,
        "tambol_id"=>$tambol_id,
        "amphur_id"=>$amphur_id,
        "province_id"=>$province_id,
        "zipcode"=>$zipcode,
        "occupation_id"=>$occupation_id,
        "is_login"=>"1",
        "userId"=>$userId,
        "displayName"=>$displayName,
        "pictureUrl"=>$pictureUrl,
        "status"=>"1",
        "add_by"=>$customer_name." ".$customer_sname,
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$customer_name." ".$customer_sname,
        "edit_when"=>date("Y-m-d H:i:s")
    ]);
    if($rs) {

        $DB->QueryUpdate("customer", [
            "is_login"=>"2",
            "userId"=>"",
            "displayName"=>"",
            "pictureUrl"=>"",
            "edit_by"=>$customer_name." ".$customer_sname,
            "edit_when"=>date("Y-m-d H:i:s")
        ], " userId='".$userId."' AND customer_id!='".$customer_id."' ");

        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ลงทะเบียนเรียบร้อยแล้ว รอเจ้าหน้าตรวจสอบข้อมูลภายใน 24 ชั่วโมง"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }