function ajx() {
    //alert("122334");
    var _url = "/ajax/user.php";
    var name = $("#aja").val();
    var pwd = $("#pwd").val();
    //alert(document.getElementById("aja").value);
    //var html = document.getElementById("aja");
    //html.innerHTML = xx;
    $.ajax({
        type: "POST",
        url: _url,
        data: "cmd=submit&name=" + name + "&pwd=" + pwd,
        success: function (msg) {
            //alert("Data Saved: " + msg);
            //var result = $("#result");
            //result.html($.parseJSON(msg)['msg']);

            var ret = $("#ret");
            //ret.html($.parseJSON(msg)['state']);
            if ($.parseJSON(msg)['state'] === "ok") {
                alert("成功");
                //window.open("/hall");
            }

        }
    });
}

function comment() {
    var _url = "/ajax/user.php";
    var comment = $("#speak").val();
    $.ajax({
        type: "POST",
        url: _url,
        data: "cmd=comment&comment=" + comment,
        success: function (msg) {
            var ret = $("#comment");
            if ($.parseJSON(msg)['state'] === "ok") {
                ret.html(comment);
            }

        }
    });
}

function google() {
    var google = $("#google").val();
    var _url = "http://www.baidu.com";
    window.open(_url+"?"+google);
}

function a(o) {
    alert(o);
}

function wind() {
    var windNode = $("#wind");
    //windNode.css("display", "block");
    //windNode.show("slow");
    windNode.fadeIn("slow");
}

function hide() {
    var wind = $("#wind");
    //wind.hide("slow");
    //淡出
    wind.fadeOut("slow");
    
}

//function show() {
//        var sp = $("#sp");
//        sp.hide("slow");
//}
