<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $staff_id = $_POST["staff_id"] ?? "";

    // if( $DB->QueryHaving("plan", "plan_name", $field['plan_name']) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากคุณระบุชื่อซ้ำกับที่มีอยู่ !!!"
    //     ));
    //     exit();
    // }

    $sql = "SELECT * FROM staff WHERE staff_id='".$DB->Escape($staff_id)."' ";
    $staff = $DB->QueryFirst($sql);
    if( $staff==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>'ไม่พบข้อมูล'
        ));
        exit();
    }

    if( $DB->QueryDelete("staff", "staff_id='".$DB->Escape($staff_id)."' ") ) {
        $dir = $SERVER_ROOT."../files/staff/";
        $options = array(
            "dir"       => $dir,
            "fileName"  => $staff["image"],
        );
        $removed = Func::RemoveFile($options);
        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ลบข้อมูลเสร็จเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    