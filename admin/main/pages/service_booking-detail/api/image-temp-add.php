<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $random_id = trim($_POST['random_id'] ?? "");
    $base64 = trim($_POST['base64'] ?? "");

    if(  $random_id == "" ||
        $base64 == ""
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
    
    $dir = "files/temp/".$random_id."/";
    $options = array(
        "dir" => $SERVER_ROOT."../".$dir
    );
    Func::MakeDir($options);
    $options = array(
        "base64"        => $base64,   // base64 string
        "dir"           => $SERVER_ROOT."../".$dir,              // path on sftp server
        "rename"        => time().Func::GenerateRandom(5),                        // new filename without extension (optional)
        "allowType"     => ["png"],     // allow file type
    );
    $uploader = Func::UploadBase64($options);
    if( $uploader["status"]=="ok" ) {
        // echo "Upload Success. File name : ".$uploader["fileName"];
        if( !$DB->QueryHaving("image_temp", "random_id", $random_id) ) {
            $DB->QueryInsert("image_temp", [
                "random_id"=>$random_id,
                "add_by"=>$_SESSION["tnkj_staff"]["username"],
                "add_when"=>date("Y-m-d H:i:s")
            ]);
        }

        echo json_encode(array(
            "status"=>"ok",
            "image"=>"../../".$dir.$uploader["fileName"]
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }