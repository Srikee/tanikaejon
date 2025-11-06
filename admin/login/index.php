<?php 
    include_once('../config/all.php');

    if( ChkLogin()==true ) {
        Func::LinkTo("../main");
        exit();
    }
?>
<!DOCTYPE html>
<html translate="no">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>STMIS::สำหรับบุคลากร - โรงเรียนสาธิตมหาวิทยาลัยสงขลานครินทร์ (ฝ่ายมัธยมศึกษา)</title>
    <link rel="icon" href="<?php echo $CLIENT_ROOT; ?>../images/favicon.png" />
    <!-- bootstrap -->
    <link href="<?php echo $CLIENT_ROOT; ?>../assets/bootstrap-5.3.7/css/bootstrap.min.css" rel="stylesheet" />
    <script src="<?php echo $CLIENT_ROOT; ?>../assets/bootstrap-5.3.7/js/bootstrap.bundle.min.js"></script>
    <!-- font-awesome -->
    <link href="<?php echo $CLIENT_ROOT; ?>../assets/fontawesome-free-7.0.0/css/all.min.css" rel="stylesheet" />
    <!-- jquery -->
    <script src="<?php echo $CLIENT_ROOT; ?>../assets/jquery/jquery-3.7.1.min.js"></script>
    <!-- sweetalert2 -->
    <script src="<?php echo $CLIENT_ROOT; ?>../assets/sweetalert2/sweetalert.min.js"></script>
    <!-- func -->
    <script src="<?php echo $CLIENT_ROOT; ?>../assets/func.js?v=<?php echo $VERSION; ?>"></script>
    <style>
    :root {
        --primary-color: #1e6fba;
        --secondary-color: #345373;
        --accent-color: #3498db;
        --light-color: #f8f9fa;
    }

    ::placeholder {
        line-height: 0px;
        padding: 20px 0;
    }

    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    html {
        height: 100%;
    }

    body {
        background-color: #f5f7fa;
        height: 100%;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .login-container {
        display: flex;
        width: 100%;
        max-width: 1000px;
        height: 600px;
        background: white;
        border-radius: 20px;
        box-shadow: 0 15px 30px rgba(0, 0, 0, 0.1);
        overflow: hidden;
    }

    .login-left {
        flex: 1;
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: white;
        padding: 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        position: relative;
        overflow: hidden;
    }

    .login-left::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
        opacity: 1;
    }

    .logo {
        width: 120px;
        height: 120px;
        background: rgba(255, 255, 255, 0.15);
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 25px;
        box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        backdrop-filter: blur(5px);
        border: 2px solid rgba(255, 255, 255, 0.3);
        position: relative;
        z-index: 1;
    }

    .logo i {
        font-size: 55px;
        color: white;
    }

    .logo-image {
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 25px auto;
    }

    .logo-image img {
        width: 100px;
        border-radius: 10px;
    }

    .info {
        text-align: center;
        position: relative;
        z-index: 1;
    }

    .info h1 {
        font-size: 2.2rem;
        font-weight: 700;
        margin-bottom: 10px;
    }

    .info p {
        font-size: 1.1rem;
        opacity: 0.9;
        margin-bottom: 25px;
    }

    .features {
        margin-top: 30px;
        text-align: left;
    }

    .feature-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        background: rgba(255, 255, 255, 0.1);
        padding: 12px 15px;
        border-radius: 10px;
        backdrop-filter: blur(5px);
        transition: transform 0.3s;
    }

    .feature-item:hover {
        transform: translateX(5px);
    }

    .feature-item i {
        margin-right: 12px;
        font-size: 1.2rem;
        color: rgba(255, 255, 255, 0.9);
        width: 25px;
    }

    .feature-item span {
        font-size: 1rem;
    }

    .login-right {
        flex: 1;
        padding: 50px 40px;
        display: flex;
        flex-direction: column;
        justify-content: center;
        background-color: var(--light-color);
    }

    .login-form-container {
        width: 100%;
        max-width: 350px;
        margin: 0 auto;
    }

    .login-header {
        text-align: center;
        margin-bottom: 35px;
    }

    .login-header h2 {
        color: var(--secondary-color);
        font-weight: 700;
        font-size: 1.8rem;
        margin-bottom: 8px;
    }

    .login-header p {
        color: #6c757d;
        font-size: 1rem;
    }

    .form-group {
        margin-bottom: 25px;
        position: relative;
    }

    .form-label {
        font-weight: 600;
        margin-bottom: 8px;
        color: var(--secondary-color);
        display: flex;
        align-items: center;
    }

    .form-label i {
        margin-right: 8px;
        color: var(--primary-color);
    }

    .input-group {
        position: relative;
    }

    .form-control {
        padding: 14px 15px 14px 45px;
        border-radius: 10px;
        border: 2px solid #cbe0ff;
        transition: all 0.3s;
        font-size: 1rem;
        background-color: white;
        border-top-right-radius: 10px !important;
        border-bottom-right-radius: 10px !important;
    }

    .form-control:focus {
        border-color: var(--accent-color);
        box-shadow: 0 0 0 0.2rem rgba(16, 185, 129, 0.15);
        background-color: white;
    }

    .input-icon {
        position: absolute;
        left: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        z-index: 5;
        transition: color 0.3s;
    }

    .form-control:focus+.input-icon {
        color: var(--accent-color);
    }

    .password-toggle {
        position: absolute;
        right: 15px;
        top: 50%;
        transform: translateY(-50%);
        color: #6c757d;
        cursor: pointer;
        transition: color 0.3s;
        z-index: 5;
    }

    .password-toggle:hover {
        color: var(--accent-color);
    }

    .btn-login {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        border: none;
        color: white;
        padding: 14px;
        border-radius: 10px;
        font-weight: 600;
        width: 100%;
        transition: all 0.3s;
        font-size: 1.05rem;
        letter-spacing: 0.5px;
        box-shadow: 0 4px 15px rgba(16, 185, 129, 0.3);
    }

    .btn-login:hover {
        transform: translateY(-2px);
        box-shadow: 0 6px 20px rgba(16, 185, 129, 0.4);
    }

    .btn-login:active {
        transform: translateY(0);
    }

    .btn-login i {
        margin-right: 8px;
    }

    .student-options {
        display: flex;
        justify-content: space-between;
        margin-top: 20px;
        font-size: 0.9rem;
    }

    .student-options a {
        color: var(--primary-color);
        text-decoration: none;
        transition: color 0.3s;
    }

    .student-options a:hover {
        color: var(--secondary-color);
        text-decoration: underline;
    }

    .login-footer {
        text-align: center;
        margin-top: 30px;
        color: #6c757d;
        font-size: 0.9rem;
    }

    /* ปุ่มเลือกประเภทผู้ใช้ */
    .btn-select-user {
        display: block;
        text-align: center;
        padding: 4px 0;
        border-radius: 10px;
        font-weight: 600;
        background: #e9f2ff;
        color: var(--secondary-color);
        border: 2px solid transparent;
        text-decoration: none;
        transition: all 0.25s ease;
        font-size: 14px;
        box-shadow: 0 2px 5px rgba(0, 0, 0, 0.05);
    }

    .btn-select-user:hover {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.15);
    }

    .btn-select-user.active {
        background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
        color: #fff;
        border-color: var(--primary-color);
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
    }

    .btn-select-user.active:hover {
        transform: translateY(-2px);
    }

    @media (max-width: 992px) {
        body {
            height: auto;
        }

        .login-container {
            flex-direction: column;
            margin: 20px;
            border-radius: 15px;
            height: auto;
            max-width: 500px;
        }

        .login-left,
        .login-right {
            padding: 25px 20px;
        }

        .logo {
            width: 80px;
            height: 80px;
        }

        .logo i {
            font-size: 40px;
        }

        .info h1 {
            font-size: 1.6rem;
        }

        .login-form-container {
            max-width: 100%;
        }

        .student-options {
            flex-direction: column;
            gap: 10px;
            text-align: center;
        }
    }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-left">
            <!-- <div class="logo">
                <i class="fas fa-user-tie"></i>
            </div> -->
            <div class="logo-image">
                <img src="../../images/favicon.png" alt="Brand">
            </div>
            <div class="info">
                <h1>โครงการตานีแก้จน</h1>
            </div>
        </div>
        <div class="login-right">
            <div class="login-form-container">
                <div class="login-header">
                    <h2 class="mb-3">เข้าสู่ระบบสำหรับแอดมิน</h2>
                </div>
                <form id="loginForm">
                    <div class="form-group">
                        <label for="username" class="form-label">
                            <i class="fas fa-user"></i>ชื่อผู้ใช้งาน
                        </label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="username" placeholder="กรอกชื่อผู้ใช้งาน"
                                required>
                            <span class="input-icon">
                                <i class="fas fa-user"></i>
                            </span>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="password" class="form-label">
                            <i class="fas fa-lock"></i>รหัสผ่าน
                        </label>
                        <div class="input-group">
                            <input type="password" class="form-control" id="password" placeholder="กรอกรหัสผ่าน"
                                required>
                            <span class="input-icon">
                                <i class="fas fa-lock"></i>
                            </span>
                            <span class="password-toggle" id="togglePassword">
                                <i class="fas fa-eye"></i>
                            </span>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-login">
                        <i class="fas fa-sign-in-alt"></i>เข้าสู่ระบบ
                    </button>
                </form>
                <div class="login-footer">
                    <div class="copyright">
                        &copy; 2025 โครงการตานีแก้จน
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script>
    document.getElementById('togglePassword').addEventListener('click', function() {
        const passwordInput = document.getElementById('password');
        const icon = this.querySelector('i');
        if (passwordInput.type === 'password') {
            passwordInput.type = 'text';
            icon.classList.remove('fa-eye');
            icon.classList.add('fa-eye-slash');
        } else {
            passwordInput.type = 'password';
            icon.classList.remove('fa-eye-slash');
            icon.classList.add('fa-eye');
        }
    });
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        e.preventDefault();
        const username = document.getElementById('username').value;
        const password = document.getElementById('password').value;
        if (username && password) {
            const submitBtn = document.querySelector('.btn-login');
            const originalText = submitBtn.innerHTML;
            submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i>กำลังเข้าสู่ระบบ...';
            submitBtn.disabled = true;
            $.ajax({
                url: 'api/login.php',
                type: 'POST',
                dataType: 'json',
                data: {
                    username: username,
                    password: password
                },
                success: function(res) {
                    if (res.status == 'ok') {
                        Func.LinkTo('../main');
                    } else {
                        Func.ShowAlert({
                            title: 'เข้าสู่ระบบไม่สำเร็จ',
                            html: res.message,
                            type: 'error',
                            callback: function() {
                                submitBtn.innerHTML = originalText;
                                submitBtn.disabled = false;
                            }
                        });
                    }
                },
                error: function(xhr) {
                    Func.ShowAlert({
                        title: 'เกิดข้อผิดพลาด',
                        html: 'ไม่สามารถเชื่อมต่อกับเซิร์ฟเวอร์ได้',
                        type: 'error',
                        callback: function() {
                            submitBtn.innerHTML = originalText;
                            submitBtn.disabled = false;
                        }
                    });
                }
            });
        } else {
            Func.ShowAlert({
                title: 'เกิดข้อผิดพลาด',
                html: 'กรุณากรอกชื่อผู้ใช้และรหัสผ่าน',
                type: 'error'
            });
        }
    });
    </script>
</body>

</html>