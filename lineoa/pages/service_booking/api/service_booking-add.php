<?php
    include_once("../../../../config/all.php");
    $password1 = trim($_POST['password1'] ?? "");
    $password2 = trim($_POST['password2'] ?? "");
    $password3 = trim($_POST['password3'] ?? "");
    if(  $password1 == "" ||
        $password2 == "" ||
        $password3 == ""
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
    if( $customer["password"]!=Func::Encrypt($password1) ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"รหัสผ่านเดิมไม่ถูกต้อง"
        ));
        exit();
    }
    if( $password2!=$password3 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ยืนยันรหัสผ่านไม่ถูกต้อง"
        ));
        exit();
    }
    $rs = $DB->QueryUpdate("customer", [
        "password"=>Func::Encrypt($password3),
        "edit_by"=>$customer["customer_name"]." ".$customer["customer_sname"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "customer_id='".$DB->Escape($customer_id)."' ");
    if($rs) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"เปลี่ยนรหัสผ่านเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }