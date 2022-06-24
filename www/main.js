const HOST = "http://localhost:8080/";
$(document).ready(() => {
    // *******************************************************
    // ********** view/Product/ProductCreate.php
    // *******************************************************

    // Function to handle create product form
    $('#product_create_form').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            type: 'post',
            url: 'api/Product/ProductPost.api.php',
            data: $('form').serialize(),
            success: function() {
                window.location.reload();
            }
        });
    });

    // *******************************************************
    // ********** Signup.php
    // *******************************************************

    $('#sign_up_form').on('submit', function(e) {
        e.preventDefault();
        $("#message_signup").css("display", "none");

        if ($("#confirm-password").val() != $("#password").val()) {
            $("#message_signup").css("display", "block");
            $("#message_signup").html("Password mismatch");
        } else {
            var form = new FormData();
            form.append("username", $("#username").val());
            form.append("password", $("#password").val());

            var settings = {
                "url": "/api/Utils/Signup.api.php",
                "method": "POST",
                "timeout": 0,
                "processData": false,
                "mimeType": "multipart/form-data",
                "contentType": false,
                "data": form,
                complete: function(e, xhr, settings) {
                    if (e.status === 200) {
                        if (e.responseText == "Success") {
                            window.location.replace(`/view/utilsView/Login.php?status=created`)
                        } else {
                            $("#message_signup").css("display", "block");
                            $("#message_signup").html("Some thing went wrong, please try again later");
                        };
                    } else {
                        $("#message_signup").css("display", "block");
                        $("#message_signup").html(e.responseText);
                    }
                }
            };
            $.ajax(settings);
        }
    });

    // *******************************************************
    // ********** Login.php
    // *******************************************************

    $('#login_form').on('submit', function(e) {
        e.preventDefault();
        $("#message_signin").css("display", "none");
        $(".alert-info").css("display", "none");

        var form = new FormData();
        form.append("username", $("#username").val());
        form.append("password", $("#password").val());

        var settings = {
            "url": "/api/Utils/Login.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Sign in success") {
                        window.location.replace(`/`);
                    } else {
                        $("#message_signin").css("display", "block");
                        $("#message_signin").html("Some thing went wrong, please try again later");
                    };
                } else {
                    $("#message_signin").css("display", "block");
                    $("#message_signin").html(e.responseText);
                }
            }
        };
        $.ajax(settings);
    });

    // *******************************************************
    // ********** Signup.php
    // *******************************************************

    // function to handle Telephone input
    $("#sdt").on('input', function(e) {
        $(this).val($(this).val().replace(/[^0-9]/g, ''));
    });


    $('#user-detail-form').on('submit', function(e) {
        e.preventDefault();
        $("#message_update_user_infor").css("display", "none");
        $("#message_update_user_danger").css("display", "none");

        var form = new FormData();
        form.append("ho_ten", $("#ho_ten").val());
        form.append("gioi_tinh", $("#gioi_tinh").val());
        form.append("ngay_sinh", $("#ngay_sinh").val());
        form.append("sdt", $("#sdt").val());
        form.append("cmnd", $("#cmnd").val());

        var settings = {
            "url": "/api/User/UserUpdateInformation.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        $("#message_update_user_infor").css("display", "block");
                        $("#message_update_user_infor").html("Cập nhật thông tin người dùng thành công");
                    } else {
                        $("#message_update_user_danger").css("display", "block");
                        // $("#message_update_user_danger").html("Có lỗi đã xảy ra, vui lòng thử lại sau");
                        $("#message_update_user_danger").html(e.responseText);
                    };
                } else {
                    $("#message_update_user_danger").css("display", "block");
                    $("#message_update_user_danger").html(e.responseText);
                }
            }
        };
        $.ajax(settings);

    });


    // *******************************************************
    // ********** view/Common/Header.php
    // ******************************************************* 
    // Hàm thêm class active vào các navbarlink ở header để thay đổi trạng thái active
    // đối với các navbarlink đang ở trong section của nó
    function _navbarlinksActive() {
        let navbarlinks = document.querySelectorAll('#navbar .scrollto')
        let position = window.scrollY + 200
        navbarlinks.forEach(navbarlink => {
            if (!navbarlink.hash) return
            let section = document.querySelector(navbarlink.hash)
            if (!section) return
            if (position >= section.offsetTop && position <= (section.offsetTop + section.offsetHeight)) {
                navbarlink.classList.add('active')
            } else {
                navbarlink.classList.remove('active')
            }
        })
    };

    // Gọi hàm _navabrlinkActive khi scroll
    $(document).scroll(_navbarlinksActive);

    // Hàm scroll tới element được truyền
    function _scrollTo(el) {
        let header = document.getElementById('header')
        let offset = header.offsetHeight

        let elementPos = el.offsetTop
        window.scrollTo({
            top: elementPos - offset,
            behavior: 'smooth'
        })
    };

    // Hàm thay đổi header khi scroll
    function _headerScrolled() {
        let header = document.getElementById('header')
        if (window.scrollY !== 0) {
            header.classList.add('header-scrolled')
        } else {
            header.classList.remove('header-scrolled')
        }
    };

    // Gọi hàm _headerScrolled khi scroll
    $(document).scroll(_headerScrolled);


    // tạo biến navbarMobileOn để check state
    let navbarMobileOn = false

    // Khi click vào nút mobile menu thì thêm xóa các class liên quan để 
    // hiển thị giao diện phù hợp
    $('.mobile-nav-toggle').click((e) => {
        let navbar = document.getElementById('navbar')
        navbar.classList.toggle('navbar-mobile')
        e.target.classList.toggle('fa-bars')
        e.target.classList.toggle('fa-times')

        let dropdownActives = document.querySelectorAll('.navbar .dropdown > a')
        dropdownActives.forEach(dropdownActive => {
            dropdownActive.nextElementSibling.classList.remove('dropdown-active')
        });

        let dropdownArrowsM = document.querySelectorAll('.navbar .dropdown .dropdown-icon-mobile')
        dropdownArrowsM.forEach(el => {
            //reset chiều icon
            el.classList.replace('fa-chevron-down', 'fa-chevron-right')
            let dropdown = el.parentElement
                // bắt click dropdown thay đổi icon
            $(dropdown).bind('click.changeArrow', e => {
                el.classList.toggle('fa-chevron-right')
                el.classList.toggle('fa-chevron-down')
            })
        })
    });

    // Bắt sự kiện click dropdown
    let dropdownActives = document.querySelectorAll('.navbar .dropdown > a')
    dropdownActives.forEach(dropdownActive => {
        $(dropdownActive).click(e => {
            if (e.target.nextElementSibling) {
                e.target.nextElementSibling.classList.toggle('dropdown-active')
            }
        });
    });
    let dropdownArrowsM = document.querySelectorAll('.navbar .dropdown .dropdown-icon-mobile')
    dropdownArrowsM.forEach(el => {
        // bắt click arrow để dropdown 
        $(el).bind('click', e => {
            el.parentElement.nextElementSibling.classList.toggle('dropdown-active')
        })
    })


    // Bắt sự kiện click vào các element có class scrollto để
    // scroll đến section cụ thể dựa vào hash của element
    // nếu đang trong phần navbar_mobile thì tắt đi rồi srcoll
    let scrollToElements = document.querySelectorAll('.scrollto')
    scrollToElements.forEach(scrollToElement => {
        $(scrollToElement).click(e => {
            if (e.target.hash !== undefined) {
                e.preventDefault()
                let hashElement = document.querySelector(e.target.hash)

                let navbar = document.getElementById('navbar')
                if (navbar.classList.contains('navbar-mobile')) {
                    navbar.classList.remove('navbar-mobile')

                    let navbarToggle = document.getElementsByClassName('mobile-nav-toggle')[0]
                    navbarToggle.classList.toggle('fa-bars')
                    navbarToggle.classList.toggle('fa-times')

                    let dropdownActives = document.querySelectorAll('.navbar .dropdown > a')
                    dropdownActives.forEach(dropdownActive => {
                        dropdownActive.nextElementSibling.classList.remove('dropdown-active')
                    });

                    // bỏ event listener đã bắt ở nút toggle menu khi nhấn section
                    let dropdownArrowsM = document.querySelectorAll('.navbar .dropdown .dropdown-icon-mobile')
                    dropdownArrowsM.forEach(el => {
                        let dropdown = el.parentElement
                        $(dropdown).unbind('click.changeArrow')
                    })
                }
                if (hashElement !== null) {
                    _scrollTo(hashElement)
                }
            }
        });
    });

    // Scroll tới hash của page khi vừa load lại
    _scrollTo(window.location.hash);

    //Ngừng scroll khi bật navbar-mobile
    $(document).scroll(e => {
        if (document.querySelector('.navbar-mobile') !== null) {
            _disableScroll();
        } else {
            _enableScroll();
        }
    });

    function _disableScroll() {
        window.onscroll = function() {
            window.scrollTo(0, 0);
        };
    }

    function _enableScroll() {
        window.onscroll = function() {};
    }


    // *******************************************************
    // ********** index.php
    // ******************************************************* 

    /*--------------------------------------------------------------
    # Poster slideshow
    --------------------------------------------------------------*/

    if (window.location.href == 'http://localhost:8080/') {
        let slideIndex = 1;

        // Hàm tăng giảm index và gọi lại _posterShowSlides(n)
        function _posterPlusSlides(n) {
            slideIndex += n;
            _posterShowSlides(slideIndex);
        }

        // Hàm chuyển đến slide dựa theo index
        function _posterShowSlides(n) {
            if (n > 4) {
                slideIndex = 1;
            } else if (n < 1) {
                slideIndex = 4;
            }
            document.getElementById('poster-radio' + slideIndex).checked = true;
        }

        // Khi nhấn vào nút control thì sẽ gọi hàm _posterPlusSlides(n)
        $('.next-btn').click(e => {
            _posterPlusSlides(1)
        });
        $('.prev-btn').click(e => {
            _posterPlusSlides(-1)
        });

        // Tự động slideshow
        setInterval(() => {
            slideIndex++;
            _posterShowSlides(slideIndex);
        }, 3000);
    };


    // *******************************************************
    // ********** view/Phim/PhimManagement.php
    // ******************************************************* 


    // Hiện tên khi select file
    $(".custom-file-input").on("change", function() {
        var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
    });

    // Hiện preview picture input
    $('#phim-poster-doc-input').change(evt => {
        let img = document.getElementById('phim-poster-doc-img-input');
        if ((evt.target).value == "") {
            img.src = ""
            $("#phim-poster-doc-input").siblings(".custom-file-label").removeClass("selected").html("Chọn poster dọc cho phim");
        } else {
            img.src = URL.createObjectURL(evt.target.files[0]);
        }
    });
    $('#phim-poster-ngang-input').change(evt => {
        let img = document.getElementById('phim-poster-ngang-img-input');
        if ((evt.target).value == "") {
            img.src = ""
            $("#phim-poster-ngang-input").siblings(".custom-file-label").removeClass("selected").html("Chọn poster ngang cho phim");
        } else {
            img.src = URL.createObjectURL(evt.target.files[0]);
        }
    });

    // Hiện preview picture update
    $('#phim-poster-doc-update').change(evt => {
        let img = document.getElementById('phim-poster-doc-img-update');
        if ((evt.target).value == "") {
            img.src = ""
            $("#phim-poster-doc-update").siblings(".custom-file-label").removeClass("selected").html("Chọn poster dọc cho phim");
        } else {
            img.src = URL.createObjectURL(evt.target.files[0]);
        }
    });
    $('#phim-poster-ngang-update').change(evt => {
        let img = document.getElementById('phim-poster-ngang-img-update');
        if ((evt.target).value == "") {
            img.src = ""
            $("#phim-poster-ngang-update").siblings(".custom-file-label").removeClass("selected").html("Chọn poster ngang cho phim");
        } else {
            img.src = URL.createObjectURL(evt.target.files[0]);
        }
    });

    // button clear form to clear img
    $("#phim-create-form .phim-clear-btn").click(e => {
        $("#phim-poster-ngang-input").val('');
        $("#phim-poster-ngang-img-input").attr('src', '');
        $("#phim-poster-ngang-input").siblings(".custom-file-label").removeClass("selected").html("Chọn poster ngang cho phim");
        $("#phim-poster-doc-input").val('');
        $("#phim-poster-doc-img-input").attr('src', '');
        $("#phim-poster-doc-input").siblings(".custom-file-label").removeClass("selected").html("Chọn poster dọc cho phim");
    });


    // Handle form tạo phim
    $('#phim-create-form').on('submit', function(e) {
        e.preventDefault();
        $("message_create_phim").css("display", "none");

        let form = new FormData(document.getElementById('phim-create-form'));

        form.append('ten_phim', $('#phim-name-input').val());
        form.append('nha_san_xuat', $('#phim-nsx-input').val());
        form.append('quoc_gia', $('#phim-nation-input').val());
        form.append('dien_vien', $('#phim-actor-input').val());
        form.append('dao_dien', $('#phim-director-input').val());
        form.append('the_loai', $('#phim-type-input').val());
        form.append('ngay_phat_hanh', $('#phim-ngay-phat-hanh-input').val());
        form.append('mo_ta', $('#phim-mo-ta-input').val());
        form.append('thoi_luong', $('#phim-time-input').val());

        var settings = {
            "url": "/api/Phim/PhimCreate.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        window.location.replace(`/view/Phim/PhimManagement.php?status=created`)
                    } else {
                        $("#message_create_phim").css("display", "block");
                        $("#message_create_phim").html(e.responseText);
                    };
                } else {
                    $("#message_create_phim").css("display", "block");
                    $("#message_create_phim").html(e.responseText);
                }
            }
        }
        $.ajax(settings);
        
    });

    // Handle xóa phim 
    let phimDeleteBtns = document.getElementsByClassName('phim-delete-btn');
    Array.from(phimDeleteBtns).forEach((btn) => {
        $(btn).click(e => {
            let id = $(btn).val();
            let tenPhim = $(btn.parentNode).siblings('.ten-phim-td').text();

            $('#phimDeleteModal .modal-body').html("Bạn có chắc chắn muốn xóa <b>" + tenPhim + "</b> chứ?");

            $('#phim-delete-confirm-btn').click(e => {
                var form = new FormData();
                form.append('phim_id', id);

                var settings = {
                    "url": "/api/Phim/PhimDelete.api.php",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form,
                    complete: function(e, xhr, settings) {
                        if (e.status === 200) {
                            if (e.responseText == "Success") {
                                window.location.replace(`/view/Phim/PhimManagement.php?status=deleted`)
                            } else {
                                $('#phimDeleteModal .modal-body').html(e.responseText);
                            };
                        } else {
                            $('#phimDeleteModal .modal-body').html(e.responseText);
                        }
                    }
                }
                $.ajax(settings);
            });
        });
    });

    // Handle chỉnh sửa phim
    let phimUpdateBtns = document.getElementsByClassName('phim-update-btn');
    Array.from(phimUpdateBtns).forEach((btn) => {
        $(btn).click(e => {
            let phimDetailInfo;
            let id = $(btn).val();
            $.ajax({
                type: "GET",
                dataType: "json",
                data: { 'phim-id': id },
                url: "/api/Phim/PhimGetDetail.api.php",
                success: function(data) {
                    phimDetailInfo = data;
                    $('#phim-name-update').val(data.ten_phim);
                    $('#phim-nsx-update').val(data.nha_san_xuat);
                    $('#phim-nation-update').val(data.quoc_gia);
                    $('#phim-actor-update').val(data.dien_vien);
                    $('#phim-director-update').val(data.dao_dien);
                    $('#phim-type-update').val(data.the_loai);
                    $('#phim-ngay-phat-hanh-update').val(data.ngay_phat_hanh);
                    $('#phim-mo-ta-update').val(data.mo_ta);
                    $('#phim-time-update').val(data.thoi_luong);
                    $("#phim-poster-doc-img-update").attr('src', data.poster_doc.image_content);
                    $("#phim-poster-doc-update").siblings(".custom-file-label").addClass("selected").html(data.poster_doc.image_content.slice(data.poster_doc.image_content.lastIndexOf('/') + 1 ));
                    $("#phim-poster-ngang-img-update").attr('src', data.poster_ngang.image_content);
                    $("#phim-poster-ngang-update").siblings(".custom-file-label").addClass("selected").html(data.poster_ngang.image_content.slice(data.poster_ngang.image_content.lastIndexOf('/') + 1 ));
                }
            });
            $('#phim-update-form').on('submit', function(e) {
                e.preventDefault();
                $("message_update_phim").css("display", "none");

                // if ($("#confirm-password").val() != $("#password").val()) {
                //     $("#message_signup").css("display", "block");
                //     $("#message_signup").html("Password mismatch");
                if (0) {} else {
                    let form = new FormData(document.getElementById('phim-update-form'));

                    form.append('phim_id', id);
                    form.append('ten_phim', $('#phim-name-update').val());
                    form.append('nha_san_xuat', $('#phim-nsx-update').val());
                    form.append('quoc_gia', $('#phim-nation-update').val());
                    form.append('dien_vien', $('#phim-actor-update').val());
                    form.append('dao_dien', $('#phim-director-update').val());
                    form.append('the_loai', $('#phim-type-update').val());
                    form.append('ngay_phat_hanh', $('#phim-ngay-phat-hanh-update').val());
                    form.append('mo_ta', $('#phim-mo-ta-update').val());
                    form.append('thoi_luong', $('#phim-time-update').val());
                    form.append('poster_doc_old_src', phimDetailInfo.poster_doc.image_content);
                    form.append('poster_ngang_old_src', phimDetailInfo.poster_ngang.image_content);

                    var settings = {
                        "url": "/api/Phim/PhimUpdate.api.php",
                        "method": "POST",
                        "timeout": 0,
                        "processData": false,
                        "mimeType": "multipart/form-data",
                        "contentType": false,
                        "data": form,
                        complete: function(e, xhr, settings) {
                            if (e.status === 200) {
                                if (e.responseText == "Success") {
                                    window.location.replace(`/view/Phim/PhimManagement.php`)
                                } else {
                                    $("#message_update_phim").css("display", "block");
                                    $("#message_update_phim").html(e.responseText);
                                };
                            } else {
                                $("#message_update_phim").css("display", "block");
                                $("#message_update_phim").html(e.responseText);
                            }
                        }
                    }
                    $.ajax(settings);
                }
            });
        });
    });

    // *******************************************************
    // ********** view/Users/UserDetail.php
    // *******************************************************
    // Function to handle change tab
    $(".tab").on("click", function() {
        $('.tab.active').removeClass('active');
        $('.tab-content').removeClass('tab-content-active');
        $(this).addClass("active");
        $(`.tab-content`).css("display", "none");
        $(`#${$(this).attr('id')}-content`).css("display", "block");
    })

    // Function to handle formart date time in ticket
    function _update_vephim_data(){
        $(".ve_phim_time_start").each(function(){
            let temp = $(this);
            let time = temp.attr("value");
            $(this).html(`START TIME: ${moment(time).format('dddd, MMMM Do YYYY, h:mm a')}`);
        });

        $(".ve_phim_time_end").each(function(){
            let temp = $(this);
            let time = temp.attr("value");
            $(this).html(`START TIME: ${moment(time).format('dddd, MMMM Do YYYY, h:mm a')}`);
        });

        $(".ve_phim_time_main").each(function(){
            let temp = $(this);
            let time = temp.attr("value");
            $(this).html(`  
                            <span class="time-main">${moment(time).format('D')}</span>
                            <span>${moment(time).format('M')}</span>
                            <span>${moment(time).format('YYYY')}</span>
                        `);
        });
    }
    
    // Excute the function
    _update_vephim_data();

    // *******************************************************
    // ********** view/Users/UserManagement.php
    // *******************************************************
    // Handle disable user 
    let userDeleteBtns = document.getElementsByClassName('user-delete-btn');
    Array.from(userDeleteBtns).forEach((btn) => {
        $(btn).click(e => {
            let id = $(btn).val();
            let tenPhim = $(btn.parentNode).siblings('.ten-phim-td').text();

            $('#phimDeleteModal .modal-body').html("Bạn có chắc là muốn xóa <b>" + tenPhim + "</b> chứ?");

            $('#user-delete-confirm-btn').click(e => {
                var form = new FormData();
                form.append('user_id', id);

                var settings = {
                    "url": "/api/User/UserDisable.api.php",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form,
                    complete: function(e, xhr, settings) {
                        if (e.status === 200) {
                            if (e.responseText == "Success") {
                                window.location.replace(`/view/Users/UserManagement.php?status=deleted`)
                            } else {
                                $('#phimDeleteModal .modal-body').html(e.responseText);
                            };
                        } else {
                            $('#phimDeleteModal .modal-body').html(e.responseText);
                        }
                    }
                }
                $.ajax(settings);
            });
        });
    });
  
    // *******************************************************
    // ********** view/LichChieu/LichChieuManagement.php
    // *******************************************************

    // Function to hanlde create session
    $('#session_create_form').on('submit', function(e) {
        e.preventDefault();
        $("#message_session_danger").css("display", "none");
        let form = new FormData();

        if(new Date($('#gio_bat_dau').val()).getTime() >= new Date($('#gio_ket_thuc').val()).getTime()){
            $("#message_session_danger").css("display", "block");
            $("#message_session_danger").html("Giờ kết thúc phải lớn hơn giờ bắt đầu");
            return;
        }

        form.append('phim_id', $('#phim_id').val());
        form.append('phong_chieu_id', $('#phong_chieu_id').val());
        form.append('gio_bat_dau', $('#gio_bat_dau').val());
        form.append('gio_ket_thuc', $('#gio_ket_thuc').val());
        form.append('gia', $('#gia').val());

        var settings = {
            "url": "/api/LichChieu/LichChieuCreate.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        window.location.replace(`${window.location.pathname}?status=created`)
                    } else {
                        $("#message_session_danger").css("display", "block");
                        $("#message_session_danger").html(e.responseText);
                    };
                } else {
                    $("#message_session_danger").css("display", "block");
                    $("#message_session_danger").html(e.responseText);
                }
            }
        }

        $.ajax(settings);
    });

    // Function to handle formart datetime for session
    function _update_lichchieu_datetime(){
        $(".datetime").each(function(){
            let temp = $(this);
            let time = temp.attr("value");
            let formated_time = moment(time).format('DD/MM/YYYY HH:mm');
            $(this).html(formated_time);
        });
    }

    // Excute the function
    _update_lichchieu_datetime();

    // Function to handle delete session
    $("#delete_session_confirm_btn").click(function() {
        $("#message_session_danger").css("display", "none");
        
        let form = new FormData();
        form.append('lich_chieu_id', selected_session);

        var settings = {
            "url": "/api/LichChieu/LichChieuDelete.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        window.location.replace(`${window.location.pathname}?status=deleted`)
                    } else {
                        $("#message_session_danger").css("display", "block");
                        $("#message_session_danger").html(e.responseText);
                    };
                } else {
                    $("#message_session_danger").css("display", "block");
                    $("#message_session_danger").html(e.responseText);
                }
            }
        }

        $.ajax(settings);
    });

    // Function to handle filter
    $('#session_film_filter').on('change', function() {
        if(this.value == 'ALL'){
            window.location.replace(`${window.location.pathname}`);
        }else{
            window.location.replace(`${window.location.pathname}?film=${this.value}`);
        }
    });
  
    // *******************************************************
    // ********** view/PhongChieu/PhongChieuManagement.php
    // *******************************************************

    // Handle form tạo phòng chiếu
    $('#phong-create-form').on('submit', function(e) {
        e.preventDefault();
        $("#message_create_phong").css("display", "none");

        var form = new FormData();
        form.append('ten_phong', $('#phong-name-input').val());

        var settings = {
            "url": "/api/PhongChieu/PhongChieuCreate.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        window.location.replace(`${window.location.pathname}?status=created`);
                    } else {
                        $("#message_create_phong").css("display", "block");
                        $("#message_create_phong").html(e.responseText);
                    };
                } else {
                    $("#message_create_phong").css("display", "block");
                    $("#message_create_phong").html(e.responseText);
                }
            }
        }
        $.ajax(settings);
    });

    // Handle chỉnh sửa phòng chiếu
    let phongUpdateBtns = document.getElementsByClassName('update-phong-btn');
    Array.from(phongUpdateBtns).forEach((btn) => {
        $(btn).click(e => {
            let phongDetailInfo;
            let id = $(btn).val();
            $.ajax({
                type: "GET",
                dataType: "json",
                data: { 'phong_chieu_id': id },
                url: "/api/PhongChieu/PhongChieuGetDetail.api.php",
                success: function(data) {
                    phongDetailInfo = data;
                    $('#phong-name-update').val(data.ten_phong);
                }
            });
            $('#phong-update-form').on('submit', function(e) {
                e.preventDefault();
                $("#message_update_phong").css("display", "none");
                
                var form = new FormData();
                form.append('phong_chieu_id', id);
                form.append('ten_phong', $('#phong-name-update').val());

                var settings = {
                    "url": "/api/PhongChieu/PhongChieuUpdate.api.php",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form,
                    complete: function(e, xhr, settings) {
                        if (e.status === 200) {
                            if (e.responseText == "Success") {
                                window.location.replace(`/view/PhongChieu/PhongChieuManagement.php`)
                            } else {
                                $("#message_update_phong").css("display", "block");
                                $("#message_update_phong").html(e.responseText);
                            };
                        } else {
                            $("#message_update_phong").css("display", "block");
                            $("#message_update_phong").html(e.responseText);
                        }
                    }
                }
                $.ajax(settings);
            });
        });
    });

    // Handle xóa phòng chiếu
    let roomDeleteBtns = document.getElementsByClassName('delete-phong-btn');
    Array.from(roomDeleteBtns).forEach((btn) => {
        $(btn).click(e => {
            $("#message_delete_phong").css("display", "none");

            $('#phong-delete-confirm-btn').click(function() {
                $("#message_delete_phong").css("display", "none");
        
                var form = new FormData();
                form.append('phong_chieu_id', selected_room);
        
                var settings = {
                    "url": "/api/PhongChieu/PhongChieuDelete.api.php",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form,
                    complete: function(e, xhr, settings) {
                        if (e.status === 200) {
                            if (e.responseText == "Success") {
                                window.location.replace(`${window.location.pathname}?status=deleted`);
                            } else {
                                $("#message_delete_phong").css("display", "block");
                                $("#message_delete_phong").html("Some thing went wrong, please try again later");
                            };
                        } else {
                            $("#message_delete_phong").css("display", "block");
                            $("#message_delete_phong").html(e.responseText);
                        }
                    }
                }
                $.ajax(settings);
            });
        });
    });
                       
    // *******************************************************
    // ********** view/Ve/VeCreate.php
    // *******************************************************

    // Function to handle formart date for session
    function _update_date_format(){
        $(".date_format").each(function(){
            let temp = $(this);
            let time = temp.attr("value");
            let formated_time = moment(time).format('DD/MM/YYYY');
            $(this).html(formated_time);
        });
    }

    // Function to init default value for list time
    function _init_session_time_list(){
        let date_start = $("#select-lich").val();
        var settings = {
            "url": `/api/LichChieu/LichChieuGetByFilmAndDateStart.api.php?phim_id=${getUrlParameter('phim_id')}&date_start=${date_start}`,
            "method": "GET",
            "timeout": 0,
            complete: function(e, xhr, settings) {
                let list_time_start =  JSON.parse(e.responseText);
                let htmlStr = ``;
                for(let i in list_time_start){
                    let tmp = list_time_start[i];
                    
                    htmlStr += `<div class="lich-chieu-item gio_chieu_item text-center time_format" onclick="_update_seat(${tmp['lich_chieu_id']})" value='${tmp['lich_chieu_id']}' date="${tmp['gio_bat_dau']}" time="${tmp['gio_chieu']}" room="${tmp['ten_phong']}" price="${tmp['gia']}">${moment(tmp['gio_chieu'], ['h:m a', 'H:m']).format("HH:mm")} - ${moment(tmp['gio_chieu_xong'], ['h:m a', 'H:m']).format("HH:mm")} ${tmp['ten_phong']}</div>`;
                }
                $("#list-gio-chieu").html(htmlStr);
            }
        }

        $.ajax(settings);
    }

    // Excute the function
    _init_session_time_list();

    // Excute the function
    _update_date_format();

    // Function to handle update session time
    $('#select-lich').on('change', function() {
        var settings = {
            "url": `/api/LichChieu/LichChieuGetByFilmAndDateStart.api.php?phim_id=${getUrlParameter('phim_id')}&date_start=${this.value}`,
            "method": "GET",
            "timeout": 0,
            complete: function(e, xhr, settings) {
                let list_time_start =  JSON.parse(e.responseText);
                let htmlStr = ``;
                for(let i in list_time_start){
                    let tmp = list_time_start[i];
                    htmlStr += `<div class="lich-chieu-item gio_chieu_item text-center time_format" onclick="_update_seat(${tmp['lich_chieu_id']})" value='${tmp['lich_chieu_id']}' date="${tmp['gio_bat_dau']}" time="${tmp['gio_chieu']}" room="${tmp['ten_phong']}" price="${tmp['gia']}">${moment(tmp['gio_chieu'], ['h:m a', 'H:m']).format("HH:mm")} - ${moment(tmp['gio_chieu_xong'], ['h:m a', 'H:m']).format("HH:mm")} ${tmp['ten_phong']}</div>`;
                }
                $("#list-gio-chieu").html(htmlStr);
                $("#select-ghe").html("");
            }
        }

        $.ajax(settings);
    });

    // Function to add class for gio_chieu when clicked
    $(document).on('click', ".gio_chieu_item", function() {
        $(".gio_chieu_item").removeClass("time-selected");
        $(this).addClass("time-selected");  
    });

    //
    $("#create-ve-confirm__btn").click(function() {
        $("#message_ticket_danger").css("display","none");
        
        let lich_chieu_id = $(".time-selected").first().attr("value");
        let ghe_id = $("#select-ghe").val();

        let form = new FormData();
        form.append('lich_chieu_id', lich_chieu_id);
        form.append('ghe_id', ghe_id);

        var settings = {
            "url": "/api/VePhim/VePhimCreate.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        _update_ve_success();
                        $(".confirm-ve").css("display","none");
                        $("#veSuccess").modal('show');
                    } else {
                        $("#message_ticket_danger").css("display", "block");
                        $("#message_ticket_danger").html(e.responseText);
                    };
                } else {
                    $("#message_ticket_danger").css("display", "block");
                    $("#message_ticket_danger").html(e.responseText);
                }
            }
        }

        $.ajax(settings);
    });


    // *******************************************************
    // ********** view/Ghe/GheManagement.php
    // *******************************************************

    // Handle form tạo ghế
    $('#ghe-create-form').on('submit', function(e) {
        e.preventDefault();
        $("#message_create_ghe").css("display", "none");

        var form = new FormData();
        form.append('ma_ghe', $('#ghe-name-input').val());
        form.append('phong_chieu_id', $('#select-phong-existed').val());

        var settings = {
            "url": "/api/Ghe/GheCreate.api.php",
            "method": "POST",
            "timeout": 0,
            "processData": false,
            "mimeType": "multipart/form-data",
            "contentType": false,
            "data": form,
            complete: function(e, xhr, settings) {
                if (e.status === 200) {
                    if (e.responseText == "Success") {
                        window.location.replace(`${window.location.pathname}?status=created`);
                    } else {
                        $("#message_create_ghe").css("display", "block");
                        $("#message_create_ghe").html(e.responseText);
                    };
                } else {
                    $("#message_create_ghe").css("display", "block");
                    $("#message_create_ghe").html(e.responseText);
                }
            }
        }
        $.ajax(settings);
    });

    // Handle xóa ghế
    let gheDeleteBtns = document.getElementsByClassName('delete-ghe-btn');
    Array.from(gheDeleteBtns).forEach((btn) => {
        $(btn).click(e => {
            $("#message_delete_ghe").css("display", "none");

            $('#ghe-delete-confirm-btn').click(function() {
                $("#message_delete_ghe").css("display", "none");
        
                var form = new FormData();
                form.append('ghe_id', selected_ghe);
        
                var settings = {
                    "url": "/api/Ghe/GheDelete.api.php",
                    "method": "POST",
                    "timeout": 0,
                    "processData": false,
                    "mimeType": "multipart/form-data",
                    "contentType": false,
                    "data": form,
                    complete: function(e, xhr, settings) {
                        if (e.status === 200) {
                            if (e.responseText == "Success") {
                                window.location.replace(`${window.location.pathname}?status=deleted`);
                            } else {
                                $("#message_delete_ghe").css("display", "block");
                                $("#message_delete_ghe").html("Some thing went wrong, please try again later");
                            };
                        } else {
                            $("#message_delete_ghe").css("display", "block");
                            $("#message_delete_ghe").html(e.responseText);
                        }
                    }
                }
                $.ajax(settings);
            });
        });
    });
});

