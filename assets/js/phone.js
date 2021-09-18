jQuery(document).ready(function ($) {
  $('.wb_cta_phone_close').on('click', function() {
    $('.wb_cta_phone_message_window').fadeOut();
  });

  $('.scs_open_phone_chatbox').on('click', function() {
      $('.wb_cta_phone_message_window').fadeIn();
  });

  $('.wb_cta_phone_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var phoneId = $('#snc_phone_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var phoneId = $('#snc_phone_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var phoneId = $('#snc_phone_name3').val(); 
      } else {
        var phoneId = $('#snc_phone_name').val();
      }
  
      var url = $('#snc_phone_url').val() + phoneId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_phone_message_window').fadeOut();
  });
});