$(document).ready(function() {
    var socket = new WebSocket(host);
    socket.onmessage = function (msg) {
        var origin_quest_id = $("#quest_container").data('quest_id');
        var msgDataList = msg.data.split('::');
        switch (msgDataList[0]) {
            case 'quest_comment_store':
                if (origin_quest_id == msgDataList[1]) {
                    $.get("/quest/comment/renderQuestComment", {comment_id: msgDataList[2]}, function (data) {
                        $("#quest_comments_container").append(data);
                    });
                }
                break;
            case 'quest_comment_update':
                if ($(".comment_area[data-comment_id='" + msgDataList[1] + "']").length > 0) {
                    $.get("/quest/comment/renderQuestComment", {comment_id: msgDataList[1]}, function (data) {
                        $(".comment_area[data-comment_id='" + msgDataList[1] + "']").parents('.comment').replaceWith(data);
                    });
                }
                break;
            case 'quest_comment_delete':
                if ($(".comment_area[data-comment_id='" + msgDataList[1] + "']").length > 0) {
                    $(".comment_area[data-comment_id='" + msgDataList[1] + "']").parents('.comment').remove();
                }
                break;
        }
    };

    window.onbeforeunload = function() {
        socket.onclose = function () {};
        socket.close();
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

    /*$("#quest_comments_form textarea").keypress(function(e) {
        if(e.which == 13) {
            addComment($("#quest_comments_form"));
        }
    });*/

    $("#quest_comments_form").on('submit' ,function(e) {
        e.preventDefault();
    }).validate({
        errorClass: "has-error",
        rules: {
            comment: "required"
        },
        submitHandler: function(form) {
            addComment($(form));
            return false;
        },
        highlight: function(element, errorClass) {
            $(element).parents('.form-group').addClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).parents('.form-group').removeClass(errorClass);
        }
    });

    $(document.body).on('submit', '.delete_quest_comment_form' ,function(e) {
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize()
        });
        e.preventDefault();
    });

    $(document.body).on('click', '.update_quest_comment' ,function(){
        var button = $(this);
        var comment_area = button.parents('.comment_area');
        var comment_form = comment_area.find('.update_quest_comment_form');
        var comment_content = comment_area.find('.comment_content');
        var comment_id = comment_area.data('comment_id');

        if (comment_form.is(":visible")) {
            comment_form.hide();
            comment_content.show();
            button.removeClass('btn-info').addClass('btn-primary');
        } else {
            comment_form.show();
            comment_content.hide();

            $("#update_quest_comment_form_" + comment_id).on('submit' ,function(e) {
                e.preventDefault();
            }).validate({
                errorClass: "has-error",
                rules: {
                    comment: "required"
                },
                submitHandler: function(form) {
                    $.ajax({
                        type: "POST",
                        url: $(form).attr('action'),
                        data: $(form).serialize()
                    });
                    return false;
                },
                highlight: function(element, errorClass) {
                    $(element).parents('.form-group').addClass(errorClass);
                },
                unhighlight: function(element, errorClass) {
                    $(element).parents('.form-group').removeClass(errorClass);
                }
            });
            button.removeClass('btn-primary').addClass('btn-info');
        }
    });
});