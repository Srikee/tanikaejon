<div class="ks-titlebar">
    <a href="Javascript:" class="ks-toggle-menu btn me-2">
        <i class="fa-solid fa-bars"></i>
    </a>
    <a href="./" class="text-decoration-none">เมนูการใช้งาน</a>
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
            "customer-pending", "customer-pending-detail",
            "customer", "customer-detail",
            "customer-forgot", "customer-forgot-detail"
        ];
        $sql = "
            SELECT
                IFNULL(COUNT(*),0)
            FROM `customer`
            WHERE `status`='1'
        ";
        $badge1 = $DB->QueryString($sql);

        $sql = "
            SELECT
                IFNULL(COUNT(*),0)
            FROM `forgot`
            WHERE `status`='1'
        ";
        $badge2 = $DB->QueryString($sql);
    ?>
    <li class="ks-menu-item <?php if (in_array($PAGE, $menus)) echo "active"; ?>">
        <a href="Javascript:" class="btn-open-submenu">
            <i class="fas fa-users me-1"></i> ข้อมูลลูกค้า
            <i class="fas fa-angle-right ks-menu-icon-sub"></i>
            <?php
                if( $badge1>0 ) {
                    echo '<span class="ks-badge">'.$badge1.'</span>';
                }
            ?>
        </a>
        <ul class="ks-submenu" style="<?php if (in_array($PAGE, $menus)) echo "display:block;"; ?>">
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["customer-pending", "customer-pending-detail"])) echo "active"; ?>">
                <a href="./?page=customer-pending">ลูกค้าใหม่</a>
                <?php
                    if( $badge1>0 ) {
                        echo '<span class="ks-badge">'.$badge1.'</span>';
                    }
                ?>
            </li>
            <li class="ks-submenu-item <?php if (in_array($PAGE, ["customer", "customer-detail"])) echo "active"; ?>">
                <a href="./?page=customer">ลูกค้าทั้งหมด</a>
            </li>
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["customer-forgot", "customer-forgot-detail"])) echo "active"; ?>">
                <a href="./?page=customer-forgot">ลูกค้าแจ้งลืมรหัสผ่าน</a>
                <?php
                    if( $badge2>0 ) {
                        echo '<span class="ks-badge">'.$badge2.'</span>';
                    }
                ?>
            </li>
        </ul>
    </li>



    <?php
        $menus = [
            "service_booking-pending", "service_booking-pending-detail",
            "service_booking", "service_booking-detail",
        ];
        $sql = "
            SELECT
                IFNULL(COUNT(*),0)
            FROM `service_booking`
            WHERE `status`='1'
        ";
        $badge3 = $DB->QueryString($sql);
    ?>
    <li class="ks-menu-item <?php if (in_array($PAGE, $menus)) echo "active"; ?>">
        <a href="Javascript:" class="btn-open-submenu">
            <i class="fas fa-handshake-angle me-1"></i> ข้อมูลผู้ใช้บริการ
            <i class="fas fa-angle-right ks-menu-icon-sub"></i>
            <?php
                if( $badge3>0 ) {
                    echo '<span class="ks-badge">'.$badge3.'</span>';
                }
            ?>
        </a>
        <ul class="ks-submenu" style="<?php if (in_array($PAGE, $menus)) echo "display:block;"; ?>">
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["service_booking-pending", "service_booking-pending-detail"])) echo "active"; ?>">
                <a href="./?page=service_booking-pending">ผู้ขอใช้บริการใหม่</a>
                <?php
                    if( $badge3>0 ) {
                        echo '<span class="ks-badge">'.$badge3.'</span>';
                    }
                ?>
            </li>
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["service_booking", "service_booking-detail"])) echo "active"; ?>">
                <a href="./?page=service_booking">ผู้ขอใช้บริการทั้งหมด</a>
            </li>
        </ul>
    </li>



    <?php
        $menus = [
            "occupation", "occupation-add", "occupation-edit",
            "service", "service-add", "service-edit"
        ];
    ?>
    <li class="ks-menu-item <?php if (in_array($PAGE, $menus)) echo "active"; ?>">
        <a href="Javascript:" class="btn-open-submenu">
            <i class="fas fa-gear me-1"></i> ตั้งค่าข้อมูลพื้นฐาน
            <i class="fas fa-angle-right ks-menu-icon-sub"></i>
        </a>
        <ul class="ks-submenu" style="<?php if (in_array($PAGE, $menus)) echo "display:block;"; ?>">
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["occupation", "occupation-add", "occupation-edit"])) echo "active"; ?>">
                <a href="./?page=occupation">ข้อมูลอาชีพ</a>
            </li>
            <li
                class="ks-submenu-item <?php if (in_array($PAGE, ["service", "service-add", "service-edit"])) echo "active"; ?>">
                <a href="./?page=service">ข้อมูลการบริการ</a>
            </li>
        </ul>
    </li>


    <?php
        $menus = ["provider", "provider-add", "provider-edit"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=provider"><i class="fas fa-user-tag me-1"></i> ข้อมูลผู้ให้บริการ</a>
    </li>



    <?php
        $menus = ["staff", "staff-add", "staff-edit"];
    ?>
    <li class="ks-menu-item <?php if( in_array($PAGE, $menus) ) echo "active"; ?>">
        <a href="./?page=staff"><i class="fas fa-user-tie me-1"></i> ข้อมูลเจ้าหน้าที่</a>
    </li>










</ul>