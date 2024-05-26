jQuery(function ajaxRequestToServer($) {
    // custom select start
    function customSelectFun() {
        var uniCustomSelect = $('.custom-select-wrapper');
        uniCustomSelect.each(function() {
            var thisCustomSelect = $(this),
                options = thisCustomSelect.find('option'),
                firstOptionText = options.first().text();
            var selectedItem = $('<div></div>', {
                class: 'selected-item'
            }).appendTo(thisCustomSelect).text(firstOptionText);
            var allItems = $('<div></div>', {
                class: 'all-items all-items-hide'
            }).appendTo(thisCustomSelect);

            options.each(function() {
                var that = $(this),
                    optionText = that.text();
                //  optionValue = that.val();

                var thatValue = $(this),
                    optionValue = that.val();
                //console.log(that.val());
                var item = $('<div></div>', {
                    class: 'item',
                    value: optionValue,
                    on: {
                        click: function() {
                            var selectedOptionText = that.text();
                            selectedItem.text(selectedOptionText).removeClass('arrowanim');
                            allItems.addClass('all-items-hide');

                            // custom for move label
                            uniCustomSelect.addClass('move-label-top');
                        }
                    }
                }).appendTo(allItems).text(optionText);
            });
        });
        var selectedItem = $('.selected-item'),
            allItems = $('.all-items');
        selectedItem.on('click', function(e) {
            var currentSelectedItem = $(this),
                currentAllItems = currentSelectedItem.next('.all-items');
            allItems.not(currentAllItems).addClass('all-items-hide');
            selectedItem.not(currentSelectedItem).removeClass('arrowanim');
            currentAllItems.toggleClass('all-items-hide');
            currentSelectedItem.toggleClass('arrowanim');



            e.stopPropagation();
        });
        $(document).on('click', function() {
            var opened = $('.all-items:not(.all-items-hide)'),
                index = opened.parent().index();
            uniCustomSelect.eq(index).find('.all-items').addClass('all-items-hide');
            uniCustomSelect.eq(index).find('.selected-item').removeClass('arrowanim');
        });
    }
    customSelectFun();

    $('.like-btn').click(function(e) {
        let data = new FormData();
        let current_post_id_front = $('.post-id-value').val();
        // let current_user_name_front = $('.current-user-name-value').val();
        data.append('action', 'plugin_user_like'); // action hook name
        data.append('currentPostIDFront', current_post_id_front);

        $.ajax({
            url: global_vars.adminURL,
            data: data,
            type: "POST",
            contentType: false,
            processData: false,

            success: function(response) {
                $('.btn-like-01').addClass('liked');
                $('.btn-like-01').removeClass('like-btn');
                setTimeout(() => {
                    location.reload();
                }, 200);
                console.log('tamam');
            },
            error: function() {
                $(".errorMessage").addClass("open");
                $(".errorMessage").text('حدث خطآ في الاتصال');
            },

        });
    });

    $('.liked').click(function(e) {
        let data = new FormData();
        let current_post_id_front = $('.post-id-value').val();
        // let current_user_name_front = $('.current-user-name-value').val();
        data.append('action', 'remove_user_like'); // action hook name
        data.append('currentPostIDFront', current_post_id_front);

        $.ajax({
            url: global_vars.adminURL,
            data: data,
            type: "POST",
            contentType: false,
            processData: false,

            success: function(response) {
                console.log(response);
                $('.btn-like-01').removeClass('liked');
                $('.btn-like-01').addClass('like-btn');
                setTimeout(() => {
                    location.reload();
                }, 200);
                console.log('tamam');
            },
            error: function() {
                $(".errorMessage").addClass("open");
                $(".errorMessage").text('حدث خطآ في الاتصال');
            },

        });
    });

    $('.add-comment-btn').click(function() {
        //$('#comments-list').change(function(){
        let current_post_id_front = $('.post-id-value').val();
        let selected_comment_value_front = $('#comments-list').children("option:selected").val();
        let selected_comment_text_front = $('#comments-list').children("option:selected").text();

        let data = new FormData();
        // console.log(selected_comment_text_front);

        data.append('action', 'plugin_user_comment'); // action hook name
        data.append('currentPostIDFront', current_post_id_front);
        data.append('selectedCommentValue', selected_comment_value_front);
        data.append('selectedCommentText', selected_comment_text_front);

        $.ajax({
            url: global_vars.adminURL,
            data: data,
            type: "POST",
            contentType: false,
            processData: false,

            success: function(response) {
                console.log(response);
                console.log("tamam");
                // $('.btn-like-01').toggleClass('liked');
                if (response == 'true') {
                    // $('.errorMessage').text('جاري تسجيل البيانات');
                    // $('.user-number').text('open');
                    // $('.user-img').text('open');
                    // $('.user-comment').text(selected_comment_text_front)

                    setTimeout(() => {
                        location.reload();
                    }, 500);
                    console.log('tamam');
                } else {
                    $('.errorMessage').text('حدث خطآ في الاتصال');
                }

            },
            error: function() {
                $('.errorMessage').addClass('open');
                $('.errorMessage').text('حدث خطآ في الاتصال');
            },

        });
    });

    // $('#comments-list').click(function(e) {
    //     let data = new FormData();
    //     let current_post_id_front = $('.post-id-value').val();
    //     let current_comment_value_front = $('#comments-list:selected').val();
    //     console.log(current_comment_value_front);
    //     data.append('action', 'plugin_user_comment'); // action hook name
    //     data.append('currentPostIDFront', current_post_id_front);

    //     $.ajax({
    //         url: global_vars.adminURL,
    //         data: data,
    //         type: "POST",
    //         contentType: false,
    //         processData: false,

    //         success: function(response) {
    //             console.log(response);
    //             console.log("tamam");
    //             $('.btn-like-01').toggleClass('liked');
    //             // if (response == "true") {
    //             //     $(".errorMessage").addClass("open");
    //             //     $(".errorMessage").text("جاري تسجيل البيانات");

    //             //     setTimeout(() => {
    //             //         $(".errorMessage").fadeOut("slow");
    //             //     }, 3000);
    //             //     console.log("tamam");
    //             // } else {
    //             //     $(".errorMessage").text("تم تسجيل طلب الحضور علي هذا الرقم من قبل");
    //             // }

    //         },
    //         error: function() {
    //             $(".errorMessage").addClass("open");
    //             $(".errorMessage").text('حدث خطآ في الاتصال');
    //         },

    //     });
    // });


});