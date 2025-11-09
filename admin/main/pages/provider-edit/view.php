<?php
    $provider_id = $_GET["provider_id"] ?? "";

    $sql = "
        SELECT 
            * 
        FROM provider
        WHERE provider_id='".$DB->Escape($provider_id)."'
    ";
    $obj = $DB->QueryObj($sql);
    if(sizeof($obj) == 0) {
        ShowAlert("", "ไม่พบข้อมูลผู้ให้บริการที่ต้องการแก้ไข", "error", "./?page=provider");
        exit();
    }
    $data = $obj[0];
?>
<input type="hidden" id="data" value="<?php echo htmlspecialchars(json_encode($data)); ?>">
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=provider">ข้อมูลผู้ให้บริการ</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">แก้ไขข้อมูลผู้ให้บริการ</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <form id="formdata">
        <input type="hidden" name="provider_id" value="<?php echo $data["provider_id"]; ?>">
        <table class="table table-bordered table-hover">
            <tr>
                <th valign="middle" style="width:130px;">ชื่อ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="provider_name" name="provider_name"
                        value="<?php echo $data["provider_name"]; ?>" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">นามสกุล<span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="provider_sname" name="provider_sname"
                        value="<?php echo $data["provider_sname"]; ?>" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">เลขบัตร ปชช. <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="card_id" name="card_id"
                        value="<?php echo $data["card_id"]; ?>" maxlength="13" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">เบอร์มือถือ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" id="phone" name="phone"
                        value="<?php echo $data["phone"]; ?>" maxlength="10" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">ที่อยู่ <span class="text-danger">*</span></th>
                <td><input type="text" class="form-control" id="address" name="address"
                        value="<?php echo $data["address"]; ?>" required></td>
            </tr>
            <tr>
                <th valign="middle">จังหวัด <span class="text-danger">*</span></th>
                <td>
                    <select name="province_id" id="province_id" class="form-control" data-select>
                        <option value="">เลือกจังหวัด</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th valign="middle">อำเภอ <span class="text-danger">*</span></th>
                <td>
                    <select name="amphur_id" id="amphur_id" class="form-control" data-select>
                        <option value="">เลือกอำเภอ</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th valign="middle">ตำบล <span class="text-danger">*</span></th>
                <td>
                    <select name="tambol_id" id="tambol_id" data-select class="form-select" required>
                        <option value="">เลือกตำบล</option>
                    </select>
                </td>
            </tr>
            <tr>
                <th valign="middle">รหัสไปรษณีย์ <span class="text-danger">*</span></th>
                <td>
                    <input type="text" class="form-control" name="zipcode" id="zipcode"
                        value="<?php echo $data["zipcode"]; ?>" maxlength="5" required>
                </td>
            </tr>
            <tr>
                <th valign="middle">อาชีพ <span class="text-danger">*</span></th>
                <td>
                    <select class="form-control form-control-lg" id="occupation_id" name="occupation_id" data-select
                        required>
                        <option value="">-- เลือกอาชีพ --</option>
                        <?php
                            $sql = "SELECT * FROM occupation WHERE `status`='Y' ORDER BY occupation_name ASC";
                            $obj = $DB->QueryObj($sql);
                            foreach ($obj as $row) {
                                $selected = ($row["occupation_id"]==$data["occupation_id"]) ? "selected" : "";
                                echo '<option value="' . $row['occupation_id'] . '" '.$selected.'>' . $row['occupation_name'] . '</option>';
                            }
                        ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th valign="middle">สถานะ <span class="text-danger">*</span></th>
                <td>
                    <select name="status" id="status" class="form-control">
                        <option value="1" <?php if($data["status"] == "1") echo "selected"; ?>>รอตรวจสอบ</option>
                        <option value="2" <?php if($data["status"] == "2") echo "selected"; ?>>ตรวจสอบแล้ว</option>
                        <option value="3" <?php if($data["status"] == "3") echo "selected"; ?>>ยกเลิก</option>
                    </select>
                </td>
            </tr>
        </table>
        <div>
            <button type="submit" class="btn btn-warning me-2" provider="ยืนยันการแก้ไข">
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