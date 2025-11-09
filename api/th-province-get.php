<?php
    include_once('../config/all.php');

    $sql = "SELECT * FROM th_province ORDER BY province_name_thai ASC";
    $data = $DB->QueryObj($sql);

    echo json_encode([
        "status"=>"ok",
        "data"=>$data
    ]);
    
    