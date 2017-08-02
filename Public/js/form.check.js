//-------- 管理员添加表单验证函数  AdminController->add()  ---------//
function adminAddFormCheck() {

	var account = $(":text[id=e8_account]").val();
	var name = $(":text[id=name]").val();
	var email = $(":text[id=e8_email]").val();
	var password = $(":password[id=password]").val();
	var password_ = $(":password[id=passwordConfirm]").val();
	var admingroup = $("#e8_admin_group").val();
	var account_reg = /^[a-zA-Z0-9_]{6,16}$/; // 账号验证正则表达式
	var email_reg = /^([a-zA-Z0-9_-])+@([a-zA-Z0-9_-])+((.[a-zA-Z0-9_-]{2,3}){1,2})$/; // 邮箱验证正则表达式

	if (account == "") {
		alert('账号不能为空!!');
		$(":text[id=e8_account]").focus();
		return false;
	}

	if (!account_reg.test(account)) {
		alert('账号格式不正确!!');
		$(":text[id=e8_account]").focus();
		return false;
	}

	if (name == "") {
		alert("姓名不能为空!!");
		$(":text[id=name]").focus();
		return false;
	}

	if (email == "") {
		alert("邮箱不能为空!!");
		$(":text[id=e8_email]").focus();
		return false;
	}

	if (!email_reg.test(email)) {
		alert("邮箱格式不正确!!");
		$(":text[id=e8_email]").focus();
		return false;
	}

	if (password == "") {
		alert("密码不能为空!!");
		$(":password[id=password]").focus();
		return false;
	}

	if (password.length < 6 || password.length > 22) {
		alert("密码长度在6到22位之间!!");
		$(":password[id=password]").focus();
		return false;
	}

	if (password_ == "") {
		alert("重复密码不能为空");
		$(":password[id=passwordConfirm]").focus();
		return false;
	}

	if (password != password_) {
		alert("两次密码不一样!!");
		$(":password[id=passwordConfirm]").focus();
		return false;
	}

	if (admingroup == "") {
		alert("管理员分组不能为空!!");
		return false;
	}
}

// ---------- 管理员分组添加修改表单验证 ----------//
function checkAdminGroupForm() {
	var name = $("#admin-group-name").val();
	var permGroupId = $("#perm-group-id").find("option:selected").length;

	if (name == "") {
		alert("管理员分组名称不能为空!!");
		$("#admin-group-name").focus();
		return false;
	}

	if (permGroupId == 0) {
		alert("管理员分组权限不能为空!!");
		return false;
	}

}

// ------- 权限添加修改表单验证 PermissionController->add ---------//
function checkPermissionForm() {
	var name = $("#perm-name").val();
	var action = $("#perm-action").val();

	if (name == "") {
		alert("权限名称不能为空!!");
		$("#perm-name").focus();
		return false;
	}
	if (action == "") {
		alert("Action不能为空!!");
		$("#perm-action").focus();
		return false;
	}
}

// ---------- 权限分组添加修改表单验证 PermGroupController->add|edit -----------//
function checkPermGroupForm() {
	var name = $("#perm-group-name").val();
	var value = $("#perm-group-value").val();

	if (name == "") {
		alert("权限分组名称不能为空!!");
		$("#perm-group-name").focus();
		return false;
	}

	if (value == "") {
		alert("权限分组中的权限不能为空!!");
		return false;
	}
}

// ----------模板管理添加修改表单验证 TemplateController ->add|edit --------//
function checkTemplateForm() {
	var name = $("#template-name").val();
	var url = $("#template-url").val();
	var url_reg = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
	if (name == "") {
		alert("模板名称不能为空!!");
		$("#template-name").focus();
		return false;
	}
	if (!url_reg.test(url)) {
		alert("链接地址格式错误!!");
		$("#template-url").focus();
		return false;
	}
}
// --------文章管理添加修改表单ContentController->add|edit--------//
function checkContentForm() {
	var title = $("#content-title").val();
	var class_id = $("#content-class_id").val();
	var author = $("#content-author").val();
	var addtime = $("#datepicker").val();
	var toptimestr = $("#top-time").val();
	var sort = $("#sort").val();
	//var url = $("#url").val();
	//var url_reg = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
	var sort_reg = /^(0|[1-9]\d*)$/;

	if (title == "") {
		alert("文章标题不能为空!!");
		$("#template-name").focus();
		return false;
	}
	if (class_id == "") {
		alert("栏目未选择!!");
		$("#content-class_id").focus();
		return false;
	}
	if (addtime == "") {
		alert("发布时间不能为空!!");
		$("#datepicker").focus();
		return false;
	}
	/*if (url != "") {
		if (!url_reg.test(url)) {
			alert("链接地址格式错误!!");
			$("#content-url").focus();
			return false;
		}
	}*/
	if (!sort_reg.test(sort)) {
		alert("排序必须是数值!!");
		$("#content-sort").focus();
		return false;
	}

	if (toptimestr != '') {
		
		var toptimeint = new Date(toptimestr);
		var toptime = toptimeint.getTime() / 1000;
		var nowtime = Date.parse(new Date()) / 1000;

		if (toptime < nowtime) {
			alert("置顶时间小于当前时间!!");
			$("#top-time").focus();
			return false;
		}
	}

}

// -------------栏目管理表单验证ClassController->add|edit------------//
function checkClassForm() {
	var name = $("#class-name").val();
	var channel_id = $("#class-channel_id").val();
	var indexTemplate = $("#class-indexTemplate").val();
	var contentTemplate = $("#class-contentTemplate").val();
	var sort = $("#class-sort").val();
	var url = $("#class-url").val();
	var url_reg = /http(s)?:\/\/([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
	var sort_reg = /^(0|[1-9]\d*)$/;
	if (name == "") {
		alert("栏目标题不能为空!!");
		$("#template-name").focus();
		return false;
	}
	if (channel_id == "") {
		alert("内容模型不能为空!!");
		$("#template-name").focus();
		return false;
	}
	if (indexTemplate == "") {
		alert("栏目封面模板不能为空!!");
		$("#template-name").focus();
		return false;
	}
	if (contentTemplate == "") {
		alert("栏目内容模板不能为空!!");
		$("#template-name").focus();
		return false;
	}
	if (url != "") {
		if (!url_reg.test(url)) {
			alert("链接地址格式错误!!");
			$("#content-url").focus();
			return false;
		}
	}
	if (!sort_reg.test(sort)) {
		alert("排序必须是数值!!");
		$("#content-sort").focus();
		return false;
	}
}