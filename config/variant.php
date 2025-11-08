<?php
    $VERSION = "1.0.30";

    $LINEAO_CHANNEL_ACCESS_TOKEN = "XvDR60THam9pSjcPFlI0JICGgHeCFlSXBhE44/u0/VxPvNv3tS5isD7rvsG4Lnr0wReMvRGBeGoBTxlwl/Cp6zGBtCRyAEpgZFnl8FMdqLJcZq0USnZ806IUiesAF9bqZMBHUGcBuAKe3BA/twqbyQdB04t89/1O/w1cDnyilFU=";
    
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


    function SentMessageToLine($userId, $message, $url="") {
        global $LINEAO_CHANNEL_ACCESS_TOKEN;
        $userId = trim( $userId ?? "" );
        $message = trim( $message ?? "" );
        $url = trim( $url ?? "" );
        if($userId=="") return false;
        if($message=="") return false;
        $contents = [
            [
                "type"=>"text",
                "text"=>$message,
                "wrap"=>true
            ]
        ];
        if( $url!="" ) {
            $contents[] = [
                "type"=> "button",
                "action"=> [
                    "type"=> "uri",
                    "label"=> "เปิดดู",
                    "uri"=> $url
                ],
                "style"=> "primary",
                "color"=> "#198754",
                "margin"=> "xl"
            ];
        }
        $body = [
            "to" => [$userId],
            "messages" => [
                [
                    "type"=>"flex",
                    "altText"=>"แจ้งข้อความ",
                    "contents"=>[
                        "type"=>"bubble",
                        "body"=>[
                            "type"=>"box",
                            "layout"=>"vertical",
                            "contents"=>$contents
                        ]
                    ]
                ]
            ]
        ];
        $rs = Func::Curl(
            "https://api.line.me/v2/bot/message/multicast",
            array(
                "authorization: Bearer ".$LINEAO_CHANNEL_ACCESS_TOKEN,
                "cache-control: no-cache",
                "content-type: application/json; charset=UTF-8"
            ),
            json_encode($body)
        );
        // $rs = Func::Curl(
        //     "https://api.line.me/v2/bot/message/multicast",
        //     array(
        //         "authorization: Bearer ".$LINEAO_CHANNEL_ACCESS_TOKEN,
        //         "cache-control: no-cache",
        //         "content-type: application/json; charset=UTF-8"
        //     ),
        //     '
        //         {
        //             "to": '.json_encode([$userId]).',
        //             "messages": [{
        //                 "type": "flex",
        //                 "altText": "แจ้งข้อความ",
        //                 "contents": {
        //                     "type": "bubble",
        //                     "body": {
        //                         "type": "box",
        //                         "layout": "vertical",
        //                         "contents": [
        //                             {
        //                                 "type": "text",
        //                                 "text": "'.$message.'",
        //                                 "wrap": true
        //                             },
        //                             {
        //                                 "type": "button",
        //                                 "action": {
        //                                     "type": "uri",
        //                                     "label": "เปิดดู",
        //                                     "uri": "'.$url.'"
        //                                 },
        //                                 "style": "primary",
        //                                 "color": "#198754",
        //                                 "margin": "xl"
        //                             }
        //                         ]
        //                     }
        //                 }
        //             }]
        //         }
        //     '
        // );
        return $rs;
    }