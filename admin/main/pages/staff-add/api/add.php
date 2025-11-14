<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }
    $password1 = trim( $_POST["password1"] ?? "" );
    $password2 = trim( $_POST["password2"] ?? "" );
    if( $password1 != $password2 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ยืนยันรหัสผ่านไม่ถูกต้อง"
        ));
        exit();
    }
    // $field["password"] = Func::Encrypt($password2);
    $field = array(
        "staff_name"=>trim($_POST["staff_name"] ?? ""),
        "staff_sname"=>trim($_POST["staff_sname"] ?? ""),
        "username"=>trim($_POST["username"] ?? ""),
        "password"=>$password2,
        "status"=>trim($_POST["status"] ?? ""),
        "add_by"=>$_SESSION["tnkj_staff"]["username"],
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

    $skips = [];
    foreach($field as $k=>$f) {
        if( in_array($k, $skips) ) continue;
        $field[$k] = trim($f);
        if($field[$k]=="") {
            echo json_encode(array(
                "status"=>"no",
                "message"=>"กรุณาระบุข้อมูลให้ครบถ้วน -> ".$k." ว่าง"
            ));
            exit();
        }
    }

    $sql = "SELECT * FROM staff WHERE username='".$DB->Escape($field['username'])."' ";
    $obj = $DB->QueryObj($sql);
    if( count($obj) > 0 ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่สามารถเพิ่มได้ เนื่องจากคุณระบุ "ชื่อผู้ใช้งาน" ซ้ำกับที่มีอยู่'
        ));
        exit();
    }

    $base64 = $_POST["base64"] ?? "";  // 'data:image/png;base64,AAAFBfj42Pj4'
    $dir = $SERVER_ROOT."../files/staff/";
    $options = array(
        "base64"        => $base64,   // base64 string
        "dir"           => $dir,              // path on sftp server
        "rename"        => time().Func::GenerateRandom(5),                        // new filename without extension (optional)
        "allowType"     => ["png"],     // allow file type
    );
    $uploader = Func::UploadBase64($options);
    if( $uploader["status"]=="ok" ) {
        $field["image"] = $uploader["fileName"];
    }

    $field["staff_id"] = $DB->QueryMaxId("staff", "staff_id");
    if( $DB->QueryInsert("staff", $field) ) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"เพิ่มข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    