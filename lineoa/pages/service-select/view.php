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
    

    // $sql = "
    //     SELECT 
    //         sbr.*
    //     FROM service_booking_review sbr
    //     WHERE sbr.service_booking_id = '".$service_booking_id."' 
    // ";
    // $service_booking_review = $DB->QueryFirst($sql);
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
            <h5 class="card-title">นวดเพื่อสุขภาพ</h5>
            <p class="card-text">บริการนวดเพื่อสุขภาพราคาถูก</p>
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
    <div class="card  mb-3">
        <div class="card-header">
            คะแนนรีวิวของลูกค้า
        </div>
        <div class="card-body ">
            <div class="row mb-3">
                <div class="col">
                    <div>
                        <span class="fs-2 fw-bold">4.9</span>
                        <span>/5</span>
                    </div>
                    <div>
                        จากผู้ใช้งานจริง 124 ราย
                    </div>
                </div>
                <div class="col-auto text-warning">
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                    <i class="fas fa-star star"></i>
                </div>
            </div>
            <div class="mb-3">แจกแจงคะแนน</div>
            <div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">5 ดาว</div>
                        <div class="col text-end">90%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-valuenow="90" aria-valuemin="0" aria-valuemax="90">
                        <div class="progress-bar" style="width: 90%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">4 ดาว</div>
                        <div class="col text-end">95%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="95"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 95%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">3 ดาว</div>
                        <div class="col text-end">3%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="3"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 3%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">2 ดาว</div>
                        <div class="col text-end">5%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="5"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 5%"></div>
                    </div>
                </div>
                <div class="mb-3">
                    <div class="row">
                        <div class="col">1 ดาว</div>
                        <div class="col text-end">2%</div>
                    </div>
                    <div class="progress" role="progressbar" aria-label="Basic example" aria-valuenow="2"
                        aria-valuemin="0" aria-valuemax="100">
                        <div class="progress-bar" style="width: 2%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="card card-custom mb-card">
        <div class="card-header card-header-custom">รีวิวจากลูกค้า</div>
        <div class="card-body">
            <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                    <img src="../images/default-profile.png" width="40" class="rounded-circle me-2" alt="user">
                    <div>
                        <strong>คุณเอ</strong><br>
                        <small class="text-muted">ให้ 5 ดาว</small>
                    </div>
                </div>
                <p class="small-note">บริการดีมาก นวดแล้วสบายตัวสุด ๆ ชอบมากค่ะ</p>

                <div class="d-flex gap-2">
                    <img src="https://placehold.co/600x400" class="rounded" style="width:32%; object-fit:cover;">
                    <img src="https://placehold.co/600x400" class="rounded" style="width:32%; object-fit:cover;">
                    <img src="https://placehold.co/600x400" class="rounded" style="width:32%; object-fit:cover;">
                </div>
            </div>
            <hr>
            <div class="mb-3">
                <div class="d-flex align-items-center mb-2">
                    <img src="../images/default-profile.png" width="40" class="rounded-circle me-2" alt="user">
                    <div>
                        <strong>คุณบี</strong><br>
                        <small class="text-muted">ให้ 4 ดาว</small>
                    </div>
                </div>
                <p class="small-note">บรรยากาศดี ผ่อนคลาย ราคาถูกเมื่อเทียบกับคุณภาพ</p>
                <div class="d-flex gap-2">
                    <img src="https://placehold.co/600x400" class="rounded" style="width:32%; object-fit:cover;">
                </div>
            </div>

        </div>
    </div>
</div>
<div class="footer">
    <div class="row">
        <div class="col-auto pe-2">
            <button type="button" onclick="Func.Back()" class="btn btn-light btn-lg">
                <i class="fas fa-arrow-left me-1"></i> ย้อนกลับ
            </button>
        </div>
        <div class="col ps-2">
            <a href="./?page=service_booking-add&service_id=<?php echo $service_id; ?>" type="button"
                class="btn btn-success btn-lg w-100">
                ถัดไป <i class="fas fa-arrow-right ms-1"></i>
            </a>
        </div>
    </div>
</div>