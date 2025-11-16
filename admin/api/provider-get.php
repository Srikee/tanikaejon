<?php
    include_once('../config/all.php');

    $search = isset($_GET['search']) ? $_GET['search'] : '';

    $condition = "";
    if ($search != "") {
        $condition .= " AND (
                provider_name LIKE '%".$DB->Escape($search)."%'
             OR provider_sname LIKE '%".$DB->Escape($search)."%'
             OR phone LIKE '%".$DB->Escape($search)."%'
        )";
    }

    $sql = "
        SELECT 
            * 
        FROM `provider` 
        WHERE `status` = '2' 
            ".$condition."
        ORDER BY 
            provider_name ASC,
            provider_sname ASC
    ";
    $data = $DB->QueryObj($sql);
    echo json_encode([
        "status" => "ok",
        "data" => $data
    ]);