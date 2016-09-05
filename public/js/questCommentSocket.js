$(document).ready(function() {
    var socket = null;
    socket = new WebSocket(host);
    socket.onmessage = function (msg) {
        var origin_quest_id = $("#quest_container").data('quest_id');
        var msgDataList = msg.data.split('::');
        if (msgDataList[0] = 'quest_comment_store' && origin_quest_id == msgDataList[1]) {
            $.get("/quest/comment/renderQuestComment", {comment_id: msgDataList[2]}, function (data)
            {
                $("#quest_comments_container").append(data);
            });

        }
        if (msgDataList[0] = 'quest_comment_update' && $(".comment_content[data-comment_id='" + msgDataList[1] + "']").length > 0) {
            $.get("/quest/comment/renderQuestComment", {comment_id: msgDataList[1]}, function (data)
            {
                $(".comment_content[data-comment_id='" + msgDataList[1] + "']").parents('.comment').replaceWith(data);
            });
        }
    };

    var addComment = function(form) {
        var form_textarea = form.find('textarea');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            success: function(data)
            {
                form_textarea.val('');
                $('html, body').animate({
                    scrollTop: $(document).height()
                }, 'slow');
            }
        });
    };

    $("#quest_comments_form textarea").keypress(function(e) {
        if(e.which == 13) {
            addComment($("#quest_comments_form"));
        }
    });

    $("#quest_comments_form").submit(function(e) {
        addComment($(this));
        e.preventDefault();
    });

    $(document.body).on('click', '.update_quest_comment' ,function(){
        var button = $(this);
        var comment_area = button.parents('.comment_area');
        var comment_id = button.data('comment_id');

        if (comment_area.has('.update_quest_comment_form').length) {
            comment_area.find('.comment_content').html(button.data('origin_text'));
            button.removeData('origin_text').removeClass('btn-info').addClass('btn-primary');
        } else {
            $.get("/quest/comment/renderQuestCommentForm", {comment_id: comment_id}, function (data)
            {
                comment_area.find('.comment_content').html(data);
                try {
                    socket.send(comment_id);
                } catch (e) {
                }
            });
            button.data('origin_text', comment_area.find('.comment_content').text());
            button.removeClass('btn-primary').addClass('btn-info');
        }
    });
});