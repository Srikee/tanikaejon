<div>
    แบบฟอร์มลงทะเบียน
</div>
<form id="formdata">
    <div class="mb-3">
        <label for="customer_name">ชื่อ</label>
        <input type="text" class="form-control form-control-lg" id="customer_name" name="customer_name"
            autocomplete="customer_name" required>
    </div>
    <div class="mb-3">
        <label for="customer_sname">นามสกุล</label>
        <input type="text" class="form-control form-control-lg" id="customer_sname" name="customer_sname"
            autocomplete="customer_sname" required>
    </div>
    <div class="mb-3">
        <label for="phone">เบอร์มือถือ</label>
        <input type="text" class="form-control form-control-lg" id="phone" name="phone" autocomplete="phone" required>
    </div>
    <div class="mb-3">
        <label for="password">รหัสผ่าน</label>
        <input type="password" class="form-control form-control-lg mb-4" id="password" name="password"
            autocomplete="password" required>
    </div>
    <div class="row">
        <div class="col">
            <button id="btn-submit" type="submit" class="btn btn-success btn-lg btn-block w-100" disabled>
                <i class="fas fa-sign-in-alt me-2"></i> ลงทะเบียน
            </button>
        </div>
    </div>
</form>