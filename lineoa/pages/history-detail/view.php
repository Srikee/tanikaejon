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
    ประวัติการใช้บริการ
</div>
<div class="container-fluid">
    <div>
        <table class="table table-hover mb-4">
            <tr>
                <th style="min-width:140px;width:140px;">บริการ</th>
                <td>
                    <?php echo $service_booking["service_name"]; ?>
                </td>
            </tr>
            <tr>
                <th>รายละเอียดการใช้บริการ</th>
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