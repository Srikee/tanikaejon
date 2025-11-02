<?php
    include_once("../../config/all.php");
    $user_line = $_POST["user_line"];




    $sql = "SELECT * FROM user_line WHERE userId='".$DB->Escape($user_line["userId"])."' ";
    $obj = $DB->QueryObj($sql);
    $_SESSION["customer"]["user_line"] = $user_line;
    if( sizeof($obj)==1 ) {
		$customer_id = $obj[0]["customer_id"];
		$sql = "
			SELECT 
                c.*
			FROM customer c
			WHERE c.customer_id='".$DB->Escape($customer_id)."' 
		";
		$objCustomer = $DB->QueryFirst($sql);
        if( $objCustomer==null ) {
            echo json_encode(array(
                "status"=>"no",
                "message"=>"ไม่พบข้อมูลลูกค้า"
            ));
            exit();
        }
        echo json_encode(array(
            "status"=>"ok",
            "data"=>$objCustomer
		));
        $_SESSION["customer"]["data"] = $objCustomer;
    } else {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"ไม่พบข้อมูล"
        ));
    }