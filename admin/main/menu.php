<div class="ks-titlebar">
    <a href="Javascript:" class="ks-toggle-menu btn me-2">
        <i class="fa-solid fa-bars"></i>
    </a>
    <a href="./" class="text-decoration-none">งานแอดมินระบบ</a>
</div>
<ul class="ks-menu">

    <?php
        $menus = ["index"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./"><i class="fas fa-home me-1"></i> หน้าหลัก</a>
    </li>


    <?php
        $menus = [
            "report-attendance", "report-leave", "report-leave-detail",
        ];
    ?>
    <li class="ks-menu-item <?php if (in_array($PAGE, $menus)) echo "active"; ?>">
        <a href="#" class="btn-open-submenu">
            <i class="fas fa-chart-simple me-1"></i> รายงาน
            <i class="fas fa-angle-right ks-menu-icon-sub"></i>
        </a>
        <ul class="ks-submenu" style="<?php if (in_array($PAGE, $menus)) echo "display:block;"; ?>">
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["report-leave", "report-leave-detail"])) echo "active"; ?>">
                <a href="./?page=report-leave">ข้อมูลใบลาทั้งหมด</a>
            </li>
            <li class="ks-submenu-item <?php if (in_array($PAGE, ["report-attendance"])) echo "active"; ?>">
                <a href="./?page=report-attendance">การมาเรียนของนักเรียน</a>
            </li>
        </ul>
    </li>



    <?php
        $menus = ["staff", "staff-add", "staff-edit", "staff-detail"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=staff"><i class="fas fa-user-tie me-1"></i> ข้อมูลบุคลากร</a>
    </li>


    <?php
        $menus = ["role"];
    ?>
    <!-- <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=role"><i class="fas fa-users-rectangle me-1"></i> จัดการสิทธิ์บุคลากร</a>
    </li> -->



    <?php
        $menus = ["login", "login-detail"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=login"><i class="fas fa-users me-1"></i> ตรวจสอบผู้ล็อกอิน</a>
    </li>

    <?php
        $menus = ["send-mail"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=send-mail"><i class="fas fa-envelope me-1"></i> ส่งอีเมล</a>
    </li>

    <?php
        $menus = ["forge"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=forge"><i class="fas fa-user-tag me-1"></i> จำลองสิทธิ์</a>
    </li>

</ul>