var language = $('meta[name="language"]').attr('content');
var token = $('meta[name="token"]').attr('content');
var string_root = '';
var string_sub = '';

if (language == 'en') {
    string_root += '<label>Folder name: </label>'
    string_root += '<input type="text" name="rootfolder">';
    string_root += '<button class="btn btn-primary" onclick="add_root_folder()">Add</button>';
} else {
    string_root += '<label>Tên thư mục: </label>'
    string_root += '<input type="text" name="rootfolder">';
    string_root += '<button class="btn btn-primary" onclick="add_root_folder()">Thêm</button>';
}

if (language == 'en') {
    string_sub += '<label>Subfolder name: </label>';
    string_sub += '<input type="text" name="subfolder">';
} else {
    string_sub += '<label>Tên thư mục con: </label>';
    string_sub += '<input type="text" name="subfolder">';
}

$(document).ready(function(){
    if ($('div').hasClass('error_login')) {
        $('.form-login td').css('padding-top', '0px');
        $('#login').modal();
    }

    if ($('div').hasClass('add_user')) {
        $('#add-user').modal();
    }

    $('.heading-add-folder button.btn-success').click(function(){
        $('.add-folder').html(string_root);
    });

    $('.td-button-folder button.btn-primary').click(function(){
        var id = $(this).attr('id');
        id = id.substring(7, id.length);
        $('.td-button-folder button').removeClass('border-red');
        $(this).addClass('border-red');

        if (language == 'en') {
            string = string_sub + '<button class="btn btn-primary" onclick="add_subfolder(' + id + ')">Add</button>';
        } else {
            string = string_sub + '<button class="btn btn-primary" onclick="add_subfolder(' + id + ')">Thêm</button>';
        }
        $('.add-folder').html(string);  
    });

    $('input[name="select_all"]').change(function(){
        $('input:checkbox').not(this).prop('checked', this.checked);
        if ($(this).is(":checked")) {
            if (language == 'en') {
                $('.heading-add-folder .btn-primary span').text('Deselect all');
            } else {
                $('.heading-add-folder .btn-primary span').text('Bỏ chọn tất cả');
            }         
        } else {
            if (language == 'en') {
                $('.heading-add-folder .btn-primary span').text('Select all');
            } else {
                $('.heading-add-folder .btn-primary span').text('Chọn tất cả');
            }
        }
    });

    $('.heading-add-folder .btn-danger').click(function(){
        var flag = true;
        if (language == 'en') {
            flag = confirm('You want to delete this folder?');
        } else {
            flag = confirm('Bạn muốn xóa thư mục này chứ?');
        }
        if (flag) {
            var array_folder = [];
            $.each($("input[name='checkbox_folder']:checked"), function(){      
                array_folder.push($(this).val());
                $('#tr-folder-' + $(this).val()).remove();
            });
            if (array_folder.length) {
                $.ajax({
                    url: "folder/delete",
                    method: "post",
                    data: {_token:token, id_folder:array_folder}
                });
            } else {
                if (language == 'en') {
                    alert('Select a folder to delete');
                } else {
                    alert('Chọn 1 thư mục để xóa');
                }
            }
        }
    });

    $('.heading-permission-user .btn-success').click(function(){
        var flag = true;
        if (language == 'en') {
            flag = confirm('You want to permit these users?');
        } else {
            flag = confirm('Bạn muốn cấp quyền cho các user này chứ?');
        }
        if (flag) {
            var array_user = [];
            var folder_id = $('.heading-permission-user label').attr('id');
            $.each($("input[name='user_permission']:checked"), function(){
                array_user.push($(this).val());
                $('#user-permission-' + $(this).val()).remove();
            });
            if (array_user.length) {
                $.ajax({
                    url: "permission",
                    method: "post",
                    data: {_token:token, id_user:array_user, folder_id: folder_id}
                });
            } else {
                if (language == 'en') {
                    alert('Select user to permit');
                } else {
                    alert('Chọn 1 user để cấp quyền.');
                }
            }
        }
    });

    $('i.sort').click(function(){
        var created_at = [];
        $.each($('tbody tr'), function(){
            created_at.push($(this).html());
        });
        var tr_id = $.makeArray($('tbody tr[id]').map(function() {
            return this.id;
        }));

        created_at = created_at.reverse();
        var tr_tag = '';
        for (var i = 0; i < created_at.length; i++) {
            tr_tag += '<tr id="' + tr_id[i] + '">' + created_at[i] + '</tr>';
        } 
        $('tbody').html(tr_tag);
        if ($(this).hasClass('glyphicon-triangle-top')) {
            $(this).removeClass('glyphicon-triangle-top').addClass('glyphicon-triangle-bottom');
        } else {
            $(this).removeClass('glyphicon-triangle-bottom').addClass('glyphicon-triangle-top');
        }
    });

    $('.watch-video').click(function(){
        var watch_video = '';
        watch_video += '<div class="modal-dialog modal-lg">';
        watch_video += '<div class="modal-content">';
        watch_video += '<video width="100%" height="100%" controls="">';
        watch_video += '<source src="' + $(this).val() + '" type="video/mp4">';
        watch_video += '</video>';
        watch_video += '</div>';
        watch_video += '</div>'

        $('#watch-video').html(watch_video);
        $('#watch-video').modal();
    });

    $('.heading-add-video .btn-danger').click(function(){
        var flag = true;
        if (language == 'en') {
            flag = confirm('You want to delete these videos?');
        } else {
            flag = confirm('Bạn muốn xóa các video này chứ?');
        }
        if (flag) {
            var array_video = [];
            $.each($("input[name='checkbox_video']:checked"), function(){      
                array_video.push($(this).val());
                $('#tr-folder-' + $(this).val()).remove();
            });
            if (array_video.length) {
                $.ajax({
                    url: "video/delete",
                    method: "post",
                    data: {_token:token, id_video:array_video}
                });
            } else {
                if (language == 'en') {
                    alert('Select a video to delete');
                } else {
                    alert('Chọn 1 video để xóa');
                }
            }
        }
    });

    // $('.heading-add-video .btn-warning').click(function(){
    //     var flag = true;
    //     if (language == 'en') {
    //         flag = confirm('You want to delete these videos?');
    //     } else {
    //         flag = confirm('Bạn muốn tải các video này chứ?');
    //     }
    //     if (flag) {
    //         var array_video = [];
    //         $.each($("input[name='checkbox_video']:checked"), function(){      
    //             array_video.push($(this).val());
    //         });

    //         if (array_video.length) {
    //             $.ajax({
    //                 url: "video/download",
    //                 method: "POST",
    //                 data: {_token:token, id_video:array_video},
    //                 success: function(data){
                        
    //                 }
    //             });
    //         } else {
    //             if (language == 'en') {
    //                 alert('Select a video to download');
    //             } else {
    //                 alert('Chọn 1 video để tải về');
    //             }
    //         }
    //     }
    // });
});

