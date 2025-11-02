<?php
    class Func {
        public static $fullmonth = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
        public static $shortmonth = ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย","ก.ค","ส.ค","ก.ย","ต.ค","พ.ย.","ธ.ค."];
        public static function SendLineNotify($lineToken, $message) {
            $LINE_API = "https://notify-api.line.me/api/notify";
            $headers = [
                'Authorization: Bearer ' . $lineToken
            ];
            $fields = [
                'message' => $message
            ];
            try {
                $ch = curl_init();
                curl_setopt($ch, CURLOPT_URL, $LINE_API);
                curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
                curl_setopt($ch, CURLOPT_POST, count($fields));
                curl_setopt($ch, CURLOPT_POSTFIELDS, $fields);
                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
                curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
                $result = curl_exec($ch);
                curl_close($ch);
                if ($result == false) throw new Exception(curl_error($ch), curl_errno($ch));
                $json = json_decode($result, true);
                if( isset($json["status"]) && $json["status"]==200 ) return true;
            } catch (Exception $e) { }
            return false;
        }
        public static function Curl($Url, $headers, $feilds, $method="POST") {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $Url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 30,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => $feilds,
                CURLOPT_HTTPHEADER => $headers
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }
        public static function ReplyMessage($message) {
            global $CHANNEL_ACCESS_TOKEN, $replyToken;
            self::Curl(
                "https://api.line.me/v2/bot/message/reply",
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                '
                    {
                        "replyToken": "'.$replyToken.'",
                        "messages": [{
                            "type": "text",
                            "text": "'.$message.'"
                        }]
                    }
                '
            );
        }
        public static function ReplyQuickMessage($message, $messages) {
            // Ex. ReplyQuickMessage("แน่ใจไหม ?", array("ใช่", "ไม่"));
            global $CHANNEL_ACCESS_TOKEN, $replyToken;
            $items = array();
            foreach($messages as $val) {
                $items[] = array(
                    "type"=>"action",
                    "action"=>array(
                        "type"=>"message",
                        "label"=>$val,
                        "text"=>$val,
                    )
                );
            }
            $res = self::Curl(
                "https://api.line.me/v2/bot/message/reply",
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                '
                    {
                        "replyToken": "'.$replyToken.'",
                        "messages": [{
                            "type": "text",
                            "text": "'.$message.'",
                            "quickReply": {
                                "items": '.json_encode($items).'
                            }
                        }]
                    }
                '
            );
        }
        public static function SendMessage($users, $message) {
            global $CHANNEL_ACCESS_TOKEN;
            $messages = array(
                array(
                    "type"=>"text",
                    "text"=>$message
                )
            );
            self::Curl(
                "https://api.line.me/v2/bot/message/multicast",
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                '
                    {
                        "to": '.json_encode($users).',
                        "messages": '.json_encode($messages).'
                    }
                '
            );
        }
        public static function SendMessageAll($message) {
            global $CHANNEL_ACCESS_TOKEN;
            $messages = array(
                array(
                    "type"=>"text",
                    "text"=>$message
                )
            );
            self::Curl(
                "https://api.line.me/v2/bot/message/broadcast",
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                '
                    {
                        "messages": '.json_encode($messages).'
                    }
                ',
                'POST'
            );
        }
        public static function GetUser($userId) {
            global $CHANNEL_ACCESS_TOKEN;
            $user = self::Curl(
                "https://api.line.me/v2/bot/profile/".$userId,
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                '
                    {}
                ',
                'GET'
            );
            $user = json_decode($user, true);
            if( !isset($user["userId"]) ) {
                return null;
            }
            return $user;
        }
        public static function GetContent($arrData) {
            $url = $arrData["url"];
            $postdata = http_build_query($arrData);
            $opts = array(
                'http' => array(
                    'method'  => 'POST',
                    'header'  => 'Content-type: application/x-www-form-urlencoded',
                    'content' => $postdata
                ),
                "ssl"=>array(
                    "verify_peer"=>false,
                    "verify_peer_name"=>false,
                )
            );
            $context = stream_context_create($opts);
            return file_get_contents($url, false, $context);
        }
        public static function GetClientIpEnv() {
            $ipaddress = '';
            if (getenv('HTTP_CLIENT_IP'))
                $ipaddress = getenv('HTTP_CLIENT_IP');
            else if(getenv('HTTP_X_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_X_FORWARDED_FOR');
            else if(getenv('HTTP_X_FORWARDED'))
                $ipaddress = getenv('HTTP_X_FORWARDED');
            else if(getenv('HTTP_FORWARDED_FOR'))
                $ipaddress = getenv('HTTP_FORWARDED_FOR');
            else if(getenv('HTTP_FORWARDED'))
                $ipaddress = getenv('HTTP_FORWARDED');
            else if(getenv('REMOTE_ADDR'))
                $ipaddress = getenv('REMOTE_ADDR');
            else
                $ipaddress = 'UNKNOWN';
        
            return $ipaddress;
        }
        public static function DateTh($date, $time=true) {
            if( $date=="0000-00-00" || $date=="" ) return "";
            $arr1 = explode(" ", $date);
            $arr2 = explode("-", $arr1[0]);
            if( sizeof($arr2)<=2 ) return "";
            $rs = $arr2[2]."/".$arr2[1]."/".($arr2[0]*1+543);
            if( sizeof($arr1)==2 ) $rs .= " ".substr($arr1[1], 0, 5);
            if( $time==false ) {
                $arr = explode(" ", $rs);
                return $arr[0];
            }
            return $rs;
        }
        public static function DateEn($date, $time=true) {
            $arr1 = explode(" ", $date);
            $arr2 = explode("/", $arr1[0]);
            if( sizeof($arr2)<=2 ) return "";
            $rs = ($arr2[2]*1-543)."-".$arr2[1]."-".($arr2[0]);
            if( sizeof($arr1)==2 ) $rs .= " ".substr($arr1[1], 0, 5);
            if( $time==false ) {
                $arr = explode(" ", $rs);
                return $arr[0];
            }
            return $rs;
        }
        public static function GetDateNowTh() {
            $date = date("d/m/").(date("Y")*1+543);
            return $date;
        }
        public static function GetDateNowEn() {
            $date = date("Y-m-d");
            return $date;
        }
        public static function ToNum($num) {
            $num = $num."";
            $num = @str_replace(" %", "", $num);
            return @number_format( str_replace(",","",$num)*1, 2, '.', '');
        }
        public static function PrintData($data) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        public static function LinkTo($url) {
            echo '
                <script>
                    location.href = "'.$url.'";
                </script>
            ';
            exit();
        }
        public static function Back() {
            echo '
                <script>
                    history.back();
                </script>
            ';
            exit();
        }
        public static function Reload() {
            echo '
                <script>
                    var href = window.location.href;
                    window.history.replaceState({}, "", href);
                    location.reload();
                </script>
            ';
            exit();
        }
        public static function ShowAlert($title="แจ้งข้อความ", $html="ระบุข้อความ", $type="question", $href="") {
            // $type = success, error, warning, info, question
            echo '
                <script>
                    ShowAlert({
                        title: "'.$title.'",
                        html: "'.$html.'",
                        type: "'.$type.'",
                        callback: function() {
                            if( "'.$href.'"!="" ) {
                                window.location.href = "'.$href.'";
                            }
                        }
                    });
                </script>
            ';
        }
        public static function AcceptImplode($type) {
            foreach ($type as $key => $value) {
                $type[$key] = ".".$type[$key];
            }
            return implode(", ", $type);
        }
        public static function GetTypeBase64($base64) {
            $arr1 = explode(";base64", $base64);
            $arr2 = explode("/", $arr1[0]);
            $type = $arr2[ sizeof($arr2)-1 ];
            if( $type=="vnd.openxmlformats-officedocument.wordprocessingml.document" ) return "docx";
            if( $type=="msword" ) return "doc";
            return $type;
        }
        public static function UploadBase64($base64, $host, $user, $pass, $dir, $rename=null, $allowType=[]) {
            $type = GetTypeBase64($base64);  // support : jpg, jpeg, png, gif, pdf, doc, docx
            if( !in_array($type, $allowType) ) return array( "status"=>"no", "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            $rename = ( $rename==null ) ? time() : $rename;
            $fileName = $rename.".".$type;
            file_put_contents("/tmp/".$fileName, base64_decode(explode(',',$base64)[1]));
            $ftp = new FTPConnect($host, $user, $pass);
            $rs = $ftp->UploadFile("/tmp/".$fileName, $dir.$fileName);
            if($rs) return array( "status"=>"ok", "fileName"=>$fileName );
            return array( "status"=>"no", "fileName"=>"", "message"=>"ไม่พบไฟล์" );
        }
        public static function UploadRenameFile($elementName, $host, $user, $pass, $dir, $rename=null, $allowType=null, $index=null) {
            if( isset($_FILES[$elementName]) && $_FILES[$elementName]["size"]>0 ) {
                $ftp = new FTPConnect($host, $user, $pass);
                if( $index!==null ) {
                    $tmpName = $_FILES[$elementName]['tmp_name'][$index];
                    $name = $_FILES[$elementName]['name'][$index];
                    $size = $_FILES[$elementName]['size'][$index];
                } else {
                    $tmpName = $_FILES[$elementName]['tmp_name'];
                    $name = $_FILES[$elementName]['name'];
                    $size = $_FILES[$elementName]['size'];
                }
                $type = strtolower(pathinfo($name, PATHINFO_EXTENSION));
                if( $rename===null ) $rename = $name;
                if( $allowType!==null && !in_array($type, $allowType) ) return array( "status"=>"no", "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
                if( $allowType!==null) {
                    foreach ($allowType as $key => $value) {
                        if( $ftp->IsFile($dir.$rename.".".$value) ) $ftp->Unlink($dir.$rename.".".$value);
                    }
                }
                if( !$ftp->IsDir($dir) ) return array( "status"=>"no", "fileName"=>"", "message"=>"ไม่พบโฟลเดอร์ ".$dir );
                $fileName = $rename.".".$type;
                $ftp->MoveUploadFile($tmpName, $dir.$fileName);
                return array( "status"=>"ok", "fileName"=>$fileName );
            }
            return array( "status"=>"no", "fileName"=>"", "message"=>"ไม่พบไฟล์" );
        }
        public static function MoveUploadFile($host, $user, $pass, $file, $target_file) {
            $ftp = new FTPConnect($host, $user, $pass);
            return $ftp->MoveUploadFile($file, $target_file);
        }
        public static function MakeDir($host, $user, $pass, $target_path) {
            $ftp = new FTPConnect($host, $user, $pass);
            $ftp->MkDir($target_path);
        }
        public static function RemoveDir($host, $user, $pass, $target_path) {
            if( self::IsDir($host, $user, $pass, $target_path) ) {
                $ftp = new FTPConnect($host, $user, $pass);
                return $ftp->RmDir($target_path);
            }
            return false;
        }
        public static function RemoveFile($host, $user, $pass, $target_file) {
            if( self::IsFile($host, $user, $pass, $target_file) ) {
                $ftp = new FTPConnect($host, $user, $pass);
                return $ftp->Unlink($target_file);
            }
            return false;
        }
        public static function IsDir($host, $user, $pass, $target_path) {
            $ftp = new FTPConnect($host, $user, $pass);
            return $ftp->IsDir($target_path);
        }
        public static function IsFile($host, $user, $pass, $target_file) {
            $ftp = new FTPConnect($host, $user, $pass);
            return $ftp->IsFile($target_file);
        }
        public static function ListFile($host, $user, $pass, $target_path) {
            $ftp = new FTPConnect($host, $user, $pass);
            return $ftp->GetFile($target_path);
        }
        public static function PSUPassport($username, $password) {
            $username = strtolower(trim($username));
            $client = new SoapClient("https://passport.psu.ac.th/authentication/authentication.asmx?wsdl");
            $resp = $client->Authenticate(array(
                'username'=> $username,
                'password'=> $password
            ));
            if($resp->AuthenticateResult) {
                $resp = $client->GetUserDetails(array(
                    'username'=> $username,
                    'password'=> $password
                ));
                $data = array();
                $arr = explode("@", $resp->GetUserDetailsResult->string[0]);
                $data["username"] = $arr[0];
                $data["name"] = $resp->GetUserDetailsResult->string[1];
                $data["sname"] = $resp->GetUserDetailsResult->string[2];
                $data["id"] = $resp->GetUserDetailsResult->string[3];
                switch($resp->GetUserDetailsResult->string[4]) {
                    case "M" : case "1" : $data["sex"] = "ชาย"; break;
                    case "F" : case "2" : $data["sex"] = "หญิง"; break;
                    default : $data["sex"] = $resp->GetUserDetailsResult->string[4];
                }
                $data["card_id"] = $resp->GetUserDetailsResult->string[5];
                $data["department"] = $resp->GetUserDetailsResult->string[8];
                $data["campus"] = $resp->GetUserDetailsResult->string[10];
                $data["prefix"] = $resp->GetUserDetailsResult->string[12];
                $data["email"] = $resp->GetUserDetailsResult->string[13];
                $arr = explode(",", $resp->GetUserDetailsResult->string[14]);
                $arr = explode("=", $arr[4]);
                $data["type"] = $arr[1];        // Students/Staffs/Alumni
                $data["campus_id"] = $resp->GetUserDetailsResult->string[9]; // C02
                $data["old"] = $resp->GetUserDetailsResult->string;
                return $data;
            } else {
                return null;
            }
        }
        public static function Encrypt($data) {
            $cryption = new KSCryption();
            return $cryption->encrypt($data, "key123*!");
        }
        public static function Decrypt($data) {
            $cryption = new KSCryption();
            return $cryption->decrypt($data, "key123*!");
        }
        public static function CheckFeildEmpty($feild, $message) {
            if( !$feild || $feild=="" || $feild==null ) {
                echo json_encode(array(
                    "status"=>false,
                    "message"=>$message
                ));
                exit();
            }
        }
        public static function GenerateRandom($length = 10) {
            $characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $charactersLength = strlen($characters);
            $randomString = '';
            for ($i = 0; $i < $length; $i++) {
                $randomString .= $characters[rand(0, $charactersLength - 1)];
            }
            return $randomString;
        }
        public static function GetLateDay($StrDate) {
            $now = new DateTime(date("Y-m-d"));
            $date = new DateTime(date_format(date_create($StrDate), "Y-m-d"));
            $late_day = 0;
            while(true) {
                if( $now->format("Y-m-d")==$date->format("Y-m-d") ) break;
                if($late_day==100) return "99+";
                if( $date->format('w')!=0 && $date->format('w')!=6 ) {
                    $late_day++;
                }
                $date->modify("+1 days");
            }
            return $late_day;
        }
        public static function SendSMS($message, $arr_phone) {
            $token = "eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC90aHNtcy5jb21cL21hbmFnZVwvYXBpLWtleSIsImlhdCI6MTY0ODQ1NzIzOCwibmJmIjoxNjkwMjgxNTg1LCJqdGkiOiI4U0pjRkx3TXJZek9tVHIyIiwic3ViIjozMjU1LCJwcnYiOiIyM2JkNWM4OTQ5ZjYwMGFkYjM5ZTcwMWM0MDA4NzJkYjdhNTk3NmY3In0.luoVyoe8v1IP5AejGF_ZAMceLxaZqhOzPfDLtwGqSVg";
            $feild = [
                "sender"=>"SUMMER",
                "msisdn"=>$arr_phone,
                "message"=>$message
            ];
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'https://thsms.com/api/send-sms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 0,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>json_encode($feild),
                CURLOPT_HTTPHEADER => array(
                    'Authorization: Bearer '.$token,
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }
        public static function SetMenuLogin($UserId) {
            global $CHANNEL_ACCESS_TOKEN;
            // U4b41bf8cf53b5044bc245214018ddcf2
            self::Curl(
                'https://api.line.me/v2/bot/user/'.$UserId.'/richmenu/richmenu-40a83181e7f764b856e224169cae13ee',
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                ''
            );
        }
        public static function SetMenuMain($UserId) {
            global $CHANNEL_ACCESS_TOKEN;
            self::Curl(
                'https://api.line.me/v2/bot/user/'.$UserId.'/richmenu/richmenu-3795a29bf8353456b5b3879cdbb6f00c',
                array(
                    "authorization: Bearer ".$CHANNEL_ACCESS_TOKEN,
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                ),
                ''
            );
        }
        public static function FormatPhoneNumber($number) {
            $number = preg_replace('/\D/', '', $number);
            if (strlen($number) === 10) {
                return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $number);
            }
            return $number;
        }
    }