$(document).ready(function () {
    $.get(
        '/user/get-user-close-ad-window'
    ).then(function (response) {
        $('#footer').after(response)
    })

    $(document).on('click','.setAdWindowViewed', function () {
        $(document).find('.modal').remove()
        $.post('/user/set-user-close-ad-window')
    })
})