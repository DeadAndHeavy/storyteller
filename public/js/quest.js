$(document).on('click', '#add_episode', function ()
{
    var episodes_count = $('.episode').length;
    $.get("/quest/addEpisodeHtml", {episode_number: episodes_count + 1}, function (data)
    {
        $("#quest_episodes").append(data);
    });
});

