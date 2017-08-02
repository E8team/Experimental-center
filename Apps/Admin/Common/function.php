<?php

function checkUrl($content)
{

    //包含url链接
    $pattern1 = '#[-a-zA-Z0-9@:%_\+.~\#?&//=]{2,256}\.[a-z]{2,4}\b(\/[-a-zA-Z0-9@:%_\+.~\#?&//=]*)?#si';
    //包含ip地址
    $pattern2 = '/((1?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(1?\d{1,2}|2[0-4]\d|25[0-5])/';
    if(preg_match($pattern1, $content) || preg_match($pattern2, $content))
    {
        return -3;
    }
    return 0;
}
/**
 * 系统邮件发送函数
 * @param string $to    接收邮件者邮箱
 * @param string $name  接收邮件者名称
 * @param string $subject 邮件主题
 * @param string $body    邮件内容
 * @param string $attachment 附件列表
 * @return boolean
 */
function think_send_mail($to, $name, $subject = '', $body = '', $attachment = null){
	$config = C('THINK_EMAIL');
	vendor('PHPMailer.class#phpmailer'); //从PHPMailer目录导class.phpmailer.php类文件
	$mail             = new \Vendor\PHPMailer(); //PHPMailer对象
	$mail->CharSet    = 'UTF-8'; //设定邮件编码，默认ISO-8859-1，如果发中文此项必须设置，否则乱码
	$mail->IsSMTP();  // 设定使用SMTP服务
	$mail->SMTPDebug  = 0;                     // 关闭SMTP调试功能
	// 1 = errors and messages
	// 2 = messages only
	$mail->SMTPAuth   = true;                  // 启用 SMTP 验证功能
	             
	$mail->Host       = $config['SMTP_HOST'];  // SMTP 服务器
	$mail->Port       = $config['SMTP_PORT'];  // SMTP服务器的端口号
	if($config['SMTP_PORT'] != 25){
		$mail->SMTPSecure = 'ssl';  			// 使用安全协议
	}
	$mail->Username   = $config['SMTP_USER'];  // SMTP服务器用户名
	$mail->Password   = $config['SMTP_PASS'];  // SMTP服务器密码
	$mail->SetFrom($config['FROM_EMAIL'], $config['FROM_NAME']);
	$replyEmail       = $config['REPLY_EMAIL']?$config['REPLY_EMAIL']:$config['FROM_EMAIL'];
	$replyName        = $config['REPLY_NAME']?$config['REPLY_NAME']:$config['FROM_NAME'];
	$mail->AddReplyTo($replyEmail, $replyName);
	$mail->Subject    = $subject;
	$mail->MsgHTML($body);
	$mail->AddAddress($to, $name);
	if(is_array($attachment)){ // 添加附件
		foreach ($attachment as $file){
			is_file($file) && $mail->AddAttachment($file);
		}
	}
	return $mail->Send() ? true : $mail->ErrorInfo;
}

/**
 * 修改记录
 * Verision: 1.0
 * Time: 2014/7/9
 * Form: Function Name + Editor + Time
 */

/**
 * 根据时间参数，计算距离现在过了多长时间
 *
 * @param Integer $time
 *        	时间戳
 * @return String $timeStr 距离现在多长时间的字符串
 * @author webdd
 */
function timeToNow($time) {
	$now = time ();
	$old = $time;
	$date = floor ( ($now - $old) / 86400 );
	$hour = floor ( ($now - $old) % 86400 / 3600 );
	$minute = floor ( ($now - $old) % 86400 % 3600 / 60 );
	$second = floor ( ($now - $old) % 86400 % 60 );
	// echo "天" . $date . "时" . $hour . "分" . $minute . '秒' . $second . '<br />';
	// $timeArr = array('day'=>$date,'hour'=>$hour,'minute'=>$minute,'second'=>$second);
	if ($date != 0) {
		return $date . '天以前';
	} else if ($hour != 0) {
		return $hour . '小时以前';
	} else if ($minute != 0) {
		return $minute . '分钟以前';
	} else {
		return $second . '秒以前';
	}
}

