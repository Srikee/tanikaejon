<?php
    include_once("../../../config/all.php");
?>
<div class="header2">
    <button type="button" class="backbutton" onclick="Func.Back()" style="display:none">
        <i class="fas fa-arrow-left me-1"></i>
    </button>
    ประวัติการใช้บริการ
    <div class="">
        <input type="text" class="form-control form-control-lg mt-3" id="search" placeholder="ค้นหา...">
        <span class="form-text text-danger">
            * ค้นหา เช่น ตัดต้นไม้ ความสะอาด
        </span>
    </div>
</div>
<div class="container-fluid py-4">
    <div id="history"></div>
</div>