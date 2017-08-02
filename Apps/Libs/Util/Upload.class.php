<?php
//+---------------------------------
//| E8网络工作室 http:www.e8net.cn
//+---------------------------------
//| 文件上传类
//+---------------------------------
//| Author: webdd <2014/8/30>
//+---------------------------------

namespace Libs\Util;

class Upload {

	/**
	 * 系统文件上传函数
	 * @param unknown_type $type 文件上传类型
	 * @param unknown_type $thumb 是否生成缩略图
	 * @param unknown_type $path 返回路径还是上传文件对象
	 * @return String | Object
	 */
	function upload($type,$thumb = false,$path=true){
		// 上传文件类型
		$ext_arr = array(
				'image' => array('gif', 'jpg', 'jpeg', 'png', 'bmp'),
				'photo' => array('jpg', 'jpeg', 'png'),
				'flash' => array('swf', 'flv'),
				'media' => array('swf', 'flv', 'mp3', 'wav', 'wma', 'wmv', 'mid', 'avi', 'mpg', 'asf', 'rm', 'rmvb'),
				'file' => array('doc', 'docx', 'xls', 'xlsx', 'ppt', 'htm', 'html', 'txt', 'zip', 'rar', 'gz', 'bz2','pdf')
		);
		$upload = new \Think\Upload();// 实例化上传类
		$upload->maxSize   =     3145728 ;// 设置附件上传大小
		$upload->autoSub = true;//使用子目录保存上传文件
		$upload->subType = 'date';//使用日期模式创建子目录
		$upload->dateFormat = 'Ymd';//设置子目录日期格式
		$upload->allowExts  = $ext_arr[$type];// 设置附件上传类型
		$upload->rootPath = "./Public/e8admin/upload/";
		$upload->savePath =  $type."/";// 设置附件上传目录
		$upload->thumb = $thumb;//生成缩略图
		$upload->thumbMaxWidth = '200';//缩略图最大宽度
		$upload->thumbMaxHeight = '200';//缩略图最大高度
		$upload->thumbRemoveOrigin = true;
	
		// 上传文件
		$info   =   $upload->upload();
		if(!$info) {
			// 上传错误提示错误信息
			$this->error($upload->getError());
		}else{
			// 上传成功 获取上传文件信息
			if ($path){
				foreach($info as $file){
					return $file['savepath'].$file['savename'];
				}
			} else {
				return $info;
			}
		}
	}

}