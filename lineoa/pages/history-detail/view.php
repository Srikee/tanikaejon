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

    $service_booking_id = trim( $_GET["service_booking_id"] ?? "" );
    $sql = "
        SELECT 
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id = sb.customer_id
        WHERE sb.status IN (1, 2, 3, 4)
            AND sb.service_booking_id = '".$DB->Escape($service_booking_id)."' 
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
    รายละเอียดขอใช้บริการ
    <button type="button" class="btn-header-reload" onclick="Func.Reload()">
        <i class="fas fa-rotate"></i>
    </button>
</div>
<div class="container-fluid">
    <div>
        <table class="table table-hover mb-4">
            <tr>
                <th style="min-width:140px;width:140px;">รหัสขอใช้บริการ</th>
                <td class="fw-bold">
                    <?php echo $service_booking["service_booking_id"]; ?>
                </td>
            </tr>
            <tr>
                <th>วันที่ส่งขอใช้บริการ</th>
                <td>
                    <?php echo Func::DateTh($service_booking["booking_datetime"]); ?> น.
                </td>
            </tr>
            <tr>
                <th>บริการขอใช้</th>
                <td>
                    <?php echo $service_booking["service_name"]; ?>
                </td>
            </tr>
            <tr>
                <th>รายละเอียดการขอใช้บริการ</th>
                <td>
                    <?php echo nl2br($service_booking["note"]); ?>
                </td>
            </tr>
            <tr>
                <th>สถานที่</th>
                <td>
                    <?php echo nl2br($service_booking["location"]); ?>
                </td>
            </tr>
            <tr>
                <th>ผู้ใช้บริการ</th>
                <td>
                    <?php echo $service_booking["customer_name"]; ?>
                    <?php echo $service_booking["customer_sname"]; ?>
                </td>
            </tr>
            <tr>
                <th>เบอร์มือถือ</th>
                <td><?php echo $service_booking["phone"]; ?></td>
            </tr>
            <tr>
                <th>สถานะ</th>
                <td>
                    <?php echo $StatusServiceBooking[$service_booking["status"]]; ?>
                </td>
            </tr>
        </table>
        <div class="row mb-3 images-section">
            <?php
                $dir = "files/service_booking/".$service_booking["service_booking_id"]."/";
                $options = array(
                    "dir"   => "../../../".$dir
                );
                $files = Func::ListFile($options);
                foreach($files as $file) {
                    echo '
                        <div class="col-6">
                            <img src="../'.$dir.$file.'" alt="Image" class="image">
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
</div>
<div class="footer">
    <div class="row">
        <div class="col-auto pe-1">
            <a href="./?page=history-tracking&service_booking_id=<?php echo $service_booking["service_booking_id"]; ?>"
                class="btn btn-success btn-lg">
                <i class="fas fa-shuffle me-1"></i> ติดตาม
            </a>
        </div>
        <div class="col ps-1">
            <?php
                if( $service_booking["status"]=="3" ) {
                    $sql = "
                        SELECT 
                            sbr.*
                        FROM service_booking_review sbr
                        WHERE sbr.service_booking_id = '".$service_booking_id."' 
                    ";
                    $service_booking_review = $DB->QueryFirst($sql);
                    $button_title = "ให้คะแนน";
                    if( $service_booking_review!=null ) {
                        $button_title = "ดูคะแนน";
                    }
            ?>
            <a href="./?page=history-review&service_booking_id=<?php echo $service_booking["service_booking_id"]; ?>"
                class="btn btn-info btn-lg w-100">
                <i class="fas fa-star me-1"></i> <?php echo $button_title; ?>
            </a>
            <?php } else { ?>
            <button class="btn btn-info btn-lg w-100" disabled>
                <i class="fas fa-star me-1"></i> ให้คะแนน
            </button>
            <?php } ?>
        </div>
    </div>
</div>