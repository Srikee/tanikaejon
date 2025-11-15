<?php
    include_once("../../../config/all.php");

    $service_id = $_GET["service_id"] ?? "";
    $sql = "
        SELECT 
            s.*
        FROM service s
        WHERE s.service_id = '".$DB->Escape($service_id)."' 
    ";
    $service = $DB->QueryFirst($sql);
    if($service==null) {
        echo "No Data Service";
        exit();
    }
    $service_id = $service["service_id"];
    

    $sql = "
        SELECT 
            sbr.*
        FROM service_booking_review sbr
                INNER JOIN service_booking sb ON sb.service_booking_id = sbr.service_booking_id
        WHERE sb.service_id = '".$service_id."' 
        ORDER BY sbr.add_when DESC
    ";
    $service_booking_review = $DB->QueryObj($sql);
?>
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    รายละเอียดบริการ
    <button type="button" class="btn-header-reload" onclick="Func.Reload()">
        <i class="fas fa-rotate"></i>
    </button>
</div>
<div class="container-fluid py-1">
    <div class="card mb-3">
        <div class="card-header">
            ชื่อบริการ
        </div>
        <div class="card-body ">
            <h5 class="card-title"><?php echo $service["service_name"]; ?></h5>
            <p class="card-text"><?php echo $service["service_desc"]; ?></p>
        </div>
    </div>
    <div class="card  mb-3">
        <div class="card-header">
            รายละเอียดบริการ
        </div>
        <div class="card-body">
            <p class="card-text"><?php echo nl2br($service["service_info"]??""); ?></p>
        </div>
    </div>
    <?php 
        if(sizeof($service_booking_review)>0) {
            $avg_review_star = 0;
            $number_review = 0;
            foreach($service_booking_review as $key => $review) {
                $avg_review_star += floatval($review["review_star"]);
                $number_review++;
            }
            $avg_review_star = $avg_review_star / $number_review;
    ?>
    <div class="card  mb-3">
        <div class="card-header">
            คะแนนรีวิวของลูกค้า
        </div>
        <div class="card-body ">
            <div class="row mb-2">
                <div class="col">
                    <div>
                        <span class="fs-2 fw-bold"><?php echo number_format($avg_review_star, 1); ?></span>
                        <span>/5</span>
                    </div>
                </div>
                <div class="col-auto d-flex align-items-center">
                    <div class="text-warning">
                        <?php 
                            for ($i=1; $i <= 5; $i++) { 
                                if($i <= floor($avg_review_star)) {
                                    echo '<i class="fas fa-star star"></i>';
                                } else if($i - $avg_review_star < 1) {
                                    echo '<i class="fas fa-star-half-alt star"></i>';
                                } else {
                                    echo '<i class="far fa-star star"></i>';
                                }
                            }
                        ?>
                    </div>
                </div>
            </div>
            <div class="mb-2 text-muted">
                จากผู้ใช้งานจริง <?php echo number_format($number_review, 0); ?> ราย
            </div>
            <div>
                <?php
                    for ($i=5; $i >= 1; $i--) {
                        // นับจำนวนรีวิวที่ได้ดาวเท่ากับ $i
                        $count = 0;
                        foreach($service_booking_review as $review) {
                            if(intval($review["review_star"]) == $i) {
                                $count++;
                            }
                        }
                        $percentage = ($number_review > 0) ? ($count / $number_review) * 100 : 0;
                        echo '
                            <div class="mb-3">
                                <div class="row progress-text">
                                    <div class="col">'.$i.' ดาว</div>
                                    <div class="col text-end">'.number_format($percentage, 0).'%</div>
                                </div>
                                <div class="progress" role="progressbar" aria-valuenow="'.number_format($percentage, 0).'" aria-valuemin="0" aria-valuemax="100">
                                    <div class="progress-bar" style="width: '.number_format($percentage, 0).'%"></div>
                                </div>
                            </div>
                        ';
                    }
                ?>
            </div>
        </div>
    </div>
    <div class="card card-custom mb-card">
        <div class="card-header card-header-custom">รีวิวจากลูกค้า</div>
        <div class="card-body">
            <?php
                foreach($service_booking_review as $review) {
                    $review_comment = $review["review_comment"];
                    if( $review_comment != "" ) {
                        $review_comment = '<p class="small-note">'.$review_comment.'</p>';
                    }
                    
                    $review_image = "";
                    $dir = "files/service_booking_review/".$review["service_booking_id"]."/";
                    $options = array(
                        "dir"   => "../../../".$dir
                    );
                    $files = Func::ListFile($options);
                    if( sizeof($files)>0 ) {
                        $review_image .= '<div class="row mb-3 images-section">';
                        foreach($files as $file) {
                            $review_image .= '
                                <div class="col-3">
                                    <img src="../'.$dir.$file.'" class="image">
                                </div>
                            ';
                        }
                        $review_image .= '</div>';
                    }
                    echo '
                        <div class="mb-3">
                            <div class="d-flex align-items-center mb-2">
                                <img src="../images/default-profile.png" width="40" class="rounded-circle me-2" alt="user">
                                <div>
                                    <strong>คุณบี</strong><br>
                                    <small class="text-muted">ให้ '.$review["review_star"].' ดาว</small>
                                </div>
                            </div>
                            '.$review_comment.'
                            '.$review_image.'
                        </div>
                    ';
                }
            ?>
        </div>
    </div>
    <?php } else { ?>
    <div>
        <div class="text-center py-4">
            <img src="../images/noreview.png" width="70" class="opacity-50 mb-3" />
            <p class="text-muted mb-1">ยังไม่มีรีวิวจากลูกค้า</p>
            <p class="small text-muted">บริการนี้ยังไม่มีคะแนนหรือความคิดเห็นจากลูกค้า</p>
        </div>
    </div>
    <?php } ?>
</div>
<div class="footer">
    <div class="row">
        <div class="col-auto pe-2">
            <button type="button" onclick="Func.Back()" class="btn btn-light btn-lg">
                <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
            </button>
        </div>
        <div class="col ps-2">
            <a href="./?page=service_booking-add&service_id=<?php echo $service_id; ?>"
                class="btn btn-success btn-lg w-100">
                ขอใช้บริการนี้
            </a>
        </div>
    </div>
</div>