function add_string_success(string){
    return '<span class="alert alert-success">' + string + '</span>';
}

function add_string_danger(string){
    return '<span class="alert alert-danger">' + string + '</span>';
}

function delete_user(){
    if (language == 'en') {
        return confirm('You want to delete this user?');
    } else {
        return confirm('Bạn muốn xóa người dùng này chứ?');
    }
}

function delete_video(){
    if (language == 'en') {
        return confirm('You want to delete this video?');
    } else {
        return confirm('Bạn muốn xóa video này chứ?');
    }
}

function delete_folder(){
    if (language == 'en') {
        return confirm('You want to delete this folder?');
    } else {
        return confirm('Bạn muốn xóa thư mục này chứ?');
    }
}

function add_root_folder(){
    var f = $('.add-folder input').val();
    if (f.length == 0) {
        if (language == 'en') {
            alert('Folder name is not empty!');
        } else {
            alert('Tên thư mục không được để trống!');
        }
    } else {
        var flag = true
        for (var i = f.length - 1; i >= 0; i--) {
            if (f[i] == '\\' || f[i] == '/' || f[i] == ':' || f[i] == '|' || f[i] == '<'
                || f[i] == '>' || f[i] == '?' || f[i] == '*' || f[i] == '"'
            ) {
                flag = false;
            }
        }
        if (flag) {
            $.ajax({
                url: "folder",
                method: "post",
                data: {folder_name:f, _token:token},
                dataType: "json",
                success: function(data){
                    if (data.flag) {
                        if (language == 'en') {
                            $('.add-folder').html('<span class="alert alert-success">Add folder success</span>');
                        } else {
                            $('.add-folder').html('<span class="alert alert-success">Thêm thư mục thành công</span>');
                        }

                        var new_folder = '<tr id="tr-folder-' + data.folder["id"] + '">';
                        new_folder += '<td class="value-folder">';
                        new_folder += '<input type="checkbox" name="checkbox_folder" value="' + data.folder["id"] + '">';
                        new_folder += '</td>';
                        new_folder += '<td class="value-folder">';
                        new_folder += '<a href="folder/' + data.folder["id"] + '">';
                        new_folder += '<img src="upload/folder_open.jpg" class="folder-icon">';
                        new_folder += '<span> ' + data.folder["name"] + '</span>';
                        new_folder += '</a>';
                        new_folder += '</td>';
                        new_folder += '<td class="value-folder">' + data.folder["created_at"] + '</td>';
                        new_folder += '<td class="value-folder number-sub">0</td>';
                        if (language == 'en') {
                            new_folder += '<td class="td-button-folder">';
                            new_folder += '<button class="btn btn-primary" onclick="add_sub(' + data.folder["id"] + ')">';
                            new_folder += 'Add subfolder';
                            new_folder += '</button>';
                            new_folder += '</td>';
                            new_folder += '<td class="td-button-folder">';
                            new_folder += '<a href="user?folder_id=' + data.folder["id"] + '" class="btn btn-warning">';
                            new_folder += 'Grant folder permissions';
                            new_folder += '</a>';
                            new_folder += '</td>';
                            new_folder += '<td class="td-button-folder">';
                            new_folder += '<form action="folder/' + data.folder["id"] + '" method="POST">';
                            new_folder += '<input type="hidden" name="_method" value="DELETE">';
                            new_folder += '<input type="hidden" name="_token" value="' + token + '">';
                            new_folder += '<button class="btn btn-danger" onclick="return delete_folder();">Delete</button>';
                            new_folder += '</form>';
                        } else {
                            new_folder += '<td class="td-button-folder">';
                            new_folder += '<button class="btn btn-primary" onclick="add_sub(' + data.folder["id"] + ')">';
                            new_folder += 'Thêm thư mục con';
                            new_folder += '</button>';
                            new_folder += '</td>';
                            new_folder += '<td class="td-button-folder">';
                            new_folder += '<a href="user?folder_id=' + data.folder["id"] + '" class="btn btn-warning">';
                            new_folder += 'Cấp quyền thư mục';
                            new_folder += '</a>';
                            new_folder += '</td>';
                            new_folder += '<td class="td-button-folder">';
                            new_folder += '<form action="folder/' + data.folder["id"] + '" method="POST">';
                            new_folder += '<input type="hidden" name="_method" value="DELETE">';
                            new_folder += '<input type="hidden" name="_token" value="' + token + '">';
                            new_folder += '<button class="btn btn-danger" onclick="return delete_folder();">Xóa</button>';
                            new_folder += '</form>';
                        }
                        new_folder += '</td>'
                        new_folder += '</tr>';
                        $('.table-folder tbody').append(new_folder);
                    } else {
                        if (language == 'en') {
                            $('.add-folder').html(add_string_danger('This folder already exists!'));
                        } else {
                            $('.add-folder').html(add_string_danger('Thư mục này đã tồn tại!'));
                        }
                    }

                    function add_root_folder_before(){
                        if (data.flag) {
                            if (language == 'en') {
                                $('.add-folder').html('');
                            } else {
                                $('.add-folder').html('');
                            }
                        } else {
                            $('.add-folder').removeClass('alert alert-danger alert-success').html(string_root);
                        }
                    }
                    setTimeout(add_root_folder_before, 500);
                }
            });
        } else {
            if (language == 'en') {
                alert("A folder name can't contain any of the following characters: \\ / : * ? \" < > |");
            } else {
                alert("Tên thư mục không thể chứa các ký tự sau: \\ / : * ? \" < > |");
            }
        }
    }
}

