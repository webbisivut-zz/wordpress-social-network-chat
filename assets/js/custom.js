jQuery(document).ready(function ($) {
  $('.wb_cta_custom_close').on('click', function() {
    $('.wb_cta_custom_message_window').fadeOut();
  });

  $('.scs_open_custom_chatbox').on('click', function() {
      $('.wb_cta_custom_message_window').fadeIn();
  });

  $('.wb_cta_custom_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var customId = $('#snc_custom_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var customId = $('#snc_custom_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var customId = $('#snc_custom_name3').val(); 
      } else {
        var customId = $('#snc_custom_name').val();
      }
  
      var url = $('#snc_custom_url').val() + '/' + customId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_custom_message_window').fadeOut();
  });
});