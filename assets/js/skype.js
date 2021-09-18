jQuery(document).ready(function ($) {
  $('.wb_cta_skype_close').on('click', function() {
    $('.wb_cta_skype_message_window').fadeOut();
  });

  $('.scs_open_skype_chatbox').on('click', function() {
      $('.wb_cta_skype_message_window').fadeIn();
  });

  $('.wb_cta_skype_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var skypeId = $('#snc_skype_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var skypeId = $('#snc_skype_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var skypeId = $('#snc_skype_name3').val(); 
      } else {
        var skypeId = $('#snc_skype_name').val();
      }
  
      var url = $('#snc_skype_url').val() + skypeId + '?chat';
  
      window.open(url, '_blank');
  
      $('.wb_cta_skype_message_window').fadeOut();
  });
});