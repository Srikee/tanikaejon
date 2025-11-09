<?php
    include_once('../config/all.php');

    $amphur_id = $_POST['amphur_id'] ?? "";

    $sql = "SELECT * FROM th_tambol WHERE amphur_id='".$DB->Escape($amphur_id)."' ORDER BY tambol_name_thai ASC";
    $data = $DB->QueryObj($sql);

    echo json_encode([
        "status"=>"ok",
        "data"=>$data
    ]);
    
    