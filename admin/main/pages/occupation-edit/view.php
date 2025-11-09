<?php
    $occupation_id = $_GET["occupation_id"] ?? "";

    $sql = "
        SELECT 
            * 
        FROM occupation
        WHERE occupation_id='".$DB->Escape($occupation_id)."'
    ";
    $obj = $DB->QueryObj($sql);
    if(sizeof($obj) == 0) {
        ShowAlert("", "ไม่พบข้อมูลอาชีพที่ต้องการแก้ไข", "error", "./?page=occupation");
        exit();
    }
    $data = $obj[0];
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=occupation">ข้อมูลอาชีพ</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">แก้ไขข้อมูลอาชีพ</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <input type="hidden" name="occupation_id" value="<?php echo $data["occupation_id"]; ?>">
        <table class="table table-hover table-borderless">
            <tr>
                <th valign="middle" style="width:130px;">อาชีพ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="occupation_name" name="occupation_name"
                        value="<?php echo $data["occupation_name"]; ?>" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">สถานะ <span class="text-danger">*</span></th>
                <td>
                    <select name="status" id="status" class="form-control">
                        <option value="Y" <?php if($data["status"] == "Y") echo "selected"; ?>>ใช้งาน</option>
                        <option value="N" <?php if($data["status"] == "N") echo "selected"; ?>>ไม่ใช้งาน</option>
                    </select>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-warning me-2" occupation="ยืนยันการแก้ไข">
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