<div class="container-fluid my-3">
    <div class="text-center mb-4">
        <img id="img-brand" src="../images/favicon.png" alt="Login Image" class="img-fluid rounded-4"
            style="max-height: 200px;">
    </div>
    <h4 class="text-center fw-bold fs-2 mb-2">
        โปรดเข้าสู่ระบบ
    </h4>
    <p class="text-center fs-5 mb-4">โครงการตานีแก้จน</p>
    <form id="formdata" class="px-3">
        <div class="mb-3">
            <label for="phone" class="form-label">เบอร์มือถือ <span class="text-danger">* ระบุ 10 หลัก
                    ไม่มีขีด</span></label>
            <input type="tel" class="form-control form-control-lg" id="phone" name="phone" maxlength="10" required>
        </div>
        <div class="mb-3">
            <label for="password" class="form-label">รหัสผ่าน <span class="text-danger">*</span></label>
            <div class="form-inner">
                <input type="password" class="form-control form-control-lg" id="password" name="password" required>
                <i class="fa-solid fa-eye inner-button" show-password="password"></i>
            </div>
        </div>
        <div class="row mb-3 mt-4">
            <div class="col pe-2">
                <button id="btn-submit" type="submit" class="btn btn-success btn-lg w-100">
                    <i class="fas fa-sign-in-alt me-1"></i> เข้าสู่ระบบ
                </button>
            </div>
            <div class="col pe-2">
                <a href="./?page=register" class="btn btn-secondary btn-lg w-100">
                    <i class="fas fa-user-plus me-1"></i> ลงทะเบียน
                </a>
            </div>
        </div>
        <div class="text-center mb-3">
            <a href="./?page=forgot" class="btn btn-outline-secondary btn-lg w-100 mb-3">
                <i class="fa-solid fa-circle-question me-2"></i> ลืมรหัสผ่าน
            </a>
            <button type="button" class="btn btn-outline-secondary btn-lg w-100 mb-3" id="btn-contact-admin">
                <i class="fa-solid fa-phone me-2"></i> ติดต่อแอดมิน
            </button>
        </div>
    </form>
</div>