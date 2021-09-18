/**
 * Gutenberg block for shortcode
 */
( function( blocks, i18n, element ) {
	var el = element.createElement;
	var __ = i18n.__;

	var blockStyle = {
		backgroundColor: '#6bc10f',
		color: '#fff',
        padding: '10px',
        textAlign: 'center'
	};

	blocks.registerBlockType( 'wd-social-network-chat-pro-dev/wd-social-network-chat-pro', {
		title: __( 'Social network chat', 'gutenberg-examples' ),
		icon: 'button',
		category: 'layout',
		edit: function() {
			return el(
				'p',
				{ style: blockStyle },
				'Social Network Chat Button'
			);
		},
		save: function() {
			return ('[social-network-chat]');
        },
	} );
}(
	window.wp.blocks,
	window.wp.i18n,
	window.wp.element
) );
