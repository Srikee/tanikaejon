<?php
    include_once("../../../../config/all.php");
    $customer_name = trim($_POST['customer_name'] ?? "");
    $customer_sname = trim($_POST['customer_sname'] ?? "");
    $phone = trim($_POST['phone'] ?? "");
    $password = trim($_POST['password'] ?? "");
    $address = trim($_POST['address'] ?? "");
    $occupation_id = trim($_POST['occupation_id'] ?? "");
    $userId = @$_SESSION["customer"]["user_line"]["userId"];
    $displayName = @$_SESSION["customer"]["user_line"]["displayName"];
    $pictureUrl = @$_SESSION["customer"]["user_line"]["pictureUrl"];
    if(  $customer_name == "" ||
        $customer_sname == "" ||
        $phone == "" ||
        $password == "" ||
        $address == "" ||
        $occupation_id == "" ||
        strlen($phone) != 10
    ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
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
        "password"=>Func::Encrypt($password),
        "address"=>$address,
        "occupation_id"=>$occupation_id,
        "status"=>"1",
        "add_by"=>$customer_name." ".$customer_sname,
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$customer_name." ".$customer_sname,
        "edit_when"=>date("Y-m-d H:i:s")
    ]);
    if($rs) {
        $rs = $DB->QueryInsert("user_line", [
            "userId"=>$userId,
            "displayName"=>$displayName,
            "pictureUrl"=>$pictureUrl,
            "customer_id"=>$customer_id,
            "add_by"=>$customer_name." ".$customer_sname,
            "add_when"=>date("Y-m-d H:i:s"),
            "edit_by"=>$customer_name." ".$customer_sname,
            "edit_when"=>date("Y-m-d H:i:s")
        ]);
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