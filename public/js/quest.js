$(document).ready(function(){
    var actionsCount = $('.episode_action').length;
    if (actionsCount == 1) {
        $(".delete_episode_action").prop('disabled', true);
    }
});

$(document).on('click', '#add_episode_action', function ()
{
    var lastActionIndex = null;
    var $episodeAction = $('.episode_action');
    $episodeAction.each(function() {
        var value = parseFloat($(this).data('episode_action_index'));
        lastActionIndex = (value > lastActionIndex) ? value : lastActionIndex;
    });

    var actionLength = $episodeAction.length;
    $.get("/episode/renderEpisodeAction", {actionIndex: lastActionIndex + 1, questId: $(this).data('quest_id')}, function (data)
    {
        $("#episode_actions_container").append(data);
        $(".delete_episode_action").prop('disabled', false);
    });

    if (actionLength == 10) {
        $("#add_episode_action").prop('disabled', true);
    }
});

$(document).on('click', '.delete_episode_action', function ()
{
    $(this).parents('.episode_action').remove();
    var actionsCount = $('.episode_action').length;
    if ((actionsCount) == 1) {
        $(".delete_episode_action").prop('disabled', true);
    }
    $("#add_episode_action").prop('disabled', false);
});


