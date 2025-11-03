<?php
    include_once("../../../config/all.php");

    $pictureUrl = $_SESSION['customer']['user_line']['pictureUrl'];
    if( $pictureUrl==null || $pictureUrl=="" ) {
        $pictureUrl = "../images/default-profile.png?v=".$VERSION;
    }
?>
<div class="container-fluid my-5">
    <h4 class="text-center mb-5">
        แบบฟอร์มลงทะเบียน
    </h4>
    <form id="formdata" autocomplete="off">
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
                autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="customer_sname">นามสกุล <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" id="customer_sname" name="customer_sname"
                autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="address">ที่อยู่
                <span class="text-danger">*
                    <small>กรอกบ้านเลขที่, หมู่ที่, ถนน, ซอย, อาคาร (ถ้ามี)</small>
                </span>
            </label>
            <textarea class="form-control form-control-lg" id="address" name="address" rows="2" autocomplete="off"
                required></textarea>
        </div>
        <div class="mb-3">
            <label for="th_address">ตำบล/อำเภอ/จังหวัด <span class="text-danger">*</span></label>
            <textarea class="form-control form-control-lg" id="th_address" autocomplete="off" rows="2"
                readonly></textarea>
            <input type="hidden" name="tambol_id" id="tambol_id">
            <input type="hidden" name="amphur_id" id="amphur_id">
            <input type="hidden" name="province_id" id="province_id">
        </div>
        <div class="mb-3">
            <label for="zipcode">รหัสไปรษณีย์ <span class="text-danger">*</span></label>
            <input type="text" class="form-control form-control-lg" id="zipcode" name="zipcode" autocomplete="off"
                required>
        </div>
        <div class="mb-3">
            <label for="occupation_id">อาชีพ <span class="text-danger">*</span></label>
            <select class="form-control form-control-lg" id="occupation_id" name="occupation_id" required>
                <option value="">-- เลือกอาชีพ --</option>
                <?php
                    $sql = "SELECT * FROM occupation ORDER BY occupation_name ASC";
                    $obj = $DB->QueryObj($sql);
                    foreach ($obj as $row) {
                        echo '<option value="' . $row['occupation_id'] . '">' . $row['occupation_name'] . '</option>';
                    }
                ?>
            </select>
        </div>
        <div class="mb-3">
            <label for="phone">เบอร์มือถือ <span class="text-danger">* ระบุ 10 หลัก ไม่มีขีด</span></label>
            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" maxlength="10"
                autocomplete="off" required>
        </div>
        <div class="mb-3">
            <label for="password">กำหนดรหัสผ่านเข้าระบบ <span class="text-danger">*</span></label>
            <input type="password" class="form-control form-control-lg mb-4" id="password" name="password"
                autocomplete="off" required>
        </div>
        <div class="row">
            <div class="col pe-2">
                <button type="button" class="btn btn-light btn-lg w-100" onclick="Func.Back()">
                    <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
                </button>
            </div>
            <div class="col ps-2">
                <button type="submit" class="btn btn-success btn-lg btn-block w-100">
                    <i class="fas fa-sign-in-alt me-1"></i> ลงทะเบียน
                </button>
            </div>
        </div>
    </form>
</div>