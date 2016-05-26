$(document).ready(function () {
    //click btn like then set 
    $("#btn_like").click(function (e) {    
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();

        var formData = {
            user_id: $("#user_id").val(),
            comic_id: $("#comic_id").val()
        };
        var slug = $('#comic_slug').val();
        var url = '/test_laravel/comic/public/comics/' + slug + '/like';
        
        $.ajax({
            type: 'POST',
            url: url,
            data: formData,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                
                var like_counter = 'Like counter: ' + data.count;
                $("#like_counter").html(like_counter);
                if(data.action == 'unlike') {
                    $("#btn_like").html('Like');
                }
                else {
                    $("#btn_like").html('Unlike');
                }
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});