var removingEnabled = false;

$(document).ready(function(){
    var newVarsCount = $('.new_quest_variable').length;
    if (newVarsCount == 0) {
        $("#save_new_variables").prop('disabled', true);
    }
});

$('#removeEpisodeLogicModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var episode_id = button.parents(".episode_logic").data('episode-id');
    var modal = $(this);
    modal.find(".remove_episode_logic_button").data('episode-id', episode_id);
});

$(document).on('click', '.remove_episode_logic_button', function ()
{
    var episode_id = $(this).data('episode-id');
    var logic_screen = $("#episode_collapse_" + episode_id).find(".episode_logic_screen .panel-body");
    logic_screen.html("<div class='logic_row active'></div>");
});

$(document).on('click', '#add_quest_variable', function ()
{
    var lastVariableIndex = null;
    var $questVariable = $('.new_quest_variable');
    $questVariable.each(function() {
        var value = parseFloat($(this).data('variable_index'));
        lastVariableIndex = (value > lastVariableIndex) ? value : lastVariableIndex;
    });

    $.get("/variable/renderVariable", {variableIndex: lastVariableIndex + 1, questId: $(this).data('quest_id')}, function (data)
    {
        $("#quest_variables_container").append(data);
        $(".delete_variable").prop('disabled', false);
    });

    $("#save_new_variables").prop('disabled', false);
});

$(document).on('click', '.delete_variable', function ()
{
    $(this).parents('.new_quest_variable').remove();
    if ($('.new_quest_variable').length == 0) {
        $("#save_new_variables").prop('disabled', true);
    }
});

$(document).on('click', '.add-logic-var-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-primary logic_statement logic_variable_on_screen">' + $(this).data('variable-title') + '</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-assignment-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_assignment_on_screen">=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-if-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_if_on_screen">IF</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-elseif-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_elseif_on_screen">ELSEIF</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-else-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_else_on_screen">ELSE</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-endif-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_endif_on_screen">ENDIF</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-left-bracket-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_right_bracket_on_screen">(</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-right-bracket-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_left_bracket_on_screen">)</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-plus-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    console.log($(this));
    console.log(episode_logic_screen);
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    console.log(active_logic_row);
    var element = '<span class="label label-default logic_statement logic_plus_on_screen">+</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-minus-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_minus_on_screen">-</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-multiplication-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_multiplication_on_screen">*</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-division-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_division_on_screen">/</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-equal-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_equal_on_screen">==</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-not-equal-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_not_equal_on_screen">!=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-and-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_and_on_screen">AND</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-or-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_or_on_screen">OR</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-not-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_not_on_screen">NOT</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-greater-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_greater_on_screen">></span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-greater-or-equal-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_greater_or_equal_on_screen">>=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-lower-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_lower_on_screen"><=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-lower-or-equal-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_lower_or_equal_on_screen"><=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-value-button', function ()
{
    var episode_logic_screen = $(this).parents(".episode_logic");
    var active_logic_row = episode_logic_screen.find("div.logic_row.active");
    var element = '<span><input class="logic_statement logic_value_on_screen" type="text"></span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-new-line-button', function ()
{
    var episode_logic_screen = $(this).parents('.episode_logic').find('.episode_logic_screen .panel-body');
    $(".logic_row").removeClass('active');
    var element = '<div class="logic_row active"></div>';
    episode_logic_screen.append(element);
});

$(document).on('click', '.enable_removing_tool', function ()
{
    if (removingEnabled) {
        removingEnabled = false;
        $(this).addClass('btn-default');
        $(this).removeClass('btn-danger')
    } else {
        removingEnabled = true;
        $(this).addClass('btn-danger');
        $(this).removeClass('btn-default')
    }
});

$(document).on('mouseenter', '.logic_statement', function ()
{
    if (removingEnabled) {
        $(this).addClass('cursor_destroyer')
    }
});

$(document).on('click', '.logic_statement', function ()
{
    if (removingEnabled) {
        $(this).remove();
    }
});

$(document).on('click', '.logic_row', function ()
{
    $(".logic_row").removeClass('active');
    $(this).addClass('active');
});