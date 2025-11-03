<?php
    include_once("../../../../config/all.php");
    $search = trim($_POST["search"]) ?? '';

    $condition = "";
    $arr = explode(" ", $search);
    foreach($arr as $v) {
        $condition .= " AND (
            t.tambol_name_thai LIKE '%".$v."%'
            OR a.amphur_name_thai LIKE '%".$v."%'
            OR p.province_name_thai LIKE '%".$v."%'
            OR t.zipcode LIKE '%".$v."%'
        )";
    } 

    $sql = "
        SELECT 
            t.*,
            a.amphur_id,
            a.amphur_name_thai,
            p.province_id,
            p.province_name_thai
        FROM th_tambol t
            LEFT JOIN th_amphur a ON a.amphur_id=t.amphur_id
            LEFT JOIN th_province p ON p.province_id=a.province_id
        WHERE 1=1 
            ".$condition."
        LIMIT 100
    ";
    $data = $DB->QueryObj($sql);
    foreach($data as $row) {
        echo '
            <a href="Javascript:" class="list-group-item list-group-item-action" data-json="'.htmlspecialchars(json_encode($row)).'">
                <span class="badge text-bg-secondary">'.$row["tambol_name_thai"].'</span>
                <span class="badge text-bg-secondary">'.$row["amphur_name_thai"].'</span>
                <span class="badge text-bg-secondary">'.$row["province_name_thai"].'</span>
                <span class="badge text-bg-secondary">'.$row["zipcode"].'</span>
            </a>
        ';
    }