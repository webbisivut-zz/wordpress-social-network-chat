jQuery(document).ready(function ($) {
  $('.wb_cta_email_close').on('click', function() {
    $('.wb_cta_email_message_window').fadeOut();
  });

  $('.wb_cta_input_email_submit').on('click', function() {
    var chosenAgent = $('#snc_email_chosen_agent').val();
    
    if(chosenAgent == 'snc_agent1') {
      var chosenMail = $('#snc_email_name').val(); 
    } else if(chosenAgent == 'snc_agent2') {
      var chosenMail = $('#snc_email_name2').val(); 
    } else if(chosenAgent == 'snc_agent3') {
      var chosenMail = $('#snc_email_name3').val(); 
    } else {
      var chosenMail = $('#snc_email_name').val();
    }
      
    var mail = $('#wb_cta_input_mail').val();
    var readyToSend = true;

    if(!isEmail(mail)) {
      $('.wb_cta_error_in_email').show();
      readyToSend = false;
      
      setTimeout(function() {
          $('.wb_cta_error_in_email').fadeOut();
      }, 2000);
    }

    var message = $('#wb_cta_input_textarea').val();
    
    var dataObj = {};
    dataObj['message'] = message;
    dataObj['mail'] = mail;
    dataObj['chosenMail'] = chosenMail;

    var dataToSend = JSON.stringify(dataObj);

    var data = {
      'action': 'wb_cta_send_mail',
      'sendData': dataToSend
        };
        
        if(readyToSend) {
            $(this).hide();
            $('.wb_cta_loader').show();

            data = $(this).serialize() + '&' + $.param(data);
            $.ajax({
                type: 'POST',
                url: wbCtaAjax.ajaxurl,
                data: data,
                success: function(data) {
                    $('.wb_cta_success').show();

                    $('.wb_cta_input_email_submit').show();
                    $('.wb_cta_loader').hide();

                    $('#wb_cta_input_mail').val('');
                    $('#wb_cta_input_textarea').val('');

                    setTimeout(function() {
                        $('.wb_cta_success').fadeOut();
                    }, 2000);

                },
                error: function (jqXHR, exception) {
                    var msg = 'Virhe: Uncaught Error.\n' + jqXHR.responseText;
                    $('.pt_check_status').html(msg);
                }
            });
            return false;
        }
    });

    function isEmail(email) {
        var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        return regex.test(email);
    };

    $('.wb_cta_email_message_agent_wrap_inner').on('click', function() {
        var id = $(this).attr('id');
        $('#snc_email_chosen_agent').val(id);

        $('.wb_cta_email_message_agent_wrap_inner').removeClass("wb_cta_email_message_agent_wrap_inner_border");

        $(this).addClass('wb_cta_email_message_agent_wrap_inner_border');

        $('.wb_cta_email_message_agent_wrap_inner').each(function(i, obj) {
          if( !$(this).hasClass('wb_cta_email_message_agent_wrap_inner_border') ) {
            $(this).hide();
            $('#wb_cta_input_form_wrap').fadeIn();
          }
        });
      
    });

    $('.scs_open_email_chatbox').on('click', function() {
        $('.wb_cta_email_message_window').fadeIn();
        
        $('.wb_cta_email_message_agent_wrap_inner').each(function(i, obj) {
          if( $(this).hasClass('wb_cta_email_message_agent_wrap_inner_border') ) {
            $(this).removeClass('wb_cta_email_message_agent_wrap_inner_border');

            $('#wb_cta_input_form_wrap').hide();
          }

          $(this).show();
        });
    });

});