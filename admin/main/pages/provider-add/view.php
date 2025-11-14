<?php
    
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=provider">ข้อมูลผู้ให้บริการ</a></li>
            <li class="breadcrumb-item"><a href="Javascript:Func.Reload()">เพิ่มข้อมูลผู้ให้บริการ</a></li>
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
                        <th valign="middle" style="width:130px;">ชื่อ <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="provider_name" name="provider_name" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">นามสกุล <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="provider_sname" name="provider_sname" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">เลขบัตร ปชช. <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="card_id" name="card_id" maxlength="13" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">เบอร์มือถือ <span class="text-danger">*</span></th>
                        <td>
                            <input type="text" class="form-control" id="phone" name="phone" maxlength="10" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">ที่อยู่ <span class="text-danger">*</span></th>
                        <td><input type="text" class="form-control" id="address" name="address" required></td>
                    </tr>
                    <tr>
                        <th valign="middle">จังหวัด <span class="text-danger">*</span></th>
                        <td>
                            <select name="province_id" id="province_id" class="form-control" data-select required>
                                <option value="">เลือกจังหวัด</option>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">อำเภอ <span class="text-danger">*</span></th>
                        <td>
                            <select name="amphur_id" id="amphur_id" class="form-control" data-select required>
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
                            <input type="text" class="form-control" name="zipcode" id="zipcode" maxlength="5" required>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">อาชีพ <span class="text-danger">*</span></th>
                        <td>
                            <select class="form-control form-control-lg" id="occupation_id" name="occupation_id"
                                data-select required>
                                <option value="">-- เลือกอาชีพ --</option>
                                <?php
                                    $sql = "SELECT * FROM occupation WHERE `status`='Y' ORDER BY occupation_name ASC";
                                    $obj = $DB->QueryObj($sql);
                                    foreach ($obj as $row) {
                                        echo '<option value="' . $row['occupation_id'] . '">' . $row['occupation_name'] . '</option>';
                                    }
                                ?>
                            </select>
                        </td>
                    </tr>
                    <tr>
                        <th valign="middle">สถานะ <span class="text-danger">*</span></th>
                        <td>
                            <select name="status" id="status" class="form-control">
                                <option value="1">รอตรวจสอบ</option>
                                <option value="2">ตรวจสอบแล้ว</option>
                                <option value="3">ยกเลิก</option>
                            </select>
                        </td>
                    </tr>
                </table>
                <div>
                    <button type="submit" class="btn btn-success me-2" provider="ยืนยันการเพิ่ม">
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