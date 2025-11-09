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
        <table class="table table-bordered table-hover">
            <tr>
                <th valign="middle" style="width:130px;">ชื่อ <span class="text-danger">*</span></th>
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
                    <input type="text" class="form-control" id="username" name="username" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">รหัสผ่าน <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="password" name="password" required>
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
    </form>
</div>