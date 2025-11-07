<?php
    include_once("../../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    
    $search = trim($_POST['search'] ?? "");

    $condition = "";
    $arr = explode(" ", $search);
    foreach($arr as $v) {
        if($v=="") continue;
        $condition .= " AND (
            sb.service_booking_id LIKE '%".$v."%'
            OR sb.service_name LIKE '%".$v."%'
            OR sb.note LIKE '%".$v."%'
            OR sb.location LIKE '%".$v."%'
        )";
    }

    $sql = "
        SELECT 
            sb.*
        FROM service_booking sb
        WHERE sb.status IN (1, 2, 3, 4)
            AND sb.customer_id='".$DB->Escape($customer_id)."'
            ".$condition."
        ORDER BY add_when DESC
        LIMIT 50
    ";
    $data = $DB->QueryObj($sql);
    if( sizeof($data)>0 ) {
        echo '<div class="list-group">';
        foreach($data as $row) {
            echo '
                <a href="./?page=history-detail&service_booking_id='.$row["service_booking_id"].'" class="list-group-item list-group-item-action d-flex justify-content-between align-items-center" data-json="'.htmlspecialchars(json_encode($row)).'">
                    <div class="ms-2 me-auto">
                        <div>
                            <span class="fw-bold">'.$row["service_booking_id"].'</span> -
                            '.$row["service_name"].'
                        </div>
                        <div>'.Func::DateTh($row["booking_datetime"]).' น.</div>
                        <div>'.$StatusServiceBooking[$row["status"]].'</div>
                    </div>
                    <i class="fa-solid fa-arrow-right"></i>
                </a>
            ';
        }
        echo '</div>';
    } else {
        echo '<div class="text-center py-5">ไม่พบข้อมูลประวัติการใช้บริการ</div>';
    }
    