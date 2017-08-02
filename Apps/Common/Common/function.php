<?php

/**
	 * 公共函数库,提供可供公共调用的函数
	 * Version: 1.0
	 * Time: 2014/7/9
	 * Form: Function Name + Description + Author + Time
	 * 
	 * 1、SearchReplaceKw(),搜索结果描红函数,webdd,2014/7/17
	 * 
	 */

/**
 * 修改记录
 * Verision: 1.0
 * Time: 2014/7/9
 * Form: Function Name + Editor + Time
 */

/**
 * 在二维数组中递归查找某个值是否存在
 * in_array()
 * @param $value
 * @param $array
 * @return bool
 */
function deep_in_array($value, $array) {
    foreach($array as $item) {
        if(!is_array($item)) {
            if ($item == $value) {
                return $item;
            } else {
                continue;
            }
        }
        if(in_array($value, $item)) {
            return $item;
        } else if(deep_in_array($value, $item)) {
            return $item;
        }
    }
    return false;
}
/**
 * 将搜索结果中包含的关键字描红
 *
 * @param unknown_type $string        	
 * @param unknown_type $sokw        	
 * @return unknown
 */
function searchReplaceKw($string, $sokw = '') {
	if (empty ( $sokw ) || empty ( $string ))
		return $string;
	$badString = array (
			'~',
			'!',
			'@',
			'#',
			'$',
			'%',
			'^',
			'&',
			'*',
			'(',
			')',
			'-',
			'+',
			'[',
			']',
			':',
			';',
			'\'',
			'"',
			'|',
			'\\',
			',',
			'.',
			'?',
			'/',
			'<',
			'>' 
	);
	$sokw = str_replace ( $badString, ' ', $sokw );
	$sokw = preg_replace ( '/\s+/', '|', $sokw );
	return preg_replace ( "/($sokw)/", '<font color="red">\\1</font>', $string );
}

/**
 * 定义函数，用于模板输出，将用户信息拼接为Html代码
 * 
 * @param array $adminArr        	
 */
function adminHtmlCreate($adminArr, $administrator) {
	// $administrator = $_SESSION['Hfzbf00174'];
	$i = 0;
	foreach ( $adminArr as $admin ) {
		if ($i ++ < 5) {
			// 如果是当前管理员，则不能自己被编辑
			if ($admin ['admin_id'] === $administrator ['admin_id']) {
				$html .= ' <a class="btn btn-danger btn-mini"> @' . $admin ['name'] . '</a>';
			} else {
				$html .= ' <a class="btn btn-mini" href="' . __APP__ . '/Admin/Admin/edit/admin_id/' . $admin ['admin_id'] . '/mw/' . $admin ['mw'] . '"> @' . $admin ['name'] . '</a>';
			}
		} else {
			$html .= '&nbsp;...';
			break;
		}
	}
	echo $html;
}

/**
 * 定义函数，用于模板输出，将权限数组信息拼接为Html代码
 * 
 * @param unknown $permGroupArr        	
 */
function permGroupHtmlCreate($permGroupArr) {
	foreach ( $permGroupArr as $permGroup ) {
		$html .= ' <a class="btn btn-mini" href=""> @' . $permGroup ['name'] . '</a>';
	}
	echo $html;
}

/**
 * 定义函数，用于模板输出，将权限信息拼接为Html代码
 * 
 * @param array $permissionArr        	
 */
function permissionHtmlCreate($permissionArr) {
	$i = 0;
	foreach ( $permissionArr as $permission ) {
		if ($i ++ < 5) {
			$html .= ' <a class="btn btn-small" href="#"> @' . $permission ['name'] . '</a>';
		} else {
			$html .= '&nbsp;...';
			break;
		}
	}
	echo $html;
}
