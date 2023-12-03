$(document).ready(function () {
    $(document).on('click', function (e) {
        if ($('.body-content').attr('data-aoe-intro-text-for-map-creator-viewed') === 'no') {
            $.post('/site/set-aoe-intro-text-for-map-creator-viewed', {
                value: 1
            }).then(() => {
                location.reload();
            })
        }
    });

    $(document).on('click', '.intro-again', function (e) {
        $.post('/site/set-aoe-intro-text-for-map-creator-viewed', {
            value: 0
        }).then(() => {
            location.reload();
        })
    });
})