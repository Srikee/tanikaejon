<?php
    
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=service">ข้อมูลการบริการ</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">เพิ่มข้อมูลการบริการ</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <table class="table table-hover table-borderless">
            <tr>
                <th valign="middle" style="width:130px;">การบริการ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="service_name" name="service_name" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">คำอธิบาย <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="service_desc" name="service_desc" required>
                </td>
            </tr>
            <tr>
                <th valign="top">รายละเอียดบริการ <span class="text-danger">*</span></th>
                <td>
                    <textarea class="form-control" id="service_info" name="service_info" rows="10" required></textarea>
                </td>
            </tr>
            <tr>
                <th valign="middle">สถานะ <span class="text-danger">*</span></th>
                <td>
                    <select name="status" id="status" class="form-control">
                        <option value="Y">ใช้งาน</option>
                        <option value="N">ไม่ใช้งาน</option>
                    </select>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-success me-2" service="ยืนยันการเพิ่ม">
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