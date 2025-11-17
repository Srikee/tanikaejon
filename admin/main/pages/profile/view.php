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
            <li class="breadcrumb-item"><a href="./?page=profile">โปรไฟล์ของฉัน</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <input type="hidden" name="staff_id" value="<?php echo $data["staff_id"]; ?>">
        <div class="row">
            <div class="col-auto">
                <div class="mb-3" style="width:200px;">
                    <img src="<?php echo $_SESSION['tnkj_staff']["image"]; ?>" id="image" alt="Staff Picture"
                        class="w-100 mb-2 profile">
                    <button type="button" id="btn-select-image"
                        class="btn btn-outline-dark w-100">เปลี่ยนรูปโปรไฟล์</button>
                    <input type="hidden" name="base64" id="base64">
                </div>
            </div>
            <div class="col-lg">
                <table class="table table-hover table-borderless">
                    <tr>
                        <th valign="middle" style="width:140px;">ชื่อ</th>
                        <td>
                            <?php echo $data["staff_name"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">นามสกุล</th>
                        <td>
                            <?php echo $data["staff_sname"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">เบอร์มือถือ</th>
                        <td>
                            <?php echo Func::FormatPhoneNumber($data["phone"]); ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">ชื่อผู้ใช้งาน</th>
                        <td>
                            <?php echo $data["username"]; ?>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">สถานะ</th>
                        <td>
                            <?php
                                $status = [
                                    "1"=>'<span class="badge text-bg-success">ใช้งานได้</span>',
                                    "2"=>'<span class="badge text-bg-danger">ยกเลิก</span>'
                                ];
                                echo $status[$data["status"]];
                            ?>
                        </td>
                    </tr>
                </table>
                <div>
                    <a href="./?page=changepass" class="btn btn-warning me-2" title="เปลี่ยนรหัสผ่าน">
                        <i class="fas fa-key me-1"></i>
                        เปลี่ยนรหัสผ่าน
                    </a>
                    <a href="Javascript:Func.Reload()" class="btn btn-light border">
                        <i class="fas fa-sync-alt me-1"></i>
                        รีโหลด
                    </a>
                </div>
            </div>
        </div>
    </form>
</div>