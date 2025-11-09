<?php
    include_once('../config/all.php');

    $province_id = $_POST['province_id'] ?? "";

    $sql = "SELECT * FROM th_amphur WHERE province_id='".$DB->Escape($province_id)."' ORDER BY amphur_name_thai ASC";
    $data = $DB->QueryObj($sql);

    echo json_encode([
        "status"=>"ok",
        "data"=>$data
    ]);
    
    