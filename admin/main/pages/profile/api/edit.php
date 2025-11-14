<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $staff_id = trim($_POST["staff_id"] ?? "");
    
    $field = array(
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    );

    $sql = "SELECT * FROM staff WHERE staff_id='".$DB->Escape($staff_id)."' ";
    $staff = $DB->QueryFirst($sql);
    if( $staff==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่พบข้อมูล'
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
        if( $staff["image"]!="" ) {
            $options = array(
                "dir"       => $dir,
                "fileName"  => $staff["image"],
            );
            $removed = Func::RemoveFile($options);
        }
        $_SESSION['tnkj_staff']["image"] = $CLIENT_ROOT."../files/staff/".$field["image"]."?v=".$VERSION;
    }
    
    if( $DB->QueryUpdate("staff", $field, "staff_id='".$DB->Escape($staff_id)."'") ) {
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"แก้ไขข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    