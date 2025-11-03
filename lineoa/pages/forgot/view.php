<div class="container-fluid my-5">
    <h4 class="text-center mb-5">
        ลืมรหัสผ่าน
    </h4>
    <form id="formdata">
        <div class="mb-3">
            <label for="phone" class="form-label">เบอร์มือถือ</label>
            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" autocomplete="phone"
                required>
        </div>
        <!-- <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control form-control-lg" id="password" name="password"
                autocomplete="password" required>
        </div> -->
        <div class="row mb-3 mt-4">
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
        </div>
    </form>
</div>