<?php
    include_once("../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    $sql = "
        SELECT 
            c.*,
            o.occupation_name,
            ul.userId,
            ul.displayName,
            ul.pictureUrl,
            ta.tambol_name_thai,
            am.amphur_name_thai,
            pr.province_name_thai
        FROM customer c
            LEFT JOIN occupation o ON o.occupation_id = c.occupation_id
            LEFT JOIN user_line ul ON ul.customer_id = c.customer_id
            LEFT JOIN th_tambol ta ON ta.tambol_id=c.tambol_id
            LEFT JOIN th_amphur am ON am.amphur_id=c.amphur_id
            LEFT JOIN th_province pr ON pr.province_id=c.province_id
        WHERE c.customer_id = '".$customer_id."' 
    ";
    $customer = $DB->QueryFirst($sql);

    $pictureUrl = $customer["pictureUrl"];
    if( $pictureUrl==null || $pictureUrl=="" ) {
        $pictureUrl = "../images/default-profile.png?v=".$VERSION;
    }

    // Func::PrintData($_SESSION);
?>
<div class="container-fluid my-5">
    <h4 class="text-center mb-5">
        โปรไฟล์ของฉัน
    </h4>
    <div>
        <?php if( $customer!=null ) { ?>
        <div class="mb-5">
            <div class="alert alert-danger" role="alert">
                บัญชีของคุณอยู่ระหว่างการตรวจสอบโดยเจ้าหน้าที่ภายใน 24 ชั่วโมง
            </div>
        </div>
        <div class="profile-image">
            <img src="<?php echo $pictureUrl; ?>" alt="Profile" class="w-100">
        </div>
        <table class="table table-hover mb-4">
            <tr>
                <th style="width:125px;">ชื่อ-นามสกุล</th>
                <td>
                    <?php echo $customer["customer_name"]; ?>
                    <?php echo $customer["customer_sname"]; ?>
                </td>
            </tr>
            <tr>
                <th>ที่อยู่</th>
                <td>
                    <?php echo $customer["address"]; ?>
                    ต.<?php echo $customer["tambol_name_thai"]; ?>
                    อ.<?php echo $customer["amphur_name_thai"]; ?>
                    จ.<?php echo $customer["province_name_thai"]; ?>
                    <?php echo $customer["zipcode"]; ?>
                </td>
            </tr>
            <tr>
                <th>เบอร์มือถือ</th>
                <td><?php echo $customer["phone"]; ?></td>
            </tr>
            <tr>
                <th>อาชีพ</th>
                <td><?php echo $customer["occupation_name"]; ?></td>
            </tr>
            <tr>
                <th>ชื่อไลน์</th>
                <td><?php echo $customer["displayName"]; ?></td>
            </tr>
        </table>
        <a href="./?page=changepass" class="btn btn-lg btn-outline-warning w-100 mb-2">
            <i class="fa-solid fa-key me-2"></i>
            เปลี่ยนรหัสผ่าน
        </a>
        <a href="./?page=changeprofile" class="btn btn-lg btn-outline-secondary w-100 mb-2">
            <i class="fa-solid fa-pen me-2"></i>
            แก้ไขโปรไฟล์ของฉัน
        </a>
        <button type="button" class="btn btn-lg btn-danger w-100 mb-2" id="btn-logout">
            <i class="fa-solid fa-right-from-bracket me-2"></i>
            ออกจากระบบ
        </button>
        <?php } ?>
    </div>
</div>