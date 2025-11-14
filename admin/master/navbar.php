<nav class="navbar navbar-expand-lg" style="background-color: #003C71; height:60px;" data-bs-theme="dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="<?php echo $CLIENT_ROOT; ?>">
            <img src="<?php echo $CLIENT_ROOT; ?>../images/favicon.png?v=<?php echo $VERSION; ?>" alt="Satit MIS"
                class="ks-brand-logo">
            <span class="ks-brand-text">โครงการตานีแก้จน</span>
        </a>
        <ul class="navbar-nav ms-auto">
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle p-0" href="#" role="button" data-bs-toggle="dropdown"
                    aria-expanded="false">
                    <img src="<?php echo $_SESSION['tnkj_staff']["image"]; ?>" alt="" class="nav-profile">
                    <span class="d-none d-sm-inline">
                        <?php echo $_SESSION['tnkj_staff']['staff_name']; ?>
                        <?php echo $_SESSION['tnkj_staff']['staff_sname']; ?>
                    </span>
                </a>
                <ul class="dropdown-menu dropdown-menu-end position-absolute" data-bs-theme="light">
                    <li>
                        <a class="dropdown-item" href="<?php echo $CLIENT_ROOT; ?>main/?page=profile">
                            <i class="fas fa-user me-2"></i>
                            โปรไฟล์ของฉัน
                        </a>
                    </li>
                    <li>
                        <a class="dropdown-item" href="<?php echo $CLIENT_ROOT; ?>main/?page=changepass">
                            <i class="fas fa-key me-2"></i>
                            เปลี่ยนรหัสผ่าน
                        </a>
                    </li>
                    <li>
                        <hr class="dropdown-divider">
                    </li>
                    <li>
                        <a class="dropdown-item" href="Javascript:void(0)" onclick="logout()">
                            <i class="fas fa-arrow-right-from-bracket me-2"></i>
                            ออกจากระบบ
                        </a>
                        <script>
                        function logout() {
                            Func.ShowConfirm({
                                html: 'คุณต้องการออกจากระบบหรือไม่ ?',
                                icon: 'warning',
                                confirmButtonText: '<i class="fas fa-arrow-right-from-bracket me-2"></i> ออกจากระบบ',
                                cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
                                cancelButtonColor: '#6c757d',
                                callback: function(rs) {
                                    if (rs) {
                                        Func.LinkTo('../logout.php');
                                    }
                                }
                            })
                        }
                        </script>
                    </li>
                    <li>
                        <?php if( isset($_SESSION["forge"]) ) { ?>
                        <a class="dropdown-item text-danger" href="Javascript:void(0)" onclick="unforge()">
                            <i class="fas fa-user-tag me-2"></i>
                            ยกเลิกการจำลองสิทธิ์
                        </a>
                        <script>
                        function unforge() {
                            ShowConfirm({
                                html: 'คุณต้องการยกเลิกการจำลองสิทธิ์หรือไม่ ?',
                                icon: 'warning',
                                confirmButtonText: '<i class="fas fa-user-tag me-2"></i> ยกเลิกการจำลอง',
                                cancelButtonText: '<i class="fas fa-xmark me-2"></i> ไม่ต้องการ',
                                cancelButtonColor: '#6c757d',
                                callback: function(rs) {
                                    if (rs) {
                                        window.location.href = '<?php echo $CLIENT_ROOT; ?>unforge.php';
                                    }
                                }
                            })
                        }
                        </script>
                        <?php } ?>
                    </li>
                </ul>
            </li>
        </ul>
    </div>
</nav>