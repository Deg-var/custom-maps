$(document).ready(function () {
    $.get(
        '/site/get-user-close-ad-window'
    ).then(function (response) {
        $('#footer').after(response)
    })

    $(document).on('click','.setAdWindowViewed', function () {
        $(document).find('.modal').remove()
        $.post('/site/set-user-close-ad-window')
    })
})