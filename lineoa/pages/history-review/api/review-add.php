<?php
    include_once("../../../../config/all.php");

    $random_id = trim($_POST['random_id'] ?? "");
    $service_booking_id = trim($_POST['service_booking_id'] ?? "");
    $review_star = trim($_POST['review_star'] ?? "");
    $review_comment = trim($_POST['review_comment'] ?? "");

    if(  $service_booking_id == "" ||
        $review_star == ""
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
    $sql = "SELECT * FROM `service_booking` WHERE service_booking_id='".$DB->Escape($service_booking_id)."' ";
    $service_booking = $DB->QueryFirst($sql);
    if( $service_booking==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลการใช้บริการ"
        ));
        exit();
    }

    $rs = $DB->QueryInsert("service_booking_review", [
        "service_booking_id"=>$service_booking["service_booking_id"],
        "review_star"=>$review_star,
        "review_comment"=>$review_comment,
        "add_by"=>$customer["customer_name"]." ".$customer["customer_sname"],
        "add_when"=>date("Y-m-d H:i:s")
    ]);
    if($rs) {
        $dir_temp = "../../../../files/temp/".$random_id."/";
        $dir = "../../../../files/service_booking_review/".$service_booking["service_booking_id"]."/";
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
        
        
        // Insert Timeline
        $DB->QueryInsert("service_booking_timeline", [
            "service_booking_timeline_id"=>$DB->QueryMaxid("service_booking_timeline", "service_booking_timeline_id"),
            "service_booking_id"=>$service_booking["service_booking_id"],
            "timeline_desc"=>'ได้ให้คะแนนต่อการใช้บริการแล้ว',
            "add_by"=>$customer["customer_name"]." ".$customer["customer_sname"],
            "add_when"=>date("Y-m-d H:i:s"),
        ]);
        
        
        echo json_encode(array(
            "status"=>"ok",
            "message"=>'บันทึกการให้คะแนนเรียบร้อย'
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }