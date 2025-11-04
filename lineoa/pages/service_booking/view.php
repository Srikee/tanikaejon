<?php
    include_once("../../../config/all.php");

    $service_id = $_GET["service_id"];
    $sql = "
        SELECT 
            s.*
        FROM service s
        WHERE s.service_id = '".$service_id."' 
    ";
    $service = $DB->QueryFirst($sql);
    if($service==null) {
        echo "No Data Service";
        exit();
    }

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
    if($customer==null) {
        echo "No Data Customer";
        exit();
    }

    $pictureUrl = $customer["pictureUrl"];
    if( $pictureUrl==null || $pictureUrl=="" ) {
        $pictureUrl = "../images/default-profile.png?v=".$VERSION;
    }
?>
<div class="header">
    บริการของเรา
</div>
<div class="container-fluid">
    <form id="formdata" autocomplete="off">
        <input type="submit" id="btn-submit" class="d-none">
        <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
        <div class="mb-3">
            <label>บริการ</label>
            <input type="text" class="form-control form-control-lg" value="<?php echo $service["service_name"]; ?>"
                disabled>
        </div>
        <div class="mb-3">
            <label for="note" class="form-label">รายละเอียดการใช้บริการ <span class="text-danger">*</span></label>
            <textarea class="form-control form-control-lg" id="note" name="note" rows="5" required></textarea>
        </div>
        <div class="mb-3">
            <label for="location" class="form-label">สถานที่ <span class="text-danger">*</span></label>
            <textarea class="form-control form-control-lg" id="location" name="location" rows="3" required></textarea>
        </div>
        <div class="mb-3">
            <label for="customer" class="form-label">ผู้ใช้บริการ <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg"
                value="<?php echo $customer["customer_name"]; ?> <?php echo $customer["customer_sname"]; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="phone" class="form-label">เบอร์มือถือติดต่อ <span class="text-danger">* ระบุ 10 หลัก
                    ไม่มีขีด</span></label>
            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" maxlength="10"
                value="<?php echo $customer["phone"]; ?>" required>
        </div>
    </form>
</div>
<div class="footer">
    <div class="row">
        <div class="col pe-2">
            <button type="button" id="btn-image" class="btn btn-light btn-lg w-100">
                <i class="fas fa-images me-1"></i> เพิ่มรูป
            </button>
        </div>
        <div class="col ps-2">
            <button type="button" id="btn-submit" class="btn btn-success btn-lg w-100">
                <i class="fas fa-envelope me-1"></i> ส่งข้อมูล
            </button>
        </div>
    </div>
</div>