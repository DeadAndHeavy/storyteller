$(document).ready(function(){
    var actionsCount = $('.episode_action').length;
    if (actionsCount == 1) {
        $("#delete_episode_action").prop('disabled', true);
    }
});

$(document).on('click', '#add_episode_action', function ()
{
    var actionsCount = $('.episode_action').length;
    var actionIndex = actionsCount + 1;
    var questId = $(this).data('quest_id');
    $.get("/episode/renderEpisodeAction", {actionIndex: actionIndex, questId: questId}, function (data)
    {
        $("#episode_actions_container").append(data);
        $("#delete_episode_action").prop('disabled', false);
    });
    if (actionIndex == 10) {
        $("#add_episode_action").prop('disabled', true);
    }
});

$(document).on('click', '#delete_episode_action', function ()
{
    var actionsCount = $('.episode_action').length;
    $(".episode_action_" + actionsCount).remove();
    if ((actionsCount - 1) == 1) {
        $("#delete_episode_action").prop('disabled', true);
    }
    $("#add_episode_action").prop('disabled', false);

});

