jQuery(document).ready(function ($) {
    $('.wb_cta_btn').on('click', function() {
        var id = $(this).attr('id');

        if(id == 'wb_cta_chat') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Chat button');
            }
        }

        if(id == 'wb_cta_email') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Email');
            }
        }

        if(id == 'wb_cta_phone') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Phone');
            }
        }

        if(id == 'wb_cta_whatsapp') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'WhatsApp');
            }
        }

        if(id == 'wb_cta_line') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'LINE');
            }
        }

        if(id == 'wb_cta_viber') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Viber');
            }
        }

        if(id == 'wb_cta_wechat') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'WeChat');
            }
        }

        if(id == 'wb_cta_skype') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Skype');
            }
        }

        if(id == 'wb_cta_telegram') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Telegram');
            }
        }

        if(id == 'wb_cta_vk') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'VKontakte');
            }
        }

        if(id == 'wb_cta_facebook') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Facebook Messenger');
            }
        }

        if(id == 'wb_cta_custom') {
            if(typeof ga != 'undefined') {
                ga('send', 'event', 'Social Media Chat Contact', 'Custom button');
            }
        }
        
    });
});