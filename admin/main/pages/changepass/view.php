<?php
    $staff_id = $_SESSION['tnkj_staff']["staff_id"];
    $sql = "
        SELECT 
            * 
        FROM staff
        WHERE staff_id='".$DB->Escape($staff_id)."'
    ";
    $data = $DB->QueryFirst($sql);
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=changepass">เปลี่ยนรหัสผ่าน</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <input type="hidden" name="staff_id" value="<?php echo $data["staff_id"]; ?>">
        <table class="table table-hover table-borderless">
            <tr>
                <th valign="middle" style="width:140px;">รหัสผ่านเดิม <span class="text-danger">*</span></th>
                <td>
                    <div class="form-inner">
                        <input type="text" class="form-control" name="password1" id="password1" required>
                        <i class="fa-solid fa-eye inner-button" show-password="password1"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <th valign="middle">รหัสผ่านใหม่ <span class="text-danger">*</span></th>
                <td>
                    <div class="form-inner">
                        <input type="text" class="form-control" name="password2" id="password2" required>
                        <i class="fa-solid fa-eye inner-button" show-password="password1"></i>
                    </div>
                </td>
            </tr>
            <tr>
                <th valign="middle">ยืนยันรหัสผ่าน <span class="text-danger">*</span></th>
                <td>
                    <div class="form-inner">
                        <input type="text" class="form-control" name="password3" id="password3" required>
                        <i class="fa-solid fa-eye inner-button" show-password="password1"></i>
                    </div>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-warning me-2" staff="ยืนยันการแก้ไข">
                <i class="fas fa-key me-1"></i>
                ยืนยันการเปลี่ยนรหัสผ่าน
            </button>
            <a href="Javascript:Func.Reload()" class="btn btn-light border">
                <i class="fas fa-sync-alt me-1"></i>
                รีโหลด
            </a>
        </div>
    </form>
</div>