let selected_session = null;

function _set_selected_session(session_id){
    selected_session = session_id;
    $("#modal_delete_msg").html(` Bạn có chắc chắn muốn xóa lịch chiếu có mã lịch chiếu <b>${selected_session}</b>, hành động này sẽ xóa luôn tất cả các vé của suất này?`)
}

let selected_room = null;

function _set_selected_room(room_id){
    selected_room = room_id;
    $("#room_delete_msg").html(`Bạn có chắc chắn muốn xóa <b> Phòng chiếu ${selected_room}</b>, hành động này sẽ xóa luôn tất cả các lịch chiếu của phòng này?`)
}

let selected_ghe = null;

function _set_selected_ghe(ghe_id){
    selected_ghe = ghe_id;
    $("#ghe_delete_msg").html(`Bạn có chắc chắn muốn xóa <b> Ghế ${selected_ghe}</b>, hành động này sẽ xóa luôn ghế trong tất cả các vé trong quá khứ?`)
}

// Function to get url params
function getUrlParameter(sParam) {
    var sPageURL = window.location.search.substring(1),
        sURLVariables = sPageURL.split('&'),
        sParameterName,
        i;

    for (i = 0; i < sURLVariables.length; i++) {
        sParameterName = sURLVariables[i].split('=');

        if (sParameterName[0] === sParam) {
            return sParameterName[1] === undefined ? true : decodeURIComponent(sParameterName[1]);
        }
    }
    return false;
};


