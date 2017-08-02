<?php
namespace Admin\Logic;
use Think\Model;

/**
 * 模板管理逻辑层
 * @author baochao
 */
class TemplateLogic extends Model{
	/**
	 * 获取全部的模板信息
	 */
	public function get_all_template(){
		return $this->select();
	}
}
?>