<div class="mb-4">
    <img src="images/passport.png" alt="PSU Passport">
</div>
<form id="formdata">
    <div class="form-group">
        <label for="username">รหัสผู้ใช้งาน</label>
        <input type="text" class="form-control form-control-lg" id="username" name="username" required>
    </div>
    <div class="form-group">
        <label for="password">รหัสผ่าน</label>
        <input type="password" class="form-control form-control-lg mb-4" id="password" name="password" required>
    </div>
    <div class="mb-5">
        <p>
            ขอความยินยอม
            <a href="./?page=pdpa" class="text-underline">โปรดอ่านก่อนยินยอม <i
                    class="fas fa-external-link-alt ml-1"></i></a>
        </p>
        <div class="custom-control custom-checkbox">
            <input type="checkbox" class="custom-control-input" id="check-pdpa" name="check-pdpa">
            <label class="custom-control-label" for="check-pdpa">ยินยอม</label>
        </div>
    </div>
    <button id="btn-submit" type="submit" class="btn btn-success btn-lg btn-block" disabled><i
            class="fas fa-sign-in-alt mr-2"></i> เข้าสู่ระบบ</button>
</form>