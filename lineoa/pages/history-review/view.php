<?php
    include_once("../../../config/all.php");

    $customer_id = $_SESSION['customer']['data']['customer_id'];
    $sql = "
        SELECT 
            c.*,
            o.occupation_name,
            ta.tambol_name_thai,
            am.amphur_name_thai,
            pr.province_name_thai
        FROM customer c
            LEFT JOIN occupation o ON o.occupation_id = c.occupation_id
            LEFT JOIN th_tambol ta ON ta.tambol_id=c.tambol_id
            LEFT JOIN th_amphur am ON am.amphur_id=c.amphur_id
            LEFT JOIN th_province pr ON pr.province_id=c.province_id
        WHERE c.customer_id = '".$customer_id."' 
    ";
    $customer = $DB->QueryFirst($sql);

    $service_booking_id = $_GET["service_booking_id"];
    $sql = "
        SELECT 
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id = c.customer_id
        WHERE sb.service_booking_id = '".$service_booking_id."' 
            AND sb.status='3'
    ";
    $service_booking = $DB->QueryFirst($sql);
    if( $service_booking==null ) {
        echo "ไม่พบข้อมูลการใช้บริการ";
        exit();
    }

    $sql = "
        SELECT 
            sbr.*
        FROM service_booking_review sbr
        WHERE sbr.service_booking_id = '".$service_booking_id."' 
    ";
    $service_booking_review = $DB->QueryFirst($sql);
?>

<?php if( $service_booking_review==null ) { ?>
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    ให้คะแนน
</div>
<div class="container-fluid py-1">
    <form id="formdata" autocomplete="off">
        <input type="submit" id="form-submit" class="d-none">
        <input type="hidden" name="service_booking_id" value="<?php echo $service_booking_id; ?>">
        <input type="hidden" id="random_id" name="random_id" value="<?php echo Func::GenerateRandom(10); ?>">
        <div class="card text-center mb-4">
            <div class="card-header">
                <h5>ให้คะแนนต่อการใช้บริการ</h5>
            </div>
            <div class="card-body py-4">
                <i class="fa-regular fa-star star" data-star="1"></i>
                <i class="fa-regular fa-star star" data-star="2"></i>
                <i class="fa-regular fa-star star" data-star="3"></i>
                <i class="fa-regular fa-star star" data-star="4"></i>
                <i class="fa-regular fa-star star" data-star="5"></i>
            </div>
            <input type="hidden" id="review_star" name="review_star" value="">
        </div>
        <div class="mb-3">
            <label for="review_comment" class="form-label">เขียนรีวิวการใช้บริการ</label>
            <textarea class="form-control form-control-lg" id="review_comment" name="review_comment" rows="5"
                placeholder="เขียนรีวิวของคุณ..."></textarea>
        </div>
        <div class="mb-2">
            แนบรูปภาพ <span class="text-danger">สามารถแนปรูปภาพได้ไม่เกิน 4 รูป</span>
        </div>
        <div class="row mb-3 images-section">
            <div class="col-6">
                <a href="Javascript:" class="btn-add-image">
                    <div>
                        <div><i class="fas fa-images me-1"></i></div>
                        <div>แนบรูปภาพ</div>
                    </div>
                </a>
            </div>
        </div>
    </form>
</div>
<div class="footer">
    <div class="row">
        <div class="col-auto pe-2">
            <button type="button" id="btn-image" class="btn btn-light btn-lg">
                <i class="fas fa-images me-1"></i> แนปรูป
            </button>
        </div>
        <div class="col ps-2">
            <button type="button" id="btn-submit" class="btn btn-success btn-lg w-100">
                บันทึกการให้คะแนน
            </button>
        </div>
    </div>
</div>
<?php } ?>


<?php if( $service_booking_review!=null ) { ?>
<div class="header">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    การให้คะแนนของคุณ
</div>
<div class="container-fluid py-1">
    <div>
        <div class="card text-center mb-4">
            <div class="card-header">
                <h5>คะแนนต่อการใช้บริการ</h5>
            </div>
            <div class="card-body py-4">
                <?php
                    for($i=1; $i<=5; $i++) {
                        $star = "fa-regular";
                        if( $i<=$service_booking_review["review_star"]*1 ) {
                            $star = "fa-solid";
                        }
                        echo '<i class="'.$star.' fa-star star"></i>';
                    }
                ?>
            </div>
        </div>
        <?php if($service_booking_review["review_comment"]!="") { ?>
        <div class="mb-3">
            <label for="review_comment" class="form-label">รีวิวการใช้บริการ</label>
            <div><?php $service_booking_review["review_comment"]; ?></div>
        </div>
        <?php } ?>
        <?php
            $dir = "files/service_booking_review/".$service_booking["service_booking_id"]."/";
            $options = array(
                "dir"   => "../../../".$dir
            );
            $files = Func::ListFile($options);
            if( sizeof($files)>0 ) {
        ?>
        <div class="mb-2">
            รูปภาพที่รีวิว
        </div>
        <div class="row mb-3 images-section">
            <?php
                foreach($files as $file) {
                    echo '
                        <div class="col-6">
                            <img src="../'.$dir.$file.'" alt="Image" class="image">
                        </div>
                    ';
                }
            ?>
        </div>
        <?php } ?>
    </div>
</div>
<?php } ?>