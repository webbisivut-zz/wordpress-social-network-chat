jQuery(document).ready(function ($) {
    $('.wb_cta_btn').on('click', function() {
        $('#wb_cta_wrap_relative').fadeOut();

        if ($('.wb_cta_btn_chat').find("i").hasClass("fa-times")) {
            $('.wb_cta_btn_chat').find("i").removeClass("fa-times");
            $('.wb_cta_btn_chat').find("i").addClass("fa-comment-dots");
            $('.wb_cta_btn_chat').find("i").removeClass("wb_cta_btn_chat_spin_right");
            $('.wb_cta_btn_chat').find("i").addClass("wb_cta_btn_chat_spin_left");
        }
    });

    $('.wb_cta_btn_chat').on('click', function() {
        if($('#wb_cta_wrap_relative').is(":visible")) {
            $('#wb_cta_wrap_relative').fadeOut();
        } else {
            $('#wb_cta_wrap_relative').fadeIn();
        }

        if ($(this).find("i").hasClass("fa-comment-dots")) {
            $(this).find("i").removeClass("fa-comment-dots");
            $(this).find("i").addClass("fa-times");
            $(this).find("i").removeClass("wb_cta_btn_chat_spin_left");
            $(this).find("i").addClass("wb_cta_btn_chat_spin_right");
        } else if ($(this).find("i").hasClass("fa-times")) {
            $(this).find("i").removeClass("fa-times");
            $(this).find("i").addClass("fa-comment-dots");
            $(this).find("i").removeClass("wb_cta_btn_chat_spin_right");
            $(this).find("i").addClass("wb_cta_btn_chat_spin_left");
        }
        
    });
});