<?php
    include_once("../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    $sql = "
        SELECT 
            c.*,
            o.occupation_name,
            ta.tambol_name_thai,
            am.amphur_name_thai,
            pr.province_name_thai
        FROM customer c
            LEFT JOIN occupation o ON o.occupation_id = c.occupation_id
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

    $status = $service_booking["status"];
    // Func::PrintData($_SESSION);
?>
<input type="hidden" id="service_booking_id" value="<?php echo htmlspecialchars($service_booking_id); ?>">
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    ติดตามผล
</div>
<div class="container-fluid py-1">
    <div class="border pt-3 pb-2 rounded mb-4">
        <?php 
            if( in_array($status, ["1", "2","3"]) ) {
                $step1 = "completed";
                $step2 = "";
                $step3 = "";
                $step4 = "";
                $text1 = '<i class="fas fa-check"></i>';
                $text2 = '';
                $text3 = '';
                $text4 = '';
                if($status=="1") {
                    $step2 = "pending";
                    $step3 = "";
                    $step4 = "";
                    $text2 = '<i class="fas fa-hourglass-half"></i>';
                    $text3 = '';
                    $text4 = '';
                } else if($status=="2") {
                    $step2 = "completed";
                    $step3 = "pending";
                    $step4 = "";
                    $text2 = '<i class="fas fa-check"></i>';
                    $text3 = '<i class="fas fa-hourglass-half"></i>';
                    $text4 = '';
                } else if($status=="3") {
                    $step2 = "completed";
                    $step3 = "completed";
                    $step4 = "completed";
                    $text2 = '<i class="fas fa-check"></i>';
                    $text3 = '<i class="fas fa-check"></i>';
                    $text4 = '<i class="fas fa-check"></i>';
                }

        ?>
        <div class="step-horizontal">
            <div class="step <?php echo $step1; ?>">
                <div class="circle"><?php echo $text1; ?></div>
                <p>ขอใช้บริการ</p>
            </div>
            <div class="step <?php echo $step2; ?>">
                <div class="circle"><?php echo $text2; ?></div>
                <p>รับบริการแล้ว</p>
            </div>
            <div class="step <?php echo $step3; ?>">
                <div class="circle"><?php echo $text3; ?></div>
                <p>กำลังดำเนินการ</p>
            </div>
            <div class="step <?php echo $step4; ?>">
                <div class="circle"><?php echo $text4; ?></div>
                <p>เสร็จสิ้น</p>
            </div>
        </div>
        <?php } ?>
        <?php 
            if( in_array($status, ["4"]) ) {
        ?>
        <div class="step-horizontal">
            <div class="step completed">
                <div class="circle"><i class="fas fa-check"></i></div>
                <p>ขอใช้บริการ</p>
            </div>
            <div class="step cancel">
                <div class="circle"><i class="fas fa-times"></i></div>
                <p>ยกเลิก</p>
            </div>
        </div>
        <?php } ?>
    </div>

    <div>
        <h5 class="mb-3">ประวัติการดำเนินงาน</h5>
        <div class="timeline">
            <?php
                $sql = "
                    SELECT * FROM service_booking_timeline 
                    WHERE service_booking_id='".$service_booking_id."' 
                    ORDER BY add_when DESC
                ";
                $timelines = $DB->QueryObj($sql);
                foreach($timelines as $timeline) {
                    $dir = "../../../files/service_booking_timeline/".$timeline["service_booking_timeline_id"]."/";
                    $options = array(
                        "dir"   => $dir
                    );
                    $files = Func::ListFile($options);
                    $images = '';
                    if( sizeof($files)>0 ) {
                        $images = '<a href="Javascript:" class="subtext" data-id="'.$timeline["service_booking_timeline_id"].'" data-json="'.htmlspecialchars(json_encode($files)).'">ดูรูปภาพการดำเนินการ</a>';
                    }
                    echo '
                        <div class="timeline-item active">
                            <div class="timeline-date">
                                '.Func::DateThFull($timeline["add_when"], true).' น.
                            </div>
                            <div class="timeline-content">
                                <h4>'.$timeline["timeline_desc"].'</h4>
                                '.$images.'
                            </div>
                        </div>
                    ';
                }
            ?>
        </div>


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