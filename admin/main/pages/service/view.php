<?php
    $p = @$_GET["p"]*1; if($p==0) $p = 1;
    $search = $_GET["search"] ?? "";
    $condition = "";
    if( $search!="" ) {
        $condition .= " AND (
            t.service_name LIKE '%".$DB->Escape($search)."%'
        )";
    }
    $sql = "
        SELECT
            t.*
        FROM service t
        WHERE 1=1 ".$condition."
        ORDER BY t.edit_when DESC
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
            <li class="breadcrumb-item"><a href="./?page=service">ข้อมูลการบริการ</a></li>
        </ol>
    </nav>
</div>
<div class="ks-main-content">
    <div class="row mb-3">
        <div class="col">
            <a href="./?page=service-add" class="btn btn-success me-2" service="เพิ่มข้อมูล">
                <i class="fa fa-plus me-1"></i>
                เพิ่มข้อมูล
            </a>
            <a href="./?page=service" class="btn btn-light me-2 border" service="รีโหลด">
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
                <div class="form-text">พิมพ์คำค้นหา.. การบริการ</div>
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
                        <a class="page-link" href="<?php echo $href; ?>" title="หน้าแรก">
                            << </a>
                    </li>
                    <li class="page-item <?php echo $disabled_pr; ?>">
                        <a class="page-link" href="<?php echo $href_pr; ?>" title="หน้าก่อนหน้า">
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
                        <a class="page-link" href="<?php echo $href_ne; ?>" title="หน้าถัดไป">></a>
                    </li>
                    <li class="page-item <?php echo $disabled_ne; ?>">
                        <a class="page-link" href="<?php echo $href."&p=".$p_all; ?>" title="หน้าสุดท้าย">>></a>
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
                    <th style="width:60px;" class="text-center">ลำดับ</th>
                    <th style="min-width: 200px;">การบริการ</th>
                    <th style="min-width: 200px;">คำอธิบาย</th>
                    <th style="min-width: 88px; width: 88px;" class="text-center">จัดการ</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if( sizeof($obj)==0 ) {
                        echo '<tr><td colspan="4" class="text-center font-italic">ไม่พบรายการ</td></tr>';
                    } else {
                        foreach ($obj as $key => $value) {
                            $btn_edit = '<a href="./?page=service-edit&service_id='.$value["service_id"].'" title="แก้ไขข้อมูล" data-container="#table" class="btn btn-warning btn-sm"><i class="fa fa-pencil-alt"></i></a>';
                            $btn_del = '<button class="btn btn-danger btn-sm btn-del" title="ลบข้อมูล" data-container="#table"><i class="fa fa-trash"></i></button>';
                            echo '
                                <tr data-json="'.htmlspecialchars(json_encode($value)).'">
                                    <td class="text-center">'.(($show*($p-1))+($key+1)).'</td>
                                    <td>'.$value["service_name"].'</td>
                                    <td>'.$value["service_desc"].'</td>
                                    <td class="text-center p-0 pt-1">
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