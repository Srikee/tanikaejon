<?php
    
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=occupation">ข้อมูลอาชีพ</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">เพิ่มข้อมูลอาชีพ</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <table class="table table-bordered table-hover">
            <tr>
                <th valign="middle" style="width:130px;">อาชีพ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="occupation_name" name="occupation_name" required>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-success me-2" occupation="ยืนยันการเพิ่ม">
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