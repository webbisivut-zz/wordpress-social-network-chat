jQuery(document).ready(function ($) {
  // Luodaan eväste funktio
	function createSocialNetworkChatCookie(name,value,days) {
		if (days) {
			var date = new Date();
			date.setTime(date.getTime()+(days*24*60*60*1000));
			var expires = "; expires="+date.toGMTString();
		}
		else var expires = "";
		document.cookie = name+"="+value+expires+"; path=/";
	}

	// Luetaan eväste funktio
	function readSocialNetworkChatCookie(name) {
		var nameEQ = name + "=";
		var ca = document.cookie.split(';');
		for(var i=0;i < ca.length;i++) {
			var c = ca[i];
			while (c.charAt(0)==' ') c = c.substring(1,c.length);
			if (c.indexOf(nameEQ) == 0) return c.substring(nameEQ.length,c.length);
		}
		return null;
	}

	// Tuhotaan eväste funktio
	function eraseSocialNetworkChatCookie(name) {
		createFormCookie(name,"",-1);
  	}

	$('.wb_cta_btn_chat').mouseenter(function() {
		createSocialNetworkChatCookie('snc_cookie', 'true', 1);

		if(typeof $('.social-network-speech-bubble') !== 'undefined') {
			$('.social-network-speech-bubble').fadeOut();
		}	
	});

	setTimeout(function() {
		var cookie = readSocialNetworkChatCookie('snc_cookie');

		if (!cookie) {
			$('.social-network-speech-bubble').fadeIn();
		}
	}, 10000);

	$('.wb_cta_close_bubble').on('click', function() {
		createSocialNetworkChatCookie('snc_cookie', 'true', 1);
	});
});