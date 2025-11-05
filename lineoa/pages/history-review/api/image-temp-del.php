<?php
    include_once("../../../../config/all.php");

    $random_id = trim($_POST['random_id'] ?? "");
    $filename = trim($_POST['filename'] ?? "");

    if(  $random_id == "" ||
        $filename == ""
    ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
        ));
        exit();
    }
    
    $dir = "../../../../files/temp/".$random_id."/";
    $options = array(
        "dir"       => $dir,
        "fileName"  => $filename,
    );
    $removed = Func::RemoveFile($options);
    if( $removed ) {
        $options = array(
            "dir"   => $dir
        );
        $files = Func::ListFile($options);
        if( sizeof($files)==0 ) {
            if (Func::RemoveDir($options)) {
                $DB->QueryDelete("image_temp", "random_id='".$DB->Escape($random_id)."' ");
            }
        }
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ลบไฟล์แล้ว"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ลบไฟล์ไม่ได้"
        ));
    }

    