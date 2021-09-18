jQuery(document).ready(function ($) {
  $('.wb_cta_facebook_close').on('click', function() {
    $('.wb_cta_facebook_message_window').fadeOut();
  });

  $('.scs_open_facebook_chatbox').on('click', function() {
      $('.wb_cta_facebook_message_window').fadeIn();
  });

  $('.wb_cta_facebook_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var facebookId = $('#snc_facebook_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var facebookId = $('#snc_facebook_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var facebookId = $('#snc_facebook_name3').val(); 
      } else {
        var facebookId = $('#snc_facebook_name').val();
      }
  
      var url = $('#snc_facebook_url').val() + facebookId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_facebook_message_window').fadeOut();
  });
});