/**
 * 处理文档
 * 
 * @param action
 *            动作
 * @returns {Boolean}
 */
function treatCon(action) {
	var item = getCheckBoxItem('content_id');
	if (item == "") {
		alert("您未选择文档！");
		return false;
	}
	if (action.lastIndexOf("delete") != -1) {
		var result = confirm("确定要删除该文档吗？删除后将无法恢复！");
		if (result == false)
			return;
	}
	var url = action + '/content_id/' + item;
	location.href = url;
}

/*
 * 
 * 响应删除日志按钮
 */
function btndel(action) {
	var item = getCheckBoxItem('log_id');
	if (item == "") {
		alert("您未选择任何日志！");
		return false;
	}
	if (action.lastIndexOf("delete") != -1) {
		var result = confirm("确定要删除该日志吗？删除后将无法恢复！");
		if (result == false)
			return;
	}
	var url = action + '/log_id/' + item;
	location.href = url;
}

/*
 * 
 *响应删除饭卡按钮
 * 
 * */
function carddel(action) {
	var item = getCheckBoxItem('card_id');
	if (item == "") {
		alert("您未选择任何日志！");
		return false;
	}
	if (action.lastIndexOf("delete") != -1) {
		var result = confirm("确定要删除该日志吗？删除后将无法恢复！");
		if (result == false)
			return;
	}
	var url = action + '/card_id/' + item;
	location.href = url;
}
/**
 * 删除评论
 * @param action
 * @returns {Boolean}
 */
function commentdel(action) {
	var item = getCheckBoxItem('comment_id');
	if (item == "") {
		alert("您未选择任何日志！");
		return false;
	}
	if (action.lastIndexOf("delete") != -1) {
		var result = confirm("确定要删除该评论吗？删除后将无法恢复！");
		if (result == false)
			return;
	}
	var url = action + '/comment_id/' + item;
	location.href = url;
}

/**
 * 订单审核
 * @param action
 * @returns {Boolean}
 */
function ordercheck(action) {
	var item = getCheckBoxItem('order_id');
	if (item == "") {
		alert("您未选择任何订单！");
		return false;
	}
	if (action.lastIndexOf("delete") != -1) {
		var result = confirm("确定要删除该评论吗？删除后将无法恢复！");
		if (result == false)
			return;
	}
	var url = action + '/order_id/' + item;
	location.href = url;
}


/*
 * 
 *响应删除激活卡按钮
 * 
 * */
function fcarddel(action) {
	var item = getCheckBoxItem('fcard_id');
	if (item == "") {
		alert("您未选择任何日志！");
		return false;
	}
	if (action.lastIndexOf("delete") != -1) {
		var result = confirm("确定要删除该日志吗？删除后将无法恢复！");
		if (result == false)
			return;
	}
	var url = action + '/fcard_id/' + item;
	location.href = url;
}

/**
 * 批量删短信验证
 */
function delAllCheck(name){
	if ($("input:checkbox:checked").length == 0){
		alert("您没有选择任何短信！");
		return false;
	}
	
	return confirm("确定删除吗？删除后将无法恢复");
}