<?php
    $VERSION = "1.0.25";
    
    $StatusServiceBooking = [
        "1"=>'<span class="text-warning"><i class="fas fa-alarm-clock"></i> รอดำเนินการ</span>',
        "2"=>'<span class="text-info"><i class="fas fa-clock"></i> กำลังดำเนินการ</span>',
        "3"=>'<span class="text-success"><i class="fas fa-circle-check"></i> เสร็จสิ้น</span>',
        "4"=>'<span class="text-danger"><i class="fas fa-times"></i> ยกเลิก</span>',
        "5"=>'<span class="text-danger"><i class="fas fa-times"></i> ลบแล้ว</span>'
    ];
    $StatusServiceBookingShort = [
        "1"=>'<span class="text-warning"><i class="fas fa-alarm-clock"></i></span>',
        "2"=>'<span class="text-info"><i class="fas fa-clock"></i></span>',
        "3"=>'<span class="text-success"><i class="fas fa-circle-check"></i></span>',
        "4"=>'<span class="text-danger"><i class="fas fa-times"></i></span>',
        "5"=>'<span class="text-danger"><i class="fas fa-trash"></i></span>'
    ];
    $StatusServiceBookingText = [
        "1"=>'รอดำเนินการ',
        "2"=>'กำลังดำเนินการ',
        "3"=>'เสร็จสิ้น',
        "4"=>'ยกเลิก',
        "5"=>'ลบแล้ว'
    ];