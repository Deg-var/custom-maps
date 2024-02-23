$(document).ready(function () {
    let getParamsStr = '';
    let getParamsArr = location.search.replace('?', '')?.split('&')
    let getParamsObj = {};

    $(document).on('click', '.mapLikeBtn', function () {
        let mapLike = $(this);

        $.post('/site/switch-map-like-button', {
            mapId: mapLike.attr('data-map-id')
        }).then(function (response) {
            $('.mapId-' + mapLike.attr('data-map-id')).html(response)
        })
    })

    $(document).on('click', '#submitNewMap', function () {
        let submitNewMap = $(this);
        let mapName = $('#mapName')
        mapName.siblings('.invalid-feedback').hide()
        console.log(submitNewMap.attr('data-is-new'))
        submitNewMap.attr('disabled', true)
        $('.loader').show();
        if (submitNewMap.attr('data-is-new') === 'true') {
            if (mapName.val() !== '') {
                $.post('/site/new-map-create', {
                    name: mapName.val(),
                    description: $('#mapDescription').val(),
                    img_link: $('#mapImgLink').val(),
                    video_link: $('#mapVideoLink').val(),
                    mod_link: $('#mapModLink').val(),
                    game_id: $('#mapGameId').val(),
                }).then(function () {
                    window.location.href = '/site/my-maps';
                })
            } else {
                mapName.siblings('.invalid-feedback').show().text('Введите название, это обязательно')
            }
        } else if (submitNewMap.attr('data-is-new') === 'false') {
            if (mapName.val() !== '') {
                $.post('/site/map-edit-submit', {
                    id: submitNewMap.attr('data-map-id'),
                    name: mapName.val(),
                    description: $('#mapDescription').val(),
                    img_link: $('#mapImgLink').val(),
                    video_link: $('#mapVideoLink').val(),
                    mod_link: $('#mapModLink').val(),
                    game_id: $('#mapGameId').val(),
                }).then(function () {
                    window.location.href = '/site/my-maps';
                })
            } else {
                mapName.siblings('.invalid-feedback').show().text('Введите название, это обязательно')
            }
        }
    })

    $(document).on('click', '.delete-map', function () {
        let mapId = $(this).attr('data-map-id');
        $.post('/site/delete-map', {
            mapId: mapId
        }).then(() => {
            window.location.href = '/site/my-maps';
        })
    })

    $(document).on('change', '#mapsPerPage', function (e) {
        setNewGetParams('per-page', e.target.value)
    })

    $(document).on('change', '#mapsSort', function (e) {
        setNewGetParams('sort', e.target.value)
    })

    function setNewGetParams(param, value) {
        getParamsArr.map(function (param) {
            let currentParam = param.split('=')
            if (currentParam[0]) {
                getParamsObj[currentParam[0]] = currentParam[1]
            }
        })

        getParamsObj[param] = value

        for (let param in getParamsObj) {
            if (param !== '0') {
                getParamsStr += `${param}=${getParamsObj[param]}&`;
            }
        }

        location.href = location.origin + location.pathname + '?' + getParamsStr
    }
})