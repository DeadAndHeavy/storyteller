$(document).on('click', '#add_episode', function ()
{
    var episodes_count = $('.episode').length;
    $.get("/quest/addEpisode", {episode_number: episodes_count + 1}, function (data)
    {
        $("#episodes_container").append(data);
    });
});

