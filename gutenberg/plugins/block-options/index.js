const { unregisterBlockStyle } = wp.blocks;
wp.domReady( () => {
	unregisterBlockStyle( 'core/separator', 'wide' );
	unregisterBlockStyle( 'core/separator', 'default' );
	unregisterBlockStyle( 'core/separator', 'dots' );
} );
