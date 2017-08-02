<?php
/**
 * 根据时间参数，计算距离现在过了多长时间
 *
 * @param Integer $time
 *        	时间戳
 * @return String $timeStr 距离现在多长时间的字符串
 * @author webdd
 */
function time_tran($the_time) {
    $now_time = date("Y-m-d H:i:s", time());
    //echo $now_time;
    $now_time = strtotime($now_time);
    $show_time = strtotime($the_time);
    $dur = $now_time - $show_time;
    //p(date('Y-m-d', $dur));die;
    if ($dur < 0) {
        return $the_time;
    } else {
        if ($dur < 60) {
            return $dur . '秒前';
        } else {
            if ($dur < 3600) {
                return floor($dur / 60) . '分钟前';
            } else {
                if ($dur < 86400) {
                    return floor($dur / 3600) . '小时前';
                } else {
                    if ($dur < 259200) {//3天内
                        return floor($dur / 86400) . '天前';
                    } else {
                        //这里把时间戳转成标准时间
                        return date('Y-m-d', $the_time);
                    }
                }
            }
        }
    }
}
/*function timeToNow($time) {
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
}*/

/**
 * 格式化打印函数，用于格式化打印数组信息
 * 程序员调试使用
 *
 * @param unknown $con
 * @author webdd
 */
function dd($con) {
	echo "<pre>";
	var_dump ( $con );
	echo "</pre>";
	die ();
}



//字符串截取函数
function subtitle($string, $sublen, $start = 0, $code = 'UTF-8') 
{ 
    if($code == 'UTF-8') 
    { 
        $pa = "/[\x01-\x7f]|[\xc2-\xdf][\x80-\xbf]|\xe0[\xa0-\xbf][\x80-\xbf]|[\xe1-\xef][\x80-\xbf][\x80-\xbf]|\xf0[\x90-\xbf][\x80-\xbf][\x80-\xbf]|[\xf1-\xf7][\x80-\xbf][\x80-\xbf][\x80-\xbf]/"; 
        preg_match_all($pa, $string, $t_string); 

        if(count($t_string[0]) - $start > $sublen) return join('', array_slice($t_string[0], $start, $sublen))."..."; 
        return join('', array_slice($t_string[0], $start, $sublen)); 
    } 
    else 
    { 
        $start = $start*2; 
        $sublen = $sublen*2; 
        $strlen = strlen($string); 
        $tmpstr = ''; 

        for($i=0; $i< $strlen; $i++) 
        { 
            if($i>=$start && $i< ($start+$sublen)) 
            { 
                if(ord(substr($string, $i, 1))>129) 
                { 
                    $tmpstr.= substr($string, $i, 2); 
                } 
                else 
                { 
                    $tmpstr.= substr($string, $i, 1); 
                } 
            } 
            if(ord(substr($string, $i, 1))>129) $i++; 
        } 
        if(strlen($tmpstr)< $strlen ) $tmpstr.= "..."; 
        return $tmpstr; 
    } 
} 