<?php
namespace Admin\Logic;
use Think\Model;

class VisitLogic extends Model {

	/**
	 * 获取当前月和上月网站访问流量数组
	 *
	 */

	public function getVisitCount() {

		//获取当前时间包含的年月日
		$time = time();
		$y = date('y',$time);
		$m = date('m',$time);

		//如果当前月份为1月,则上月为去年12月
		if ($m == 1) {
			$y_ = $y-1;
			$m_ = 12;
		} else {
			$y_ = $y;
			$m_ = $m - 1;
		}	

		$nowCondition['y'] = $y;
		$nowCondition['m'] = $m;
		$newVisitArr = $this->getVisitCount_($nowCondition);

		$lastCondition['y'] = $y_;
		$lastCondition['m'] = $m_;
		$lastVisitArr = $this->getVisitCount_($lastCondition);

		$countArr = array (
				"now"=>$newVisitArr,
				"last"=>$lastVisitArr
			);
		return $countArr;
	}

	//getVisitCount的辅助函数,用于计算出该月每天的访问量
	public function getVisitCount_ ($condition) {

		$visitCount = array();
		for ($i = 1; $i<=31 ; $i ++) {
			$condition['d'] = $i;
			$result = $this->where($condition)->select();
			if (is_null($result)) {
				$visitCount[$i] = 0;
				continue;
			}

			$count = 0;
			foreach ($result as $key=>$val) {
				$count += $val['view'];
			}
			$visitCount[$i] = $count;
		}

		return $visitCount;
	}


	/**
	 * 获取当前月的前四个月访问总量
	 *
	 */
	public function getHistoryCount() {

		$time = time();
		$y = date('y',$time);
		$m = date('m',$time);

		$date = array();

		//获取当前月的前四个月,并拼接成数组
		for ($i=1; $i<=4; $i++) {
			$arr = array();
			if ($m != 1) {
				$arr["y"] = $y;
				$arr["m"] = $m-1;
				$date[] = $arr;
				$m = $m-1;
			} else {
				$y = $y-1;
				$m = 12;
				$arr["y"] = $y;
				$arr["m"] = $m-1;
				$date[] = $arr;
				$m = $m-1;
			}
		}
		unset($i);

		//根据条件,统计该月的总访问量
		$visitCount = array();
		foreach ($date as $v) {
			$condition['y'] = $v['y'];
			$condition['m'] = $v['m'];
			$result = $this->where($condition)->select();
			if (is_null($result)) {
				$visitCount[] = array(
						"y"=>$v['y'],
						'm'=>$v['m'],
						'count'=>0
					);

				unset($condition);
				continue;
			} 

			$count = 0;
			foreach ($result as $val) {
				$count += $val['view'];
			}
			$visitCount[] = array(
						"y"=>$v['y'],
						'm'=>$v['m'],
						'count'=>$count
					);
			unset($condition);
			unset($val);
		}

		//翻转数组
		return array_reverse($visitCount);
	}
}