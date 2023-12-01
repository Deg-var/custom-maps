$(document).ready(function () {
    $(document).on('click', '#newCommentBtn', function () {
        let newCommentText = $('#newCommentText')

        if (newCommentText.val()) {
            $.post('/site/new-comment', {
                commentText: newCommentText.val(),
                mapId: newCommentText.attr('data-map-id')
            }).then(function (response) {
                $('#forOldComments').html(response)
                newCommentText.val('')
            })
        }
    })

    $(document).on('click', '.commentLikeBtn', function () {
        let commentLike = $(this);

        $.post('/site/switch-comment-like-button', {
            commentId: commentLike.attr('data-comment-id')
        }).then(function (response) {
            $('#commentId-' + commentLike.attr('data-comment-id')).html(response)
        })
    })
})