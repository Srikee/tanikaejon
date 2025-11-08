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
    $service_booking_id = trim($_POST["service_booking_id"] ?? "");
    $timeline_desc = trim($_POST["timeline_desc"] ?? "");

    if( $random_id=="" || $service_booking_id=="" || $timeline_desc=="" ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"กรุณากรอกข้อมูลให้ครบถ้วน"
        ));
        exit();
    }

    $sql = "
        SELECT 
            sb.*,
            c.userId,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id=sb.customer_id
        WHERE sb.service_booking_id='".$DB->Escape($service_booking_id)."' 
    ";
    $service_booking = $DB->QueryFirst($sql);
    if( $service_booking==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลผู้ขอใช้บริการ"
        ));
        exit();
    }

    $sql = "
        SELECT
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id=sb.customer_id
        WHERE sb.service_booking_id='".$DB->Escape($service_booking_id)."'
    ";
    $data = $DB->QueryFirst($sql);
    if($data==null) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"No Data"
        ));
        exit();
    }
    $service_booking_id = $data["service_booking_id"];

    $rs = $DB->QueryUpdate("service_booking", [
        "status"=>"2",
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], " service_booking_id='".$service_booking_id."' ");
    if( $rs ) {

        // Insert Timeline
        $service_booking_timeline_id = $DB->QueryMaxid("service_booking_timeline", "service_booking_timeline_id");
        $rs = $DB->QueryInsert("service_booking_timeline", [
            "service_booking_timeline_id"=>$service_booking_timeline_id,
            "service_booking_id"=>$service_booking_id,
            "timeline_desc"=>$timeline_desc,
            "add_by"=>$_SESSION["tnkj_staff"]["username"],
            "add_when"=>date("Y-m-d H:i:s"),
        ]);
        $dir_temp = $SERVER_ROOT."../files/temp/".$random_id."/";
        $dir = $SERVER_ROOT."../files/service_booking_timeline/".$service_booking_timeline_id."/";
        $options = array(
            "dir" => $dir
        );
        Func::MakeDir($options);
        $options = array( 
            "dir1" => $dir_temp,
            "dir2" => $dir
        );
        Func::MoveFiles($options);
        $options = array(
            "dir" => $dir_temp
        );
        Func::RemoveDir($options);
        $DB->QueryDelete("image_temp", "random_id='".$DB->Escape($random_id)."' ");


        $userId = $service_booking["userId"];
        $message = "รหัสขอใช้บริการเลขที่ ".$service_booking["service_booking_id"]." -> ".$timeline_desc;
        $url = "line://app/2008357457-opkvYyB0?page=history-detail&service_booking_id=".$service_booking["service_booking_id"];
        SentMessageToLine($userId, $message, $url);
        
        echo json_encode(array(
            "status"=>"ok",
            "message"=>'บันทึกผลการดำเนินงานเรียบร้อย'
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }