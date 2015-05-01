var _url = "/ajax/comment.php";
function comment() {
    var comment = $("#comment").val();
    $.ajax({
        type: "POST",
        url: _url,
        data: "cmd=comment&comment=" + comment,
        success: function (msg) {
            if ($.parseJSON(msg) != 0) {
                alert("提交成功");
                var comm = $("#comm");
                comm.html(comment);
            }
            $.ajax({
                type: "POST",
                url: _url,
                data: "cmd=delCache&key=" + "commentList",
                success: function(amsg) {
                    alert($.parseJSON(amsg));
                }
            })
        }
    })
}

function deleted(id) {
    var id = id;//$("#comment_id");
    $.ajax({
        type: "POST",
        url: _url,
        data: "cmd=delete&id=" + id,
        success: function(msg) {
            if ($.parseJSON(msg) > 0) {
                alert("删除成功");
            }
            $.ajax({
                type: "POST",
                url: _url,
                data: "cmd=delCache&key=" + "commentList",
                success: function(amsg) {
                    alert($.parseJSON(amsg));
                }
            })
        }
    })
}
