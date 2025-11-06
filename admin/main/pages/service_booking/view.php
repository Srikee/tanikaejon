<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = $_GET["search"] ?? "";
    $condition = "";
    if( $search!="" ) {
        $condition .= " AND (
            sb.service_name LIKE '%".$DB->Escape($search)."%'
        )";
    }
    $sql = "
        SELECT
            sb.*,
            c.customer_name,
            c.customer_sname
        FROM service_booking sb
            LEFT JOIN customer c ON c.customer_id=sb.customer_id
        WHERE 1=1 ".$condition."
        ORDER BY sb.edit_when DESC
    ";
    $show = $SHOW;
    $all = $DB->QueryNumRow($sql);
    $p_all = ceil( $all/$show );
    $start = ($p-1)*$show;
    $obj = $DB->QueryObj($sql." LIMIT ".$start.", ".$show);
?>
<div class="ks-main-header">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb mb-0">
            <li class="breadcrumb-item"><a href="./?page=customer-pending">ผู้ขอใช้บริการทั้งหมด</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <div class="row mb-3">
        <div class="col">
            <a href="./?page=customer-pending" class="btn btn-light me-2 border" customer="รีโหลด">
                <i class="fa fa-sync me-1"></i>
                รีโหลด
            </a>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col">
            <div>
                <label for="search" class="form-label">ค้นหา</label>
                <input type="text" class="form-control" id="search" value="<?php echo htmlspecialchars($search); ?>"
                    placeholder="ค้นหา">
                <div class="form-text">พิมพ์คำค้นหา.. ลูกค้า</div>
            </div>
        </div>
    </div>
    <div class="row mb-3">
        <div class="col-auto d-flex align-items-center">
            ค้นพบ <?php echo $all; ?> รายการ
        </div>
        <div class="col">
            <!-- แสดง Pagination -->
            <?php 
                if( sizeof($obj)>0 ) { 
                    $href = "./?page=".$PAGE;
                    if( isset($_GET["search"]) ) $href .= "&search=".$_GET["search"];
                    $p_show = $PAGE_SHOW;
                    $diff_center = floor($p_show/2);
                    $min_page = $p-$diff_center;
                    $max_page = $p+$diff_center;
                    $duration = 0;
                    if( $min_page<1 ) $duration=1-$min_page;
                    else if( $max_page>$p_all ) $duration=$p_all-$max_page;
                    $min_page = $min_page+$duration;
                    $max_page = $max_page+$duration;
                    if( $min_page<=0 ) $min_page = 1;
                    if( $max_page>$p_all ) $max_page = $p_all;
            ?>
            <nav aria-label="Page navigation">
                <ul class="pagination pagination-sm justify-content-end m-0">
                    <?php 
                        $disabled_pr = "";
                        $href_pr = $href;
                        if( $p-1>1 ) $href_pr .= "&p=".($p-1);
                        if( $p==1 ) {
                            $disabled_pr = "disabled";
                            $href_pr = "#";
                        }
                    ?>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href; ?>" customer="หน้าแรก">
                            << </a>
                    </li>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href_pr; ?>" customer="หน้าก่อนหน้า">
                            < </a>
                    </li>
                    <?php
                        for($i=$min_page; $i<=$max_page; $i++) {
                            $href_p = $href;
                            if( $i>1 ) $href_p .= "&p=".$i;
                            $active = "";
                            if( $i==$p ) $active = "active";
                            echo '<li class="page-item '.$active.'"><a class="page-link" href="'.$href_p.'">'.$i.'</a></li>';
                        }
                    ?>
                    <?php 
                        $disabled_ne = "";
                        $href_ne = $href;
                        $href_ne .= "&p=".($p+1);
                        if( $p==$p_all ) {
                            $disabled_ne = "disabled";
                            $href_ne = "#";
                        }
                    ?>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href_ne; ?>" customer="หน้าถัดไป">></a>
                    </li>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href."&p=".$p_all; ?>" customer="หน้าสุดท้าย">>></a>
                    </li>
                </ul>
            </nav>
            <?php
                }
            ?>
            <!-- สิ้นสุดแสดง Pagination -->
        </div>
    </div>
    <div class="table-responsive">
        <table id="table" class="table table-bordered table-hover">
            <thead>
                <tr class="table-secondary">
                    <th style="min-width:140px;width:140px;" class="text-center">รหัสขอใช้บริการ</th>
                    <th style="min-width:150px;width:150px;" class="text-center">วันที่ขอใช้บริการ</th>
                    <th style="min-width: 200px;">บริการ</th>
                    <th class="text-center" style="min-width: 200px; width: 200px;">ลูกค้า</th>
                    <th class="text-center" style="min-width: 120px; width: 120px;">เบอร์มือถือ</th>
                    <th style="min-width: 70px; width: 70px;" class="text-center">สถานะ</th>
                    <th style="min-width: 150px; width: 150px;" class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if( sizeof($obj)==0 ) {
                        echo '<tr><td colspan="7" class="text-center font-italic">ไม่พบรายการ</td></tr>';
                    } else {
                        foreach ($obj as $key => $value) {
                            $btn_edit = '<a href="./?page=service-edit&service_id='.$value["customer_id"].'" title="แก้ไขข้อมูล" data-container="#table" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>';
                            $btn_del = '<button class="btn btn-danger btn-sm btn-del" title="ลบข้อมูล" data-container="#table"><i class="fa fa-trash"></i></button>';
                            echo '
                                <tr data-json="'.htmlspecialchars(json_encode($value)).'">
                                    <td class="text-center">'.$value["service_booking_id"].'</td>
                                    <td class="text-center">'.Func::DateTh($value["booking_datetime"]).'</td>
                                    <td>'.$value["service_name"].'</td>
                                    <td class="text-center">'.$value["customer_name"].' '.$value["customer_sname"].'</td>
                                    <td class="text-center">'.Func::FormatPhoneNumber($value["phone"]).'</td>
                                    <td class="text-center" data-bs-toggle="tooltip" data-bs-title="'.$StatusServiceBookingText[$value["status"]].'">'.$StatusServiceBookingShort[$value["status"]].'</td>
                                    <td class="text-center p-0 pt-1">
                                        <button title="ดูข้อมูล" class="btn btn-success btn-sm btn-view">
                                            ดูข้อมูล
                                        </button>
                                        '.$btn_edit.'
                                        '.$btn_del.'
                                    </td>
                                </tr>
                            ';
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>