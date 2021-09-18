jQuery(document).ready(function ($) {
  $('.wb_cta_viber_close').on('click', function() {
    $('.wb_cta_viber_message_window').fadeOut();
  });

  $('.scs_open_viber_chatbox').on('click', function() {
      $('.wb_cta_viber_message_window').fadeIn();
  });

  $('.wb_cta_viber_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var viberId = $('#snc_viber_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var viberId = $('#snc_viber_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var viberId = $('#snc_viber_name3').val(); 
      } else {
        var viberId = $('#snc_viber_name').val();
      }
  
      var url = $('#snc_viber_url').val() + viberId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_viber_message_window').fadeOut();
  });
});