function checkAll() {
    var checkall = document.getElementById("checkall");
    var check = document.getElementsByClassName("check");
    if(checkall.checked == true) {
        for(i=0; i<check.length; i++) {
            check[i].checked = true;
        }
    } else {
        for(i=0; i<check.length; i++) {
            check[i].checked = false;
        }
    }
}

//------------------------------------------------------------------------------

function shipper_cancel() {
    window.location.href = 'http://mercari.dev/admin/shippers';
}

function shipper_new() {
    window.location.href = 'http://mercari.dev/admin/shippers/add';
}

function shipper_new_submit() {
    if($('#UserUsername').val() == '') {
        alert('Full name là thông tin bắt buộc');
        return false;
    }
    if($('#UserPassword').val() == '') {
        alert('Bạn chưa nhập mật khẩu');
        return false;
    } else {
        if($('#UserPassword').val() != $('#UserRePassword').val()) {
            alert('Mật khẩu xác nhận không đúng !!!');
            return false;
        }
    }
    if($('#UserPhonenumber').val() == '' || $('#UserAddress').val() == '' || $('#UserIndentifyCard').val() == '') {
        alert('Vui lòng hoàn tất thông tin các nhân !!!');
        return false;
    }
    $.ajax({
        url: 'http://mercari.dev/admin/shippers/add',
        type: 'POST',
        data: {
            'data[User][username]': $('#UserUsername').val(),
            'data[User][gender]':   $('#UserGender').val(),
            'data[User][email]':    $('#UserEmail').val(),
            'data[User][password]': $('#UserPassword').val(),
            'data[User][re_password]':  $('#UserRePassword').val(),
            'data[User][birthday]':     $('#dtp_input2').val(),
            'data[User][address]':      $('#UserAddress').val(),
            'data[User][phonenumber]':  $('#UserPhonenumber').val(),
            'data[User][indentify_card]': $('#UserIndentifyCard').val()
        },
        success: function(data) {
            alert('Successfully !!!');
            window.location.href = 'http://mercari.dev/admin/shippers';
        },
        error: function(e) {
            alert('Ajax thất bại !!!');
            //called when there is an error
            //console.log(e.message);
        }
    });
}

function shipper_view() {
    var check = document.getElementsByClassName("check");
    var count = 0;
    var id;
    for(i=0; i<check.length; i++) {
        if(check[i].checked == true) {
            count += 1;
            id = check[i].value;
        }
    }
    if(count == 0) {
        alert('Bạn chưa chọn mục nào');
    } else {
        if(count == 1) {
            window.location.href = 'http://mercari.dev/admin/shippers/view/' + id;
        } else {
            alert('Chỉ có thể xem 1 mục tại 1 thời điểm');
        }
    }
}

function shipper_edit() {
    if($('#UserId').length) {
        $.ajax({
            url: 'http://mercari.dev/admin/shippers/edit',
            type: 'POST',
            data: {
                'data[User][id]': $('#UserId').val(),
                'data[User][username]': $('#UserUsername').val(),
                'data[User][gender]': $('#UserGender').val(),
                'data[User][birthday]': $('#dtp_input2').val(),
                'data[User][email]': $('#UserEmail').val(),
                'data[User][phonenumber]': $('#UserPhonenumber').val(),
                'data[User][address]': $('#UserAddress').val(),
                'data[User][indentify_card]': $('#UserIndentifyCard').val()
            },
            success: function(data) {
                shipper_cancel();
            },
            error: function(e) {
                alert('Ajax thất bại !!!');
                //called when there is an error
                //console.log(e.message);
            }
        });
    } else {
        if($('#ShowUserInfo').length) {
            var UserId = $('#CurUserId').val();
            window.location.href = 'http://mercari.dev/admin/shippers/edit/' + UserId;
        } else {
            var check = document.getElementsByClassName("check");
            var count = 0;
            var UserId;
            for(i=0; i<check.length; i++) {
                if(check[i].checked == true) {
                    count += 1;
                    UserId = check[i].value;
                }
            }
            if(count == 0) {
                alert('Bạn chưa chọn mục nào');
            } else {
                if(count == 1) {
                    window.location.href = 'http://mercari.dev/admin/shippers/edit/' + UserId;
                } else {
                    alert('Chỉ có thể chỉnh sửa 1 mục tại 1 thời điểm');
                }
            }
        }
    }
}

