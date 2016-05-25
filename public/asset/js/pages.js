$(document).ready(function () {

    var url = "/test_laravel/comic/public";

    //display modal form for task editing
    //$('.open-modal').click(function () {
    $('#pages-list').on('click', '.open-modal',function(){
        var page_id = $(this).val();
        var comic_slug = $('#comic_slug').val();
        var chapter_name = $('#chapter_name').val();
        var my_url = url + '/comics/' + comic_slug + '/chapters/' + chapter_name + '/pages/' + page_id + '/edit';

        $.get(my_url , function (data) {
            //success data
            console.log(my_url)
            console.log(data);
            $('#page_id').val(data.id);
            $('#btn-save').val("update");

            $('#myModal').modal('show');
        })
    });

    //display modal form for creating new task
    $('#btn-add').click(function () {
        $('#btn-save').val("add");
        $('#frmpages').trigger("reset");
        $('#myModal').modal('show');
    });

    //delete task and remove it from list
    //$('.delete-task').click(function () {
    $('#pages-list').on('click', '.delete-page',function(){
        var page_id = $(this).val();
        var comic_slug = $('#comic_slug').val();
        var chapter_name = $('#chapter_name').val();
        var my_url = url + '/comics/' + comic_slug;
        my_url += '/chapters/' + chapter_name;
        my_url += '/pages/' + page_id;

        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')

            }
        })

        $.ajax({
            type: "DELETE",
            url: my_url,
            success: function (data) {
                console.log(data);

                $("#page" + page_id).remove();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });

    //create new task / update existing task
    $("#btn-save").click(function (e) {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
            }
        })

        e.preventDefault();

//        var formData = {
//            file: $('#file').val(),
//        }
        
        var formData = new FormData();
        jQuery.each(jQuery('#file')[0].files, function(i, file) {
            formData.append('file-'+i, file);
        });
        
        //used to determine the http verb to use [add=POST], [update=PUT]
        var state = $('#btn-save').val();

        var type = "POST"; //for creating new resource
        var page_id = $('#page_id').val();
        var comic_slug = $('#comic_slug').val();
        var chapter_name = $('#chapter_name').val();
        var my_url = url + '/comics/' + comic_slug + '/chapters/' + chapter_name + '/pages';
        
        formData.append('comic_slug', comic_slug);
        formData.append('chapter_name', chapter_name);
        
        if (state == "update") {
            type = 'POST'; //for updating existing resource
            my_url = url + '/comics/' + comic_slug + '/chapters/' + chapter_name + '/pages/' + page_id + '/updateAjax';
            formData.append('page_id', page_id);
        }
        
        console.log(formData);
        
        jQuery.ajax({
            url: my_url,
            data: formData,
            dataType: 'json',
            cache: false,
            contentType: false,
            processData: false,
            type: type,
            success: function (data) {
                console.log(data);

                var page = '<div id="page' + data.id + '"><div class="thumbnail col-lg-2">';
                page += '<img src="http://localhost/test_laravel/comic/storage/app/public/' + data.link + '" /><hr>';
                page += '<button class="btn btn-warning btn-lg btn-detail open-modal" value="' + data.id + '">Edit</button> ';
                page += '<button class="btn btn-danger btn-lg btn-delete delete-task" value="' + data.id + '">Delete</button>';
                page += '</div></div>';

                if (state == "add") { 
                    //if user added a new record
                    $('#pages-list').append(page);
                } else { 
                    //if user updated an existing record
                    $("#page" + page_id).replaceWith(page);
                }

                $('#frmPage').trigger("reset");

                $('#myModal').modal('hide')
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });    
});