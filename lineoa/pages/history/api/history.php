<?php
    include_once("../../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    
    $search = trim($_POST['search'] ?? "");

    $condition = "";
    $arr = explode(" ", $search);
    foreach($arr as $v) {
        if($v=="") continue;
        $condition .= " AND (
            sb.service_name LIKE '%".$v."%'
            OR sb.note LIKE '%".$v."%'
            OR sb.location LIKE '%".$v."%'
        )";
    }

    $sql = "
        SELECT 
            sb.*
        FROM service_booking sb
        WHERE sb.customer_id='".$DB->Escape($customer_id)."'
            ".$condition."
        ORDER BY add_when DESC
        LIMIT 50
    ";
    $data = $DB->QueryObj($sql);
    foreach($data as $row) {
        echo '
            <li class="list-group-item d-flex justify-content-between align-items-start" data-json="'.htmlspecialchars(json_encode($row)).'">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">'.$row["service_name"].'</div>
                    '.$row["note"].'
                </div>
                <a href="./?page=history-detail&service_booking_id='.$row["service_booking_id"].'" class="btn btn-success btn-lg">
                    เลือก
                </a>
            </li>
        ';
    }
    