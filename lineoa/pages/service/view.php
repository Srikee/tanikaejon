<?php
    include_once("../../../config/all.php");
?>
<div class="container-fluid my-4">
    <h4 class="text-center mb-4">
        บริการของเรา
    </h4>
    <div>
        <div class="mb-3">
            <input type="text" class="form-control form-control-lg mt-3" id="search" placeholder="ค้นหาบริการของเรา...">
            <span class="form-text text-danger">
                * พิมพ์คำค้นหา เช่น ตัดต้นไม้ ทำความสะอาด เป็นต้น
            </span>
        </div>
        <ul class="list-group" id="service"></ul>
    </div>
</div>