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

    $pictureUrl = $customer["pictureUrl"];
    if( $pictureUrl==null || $pictureUrl=="" ) {
        $pictureUrl = "../images/default-profile.png?v=".$VERSION;
    }
?>
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    แก้ไขโปรไฟล์ของฉัน
</div>
<div class="container-fluid py-4">
    <form id="formdata" autocomplete="off">
        <input type="submit" id="form-submit" class="d-none">
        <div class="profile-image">
            <img src="<?php echo $pictureUrl; ?>" alt="Profile" class="w-100">
        </div>
        <div class="mb-3">
            <label>ชื่อไลน์</label>
            <input type="text" class="form-control form-control-lg"
                value="<?php echo $_SESSION['customer']['user_line']['displayName']; ?>" disabled>
        </div>
        <div class="mb-3">
            <label for="customer_name">ชื่อ <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" id="customer_name" name="customer_name"
                autocomplete="off" value="<?php echo $customer["customer_name"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="customer_sname">นามสกุล <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" id="customer_sname" name="customer_sname"
                autocomplete="off" value="<?php echo $customer["customer_sname"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="address">ที่อยู่
                <span class="text-danger">*
                    <small>กรอกบ้านเลขที่, หมู่ที่, ถนน, ซอย, อาคาร (ถ้ามี)</small>
                </span>
            </label>
            <textarea class="form-control form-control-lg" id="address" name="address" rows="2" autocomplete="off"
                required><?php echo $customer["address"]; ?></textarea>
        </div>
        <?php
            $th_address = "ต.".$customer["tambol_name_thai"]." อ.".$customer["amphur_name_thai"]." จ.".$customer["province_name_thai"];
        ?>
        <div class="mb-3">
            <label for="th_address">ตำบล/อำเภอ/จังหวัด <span class="text-danger">*</span></label>
            <textarea class="form-control form-control-lg" id="th_address" autocomplete="off" rows="2"
                readonly><?php echo $th_address; ?></textarea>
            <input type="hidden" name="tambol_id" id="tambol_id" value="<?php echo $customer["tambol_id"]; ?>">
            <input type="hidden" name="amphur_id" id="amphur_id" value="<?php echo $customer["amphur_id"]; ?>">
            <input type="hidden" name="province_id" id="province_id" value="<?php echo $customer["province_id"]; ?>">
        </div>
        <div class="mb-3">
            <label for="zipcode">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" id="zipcode" name="zipcode" autocomplete="off"
                value="<?php echo $customer["zipcode"]; ?>" required>
        </div>
        <div class="mb-3">
            <label for="occupation_id">อาชีพ <span class="text-danger">*</span></label>
            <select class="form-control form-control-lg" id="occupation_id" name="occupation_id" required>
                <option value="">-- เลือกอาชีพ --</option>
                <?php
                    $sql = "SELECT * FROM occupation ORDER BY occupation_name ASC";
                    $obj = $DB->QueryObj($sql);
                    foreach ($obj as $row) {
                        $selected = ($row["occupation_id"]==$customer["occupation_id"]) ? "selected" : "";
                        echo '<option value="' . $row['occupation_id'] . '" '.$selected.'>' . $row['occupation_name'] . '</option>';
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="phone">เบอร์มือถือ <span class="text-danger">* ระบุ 10 หลัก ไม่มีขีด</span></label>
            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" maxlength="10"
                autocomplete="off" value="<?php echo $customer["phone"]; ?>" required>
        </div>
    </form>
</div>
<div class="footer">
    <!-- <div class="row">
        <div class="col pe-2">
            <button type="button" class="btn btn-light btn-lg w-100" onclick="Func.Back()">
                <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
            </button>
        </div>
        <div class="col ps-2">
            <button type="button" id="btn-submit" class="btn btn-success btn-lg w-100">
                <i class="fas fa-pen me-1"></i> ยืนยัน
            </button>
        </div>
    </div> -->
    <div class="text-end">
        <button type="button" id="btn-submit" class="btn btn-success btn-lg">
            <i class="fas fa-pen me-1"></i> ยืนยันการแก้ไข
        </button>
    </div>
</div>