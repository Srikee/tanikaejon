<?php
    include_once("../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    $sql = "
        SELECT 
            c.*,
            o.occupation_name,
            ul.userId,
            ul.displayName,
            ul.pictureUrl,
            ta.tambol_name_thai,
            am.amphur_name_thai,
            pr.province_name_thai
        FROM customer c
            LEFT JOIN occupation o ON o.occupation_id = c.occupation_id
            LEFT JOIN user_line ul ON ul.customer_id = c.customer_id
            LEFT JOIN th_tambol ta ON ta.tambol_id=c.tambol_id
            LEFT JOIN th_amphur am ON am.amphur_id=c.amphur_id
            LEFT JOIN th_province pr ON pr.province_id=c.province_id
        WHERE c.customer_id = '".$customer_id."' 
    ";
    $customer = $DB->QueryFirst($sql);

    $service_booking_id = $_GET["service_booking_id"];
    $sql = "
        SELECT 
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id = c.customer_id
        WHERE sb.service_booking_id = '".$service_booking_id."' 
    ";
    $service_booking = $DB->QueryFirst($sql);
    if( $service_booking==null ) {
        echo "ไม่พบข้อมูลการใช้บริการ";
        exit();
    }

    // Func::PrintData($_SESSION);
?>
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    ติดตามผล
</div>
<div class="container-fluid py-4">
    <div>
        <div class="step-container">
            <div class="step completed">
                <div class="circle"></div>
                <p>ขอใช้บริการ</p>
            </div>
            <div class="step completed">
                <div class="circle"></div>
                <p>รับบริการแล้ว</p>
            </div>
            <div class="step active">
                <div class="circle"></div>
                <p>กำลังดำเนินการ</p>
            </div>
            <div class="step">
                <div class="circle"></div>
                <p>เสร็จสิ้น</p>
            </div>
        </div>

        <!-- <div class="step-container">
            <div class="step completed">
                <div class="circle"></div>
                <p>ขอใช้บริการ</p>
            </div>
            <div class="step">
                <div class="circle"></div>
                <p>ยกเลิก</p>
            </div>
        </div> -->
    </div>
</div>
<!-- <div class="footer">
    <div class="text-end">
        <a href="./?page=history-tracking&service_booking_id=<?php echo $service_booking["service_booking_id"]; ?>"
            class="btn btn-success btn-lg w-100">
            <i class="fas fa-shuffle me-1"></i> ติดตามผล
        </a>
    </div>
</div> -->