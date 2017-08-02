/**
 * 当前时间
 * 
 * @returns {String}
 */
function now_time() {
	var date = new Date();
	var time = date.getFullYear() + '年' + (date.getMonth() + 1) + '月'
			+ date.getDate() + '日  ' + date.getHours() + '时'
			+ date.getMinutes() + '分' + date.getSeconds() + '秒';
	return time;
};

/**
 * 复选框全选/取消全选函数
 * 
 * @param selectItem
 *            复选框name值
 * @param checked
 *            true为全选，false为取消全选
 */
function selectAll(checkName) {
	var checkBox = document.getElementsByName(checkName);
	for ( var i = 0; i < checkBox.length; i++) {
		if(checkBox.item(i).checked === false){
			checkBox.item(i).checked = true;
		}else{
			checkBox.item(i).checked = false;
		}
	}
}

/**
 * 获取所有被选中的复选框的值
 * 
 * @param checkName
 * @returns {String}
 */
function getCheckBoxItem(checkName) {
	var checkBox = document.getElementsByName(checkName);
	var item = "";
	for ( var i = 0; i < checkBox.length; i++) {
		if (checkBox.item(i).checked) {
			if (item == "") {
				item = checkBox.item(i).value;
			} else {
				item = item + "," + checkBox.item(i).value;
			}
		}
	}
	return item;
}