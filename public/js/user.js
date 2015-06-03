/**
 * Created by mark on 15/6/1.
 */
var _url = '/ajax/user.php';

function register() {
    var username = $("#username"). val();
    var password = $("#password"). val();
    if (username.length == 0 || password.length == 0) {
        alert("账号或者密码不能为空");
        return ;
    }
    $.ajax({
        type: "POST",
        url: _url,
        data: "cmd=register&username=" + username + "&password=" + password,
        success: function(msg) {
            var msg = $.parseJSON(msg);
            if (msg['flag'] == -1) {
                alert("用户名密码不能为空");
                return ;
            } else if (msg['flag'] == -2) {
                alert("用户名已存在");
                return ;
            } else {
                alert("注册成功");
                window.location.href = "/controller/index/";//跳转
                //location.reload(); 重新加载当前页面
            }

        }
    })

}