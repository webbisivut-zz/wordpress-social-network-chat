jQuery(document).ready(function ($) {
  $('.wb_cta_telegram_close').on('click', function() {
    $('.wb_cta_telegram_message_window').fadeOut();
  });

  $('.scs_open_telegram_chatbox').on('click', function() {
      $('.wb_cta_telegram_message_window').fadeIn();
  });

  $('.wb_cta_telegram_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var telegramId = $('#snc_telegram_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var telegramId = $('#snc_telegram_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var telegramId = $('#snc_telegram_name3').val(); 
      } else {
        var telegramId = $('#snc_telegram_name').val();
      }
  
      var url = $('#snc_telegram_url').val() + telegramId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_telegram_message_window').fadeOut();
  });
});