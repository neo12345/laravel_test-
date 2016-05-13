$(document).ready(function () {

    var url = "/test_laravel/test/public/blog/posts";

    //display modal form for post editing
    //$('.open-modal').click(function () {
    $('#posts-list').on('click', '.open-modal',function(){
        var post_id = $(this).val();

        $.get(url + '/' + post_id + '/edit' , function (data) {
            //success data
            console.log(data);
            $('#post_id').val(data.id);
            $('#title').val(data.title);
            $('#description').val(data.description);
            $('#content').val(data.content);
            $('#feature_image').val(data.feature_image);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        })
    });

    //display modal form for creating new post
    $('#btn-add').click(function () {
        $('#btn-save').val("add");
        $('#formPosts').trigger("reset");
        $('#myModal').modal('show');
    });

    //delete post and remove it from list
    //$('.delete-task').click(function () {
    $('#posts-list').on('click', '.delete-post',function(){
        var post_id = $(this).val();

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            }
        })

        $.ajax({
            type: "DELETE",
            url: url + '/' + post_id,
            success: function (data) {
                console.log(data);

                $("#post" + post_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new post / update existing post
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();
        
        var formData = {
            title: $('#title').val(),
            description: $('#description').val(),
            content: $('#content').val(),
            feature_image: $('#feature_image').val()
        }

        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var post_id = $('#post_id').val();
        
        var my_url = url;

        if (state == "update") {
            type = "PUT"; //for updating existing resource
            my_url = url + '/' + post_id;
        }

        console.log(formData);

        $.ajax({
            type: type,
            url: my_url,
            data: formData,
            dataType: 'json',
//            processData: false,
//            contentType: false,
            success: function (data) {
                console.log(data);

                var post = '<tr id="post' + data.id + '"><td><b>' + data.title + '</b></td><td>' + data.description + '</td>';
                post += '<td><button class="btn btn-warning btn-detail open-modal" value="' + data.id + '">Quick Edit</button> ';
                post += '<button class="btn btn-danger btn-delete delete-task" value="' + data.id + '">Delete</button></td></tr>';

                if (state == "add") { //if user added a new record
                    $('#posts-list').append(post);
                } else { //if user updated an existing record

                    $("#post" + post_id).replaceWith(post);
                }

                $('#formPost').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
});