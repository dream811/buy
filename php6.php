<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

//require './vendor/src/Exception.php';
//require './vendor/src/PHPMailer.php';
//require './vendor/src/SMTP.php';

require './vendor/autoload.php';

try {
	$mail = new PHPMailer(true);                              // Passing `true` enables exceptions
    //서버설정
    $mail->CharSet ="UTF-8";                     //언어셋설정                     
    //$mail->isSMTP();                             // SMTP사용 (이것을 주석을 풀면 메일이 안갑니다. 원인은 알수가 없습니다.)
    $mail->Host = 'smtp.naver.com';                // SMTP 중계서버 주소
    $mail->SMTPAuth = true;                      //  SMTP 인증사용
    $mail->Username = 'kml5395@naver.com';                // SMTP 메일사용자
    $mail->Password = 'khy0615';             		// SMTP 메일비번
    $mail->SMTPSecure = 'ssl';                    // ssl 사용
    $mail->Port = 587;                            // smtp 포트

    $mail->setFrom('kml5395@naver.com', '토우달인');  //발신자 메일주소 및 발신자 이름
    $mail->addAddress('kml5395@naver.com', '고객님');  // 수신자 메일주소 

    //$mail->addReplyTo('kml5395@naver.com', 'info'); //메일이 되돌아올 경우 받을 메일주소
    //$mail->addCC('cc@example.com');                    //모름
    //$mail->addBCC('bcc@example.com');                    //모름

    //发送附件
    // $mail->addAttachment('../xy.zip');         // 파일첨부
    // $mail->addAttachment('../thumb-1.jpg', 'new.jpg');    // 파일첨부 및 이름변경

    //Content
    $mail->isHTML(true);                                  // html 격식 허용
    $mail->Subject = ('토오달인 고객 안내메일');
	//$mail->AddEmbeddedImage("images/bg.png", "my-attach", "images/bg-2.png"); //이미지 첨부
	$mail->AddEmbeddedImage("images/bg.png", "bg");
	//$str = file_get_contents("test.html");
	$mail->Body = "
	<html>
<head>
<title>토우달인</title>
</head>
<body>                
<div style='width:800px;background:#fff;border-width:8px; border-color:#d5deed; border-style:dotted;'>
<div style='width:50%;text-align:left;'><a href='http://taodalin.com'> <img 
src=\"cid:bg\" height=100 width=800;'></a></div>
<div style='width:100%;height:300px; size='0' color='#d5deed' text-align:right;padding-left:390px;'>
<br/></br>
<div style='width:100%;height:5%;font-weight:bold;color:red;margin:0 auto;text-align:center;'><h1>고객님의 인증코드 입니다 !!</h1></div><br/><br/>
<div style='width:100%;height:7%;font-weight:bold;color:blue;margin:0 auto;text-align:center;'><h1>CODE : 1111111</h1></div>
</div>

</div>
</div>             
</body>
</html>";
   // $mail->Body    = ('<h1>토우달인 비밀번호 찾기<br><br>CODE : 111111</h1>');
    $mail->AltBody = '클라이언트에서 html지원하지 않을 경우 표시';
	$mail->SMTPDebug = 4;

    $mail->send();
    echo '1';
} catch (Exception $e) {
    echo '0: ', $mail->ErrorInfo;
}
?>