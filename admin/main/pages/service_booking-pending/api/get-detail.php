<?php
    include_once('../../../../config/all.php');

    if( !ChkLogin() ) {
        echo json_encode(array(
            "status"=>"no",
            "message"=>"Session การเข้าสู่ระบบหมดอายุ กรุณาเข้าสู่ระบบใหม่อีกครั้ง"
        ));
        exit();
    }

    $service_booking_id = trim( $_POST["service_booking_id"] ?? "" );

    $sql = "
        SELECT
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id=sb.customer_id
        WHERE sb.service_booking_id='".$DB->Escape($service_booking_id)."'
    ";
    $data = $DB->QueryFirst($sql);
    if($data==null) {
        echo "No Data";
        exit();
    }
    $service_booking_id = $data["service_booking_id"];
?>
<form>
    <input type="submit" id="btn-submit" class="d-none">
    <input type="hidden" name="service_booking_id" value="<?php echo $service_booking_id; ?>">
    <table class="table table-hover table-borderless">
        <tr>
            <td style="min-width:150px;width:150px;">รหัสขอใช้บริการ</td>
            <td id="service_booking_id" class="fw-bold"><?php echo $data["service_booking_id"]; ?></td>
        </tr>
        <tr>
            <td>วันที่ส่งขอใช้บริการ</td>
            <td id="booking_datetime"><?php echo Func::DateTh($data["booking_datetime"]); ?></td>
        </tr>
        <tr>
            <td>บริการที่ขอใช้</td>
            <td id="service_name"><?php echo $data["service_name"]; ?></td>
        </tr>
        <tr>
            <td>รายละเอียดการขอใช้บริการ</td>
            <td id="note"><?php echo $data["note"]; ?></td>
        </tr>
        <tr>
            <td>สถานที่</td>
            <td id="location"><?php echo $data["location"]; ?></td>
        </tr>
        <tr>
            <td>ผู้ใช้บริการ</td>
            <td id="fullname"><?php echo $data["customer_name"]; ?> <?php echo $data["customer_sname"]; ?></td>
        </tr>
        <tr>
            <td>เบอร์มือถือ</td>
            <td id="phone"><?php echo $data["phone"]; ?></td>
        </tr>
        <tr>
            <td>สถานะ</td>
            <td id="status"><?php echo $StatusServiceBooking[$data["status"]]; ?></td>
        </tr>
        <tr>
            <td>ระบุผู้ใช้บริการ</td>
            <td>
                <select name="provider_id" id="provider_id" class="form-select" required>
                    <option value="">-- เลือกผู้ใช้บริการ --</option>
                    <?php
                        $sql = "SELECT * FROM provider WHERE status='2' ORDER BY provider_name, provider_sname";
                        $providers = $DB->QueryObj($sql);
                        foreach($providers as $provider) {
                            echo '<option value="'.$provider["provider_id"].'">'.$provider["provider_name"].' '.$provider["provider_sname"].'</option>';
                        }
                    ?>
                </select>
            </td>
        </tr>
    </table>
</form>
<div class="row images-section">
    <?php
        $dir = "files/service_booking/".$data["service_booking_id"]."/";
        $options = array(
            "dir"   => $SERVER_ROOT."../".$dir
        );
        $files = Func::ListFile($options);
        foreach($files as $file) {
            echo '
                <div class="col-6 col-md-3">
                    <img src="'.$CLIENT_ROOT."../".$dir.$file.'" alt="Image" class="image">
                </div>
            ';
        }
    ?>
</div>