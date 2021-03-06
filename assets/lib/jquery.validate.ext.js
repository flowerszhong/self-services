var cnmsg = {
    required: "必填字段",
    remote: "请修正该字段",
    email: "请输入正确格式的电子邮件",
    url: "请输入合法的网址",
    date: "请输入合法的日期",
    dateISO: "请输入合法的日期 (ISO).",
    number: "请输入合法的数字",
    digits: "只能输入整数",
    creditcard: "请输入合法的信用卡号",
    equalTo: "请再次输入相同的值",
    accept: "请输入拥有合法后缀名的字符串",
    maxlength: jQuery.validator.format("请输入一个长度最多是 {0} 的字符串"),
    minlength: jQuery.validator.format("请输入一个长度最少是 {0} 的字符串"),
    rangelength: jQuery.validator.format("请输入一个长度介于 {0} 和 {1} 之间的字符串"),
    range: jQuery.validator.format("请输入一个介于 {0} 和 {1} 之间的值"),
    max: jQuery.validator.format("请输入一个最大为 {0} 的值"),
    min: jQuery.validator.format("请输入一个最小为 {0} 的值")
};

if (jQuery) {
    jQuery.extend(jQuery.validator.messages, cnmsg);
}


if (jQuery.validator) {
    jQuery.validator.addMethod("isStudentId", function(value, element) {
        var tel = /^[0-9]{10}$/;
        return this.optional(element) || (tel.test(value));
    }, "请输入正确的学号");

    function checkChinese(str) {
        var re = /[^\u4e00-\u9fa5]/;
        if (re.test(str)) return false;
        return true;
    };

    function checkChineseName(v) {
        if (v == '') return false;
        if (v.length < 2) {
            return false;
        }
        var name = v.replace(/·/g, '');
        name = name.replace(/•/g, '');
        if (checkChinese(name)) {
            return true;
        } else {
            return false;
        };
    };

    jQuery.validator.addMethod("isChineseName", function(value, element) {
        return checkChineseName(value);
    }, "请输入正确的姓名");
}