function add_subfolder(id){
    var folder_name = $('.add-folder input').val();
    var token = $('meta[name="token"]').attr('content');
    if (folder_name.length == 0) {
        if (language == 'en') {
            alert('Subfolder name is not empty!');
        } else {
            alert('Tên thư mục con không được để trống!');
        }
    } else {
        $.ajax({
            url: "folder",
            method: "post",
            data: {folder_name:folder_name, _token:token, parent_folder_id:id},
            dataType: "json",
            success: function(data){
                if (data.error) {
                    if (language == 'en') {
                        alert('The video already exists in this folder');
                    } else {
                        alert("Trong thư mục này đã tồn tại video");
                    }
                } else {
                    if (data.flag) {
                        if (language == 'en') {
                            $('.add-folder').html(add_string_success('Add subfolder success'));
                        } else {
                            $('.add-folder').html(add_string_success('Thêm thư mục con thành công'));  
                        }
                        var number_sub = $('#tr-folder-' + id + ' .number-sub').text();
                        number_sub++;
                        $('#tr-folder-' + id + ' .number-sub').text(number_sub);
                        $('#tr-folder-' + id + ' .td-button-folder .btn-success').remove();
                    } else {
                        if (language == 'en') {
                            $('.add-folder').html(add_string_danger('This subfolder already exists!'));
                        } else {
                            $('.add-folder').html(add_string_danger('Tên thư mục con này đã tồn tại'));
                        }
                    }
                }

                function add_subfolder_before(){
                    if (data.flag) {
                        if (language == 'en') {
                            $('.add-folder').html('');
                        } else {
                            $('.add-folder').html('');
                        }
                    } else {
                        $('.add-folder').removeClass('alert alert-danger alert-success').html(string_sub);
                    }
                }
                setTimeout(add_subfolder_before, 500);
            }
        });
    }
}

function add_root(){
    $('.add-folder').html(string_root);
}

function add_sub(id){
    $('.td-button-folder button').removeClass('border-red');
    $('#tr-folder-' + id + ' .btn-primary').addClass('border-red');

    if (language == 'en') {
        string = string_sub + '<button class="btn btn-primary" onclick="add_subfolder(' + id + ')">Add</button>';
    } else {
        string = string_sub +  '<button class="btn btn-primary" onclick="add_subfolder(' + id + ')">Thêm</button>';
    }
    $('.add-folder').html(string);
}
