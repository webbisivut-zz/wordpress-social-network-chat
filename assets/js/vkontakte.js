jQuery(document).ready(function ($) {
  $('.wb_cta_vkontakte_close').on('click', function() {
    $('.wb_cta_vkontakte_message_window').fadeOut();
  });

  $('.scs_open_vkontakte_chatbox').on('click', function() {
      $('.wb_cta_vkontakte_message_window').fadeIn();
  });

  $('.wb_cta_vkontakte_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var vkontakteId = $('#snc_vkontakte_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var vkontakteId = $('#snc_vkontakte_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var vkontakteId = $('#snc_vkontakte_name3').val(); 
      } else {
        var vkontakteId = $('#snc_vkontakte_name').val();
      }
  
      var url = $('#snc_vkontakte_url').val() + vkontakteId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_vkontakte_message_window').fadeOut();
  });
});