<?php
    include_once("../../../../config/all.php");

    $search = trim($_POST['search'] ?? "");

    $condition = "";
    $arr = explode(" ", $search);
    foreach($arr as $v) {
        if($v=="") continue;
        $condition .= " AND (
            s.service_name LIKE '%".$v."%'
            OR s.service_desc LIKE '%".$v."%'
        )";
    }

    $sql = "
        SELECT 
            s.*
        FROM service s
        WHERE 1=1
            ".$condition."
        ORDER BY service_name
        LIMIT 50
    ";
    $data = $DB->QueryObj($sql);
    foreach($data as $row) {
        echo '
            <li class="list-group-item d-flex justify-content-between align-items-start" data-json="'.htmlspecialchars(json_encode($row)).'">
                <div class="ms-2 me-auto">
                    <div class="fw-bold">'.$row["service_name"].'</div>
                    '.$row["service_desc"].'
                </div>
                <a href="./?page=service_booking-add&service_id='.$row["service_id"].'" class="btn btn-success btn-lg">
                    เลือก
                </a>
            </li>
        ';
    }
    