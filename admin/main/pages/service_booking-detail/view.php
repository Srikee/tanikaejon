<?php
    $service_booking_id = trim( $_GET["service_booking_id"] ?? "" );
    $sql = "
        SELECT
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id=sb.customer_id
        WHERE sb.status IN (2, 3, 4) 
            AND service_booking_id='".$DB->Escape($service_booking_id)."'
    ";
    $data = $DB->QueryFirst($sql);
    if( $data==null ) {
        Func::ShowAlert("", "ไม่พบข้อมูล", "error", "./?page=service_booking");
        exit();
    }
    $service_booking_id = $data["service_booking_id"];
?>
<input type="hidden" id="service_booking_id" value="<?php echo htmlspecialchars($service_booking_id); ?>">
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item">
                <a href="./?page=service_booking-detail&service_booking_id=<?php echo $service_booking_id; ?>">
                    รายละเอียดผู้ขอใช้บริการ
                </a>
            </li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <div class="row mb-3">
        <div class="col">
            <a href="./?page=service_booking-detail&service_booking_id=<?php echo $service_booking_id; ?>"
                class="btn btn-light me-2 border" title="รีโหลด">
                <i class="fa fa-sync me-1"></i>
                รีโหลด
            </a>
        </div>
    </div>
    <div class="mb-4">
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                รหัสขอใช้บริการ
            </div>
            <div class="col-lg ui-info-desc">
                <b><?php echo $data["service_booking_id"]; ?></b>
            </div>
            <div class="col-auto ui-info-title">
                วันที่ส่งขอ
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo Func::DateTh($data["booking_datetime"]); ?> น.
            </div>
        </div>
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                บริการขอใช้
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $data["service_name"]; ?>
            </div>
        </div>
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                รายละเอียด
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $data["note"]; ?>
            </div>
        </div>
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                สถานที่
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $data["location"]; ?>
            </div>
        </div>
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                ผู้ใช้บริการ
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $data["customer_name"]; ?>
                <?php echo $data["customer_sname"]; ?>
            </div>
            <div class="col-auto ui-info-title">
                เบอร์มือถือ
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $data["phone"]; ?>
            </div>
        </div>
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                สถานะ
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $StatusServiceBooking[$data["status"]]; ?>
            </div>
        </div>
        <div class="row ui-info-item">
            <div class="col-auto ui-info-title">
                ผู้ให้บริการ
            </div>
            <div class="col-lg ui-info-desc">
                <?php echo $data["provider_fullname"]; ?>
                ( <?php echo $data["provider_phone"]; ?> )
            </div>
        </div>
    </div>
    <?php
        $dir = "files/service_booking/".$data["service_booking_id"]."/";
        $options = array(
            "dir"   => $SERVER_ROOT."../".$dir
        );
        $files = Func::ListFile($options);
        if( sizeof($files)>0 ) {
    ?>
    <div class="mb-4">
        <div class="row mb-4 images-section">
            <?php
                foreach($files as $file) {
                    echo '
                        <div class="col-6 col-md-3">
                            <img src="../../'.$dir.$file.'" alt="Image" class="image">
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
    <?php } ?>
    <?php
        $sql = "
            SELECT * FROM service_booking_timeline 
            WHERE service_booking_id='".$service_booking_id."' 
            ORDER BY add_when 
        ";
        $timelines = $DB->QueryObj($sql);
    ?>
    <div class="mt-5 mb-4">
        <h5 class="mb-3 fw-bold">บันทึกผลการดำเนินงาน</h5>
        <div class="table-responsive mb-4">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="min-width:165px;width:165px;">วันที่</th>
                        <th style="min-width:300px;">ผลการดำเนินงาน</th>
                        <th style="min-width:160px;width:160px;">ผู้ดำเนินงาน</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                        foreach($timelines as $timeline) {
                            $dir = "files/service_booking_timeline/".$timeline["service_booking_timeline_id"]."/";
                            $options = array(
                                "dir"   => $SERVER_ROOT."../".$dir
                            );
                            $files = Func::ListFile($options);
                            $images = '';
                            if( sizeof($files)>0 ) {
                                $images = '<div class="row mt-3 images-section">';
                                foreach($files as $file) {
                                    $images .= '
                                        <div class="col-6 col-sm-3 col-md-2">
                                            <img src="../../'.$dir.$file.'" alt="Image" class="image">
                                        </div>
                                    ';
                                }
                                $images .= '</div>';
                            }
                            echo '
                                <tr>
                                    <td>'.Func::DateTh($timeline["add_when"], true).' น.</td>
                                    <td>
                                        <div>'.nl2br($timeline["timeline_desc"]).'</div>
                                        '.$images.'
                                    </td>
                                    <td>'.$timeline["add_by"].'</td>
                                </tr>
                            ';
                        }
                    ?>
                </tbody>
            </table>
        </div>
        <?php if($data["status"]=="2") { ?>
        <div>
            <button class="btn btn-info me-2 mb-2" id="btn-update-process">
                <i class="fa-solid fa-clock-rotate-left"></i>
                บันทึกผลการดำเนินงาน
            </button>
            <button class="btn btn-success me-2 mb-2" id="btn-update-complete">
                <i class="fa-solid fa-circle-check"></i>
                ดำเนินการเสร็จแล้ว
            </button>
        </div>
        <?php } ?>
    </div>
    <?php
        function DisplayText($text) {
            if($text=="") return "-"; 
            return nl2br($text);
        }
        $sql = "
            SELECT 
                sbr.*
            FROM service_booking_review sbr
            WHERE sbr.service_booking_id = '".$service_booking_id."' 
        ";
        $service_booking_review = $DB->QueryFirst($sql);
    ?>
    <?php if( $service_booking_review!=null ) { ?>
    <div class="mt-5 mb-5">
        <h5 class="mb-4 fw-bold">ผลการรีวิวของลูกค้า</h5>
        <div class="mb-4">
            <?php
                for($i=1; $i<=5; $i++) {
                    $star = "fa-regular";
                    if( $i<=$service_booking_review["review_star"]*1 ) {
                        $star = "fa-solid";
                    }
                    echo '<i class="'.$star.' fa-star star"></i>';
                }
            ?>
            <span class="review-score">
                <?php echo $service_booking_review["review_star"] ?> คะแนน
            </span>
        </div>
        <div class="mb-4">
            <div class="fw-bold mb-2">ข้อความรีวิว :</div>
            <div>
                <?php echo DisplayText($service_booking_review["review_comment"]); ?>
            </div>
        </div>
        <div class="mb-4">
            <div class="fw-bold mb-2">ภาพรีวิว :</div>
            <div class="row images-section">
                <?php
                    $dir = "files/service_booking_review/".$service_booking_id."/";
                    $options = array(
                        "dir"   => $SERVER_ROOT."../".$dir
                    );
                    $files = Func::ListFile($options);
                    if( sizeof($files)>0 ) {
                        foreach($files as $file) {
                            echo '
                                <div class="col-6 col-md-2">
                                    <img src="../../'.$dir.$file.'" alt="Image" class="image">
                                </div>
                            ';
                        }
                    } else {
                        echo '<div class="col">ไม่มีภาพรีวิว</div>';
                    }
                ?>
            </div>
        </div>
    </div>
    <?php } ?>
</div>