/**
 * 格式化打印函数，用于格式化打印数组信息
 * 程序员调试使用
 *
 * @param unknown $con        	
 * @author webdd
 */
function dd($con) {
	echo "<pre>";
	print_r ( $con );
	die ();
}

/**
 * 验证格式
 * 
 * @param 验证对象 $v        	
 * @param 验证类型 $type        	
 * @return boolean
 */
function checkFormat($v, $type) {
	if (empty ( $v )) {
		return false;
	}
	switch ($type) {
		case 'natural_number' :
			return ereg ( '^[1-9]\d*$', $v );
	}
}


/**
 * 对字符串进行加密
 * 
 * @param string $str
 *        	需要加密的内容
 * @param string $key
 *        	秘钥
 */
function passport_encrypt($str, $key = "e8network") { // 加密函数
	srand ( ( double ) microtime () * 1000000 );
	$encrypt_key = md5 ( rand ( 0, 32000 ) );
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen ( $str ); $i ++) {
		$ctr = $ctr == strlen ( $encrypt_key ) ? 0 : $ctr;
		$tmp .= $encrypt_key [$ctr] . ($str [$i] ^ $encrypt_key [$ctr ++]);
	}
	return base64_encode ( passport_key ( $tmp, $key ) );
}

/**
 * 对加密的字符串进行解密
 *
 * @param string $str
 *        	需要解密的密文
 * @param string $key
 *        	迷药
 */
function passport_decrypt($str, $key = "e8network") { // 解密函数
	$str = passport_key ( base64_decode ( $str ), $key );
	$tmp = '';
	for($i = 0; $i < strlen ( $str ); $i ++) {
		$md5 = $str [$i];
		$tmp .= $str [++ $i] ^ $md5;
	}
	return $tmp;
}

/**
 * 加密辅助函数
 */
function passport_key($str, $encrypt_key) {
	$encrypt_key = md5 ( $encrypt_key );
	$ctr = 0;
	$tmp = '';
	for($i = 0; $i < strlen ( $str ); $i ++) {
		$ctr = $ctr == strlen ( $encrypt_key ) ? 0 : $ctr;
		$tmp .= $str [$i] ^ $encrypt_key [$ctr ++];
	}
	return $tmp;
}
/**
 * 用于生成excel文件的函数
* author:walker
* @param $data 生成excel的数据(二维数组形式)
* @param null $savefile 生成excel的文件名(保不指定,则为当前时间戳)
* @param null $title 生成excel的表头(一维数组形式)
* @param string $sheetname 生成excel的sheet名称(缺省为sheet1)
*/
function exportExcel($data,$savefile=null,$title=null,$sheetname='sheet1'){
//若没有指定文件名则为当前时间戳
if(is_null($savefile)){
$savefile=time();
}
//若指字了excel表头，则把表单追加到正文内容前面去
if(is_array($title)){
	array_unshift($data,$title);
}
Vendor('PHPExcel.PHPExcel');
Vendor('PHPExcel.PHPExcel.IOFactory');
	Vendor('PHPExcel.PHPExcel.Reader.Excel5');
	$objPHPExcel = new PHPExcel();
         //Excel内容
	foreach($data as $k => $v){
			$obj=$objPHPExcel->setActiveSheetIndex(0);
             $row=$k+1;//行
			$nn=0;			
		foreach($v as $kk => $vv){
			if($kk == "card_num" and $kk !== 0){
				$i=0;
				while($i <= strlen($vv)){
					$value = $value.substr($vv, $i, 3).' ';//三位三位取出再合并，按逗号隔开
					$i = $i + 3;
					
				}
				$col=chr(65+$nn);//列
				$obj->setCellValue($col.$row,$value);//列,行,值
				$value="";
			}else{
				$col=chr(65+$nn);//列
				$obj->setCellValue($col.$row,$vv);//列,行,值
			}
			$nn++;
		}
	}
	//die('1');
	$objPHPExcel->getActiveSheet()->setTitle($sheetname);
	$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$savefile.'.xls"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;
}
?>