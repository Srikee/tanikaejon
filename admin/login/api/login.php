<?php
    include_once('../../../config/all.php');

    $username = trim($_POST['username'] ?? "");
    $password = trim($_POST['password'] ?? "");

    // ตรวจสอบการกรอกข้อมูล
    if ($username == "" || $password == "") {
        echo json_encode([
            'status' => 'no',
            'message' => 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน',
        ]);
        exit();
    }

    $sql = "
        SELECT * 
        FROM staff 
        WHERE status='1'
            AND username='".$DB->Escape($username)."' 
            AND password='".$DB->Escape($password)."' 
    ";
    $staff = $DB->QueryFirst($sql);
    if( $staff==null ) {
        echo json_encode([
            'status' => 'no',
            'message' => 'ชื่อผู้ใช้และรหัสผ่านไม่ถูกต้อง',
        ]);
        exit();
    }

    // เข้าสู่ระบบสำเร็จ
    $_SESSION['tnkj_staff'] = $staff;

    echo json_encode([
        'status' => 'ok',
        'message' => 'เข้าสู่ระบบสำเร็จ'
    ]);