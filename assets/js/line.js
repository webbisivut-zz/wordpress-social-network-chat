jQuery(document).ready(function ($) {
  $('.wb_cta_line_close').on('click', function() {
    $('.wb_cta_line_message_window').fadeOut();
  });

  $('.scs_open_line_chatbox').on('click', function() {
      $('.wb_cta_line_message_window').fadeIn();
  });

  $('.wb_cta_line_message_agent_wrap_inner').on('click', function() {
      var chosenAgent = $(this).attr('id');
      
      if(chosenAgent == 'snc_agent1') {
        var lineId = $('#snc_line_name').val(); 
      } else if(chosenAgent == 'snc_agent2') {
        var lineId = $('#snc_line_name2').val(); 
      } else if(chosenAgent == 'snc_agent3') {
        var lineId = $('#snc_line_name3').val(); 
      } else {
        var lineId = $('#snc_line_name').val();
      }
  
      var url = $('#snc_line_url').val() + lineId;
  
      window.open(url, '_blank');
  
      $('.wb_cta_line_message_window').fadeOut();
  });
});