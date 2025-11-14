<?php
    
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=staff">ข้อมูลเจ้าหน้าที่</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">เพิ่มข้อมูลเจ้าหน้าที่</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <div class="row">
            <div class="col-auto">
                <div class="mb-3" style="width:200px;">
                    <img src="../images/icon-profile.png?v=<?php echo $VERSION; ?>" id="image" alt="Staff Picture"
                        class="w-100 mb-2 profile">
                    <button type="button" id="btn-select-image" class="btn btn-outline-dark w-100">เลือกรูปภาพ</button>
                    <input type="hidden" name="base64" id="base64">
                </div>
            </div>
            <div class="col-lg">
                <table class="table table-hover table-borderless">
                    <tr>
                        <th valign="middle" style="width:135px;">ชื่อ <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="staff_name" name="staff_name" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">นามสกุล <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="staff_sname" name="staff_sname" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">ชื่อผู้ใช้งาน <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="username" name="username" autocomplete="off"
                                required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">รหัสผ่าน <span class="text-danger">*</span></th>
                        <td>
                            <div class="form-inner">
                                <input type="password" class="form-control" name="password1" id="password1"
                                    autocomplete="off" required>
                                <i class="fa-solid fa-eye inner-button" show-password="password1"></i>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">ยืนยันรหัสผ่าน <span class="text-danger">*</span></th>
                        <td>
                            <div class="form-inner">
                                <input type="password" class="form-control" name="password2" id="password2" required>
                                <i class="fa-solid fa-eye inner-button" show-password="password2"></i>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">สถานะ <span class="text-danger">*</span></th>
                        <td>
                            <select name="status" id="status" class="form-control">
                                <option value="1">ใช้งานได้</option>
                                <option value="2">ยกเลิก</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div>
                    <button type="submit" class="btn btn-success me-2" staff="ยืนยันการเพิ่ม">
                        <i class="fas fa-plus me-1"></i>
                        ยืนยันการเพิ่ม
                    </button>
                    <a href="Javascript:Func.Reload()" class="btn btn-light border">
                        <i class="fas fa-sync-alt me-1"></i>
                        รีโหลด
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>