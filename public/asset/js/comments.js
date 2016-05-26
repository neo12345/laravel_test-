$(document).ready(function () {
    //click btn reply then set value of frmComent > reply_to
    $(".reply").click(function () {
        var id = $(this).val();
        $('#reply_to').val(id);
        $('#comment').focus();
    });

    //click btn comment then send comment and display
    $("#btn-comment").click(function (e) {

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();

        var formData = {
            user_id: $("#user_id").val(),
            username: $("#username").val(),
            comment: $("#comment").val(),
            comic_id: $("#comic_id").val(),
            reply_to: $("#reply_to").val()
        };

        $.ajax({
            type: 'POST',
            url: '/test_laravel/comic/public/comments',
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var comment = '<div id="comment' + data.id + '" tabindex="-1"><b>' + data.username + '</b><br>' + data.created_at + '<br><br>';
                if (data.reply_to != 0) {
                    comment += 'Reply to: <a href="#comment' + data.reply_to + '">>>>' + data.reply_to + '</a><br>';
                }
                comment += '<br>' + data.comment + '<br><a href="#frmComment"><button id="reply';
                comment += data.id + '" class="btn btn-primary btn-lg pull-right reply" value="' + data.id + '">Reply</button></a>';
                comment += '<br><br><hr></div>';

                $("#comment_list").append(comment);

                var replies = '<a href="#comment' + data.id + '"><<<' + data.id + ', </a>';
                $("#comment" + data.reply_to).children('#comment_replies').append(replies);
                
                $('#frmComment').trigger("reset");
                $('#comment' + data.id).focus();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });

    });
});