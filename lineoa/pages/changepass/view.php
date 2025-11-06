<?php
    include_once("../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    $sql = "
        SELECT 
            c.*,
            o.occupation_name
        FROM customer c
            LEFT JOIN occupation o ON o.occupation_id = c.occupation_id
        WHERE c.customer_id = '".$customer_id."' 
    ";
    $customer = $DB->QueryFirst($sql);

    $pictureUrl = $customer["pictureUrl"];
    if( $pictureUrl==null || $pictureUrl=="" ) {
        $pictureUrl = "../images/default-profile.png?v=".$VERSION;
    }
?>
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    เปลี่ยนรหัสผ่าน
</div>
<div class="container-fluid py-4">
    <form id="formdata" autocomplete="off">
        <input type="submit" id="form-submit" class="d-none">
        <div class="mb-3">
            <label>เบอร์มือถือ</label>
            <input type="text" class="form-control form-control-lg" value="<?php echo $customer["phone"]; ?>"
                autocomplete="off" disabled>
        </div>
        <div class="mb-3">
            <label for="password1" class="form-label">รหัสผ่านเดิม <span class="text-danger">*</span></label>
            <input type="password" class="form-control form-control-lg" id="password1" name="password1"
                autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="password2" class="form-label">รหัสผ่านใหม่ <span class="text-danger">*</span></label>
            <input type="password" class="form-control form-control-lg" id="password2" name="password2"
                autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="password3" class="form-label">ยืนยันรหัสผ่านอีกครั้ง <span class="text-danger">*</span></label>
            <input type="password" class="form-control form-control-lg" id="password3" name="password3"
                autocomplete="off" required>
        </div>
    </form>
</div>
<div class="footer">
    <div class="text-end">
        <button type="button" id="btn-submit" class="btn btn-success btn-lg">
            <i class="fas fa-pen me-1"></i> ยืนยันการแก้ไข
        </button>
    </div>
</div>