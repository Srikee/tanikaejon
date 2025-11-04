<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    ลืมรหัสผ่าน
</div>
<div class="container-fluid py-4">
    <form id="formdata">
        <div class="mb-3">
            <label for="phone" class="form-label">เบอร์มือถือ
                <span class="text-danger">* ระบุ 10 หลัก ไม่มีขีด</span>
            </label>
            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" maxlength="10"
                autocomplete="off" required>
        </div>
        <!-- <div class="row mb-3 mt-4">
            <div class="col pe-2">
                <button type="button" class="btn btn-light btn-lg w-100" onclick="Func.Back()">
                    <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
                </button>
            </div>
            <div class="col ps-2">
                <button id="btn-submit" type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-envelope me-1"></i> ส่งข้อมูล
                </button>
            </div>
        </div> -->
        <div class="text-center mb-3">
            <button id="btn-submit" type="submit" class="btn btn-success btn-lg ">
                <i class="fas fa-envelope me-1"></i> ส่งข้อมูล
            </button>
        </div>
    </form>
</div>