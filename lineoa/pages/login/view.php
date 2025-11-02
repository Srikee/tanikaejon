<div class="container-fluid my-5">
    <h5 class="text-center mb-5">
        โปรดเข้าสู่ระบบ
    </h5>
    <form id="formdata">
        <div class="mb-3">
            <label for="phone" class="form-label">เบอร์มือถือ</label>
            <input type="text" class="form-control form-control-lg" id="phone" name="phone" autocomplete="phone"
                required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน</label>
            <input type="password" class="form-control form-control-lg" id="password" name="password"
                autocomplete="password" required>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col">
                <button id="btn-submit" type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-sign-in-alt me-2"></i> เข้าสู่ระบบ
                </button>
            </div>
            <div class="col">
                <a href="./?page=register" class="btn btn-secondary btn-lg w-100">
                    <i class="fas fa-user-plus me-2"></i> ลงทะเบียน
                </a>
            </div>
        </div>
        <div class="text-center mb-3">
            <button type="button" class="btn btn-outline-secondary btn-lg w-100">
                <i class="fa-solid fa-circle-question me-2"></i> ลืมรหัสผ่าน
            </button>
        </div>
    </form>
</div>