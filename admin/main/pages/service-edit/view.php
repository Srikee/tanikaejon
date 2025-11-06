<?php
    $service_id = $_GET["service_id"] ?? "";

    $sql = "
        SELECT 
            * 
        FROM service
        WHERE service_id='".$DB->Escape($service_id)."'
    ";
    $obj = $DB->QueryObj($sql);
    if(sizeof($obj) == 0) {
        ShowAlert("", "ไม่พบข้อมูลการบริการที่ต้องการแก้ไข", "error", "./?page=service");
        exit();
    }
    $data = $obj[0];
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=service">ข้อมูลการบริการ</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">แก้ไขข้อมูลการบริการ</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <input type="hidden" name="service_id" value="<?php echo $data["service_id"]; ?>">
        <table class="table table-bordered table-hover">
            <tr>
                <th valign="middle" style="width:130px;">การบริการ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="service_name" name="service_name"
                        value="<?php echo $data["service_name"]; ?>" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">คำอธิบาย <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="service_desc" name="service_desc"
                        value="<?php echo $data["service_desc"]; ?>" required>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-warning me-2" service="ยืนยันการแก้ไข">
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