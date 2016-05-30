$(document).ready(function () {
    //autoload new comments
    var comment = $('#comment_list').val();
    var chapter_id = $('#chapter_id').val();
    var url = '/test_laravel/comic/public/comment2s/getall/' + chapter_id;

    var data = {
        chapter_id: chapter_id
    };

    var refreshId = setInterval(function ()
    {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        $.ajax({
            url: url,
            data: data,
            type: 'POST',
            cache: false,
            success: function (data) {
//                $.each(data, function (i, data) {
//                    var exist = $('#comment' + data.id + ' #comment_comment').text();
//                    
//                    if (!exist) {
//                        var comment = '<div id="comment' + data.id + '" tabindex="-1">';
//                        comment += '<div id="comment_username"><b>' + data.username + '</b></div><br>';
//                        comment += '<div id="comment_time">' + data.created_at + '</div><br><br>';
//                        if (data.reply_to != 0) {
//                            comment += '<div id="comment_reply_to">Reply to: <a href="#comment' + data.reply_to + '">>>>' + data.reply_to + '</a></div><br>';
//                        }
//                        comment += '<br><div id="comment_comment">' + data.comment + '</div><br><a href="#frmComment"><button id="reply';
//                        comment += data.id + '" class="btn btn-primary btn-lg pull-right reply" value="' + data.id + '">Reply</button></a>';
//                        comment += '<br><br><hr></div>';
//
//                        $("#comment_list").append(comment);
//
//                        var replies = '<a href="#comment' + data.id + '"><<<' + data.id + ', </a>';
//                        $("#comment" + data.reply_to).children('#comment_replies').append(replies);
//                    }
//                });
                $("#comment_list").replaceWith(data);
            }
        });
    }, 30000);
    console.log(comment);

    //click btn reply then set value of frmComent > reply_to
    $('#comment_list').on('click', '.reply', function () {
        //$(".reply").click(function () {
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
            chapter_id: $("#chapter_id").val(),
            reply_to: $("#reply_to").val()
        };

        $.ajax({
            type: 'POST',
            url: '/test_laravel/comic/public/comment2s',
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