jQuery(document).ready(function($) {
    $(".wb_cta_whatsapp_close").on("click", function() {
        $(".wb_cta_whatsapp_message_window").fadeOut()
    }), $(".wb_cta_input_whatsapp_submit").on("click", function() {
        var chosenAgent = $("#snc_whatsapp_chosen_agent").val();
        if ("snc_agent1" == chosenAgent) var phone = $("#snc_whatsapp_name").val();
        else if ("snc_agent2" == chosenAgent) var phone = $("#snc_whatsapp_name2").val();
        else if ("snc_agent3" == chosenAgent) var phone = $("#snc_whatsapp_name3").val();
        else var phone = $("#snc_whatsapp_name").val();
        var text = $("#wb_cta_input_whatsapp_textarea").val(),
            url = $("#snc_whatsapp_url").val() + "?phone=" + phone + "&text=" + encodeURI(text);
        window.open(url, "_blank"), $(".wb_cta_whatsapp_message_window").fadeOut(), $("#wb_cta_input_whatsapp_textarea").val("")
    }), $(".wb_cta_whatsapp_message_agent_wrap_inner").on("click", function() {
        var id = $(this).attr("id"),
            quickhat;
        if ($("#snc_whatsapp_chosen_agent").val(id), "true" != $("#snc_whatsapp_quickchat").val()) $(".wb_cta_whatsapp_message_agent_wrap_inner").removeClass("wb_cta_whatsapp_message_agent_wrap_inner_border"), $(this).addClass("wb_cta_whatsapp_message_agent_wrap_inner_border"), $(".wb_cta_whatsapp_message_agent_wrap_inner").each(function(i, obj) {
            $(this).hasClass("wb_cta_whatsapp_message_agent_wrap_inner_border") || ($(this).hide(), $("#wb_cta_input_whatsapp_textarea").fadeIn())
        });
        else {
            var chosenAgent = $("#snc_whatsapp_chosen_agent").val();
            if ("snc_agent1" == chosenAgent) var phone = $("#snc_whatsapp_name").val();
            else if ("snc_agent2" == chosenAgent) var phone = $("#snc_whatsapp_name2").val();
            else if ("snc_agent3" == chosenAgent) var phone = $("#snc_whatsapp_name3").val();
            else var phone = $("#snc_whatsapp_name").val();
            var text = $("#wb_cta_input_whatsapp_textarea").val(),
                url = $("#snc_whatsapp_url").val() + "?phone=" + phone + "&text=" + encodeURI(text);
            window.open(url, "_blank"), $(".wb_cta_whatsapp_message_window").fadeOut(), $("#wb_cta_input_whatsapp_textarea").val("")
        }
    }), $(".scs_open_whatsapp_chatbox").on("click", function() {
        $(".wb_cta_whatsapp_message_window").fadeIn(), $(".wb_cta_whatsapp_message_agent_wrap_inner").each(function(i, obj) {
            $(this).hasClass("wb_cta_whatsapp_message_agent_wrap_inner_border") && ($(this).removeClass("wb_cta_whatsapp_message_agent_wrap_inner_border"), $("#wb_cta_input_whatsapp_textarea").hide()), $(this).show()
        })
    })
});
//# sourceMappingURL=whatsapp.min.js.map