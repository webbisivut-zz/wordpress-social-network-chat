jQuery(document).mouseup(function(e) {
    var container = jQuery('.wb_cta_message_window');
    var container2 = jQuery('.wb_cta_whatsapp_message_window');
    var container3 = jQuery('.wb_cta_line_message_window');
    var container4 = jQuery('.wb_cta_telegram_message_window');
    var container5 = jQuery('.wb_cta_facebook_message_window');
    var container6 = jQuery('.wb_cta_vkontakte_message_window');
    var container7 = jQuery('.wb_cta_email_message_window');
    var container8 = jQuery('.wb_cta_phone_message_window');
    var container9 = jQuery('.wb_cta_skype_message_window');
    var container10 = jQuery('.wb_cta_viber_message_window');

    if (!container.is(e.target) && container.has(e.target).length === 0) {
        container.fadeOut();
    }

    if (!container2.is(e.target) && container2.has(e.target).length === 0) {
        container2.fadeOut();
    }

    if (!container3.is(e.target) && container3.has(e.target).length === 0) {
        container3.fadeOut();
    }

    if (!container4.is(e.target) && container4.has(e.target).length === 0) {
        container4.fadeOut();
    }

    if (!container5.is(e.target) && container5.has(e.target).length === 0) {
        container5.fadeOut();
    }

    if (!container6.is(e.target) && container6.has(e.target).length === 0) {
        container6.fadeOut();
    }

    if (!container7.is(e.target) && container7.has(e.target).length === 0) {
        container7.fadeOut();
    }

    if (!container8.is(e.target) && container8.has(e.target).length === 0) {
        container8.fadeOut();
    }

    if (!container9.is(e.target) && container9.has(e.target).length === 0) {
        container9.fadeOut();
    }

    if (!container10.is(e.target) && container10.has(e.target).length === 0) {
        container10.fadeOut();
    }
});

jQuery(document).ready(function ($) {
    $('.wb_cta_btn_chat_shortcode').mouseenter(function() {
        var id = $(this).attr('id');
    
        var elem = $('#wrap_' + id);
        var height = elem.height();
    
        $(elem).css('margin-top', '-' + height * 1.5 + 'px');
        $(elem).fadeIn();
        
        $('.wb_cta_popup_window').fadeOut();
    });
    
    $('body').on('click', function() {
        $('.wb_cta_contact_buttons_shortcode_wrap').fadeOut();
    });

    $('.wb_cta_close_bubble').on('click', function() {
        $('.social-network-speech-bubble').fadeOut();
    });
});