<?php
namespace Admin\Logic;
use Think\Model;

/**
 * ģ������߼���
 * @author baochao
 */
class TemplateLogic extends Model{
	/**
	 * ��ȡȫ����ģ����Ϣ
	 */
	public function get_all_template(){
		return $this->select();
	}
}
?>