function shipper_delete() {
    var UserId = new Array();
    if(confirm('Bạn có chắc chắn muốn xóa ???')) {
        if($('#ShowUserInfo').length) {
            UserId[0] = $('#CurUserId').val();
            $.ajax({
                url: 'http://mercari.dev/admin/shippers/delete',
                type: 'POST',
                data: {
                    'data[User][id]': UserId
                },
                success: function(data) {
                    shipper_cancel();
                },
                error: function(e) {
                    alert('Ajax thất bại !!!');
                    //called when there is an error
                    //console.log(e.message);
                }
            });
        } else {
            var check = document.getElementsByClassName("check");
            var count = 0;
            for(i=0; i<check.length; i++) {
                if(check[i].checked == true) {
                    UserId[count] = check[i].value;
                    count += 1;
                }
            }
            if(count == 0) {
                alert('Bạn chưa chọn mục nào');
            } else {
                $.ajax({
                    url: 'http://tanky.com/users/delete',
                    type: 'POST',
                    data: {
                        'data[User][id]': UserId
                    },
                    success: function(data) {
                        shipper_cancel();
                    },
                    error: function(e) {
                        alert('Ajax thất bại !!!');
                        //called when there is an error
                        //console.log(e.message);
                    }
                });
            }
        }
    } else {

    }
}

function order_details_save() {
    if($('#OrderDetailsState').val() == 1) {
        if(!$('#OrderDetailsShipperID').val()) {
            alert('Chưa xác định người chuyển hàng !!!');
            return false;
        } else {
            var pid = $('#OrderDetailsState').attr('pid');
            var sid = $('#OrderDetailsShipperID').val();
            $.ajax({
                url: '/admin/shippers/order_shipping',
                type: 'POST',
                data: {
                    'pid': pid,
                    'sid': sid
                },
                success: function(data) {
                    window.location.href = '/admin/shippers/order_list';
                },
                error: function() {
                    alert('Lưu dữ liệu thất bại !!!');
                }
            });
        }
    } else if($('#OrderDetailsState').val() == 2) {
        if(confirm('Xác nhận đơn hàng đã chuyển thành công ???')) {
            if(!$('#OrderDetailsShipperID').val()) {
                alert('Chưa xác định người chuyển hàng !!!');
                return false;
            } else {
                var pid = $('#OrderDetailsState').attr('pid');
                var sid = $('#OrderDetailsShipperID').val();
                $.ajax({
                    url: '/admin/shippers/order_success',
                    type: 'POST',
                    data: {
                        'pid': pid,
                        'sid': sid
                    },
                    success: function(data) {
                        window.location.href = '/admin/shippers/order_list';
                    },
                    error: function() {
                        alert('Lưu dữ liệu thất bại !!!');
                    }
                });
            }
        }
    } else if($('#OrderDetailsState').val() == -1) {
        if(!$('#OrderDetailsShipperID').val()) {
            alert('Chưa xác định người chuyển hàng !!!');
            return false;
        } else {
            if(confirm('Xác nhận đơn hàng đã chuyển thất bại ???')) {
                var pid = $('#OrderDetailsState').attr('pid');
                var sid = $('#OrderDetailsShipperID').val();
                $.ajax({
                    url: '/admin/shippers/order_fail',
                    type: 'POST',
                    data: {
                        'pid': pid,
                        'sid': sid
                    },
                    success: function(data) {
                        window.location.href = '/admin/shippers/order_list';
                    },
                    error: function() {
                        alert('Lưu dữ liệu thất bại !!!');
                    }
                });
            }
        }
    } else {
        window.location.href = '/admin/shippers/order_list';
    }
}