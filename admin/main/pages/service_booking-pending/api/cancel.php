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
    $service_booking_id = $service_booking["service_booking_id"];

    // if( $DB->QueryHaving("plan", "plan_name", $field['plan_name']) ) {
    //     echo json_encode(array(
    //         "status"=>false,
    //         "message"=>"ไม่สามารถเพิ่มได้ เนื่องจากคุณระบุชื่อซ้ำกับที่มีอยู่ !!!"
    //     ));
    //     exit();
    // }
    $rs = $DB->QueryUpdate("service_booking", [
        "status"=>"4",
        "edit_by"=>$_SESSION["tnkj_staff"]["username"],
        "edit_when"=>date("Y-m-d H:i:s")
    ], "service_booking_id='".$DB->Escape($service_booking_id)."' ");
    if( $rs ) {

        $timeline_desc = "รหัสขอใช้บริการเลขที่ ".$service_booking_id." -> ยกเลิกใบคำขอใช้บริการแล้ว";
        // Insert Timeline
        $service_booking_timeline_id = $DB->QueryMaxid("service_booking_timeline", "service_booking_timeline_id");
        $rs = $DB->QueryInsert("service_booking_timeline", [
            "service_booking_timeline_id"=>$service_booking_timeline_id,
            "service_booking_id"=>$service_booking_id,
            "timeline_desc"=>$timeline_desc,
            "add_by"=>$_SESSION["tnkj_staff"]["username"],
            "add_when"=>date("Y-m-d H:i:s"),
        ]);

        // ส่งแจ้งเตือนไลน์
        $userId = $service_booking["userId"];
        $message = $service_booking_id;
        $url = "line://app/2008357457-opkvYyB0?page=history-detail&service_booking_id=".$service_booking_id;
        SentMessageToLine($userId, $message, $url);

        echo json_encode(array(
            "status"=>"ok",
            "message"=>"ยกเลิกใบคำขอใช้บริการนี้เรียบร้อย"
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่สามารถติดต่อฐานข้อมูลได้ !!!"
        ));
    }
    