// *******************************************************
// ********** view/Ve/VeCreate.php
// *******************************************************

// Function to handle update seat
function _update_seat(session_id) {
    var settings = {
        "url": `/api/Ghe/GetEmptySeat.api.php?session_id=${session_id}`,
        "method": "GET",
        "timeout": 0,
        complete: function(e, xhr, settings) {
            let list_empty_seat =  JSON.parse(e.responseText);
            let htmlStr = ``;
            for(let i in list_empty_seat){
                let tmp = list_empty_seat[i];
                htmlStr += `<option value="${tmp['ghe_id']}"> ${tmp['ma_ghe']}</option>`
            }
            $("#select-ghe").html(htmlStr);
        }
    }

    $.ajax(settings);
};

// Hide confirm modal
function _hide_confirm_modal(){
    $(".confirm-ve").css("display","none");
}

// Validate + Update + Show confirm modal
function _show_confirm_modal(){
    $("#message_ticket_danger").css("display","none");
    
    let lich_chieu_id = $(".time-selected").first().attr("value");
    let gio_bat_dau = moment($(".time-selected").first().attr("time"), ['h:m a', 'H:m']).format("HH:mm");
    let ngay_bat_dau = moment($(".time-selected").first().attr("date")).format("DD-MM-YYYY");
    let ten_phong_chieu = $(".time-selected").first().attr("room");
    let price = $(".time-selected").first().attr("price");
    let seat = $("#select-ghe option:selected").text();
    let seat_id = $("#select-ghe").val();

    if(lich_chieu_id == undefined || gio_bat_dau == undefined || ngay_bat_dau == undefined || ten_phong_chieu == undefined || seat == undefined || seat_id == undefined || price == undefined){
        $("#message_ticket_danger").html("Vui lòng điền đầy đủ thông tin");
        $("#message_ticket_danger").css("display","block");
        return;
    }
    $(".confirm-ve").css("display","block");

    $("#ve-detail-date").html(ngay_bat_dau);
    $("#ve-detail-time").html(gio_bat_dau);
    $("#ve-detail-phong").html(ten_phong_chieu);
    $("#ve-detail-seat").html(seat);
    $("#ve-price").html(price);
    $("#final-price").html(price);
}

// Function to update veSuccess data
function _update_ve_success(){
    let gio_bat_dau = moment($(".time-selected").first().attr("time"), ['h:m a', 'H:m']).format("HH:mm");
    let ngay_bat_dau = moment($(".time-selected").first().attr("date")).calendar();
    let ten_phong_chieu = $(".time-selected").first().attr("room");
    let seat = $("#select-ghe option:selected").text();

    $("#ve-success-date").html(ngay_bat_dau);
    $("#ve-success-time").html(gio_bat_dau);
    $("#ve-success-room").html(ten_phong_chieu);
    $("#ve-success-seat").html(seat);
}
