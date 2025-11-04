<?php
    include_once("../../../../config/all.php");

    $random_id = trim($_POST['random_id'] ?? "");
    $service_id = trim($_POST['service_id'] ?? "");
    $note = trim($_POST['note'] ?? "");
    $location = trim($_POST['location'] ?? "");
    $phone = trim($_POST['phone'] ?? "");

    if(  $service_id == "" ||
        $note == "" ||
        $location == "" ||
        $phone == "" ||
        strlen($phone) != 10
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
    $sql = "SELECT * FROM `service` WHERE service_id='".$DB->Escape($service_id)."' ";
    $service = $DB->QueryFirst($sql);
    if( $service==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลบริการ"
        ));
        exit();
    }

    $service_booking_id = $DB->QueryMaxId("service_booking", "service_booking_id");
    $rs = $DB->QueryInsert("service_booking", [
        "service_booking_id"=>$service_booking_id,
        "customer_id"=>$customer_id,
        "service_id"=>$service["service_id"],
        "service_name"=>$service["service_name"],
        "booking_datetime"=>date("Y-m-d H:i:s"),
        "note"=>$note,
        "location"=>$location,
        "phone"=>$phone,
        "status"=>"1",
        "add_by"=>$customer["customer_name"]." ".$customer["customer_sname"],
        "add_when"=>date("Y-m-d H:i:s"),
        "edit_by"=>$customer["customer_name"]." ".$customer["customer_sname"],
        "edit_when"=>date("Y-m-d H:i:s")
    ]);
    if($rs) {
        $dir_temp = "../../../../files/service_booking_temp/".$random_id."/";
        $dir = "../../../../files/service_booking/".$service_booking_id."/";
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
        $DB->QueryDelete("service_booking_image_temp", "random_id='".$DB->Escape($random_id)."' ");
        echo json_encode(array(
            "status"=>"ok",
            "message"=>'ส่งข้อมูลขอใช้บริการเรียบร้อย คุณสามารถติดตามข้อมูลในหน้า "ประวัติการใช้บริการ" ได้',
            "service_booking_id"=>$service_booking_id
        ));
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"เกิดข้อผิดพลาดในการติดต่อฐานข้อมูล กรุณาลองใหม่อีกครั้ง"
        ));
    }