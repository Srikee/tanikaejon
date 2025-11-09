<?php
    $staff_id = $_GET["staff_id"] ?? "";

    $sql = "
        SELECT 
            * 
        FROM staff
        WHERE staff_id='".$DB->Escape($staff_id)."'
    ";
    $obj = $DB->QueryObj($sql);
    if(sizeof($obj) == 0) {
        ShowAlert("", "ไม่พบข้อมูลเจ้าหน้าที่ที่ต้องการแก้ไข", "error", "./?page=staff");
        exit();
    }
    $data = $obj[0];
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=staff">ข้อมูลเจ้าหน้าที่</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">แก้ไขข้อมูลเจ้าหน้าที่</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <input type="hidden" name="staff_id" value="<?php echo $data["staff_id"]; ?>">
        <table class="table table-hover table-borderless">
            <tr>
                <th valign="middle" style="width:135px;">ชื่อ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="staff_name" name="staff_name"
                        value="<?php echo $data["staff_name"]; ?>" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">นามสกุล<span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="staff_sname" name="staff_sname"
                        value="<?php echo $data["staff_sname"]; ?>" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">ชื่อผู้ใช้งาน <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="username" name="username"
                        value="<?php echo $data["username"]; ?>" required>
                </td>
            </tr>
            <tr>
                <td valign="middle"></td>
                <td>
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" id="changepass" name="changepass" value="Y">
                        <label class="form-check-label" for="changepass">เปลี่ยนรหัสผ่าน</label>
                    </div>
                </td>
            </tr>
            <tr class="password" style="display:none">
                <th valign="middle">รหัสผ่านใหม่ <span class="text-danger">*</span></th>
                <td>
                    <div class="form-inner">
                        <input type="password" class="form-control" name="password1" id="password1">
                        <i class="fa-solid fa-eye inner-button" show-password="password1"></i>
                    </div>
                </td>
            </tr>
            <tr class="password" style="display:none">
                <th valign="middle">ยืนยันรหัสผ่าน <span class="text-danger">*</span></th>
                <td>
                    <div class="form-inner">
                        <input type="password" class="form-control" name="password2" id="password2">
                        <i class="fa-solid fa-eye inner-button" show-password="password2"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <th valign="middle">สถานะ <span class="text-danger">*</span></th>
                <td>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?php if($data["status"] == "1") echo "selected"; ?>>ใช้งานได้</option>
                        <option value="2" <?php if($data["status"] == "2") echo "selected"; ?>>ยกเลิก</option>
                    </select>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-warning me-2" staff="ยืนยันการแก้ไข">
                <i class="fas fa-pen me-1"></i>
                ยืนยันการแก้ไข
            </button>
            <a href="Javascript:Func.Reload()" class="btn btn-light border">
                <i class="fas fa-sync-alt me-1"></i>
                รีโหลด
            </a>
        </div>
    </form>
</div>