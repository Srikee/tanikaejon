<?php
    include_once("../../config/all.php");
    $user_line = $_POST["user_line"];

    $userId = trim($_POST["user_line"]["userId"] ?? "");
    $displayName = trim($_POST["user_line"]["displayName"] ?? "");
    $pictureUrl = trim($_POST["user_line"]["pictureUrl"] ?? "");

    if( $userId=="" || $displayName=="" ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบบัญชี Line ของคุณ"
        ));
        exit();
    }
    $_SESSION["customer"]["user_line"] = $user_line;
    $sql = "
        SELECT 
            c.*
        FROM customer c
        WHERE c.userId='".$DB->Escape($userId)."' 
    ";
    $objCustomer = $DB->QueryFirst($sql);
    if( $objCustomer==null ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูลลูกค้า"
        ));
        exit();
    }
    if( $objCustomer["is_login"]=="1" ) {
        $rs = $DB->QueryUpdate("customer", [
            "userId"=>$userId,
            "displayName"=>$displayName,
            "pictureUrl"=>$pictureUrl,
            // "edit_by"=>"",
            "edit_when"=>date("Y-m-d H:i:s")
        ], " customer_id='".$objCustomer["customer_id"]."' ");
        $objCustomer["userId"] = $userId;
        $objCustomer["displayName"] = $displayName;
        $objCustomer["pictureUrl"] = $pictureUrl;
        $_SESSION["customer"]["data"] = $objCustomer;
        echo json_encode(array(
            "status"=>"ok",
            "data"=>$objCustomer
		));
    } else {
        unset($_SESSION["customer"]["data"]);
        echo json_encode(array(
            "status"=>"no",
            "message"=>"บัญชีของคุณได้ออกจากระบบ"
        ));
    }