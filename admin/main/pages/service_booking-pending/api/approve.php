<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $service_booking_id = trim( $_POST["service_booking_id"] ?? "" );
    $provider_id = trim( $_POST["provider_id"] ?? "" );

    if(  $service_booking_id == "" || $provider_id == "" ) {
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

    $sql = "SELECT * FROM provider WHERE status='2' AND provider_id='".$DB->Escape($provider_id)."' ";
    $provider = $DB->QueryFirst($sql);
    if( $provider==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบผู้ให้บริการ"
        ));
        exit();
    }

    $rs = $DB->QueryUpdate("service_booking", [
        "status"=>"2",
        "provider_id"=>$provider["provider_id"],
        "provider_fullname"=>$provider["provider_name"]." ".$provider["provider_sname"],
        "provider_phone"=>$provider["phone"],
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "service_booking_id='".$DB->Escape($service_booking_id)."' ");
    if( $rs ) {

        // Insert Timeline
        $DB->QueryInsert("service_booking_timeline", [
            "service_booking_timeline_id"=>$DB->QueryMaxid("service_booking_timeline", "service_booking_timeline_id"),
            "service_booking_id"=>$service_booking_id,
            "timeline_desc"=>'รับเรื่องการขอใช้บริการแล้ว',
            "add_by"=>$_SESSION["tnkj_staff"]["username"],
            "add_when"=>date("Y-m-d H:i:s"),
        ]);

        $userId = $service_booking["userId"];
        $message = "รหัสขอใช้บริการเลขที่ ".$service_booking["service_booking_id"]." เจ้าหน้าที่รับเรื่องการขอใช้บริการแล้ว";
        $url = "line://app/2008357457-opkvYyB0?page=history-detail&service_booking_id=".$service_booking["service_booking_id"];
        SentMessageToLine($userId, $message, $url);

        echo json_encode(array(
            "status"=>"ok",
            "message"=>"รับเรื่องเรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    