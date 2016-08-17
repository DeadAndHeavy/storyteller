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

$(document).on('click', '#add_scenario_step', function ()
{
    $.get("/scenario/renderNewStep", {questId: $(this).data('quest_id')}, function (data)
    {
        $("#scenario_steps").append(data);
    });
});

$(document).on('change', '.scenario-episode-selector', function ()
{
    var scenario_step = $(this).parents('.scenario_step');
    $.get("/scenario/renderNewStep", {questId: $(this).data('quest_id'), currentEpisodeId: this.value}, function (data)
    {
        $(scenario_step).replaceWith(data);
        //$("#scenario_steps").append(data);
    });
    //$(this).parents('.scenario_step').remove();
});
