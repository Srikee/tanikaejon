<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $forgot_id = trim( $_POST["forgot_id"] ?? "" );
    $customer_id = trim( $_POST["customer_id"] ?? "" );
    $changepass = trim( $_POST["changepass"] ?? "" );
    $password1 = trim( $_POST["password1"] ?? "" );
    $password2 = trim( $_POST["password2"] ?? "" );
    $status = trim( $_POST["status"] ?? "" );
    
    if( $changepass=="Y" ) {
        if( $password1 == "" ) {
            echo json_encode(array(
                "status"=>"no",
                "message"=>"รหัสผ่านว่างเปล่า"
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
        $field["password"] = Func::Encrypt($password2);
    }
    
    $rs = $DB->QueryUpdate("forgot", [
        "status"=>$status,
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "forgot_id='".$DB->Escape($forgot_id)."' ");

    if( $rs ) {
        if( $changepass=="Y" ) {
            $DB->QueryUpdate("customer", [
                "password"=>$password2,
                "edit_by"=>$_SESSION["tnkj_staff"]["username"],
                "edit_when"=>date("Y-m-d H:i:s")
            ], "customer_id='".$DB->Escape($customer_id)."' ");
        }
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"บันทึกเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    