<?php
    /*
	*  	Author	: Srikee Eadtrong
	*  	Company	: Computer Center PSU Pattani
	*  	Date	: 31/10/2568 10.27
	*	Version : 3.0.1
	*  	
	*/
    class Func {
        public static $fullmonth = ["มกราคม","กุมภาพันธ์","มีนาคม","เมษายน","พฤษภาคม","มิถุนายน","กรกฎาคม","สิงหาคม","กันยายน","ตุลาคม","พฤศจิกายน","ธันวาคม"];
        public static $shortmonth = ["ม.ค.","ก.พ.","มี.ค.","เม.ย.","พ.ค.","มิ.ย","ก.ค","ส.ค","ก.ย","ต.ค","พ.ย.","ธ.ค."];
        public static function Dd($data) {
            PrintData($data);
            exit();
        }
        public static function DateTh($date, $time=true) {
            $date = trim($date ?? "");
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
        public static function DateEn($date) {
            $date = trim($date ?? "");
            if( $date=="" ) return "";
            $arr = explode("/", $date);
            if( sizeof($arr)<=2 ) return "";
            return ($arr[2]*1-543)."-".$arr[1]."-".($arr[0]);
        }
        public static function DateThFull($date, $time=true) {
            $date = trim($date ?? "");
            if( $date=="0000-00-00" || $date=="" ) return "";
            $arr1 = explode(" ", $date);
            $arr2 = explode("-", $arr1[0]);
            if( sizeof($arr2)<=2 ) return "";
            $thaimonth = self::$fullmonth;
            $rs = ($arr2[2]*1)." ".$thaimonth[$arr2[1]*1-1]." ".($arr2[0]*1+543);
            if( sizeof($arr1)==2 ) $rs .= " ".substr($arr1[1], 0, 5);
            if( $time==false ) {
                $arr = explode(" ", $rs);
                return $arr[0];
            }
            return $rs;
        }
        public static function DateThFullShort($date) {
            $date = trim($date ?? "");
            if( $date=="0000-00-00" || $date=="" ) return "";
            $arr1 = explode(" ", $date);
            $arr2 = explode("-", $arr1[0]);
            if( sizeof($arr2)<=2 ) return "";
            $thaimonth = self::$shortmonth;
            $yyyy = substr($arr2[0]*1+543, 2, 2);
            $rs = ($arr2[2]*1)." ".$thaimonth[$arr2[1]*1-1]." ".$yyyy;
            return $rs;
        }
        public static function GetMonthName() {
            return array(
                ""=>"",
                "01"=>"มกราคม",
                "02"=>"กุมภาพันธ์",
                "03"=>"มีนาคม",
                "04"=>"เมษายน",
                "05"=>"พฤษภาคม",
                "06"=>"มิถุนายน",
                "07"=>"กรกฎาคม",
                "08"=>"สิงหาคม",
                "09"=>"กันยายน",
                "10"=>"ตุลาคม",
                "11"=>"พฤศจิกายน",
                "12"=>"ธันวาคม"
            );
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
            $date = trim($num ?? "");
            if( $num=="" ) $num = "0";
            $num = str_replace(" %", "", $num);
            return number_format( str_replace(",","",$num)*1, 2, '.', '');
        }
        public static function ShowAlert($title="แจ้งข้อความ", $html="ระบุข้อความ", $type="question", $href="", $back=false) {
            if( $back==false ) {
                echo '
                    <script>
                        Func.ShowAlert({
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
            } else {
                echo '
                    <script>
                        ShowAlert({
                            title: "'.$title.'",
                            html: "'.$html.'",
                            type: "'.$type.'",
                            callback: function() {
                                window.history.back();
                            }
                        });
                    </script>
                ';
            }
        }
        public static function AcceptImplode($type) {
            foreach ($type as $key => $value) {
                $type[$key] = ".".$type[$key];
            }
            return implode(", ", $type);
        }
        public static function GetTypeBase64($base64) {
            // support : jpg, jpeg, png, gif, pdf, doc, docx
            $arr1 = explode(";base64", $base64);
            $arr2 = explode("/", $arr1[0]);
            $type = $arr2[ sizeof($arr2)-1 ];
            if( $type=="vnd.openxmlformats-officedocument.wordprocessingml.document" ) return "docx";
            if( $type=="msword" ) return "doc";
            return $type;
        }
        public static function UploadBase64($options) {
            /*
                Example.
                $options = array(
                    "base64"        => "data:image/png;base64,AAAFBfj42Pj4",   // base64 string
                    "dir"           => "/path/on/sftp/server/",              // path on sftp server
                    "rename"        => "newfilename",                        // new filename without extension (optional)
                    "allowType"     => ["jpg","jpeg","png","gif","pdf"],     // allow file type
                );
                $uploader = Func::UploadBase64($options);
                if( $uploader["status"]=="ok" ) {
                    echo "Upload Success. File name : ".$uploader["fileName"];
                } else {
                    echo "Error : ".$uploader["message"];
                }
            */
            $base64 = $options["base64"] ?? "";
            $dir = $options["dir"] ?? "";
            $rename = $options["rename"] ?? time();
            $allowType = $options["allowType"] ?? [];
            $type = self::GetTypeBase64($base64);  // support : jpg, jpeg, png, gif, pdf, doc, docx
            if( !in_array($type, $allowType) ) return array( "status"=>"no", "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            $rename = ( $rename=="" ) ? time() : $rename;
            $filename = $rename.".".$type;
            $rs = file_put_contents($dir.$filename, base64_decode(explode(',',$base64)[1]));
            if($rs) return array( "status"=>"ok", "fileName"=>$filename );
            return array( "status"=>"no", "fileName"=>"", "message"=>"อัพโหลดไม่สำเร็จ" );
        }
        public static function IsFile($options) {
            /*
                Example.
                $options = array(
                    "dir"       => "/path/on/sftp/server/",
                    "fileName"  => "fileName.ext",
                );
                $is = Func::IsFile($options);
                if( $is ) {
                    echo "Have file.";
                } else {
                    echo "No file.";
                }
            */
            $dir = $options["dir"] ?? "";
            $fileName = $options["fileName"] ?? "";
            if( $fileName!="" && file_exists($dir.$fileName)) {
                return true;
            }
            return false;
        }
        public static function IsDir($options) {
            /*
                Example.
                $options = array(
                    "dir"   => "/path/on/sftp/server/dir",
                    
                );
                $is = Func::IsDir($options);
                if( $is ) {
                    echo "Have Dir";
                } else {
                    echo "No Dir";
                }
            */
            $dir = $options["dir"] ?? "";
            return is_dir($dir);
        }
        public static function RemoveFile($options) {
            /*
                Example.
                $options = array(
                    "dir"       => "/path/on/sftp/server/",
                    "fileName"  => "fileName.ext",
                );
                $removed = Func::RemoveFile($options);
                if( $removed ) {
                    echo "File removed.";
                } else {
                    echo "File not found.";
                }
            */
            $dir = $options["dir"] ?? "";
            $fileName = $options["fileName"] ?? "";
            if( $fileName=="" ) return false;
            if( self::IsFile($options) ) {
                return unlink($dir.$fileName);
            }
            return false;
        }
        public static function ListFile($options) {
            /*
                Example.
                $options = array(
                    "dir"       => "/path/on/sftp/server/"
                );
                $files = Func::ListFile($options);
                foreach($files as $file) {
                    echo $file;
                }
            */
            $files = [];
            $dir = $options["dir"] ?? "";
            if (is_dir($dir)) {
                if ($dh = opendir($dir)) {
                    while (($file = readdir($dh)) !== false) {
                        if($file=="." || $file=="..") continue;
                        $files[] = $file;
                    }
                    closedir($dh);
                }
            }
            return $files;
        }
        public static function MakeDir($options) {
            /*
                Example.
                $options = array(
                    "dir"       => "/path/on/sftp/server/"
                );
                Func::MakeDir($options);
            */
            $dir = $options["dir"] ?? "";
            if ( !is_dir( $dir ) ) {
                mkdir($dir, 0777);
            }
        }
        public static function RemoveDir($options) {
            /*
                Example.
                $options = array(
                    "dir"       => "/path/on/sftp/server/"
                );
                Func::RemoveDir($options);
            */
            // $dir = rtrim($options["dir"] ?? "", "/");
            $dir = $options["dir"] ?? "";
            if ($dir == "" || !is_dir($dir)) return false;
            $files = array_diff(scandir($dir), array('.', '..'));
            foreach ($files as $file) {
                $path = "$dir/$file";
                if (is_dir($path)) {
                    self::RemoveDir(array("dir" => $path));
                } else {
                    unlink($path);
                }
            }
            return rmdir($dir);
        }
        public static function MoveFiles($options) {
            /*
                Example.
                $options = array( 
                    "dir1" => "/files/images/a/",
                    "dir2" => "/files/images/b/" 
                );
                Func::MoveFiles($options);
            */
            $dir1 = rtrim($options['dir1'], '/').'/';
            $dir2 = rtrim($options['dir2'], '/').'/';
            if (!is_dir($dir1)) return false;
            if (!is_dir($dir2)) mkdir($dir2, 0777, true);
            $files = scandir($dir1);
            foreach ($files as $file) {
                if ($file === '.' || $file === '..') continue;
                $source = $dir1 . $file;
                $destination = $dir2 . $file;
                if (is_file($source)) rename($source, $destination);
            }
            return true;
        }
        public static function SftpUploadBase64($options) {
            /*
                Example.
                $options = array(
                    "base64"        => "data:image/png;base64,AAAFBfj42Pj4",   // base64 string
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "dir"           => "/path/on/sftp/server/",              // path on sftp server
                    "rename"        => "newfilename",                        // new filename without extension (optional)
                    "allowType"     => ["jpg","jpeg","png","gif","pdf"],     // allow file type
                );
                $uploader = Func::SftpUploadBase64($options);
                if( $uploader["status"]=="ok" ) {
                    echo "Upload Success. File name : ".$uploader["fileName"];
                } else {
                    echo "Error : ".$uploader["message"];
                }
            */
            $base64 = $options["base64"] ?? "";
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? "";
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $dir = $options["dir"] ?? "";
            $rename = $options["rename"] ?? time();
            $allowType = $options["allowType"] ?? [];
            $type = self::GetTypeBase64($base64);  // support : jpg, jpeg, png, gif, pdf, doc, docx
            if( sizeof($allowType)>0 && !in_array($type, $allowType) ) return array( "status"=>"no", "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            $fileName = $rename.".".$type;
            $base64_data = base64_decode(explode(',',$base64)[1]);
            $connection = ssh2_connect($host, $port);
            if (!$connection) { return array( "status"=>"no", "fileName"=>"", "message"=>"SFTP connection failed." ); }
            if (!ssh2_auth_password($connection, $user, $pass)) { return array( "status"=>"no", "fileName"=>"", "message"=>"SFTP authentication failed." ); }
            $sftp = ssh2_sftp($connection);
            if (!$sftp) { return array( "status"=>"no", "fileName"=>"", "message"=>"SFTP subsystem initialization failed." ); }
            $sftp_fd = intval($sftp);
            $remote_file_path = $dir.$fileName;
            $stream = fopen("ssh2.sftp://$sftp_fd$remote_file_path", 'w');
            if (!$stream) { return array( "status"=>"no", "fileName"=>"", "message"=>"Could not open remote file for writing." ); }
            if (fwrite($stream, $base64_data) === FALSE) { return array( "status"=>"no", "fileName"=>"", "message"=>"Could not write data to remote file." ); }
            fclose($stream);
            return array( "status"=>"ok", "fileName"=>$fileName, "message"=>"Upload success." );
        }
        public static function SftpUploadFile($options) {
            /*
                Example.
                $options = array(
                    "elementName"   => "file",
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "dir"           => "/path/on/sftp/server/",              // path on sftp server
                    "rename"        => "newfilename",                        // new filename without extension (optional)
                    "allowType"     => ["jpg","jpeg","png","gif","pdf"],     // allow file type
                );
                $uploader = Func::SftpUploadBase64($options);
                if( $uploader["status"]=="ok" ) {
                    echo "Upload Success. File name : ".$uploader["fileName"];
                } else {
                    echo "Error : ".$uploader["message"];
                }
            */
            $elementName = $options["elementName"] ?? "";
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 22;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $dir = $options["dir"] ?? "";
            $rename = $options["rename"] ?? time();
            $allowType = $options["allowType"] ?? [];
            if( !isset($_FILES[$elementName]) || $_FILES[$elementName]["size"]==0 ) { return array( "status"=>false, "fileName"=>"", "message"=>"ไม่พบไฟล์" ); }
            $tmpName = $_FILES[$elementName]['tmp_name'];
            $name = $_FILES[$elementName]['name'];
            $size = $_FILES[$elementName]['size'];
            $type = strtolower(pathinfo($name, PATHINFO_EXTENSION));
            if( sizeof($allowType)>0 && !in_array($type, $allowType) ) return array( "status"=>"no", "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            $fileName = $rename.".".$type;
            $connection = ssh2_connect($host, $port);
            if (!$connection) { return array( "status"=>"no", "fileName"=>"", "message"=>"SFTP connection failed." ); }
            if (!ssh2_auth_password($connection, $user, $pass)) { return array( "status"=>"no", "fileName"=>"", "message"=>"SFTP authentication failed." ); }
            $sftp = ssh2_sftp($connection);
            if (!$sftp) { return array( "status"=>"no", "fileName"=>"", "message"=>"SFTP subsystem initialization failed." ); }
            $sftp_fd = intval($sftp);
            $remote_file_path = $dir.$fileName;
            $remoteStream  = fopen("ssh2.sftp://$sftp_fd$remote_file_path", 'w');
            if (!$remoteStream ) { return array( "status"=>"no", "fileName"=>"", "message"=>"Could not open remote file for writing." ); }
            $localStream = fopen($tmpName, 'r');
            if (!$localStream) { return array( "status"=>"no", "fileName"=>"", "message"=>"Could not open local file." ); }
            $writtenBytes = stream_copy_to_stream($localStream, $remoteStream);
            fclose($localStream);
            fclose($remoteStream);
            if ($writtenBytes === false) {
                return array( "status"=>"no", "fileName"=>"", "message"=>"Upload failed!" );
            } else {
                return array( "status"=>"ok", "fileName"=>$fileName, "message"=>"Upload success." );
            }
        }
        public static function SftpFileExists($options) {
            /*
                Example.
                $options = array(
                    "host"      => "sftp server name",
                    "port"      => "sftp port",
                    "user"      => "Your username",
                    "pass"      => "Your password",
                    "dir"       => "/path/on/sftp/server/",
                    "fileName"  => "fileName.ext",
                );
                $exists = Func::SftpFileExists($options);
                if( $exists ) {
                    echo "File exists.";
                } else {
                    echo "File does not exist.";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? "";
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $dir = $options["dir"] ?? "";
            $fileName = $options["fileName"] ?? "";
            if( $fileName=="" ) return false;
            $connection = ssh2_connect($host, $port);
            if (!$connection) return false;
            if (!ssh2_auth_password($connection, $user, $pass)) return false;
            $sftp = ssh2_sftp($connection);
            if (!$sftp) return false;
            $stat = @ssh2_sftp_stat($sftp, $dir.$fileName);
            return $stat !== false;
        }
        public static function SftpRemoveFile($options) {
            /*
                Example.
                $options = array(
                    "host"      => "sftp server name",
                    "port"      => "sftp port",
                    "user"      => "Your username",
                    "pass"      => "Your password",
                    "dir"       => "/path/on/sftp/server/",
                    "fileName"  => "fileName.ext",
                );
                $removed = Func::SftpRemoveFile($options);
                if( $removed ) {
                    echo "File removed.";
                } else {
                    echo "File not found.";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? "";
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $dir = $options["dir"] ?? "";
            $fileName = $options["fileName"] ?? "";
            if( $fileName=="" ) return false;
            if( !self::SftpFileExists($options) ) return false;
            $connection = ssh2_connect($host, $port);
            if (!$connection) return false;
            if (!ssh2_auth_password($connection, $user, $pass)) return false;
            $sftp = ssh2_sftp($connection);
            if (!$sftp) return false;
            return ssh2_sftp_unlink($sftp, $dir.$fileName);
        }
        public static function FtpUploadBase64($options) {
            /*
                Example.
                $options = array(
                    "base64"        => "data:image/png;base64,AAAFBfj42Pj4",   // base64 string
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "dir"           => "/path/on/sftp/server/",              // path on sftp server
                    "rename"        => "newfilename",                        // new filename without extension (optional)
                    "allowType"     => ["jpg","jpeg","png","gif","pdf"],     // allow file type
                );
                $uploader = Func::FtpUploadBase64($options);
                if( $uploader["status"]=="ok" ) {
                    echo "Upload Success. File name : ".$uploader["fileName"];
                } else {
                    echo "Error : ".$uploader["message"];
                }
            */
            $base64 = $options["base64"] ?? "";
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $dir = $options["dir"] ?? "";
            $rename = $options["rename"] ?? time();
            $allowType = $options["allowType"] ?? [];
            $type = self::GetTypeBase64($base64);  // support : jpg, jpeg, png, gif, pdf, doc, docx
            if( !in_array($type, $allowType) ) return array( "status"=>"no", "fileName"=>"", "message"=>"รูปแบบไฟล์ไม่รองรับ" );
            $fileName = $rename.".".$type;
            file_put_contents("/tmp/".$fileName, base64_decode(explode(',',$base64)[1]));
            $ftp = new FTPConnect($host, $port, $user, $pass);
            $rs = $ftp->UploadFile("/tmp/".$fileName, $dir.$fileName);
            if($rs) return array( "status"=>"ok", "fileName"=>$fileName );
            return array( "status"=>"no", "fileName"=>"", "message"=>"ไม่พบไฟล์" );
        }
        public static function FtpUploadRenameFile($options) {
            /*
                Example.
                $options = array(
                    "elementName"   => "file",
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "dir"           => "/path/on/sftp/server/",              // path on sftp server
                    "rename"        => "newfilename",                        // new filename without extension (optional)
                    "allowType"     => ["jpg","jpeg","png","gif","pdf"],     // allow file type
                    "index"         => null
                );
                $uploader = Func::FtpUploadRenameFile($options);
                if( $uploader["status"]=="ok" ) {
                    echo "Upload Success. File name : ".$uploader["fileName"];
                } else {
                    echo "Error : ".$uploader["message"];
                }
            */
            $elementName = $options["elementName"] ?? "";
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $dir = $options["dir"] ?? "";
            $rename = $options["rename"] ?? time();
            $allowType = $options["allowType"] ?? [];
            $index = $options["index"] ?? null;
            if( isset($_FILES[$elementName]) && $_FILES[$elementName]["size"]>0 ) {
                $ftp = new FTPConnect($host, $port, $user, $pass);
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
        public static function FtpMoveUploadFile($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "file"          => "/path/on/sftp/server/old.png",
                    "target_file"   => "/path/on/sftp/server/new.png",
                    
                );
                $uploader = Func::FtpMoveUploadFile($options);
                if( $uploader ) {
                    echo "Move Success.";
                } else {
                    echo "Error : Move Fail.";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $file = $options["file"] ?? "";
            $target_file = $options["target_file"] ?? "";
            $ftp = new FTPConnect($host, $port, $user, $pass);
            return $ftp->MoveUploadFile($file, $target_file);
        }
        public static function FtpMakeDir($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "target_path"   => "/path/on/sftp/server/part",
                    
                );
                $uploader = Func::FtpMakeDir($options);
                if( $uploader ) {
                    echo "Make Dir Success.";
                } else {
                    echo "Error : Make Dir Fail.";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $target_path = $options["target_path"] ?? "";
            $ftp = new FTPConnect($host, $port, $user, $pass);
            $ftp->MkDir($target_path);
        }
        public static function FtpIsDir($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "target_path"   => "/path/on/sftp/server/part",
                    
                );
                $is = Func::FtpIsDir($options);
                if( $is ) {
                    echo "Have Dir";
                } else {
                    echo "No Dir";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $target_path = $options["target_path"] ?? "";
            $ftp = new FTPConnect($host, $user, $pass);
            return $ftp->IsDir($target_path);
        }
        public static function FtpIsFile($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "target_file"   => "/path/on/sftp/server/file.png",
                    
                );
                $uploader = Func::FtpIsFile($options);
                if( $uploader ) {
                    echo "Have File";
                } else {
                    echo "No File";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $target_file = $options["target_file"] ?? "";
            $ftp = new FTPConnect($host, $port, $user, $pass);
            return $ftp->IsFile($target_file);
        }
        public static function FtpListFile($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "target_path"   => "/path/on/sftp/server/part",
                    
                );
                $files = Func::FtpListFile($options);
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $target_path = $options["target_path"] ?? "";
            $ftp = new FTPConnect($host, $port, $user, $pass);
            return $ftp->GetFile($target_path);
        }
        public static function FtpRemoveDir($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "target_path"   => "/path/on/sftp/server/part",
                    
                );
                $uploader = Func::FtpRemoveDir($options);
                if( $uploader ) {
                    echo "Move Success.";
                } else {
                    echo "Error : Move Fail.";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $target_path = $options["target_path"] ?? "";
            if( self::FtpIsDir($options) ) {
                $ftp = new FTPConnect($host, $port, $user, $pass);
                return $ftp->RmDir($target_path);
            }
            return false;
        }
        public static function FtpRemoveFile($options) {
            /*
                Example.
                $options = array(
                    "host"          => "sftp server name",
                    "port"          => "sftp port",
                    "user"          => "Your username",
                    "pass"          => "Your password",
                    "target_file"   => "/path/on/sftp/server/file.png",
                    
                );
                $uploader = Func::FtpRemoveFile($options);
                if( $uploader ) {
                    echo "Remove Success.";
                } else {
                    echo "Remove Fail.";
                }
            */
            $host = $options["host"] ?? "";
            $port = $options["port"] ?? 21;
            $user = $options["user"] ?? "";
            $pass = $options["pass"] ?? "";
            $target_file = $options["target_file"] ?? "";
            if( self::FtpIsFile($host, $user, $pass, $target_file) ) {
                $ftp = new FTPConnect($host, $port, $user, $pass);
                return $ftp->Unlink($target_file);
            }
            return false;
        }
        public static function PrintData($data) {
            echo "<pre>";
            print_r($data);
            echo "</pre>";
        }
        public static function Back() {
            echo '
                <script>
                    window.history.back();
                </script>
            ';
            exit();
        }
        public static function LinkTo($url) {
            echo '
                <script>
                    location.href = "'.$url.'";
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
        public static function BreakLine($text) {
            // $segment = new Segment();
            // $text = $segment->get_segment_array( $text );
            // $text = implode("\u{0020}", $text);
            $text = trim($text);
            if( $text=="" ) return "-";
            return $text;
        }
        public static function SendMail($options) {
            /*  
                Example.
                $options = array(
                    "host"                  => "smtp server name",
                    "port"                  => "smtp port",
                    "secure"                => "smtp secure",
                    "username"              => "Your username",
                    "password"              => "Your password",
                    "sender_email"          => "Sender email",
                    "sender_name"           => "Sender name",
                    "receiver_email"        => "Receive email",
                    "message_title"         => "Your title",
                    "message_body"          => "Your body"
                );
                $sender = SendMail($options);
                if( $sender["status"] ) {
                    echo "Send Success.";
                } else {
                    echo "Error : ".$sender["message"];
                }
            */
            date_default_timezone_set('Asia/Bangkok');
            $mail = new PHPMailer();
            $mail->CharSet = "utf-8";
            $mail->isSMTP();
            $mail->SMTPDebug = 0;
            $mail->Debugoutput = 'html';
            $mail->Host = $options["host"];
            $mail->Port = $options["port"];
            $mail->SMTPSecure = @$options["secure"];
            $mail->SMTPAuth = @$options["auth"];;
            $mail->Username = @$options["username"];
            $mail->Password = @$options["password"];
            $mail->setFrom($options["sender_email"], $options["sender_name"]);
            if( gettype($options["receiver_email"])=="array" ) {
                foreach($options["receiver_email"] as $email) {
                    $mail->addAddress($email);
                }
            } else {
                $mail->addAddress($options["receiver_email"]);
            }
            $mail->Subject = $options["message_title"];
            $mail->msgHTML($options["message_body"]);
            if ($mail->send()) {
                return array("status"=>true);
            } else {
                return array("status"=>false, "message"=>$mail->ErrorInfo);
            }
        }
        public static function PSUPassportWithSoap($username, $password, $timeout = 5000) {
            ini_set("default_socket_timeout", $timeout / 1000);
            try {
                $client = new SoapClient("https://passport.psu.ac.th/authentication/authentication.asmx?wsdl");
                $resp = $client->Authenticate(array(
                    'username' => $username,
                    'password' => $password
                ));
                if ($resp->AuthenticateResult) {
                    $resp = $client->GetUserDetails(array(
                        'username' => $username,
                        'password' => $password
                    ));
                    $data = array();
                    $arr = explode("@", $resp->GetUserDetailsResult->string[0]);
                    $data["username"] = $arr[0];
                    $data["name"] = $resp->GetUserDetailsResult->string[1];
                    $data["sname"] = $resp->GetUserDetailsResult->string[2];
                    $data["id"] = $resp->GetUserDetailsResult->string[3];
                    switch ($resp->GetUserDetailsResult->string[4]) {
                        case "M":
                        case "1":
                            $data["sex"] = "ชาย";
                            break;
                        case "F":
                        case "2":
                            $data["sex"] = "หญิง";
                            break;
                        default:
                            $data["sex"] = $resp->GetUserDetailsResult->string[4];
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
            } catch (Exception $e) {
                return null;
            }
        }
        public static function GetDateRange($start, $end) {
            $start = new DateTime($start);
            $end   = new DateTime($end);
            $end = $end->modify('+1 day');
            $interval = new DateInterval('P1D'); // เพิ่มวันละ 1
            $period   = new DatePeriod($start, $interval, $end);
            $dates = [];
            foreach ($period as $date) {
                $dayOfWeek = $date->format("w"); // 0=อาทิตย์, 6=เสาร์
                if ($dayOfWeek != 0 && $dayOfWeek != 6) {
                    $d = $date->format("Y-m-d");
                    $dates[$d] = $d;
                }
            }
            return $dates;
        }
        public static function FormatPhoneNumber($number) {
            $number = trim($number ?? '');
            $number = preg_replace('/\D/', '', $number);
            if (strlen($number) === 10) {
                return preg_replace('/(\d{3})(\d{3})(\d{4})/', '$1-$2-$3', $number);
            }
            return $number;
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
        public static function LineOASendMessage($options) {
            /*
                $rs = Func::LineOASendMessage([
                    "token"=>"CHANNEL_ACCESS_TOKEN",
                    "users"=>["userId", "userId", "userId", ...],
                    "message"=>"Message",
                ]);
            */
            $options["token"] = $options["token"] ?? "";
            $options["users"] = $options["users"] ?? [];
            $options["message"] = $options["message"] ?? "";
            if( $options["token"]=="" ) return false;
            if( sizeof($options["users"])==0 ) return false;
            if( $options["message"]=="" ) return false;
            $url = "https://api.line.me/v2/bot/message/multicast";
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => "POST",
                CURLOPT_POSTFIELDS => json_encode([
                    "to"=>$options["users"],
                    "messages"=>[
                        [
                            "type"=>"text",
                            "text"=>$options["message"]
                        ]
                    ]
                ]),
                CURLOPT_HTTPHEADER => array(
                    "authorization: Bearer ".$options["token"],
                    "cache-control: no-cache",
                    "content-type: application/json; charset=UTF-8"
                )
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
        }
        public static function Curl($Url, $headers, $feilds, $method="POST") {
            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => $Url,
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => "",
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 3,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => $method,
                CURLOPT_POSTFIELDS => $feilds,
                CURLOPT_HTTPHEADER => $headers
            ));
            $response = curl_exec($curl);
            curl_close($curl);
            return $response;
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
    }
    