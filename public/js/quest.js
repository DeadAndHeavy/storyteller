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

$(document).ready(function() {
    $('#episodes_table').DataTable({
        "columnDefs": [
            {
                "targets": [ 3 ],
                "searchable": false,
                "sortable": false
            }
        ],
        "order": [[ 1, "desc" ]]
    });
} );

$(document).ready(function() {
    $('#scenario_table').DataTable({
        "bPaginate": false,
        "columnDefs": [
            {
                "targets": [ 2 ],
                "sortable": false,
                "searchable": false
            }
        ],
        "order": [[ 1, "desc" ]],
        "oLanguage": {
            "sSearch": "Search by title or type:"
        }
    });
});

$(document).ready(function() {
    tinymce.init({
        selector: '.edit_episode_page #content',
        setup : function(ed)
        {
            ed.on('init', function()
            {
                this.getDoc().body.style.fontSize = '14px';
            });

            ed.on('keyDown', function(evt) {
                if (evt.keyCode == 9){
                    ed.execCommand('mceInsertContent', false, '&emsp;&emsp;');
                    evt.preventDefault();
                }
            });
        }
    });
});

$(document).on('click', '.episodeActionProcess', function ()
{
    var quest_episode_zone = $(this).parents('.quest-episode-zone');
    $.get("/scenario/renderNewEpisodeStep", {targetEpisodeId: $(this).data('target-episode-id')}, function (data)
    {
        $(quest_episode_zone).html(data);
    });
});