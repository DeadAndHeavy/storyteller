$(function () {
    $('[data-toggle="tooltip"]').tooltip()
})

$(document).ready(function(){
    var newVarsCount = $('.new_quest_variable').length;
    if (newVarsCount == 0) {
        $("#save_new_variables").prop('disabled', true);
    }
});

$('#removeEpisodeActionLogicModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget);
    var episode_action_id = button.parents(".episode_action_logic").data('episode-action-id');
    var modal = $(this);
    modal.find(".remove_episode_action_logic_button").data('episode-action-id', episode_action_id);
});

$(document).on('click', '.remove_episode_action_logic_button', function ()
{
    var episode_action_id = $(this).data('episode-action-id');
    var logic_screen = $("#episode_action_collapse_" + episode_action_id).find(".episode_action_logic_screen .panel-body");
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
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-primary logic_statement logic_data_variable_on_screen">' + $(this).data('variable-title') + '</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-assignment-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_data_assignment_on_screen">=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-if-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_data_if_on_screen">IF</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-elseif-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_data_elseif_on_screen">ELSEIF</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-else-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_data_else_on_screen">ELSE</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-endif-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-success logic_statement logic_data_endif_on_screen">ENDIF</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-left-bracket-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_data_right_bracket_on_screen">(</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-right-bracket-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_data_left_bracket_on_screen">)</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-end-of-operator-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-default logic_statement logic_data_end_of_operator_on_screen">;</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-plus-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_plus_on_screen">+</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-minus-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_minus_on_screen">-</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-multiplication-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_multiplication_on_screen">*</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-division-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_division_on_screen">/</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-plus-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_plus_equal_on_screen">+=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-minus-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_minus_equal_on_screen">-=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-multiplication-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_multiplication_equal_on_screen">*=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-division-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-info logic_statement logic_data_division_equal_on_screen">/=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_equal_on_screen">==</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-not-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_not_equal_on_screen">!=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-and-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_and_on_screen">AND</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-or-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_or_on_screen">OR</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-not-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_not_on_screen">NOT</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-greater-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_greater_on_screen">></span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-greater-or-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_greater_or_equal_on_screen">>=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-lower-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_lower_on_screen"><</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-lower-or-equal-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="label label-warning logic_statement logic_data_lower_or_equal_on_screen"><=</span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-value-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="logic_statement logic_data_value_on_screen"><input type="text"></span>';
    active_logic_row.append(element);
});

$(document).on('click', '.add-logic-new-line-button', function ()
{
    var episode_action_logic_screen = $(this).parents('.episode_action_logic').find('.episode_action_logic_screen .panel-body');
    episode_action_logic_screen.find(".logic_row").removeClass('active');
    var element = '<div class="logic_row active"></div>';
    episode_action_logic_screen.append(element);
});

$(document).on('click', '.add-logic-indent-button', function ()
{
    var episode_action_logic_screen = $(this).parents(".episode_action_logic");
    var active_logic_row = episode_action_logic_screen.find("div.logic_row.active");
    var element = '<span class="logic_statement logic_data_indent_on_screen">&nbsp;....&nbsp;</span>';
    active_logic_row.prepend(element);
});

$(document).on('click', '.enable_removing_tool', function ()
{
    if (!$(this).hasClass('activated')) {
        $(this).addClass('btn-danger');
        $(this).removeClass('btn-default');
        $(this).addClass('activated');
    } else {
        $(this).addClass('btn-default');
        $(this).removeClass('btn-danger');
        $(this).removeClass('activated');
    }
});

$(document).on('mouseenter', '.logic_statement', function ()
{
    if ($(this).parents('.episode_action_logic').find('.enable_removing_tool').hasClass('activated')) {
        $(this).addClass('cursor_destroyer');
    } else {
        $(this).removeClass('cursor_destroyer');
    }
});

$(document).on('mouseenter', 'div.logic_row', function ()
{
    var episode_action_logic = $(this).parents('.episode_action_logic');
    if (episode_action_logic.find('.enable_removing_tool').hasClass('activated') && $(this).is(':empty') && episode_action_logic.find('.logic_row').length > 1) {
        $(this).addClass('cursor_destroyer');
    } else {
        $(this).removeClass('cursor_destroyer');
    }
});

$(document).on('click', 'div.logic_row', function ()
{
    var episode_action_logic = $(this).parents('.episode_action_logic');
    if (episode_action_logic.find('.enable_removing_tool').hasClass('activated') && $(this).is(':empty')) {
        if (episode_action_logic.find('.logic_row').length > 1) {
            $(this).remove();
            episode_action_logic.find(".logic_row").removeClass('active');
            episode_action_logic.find(".logic_row").first().addClass('active');
        }
    }
});

$(document).on('click', '.logic_statement', function ()
{
    if ($(this).parents('.episode_action_logic').find('.enable_removing_tool').hasClass('activated')) {
        $(this).remove();
    }
});

$(document).on('click', '.logic_row', function ()
{
    var episode_action_logic_screen = $(this).parents('.episode_action_logic_screen .panel-body');
    episode_action_logic_screen.find(".logic_row").removeClass('active');
    $(this).addClass('active');
});


$("#save_scenario").submit(function(e) {
    $('.episode_action_logic').each(function(episode_action_index, episode_action_logic_container){
        var episode_action_id = $(episode_action_logic_container).data('episode-action-id');
        $(episode_action_logic_container).find('.episode_action_logic_screen .panel-body').children().each(function(row_index, logic_row) {
            $(logic_row).children().each(function(tag_index, tag) {
                var class_list = $(tag).attr('class');
                var logic_class = class_list.match(/logic_data_.*_on_screen/g)[0];
                switch(logic_class) {
                    case 'logic_data_value_on_screen':
                        $(tag).find('input').attr('value', $(tag).find('input').val());
                        break;
                    default:
                        break
                }
            });
        });
        var logic_input = $("<input>")
            .attr("type", "hidden")
            .attr("name", "episode_action[" + episode_action_id + "][logic]").val($(episode_action_logic_container).find('.episode_action_logic_screen .panel-body').html().trim());
        $('#save_scenario').append(logic_input);
    });
});