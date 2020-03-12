wp.hooks.addFilter( 'blocks.registerBlockType', 'hideBlocks', ( blockSettings, blockName ) => {

	if ( -1 < mrwEditorOptions.blockBlacklist.indexOf( blockName ) ) {
		return Object.assign({}, blockSettings, {
			supports: Object.assign( {}, blockSettings.supports, {inserter: false} )
		});
	}

	return blockSettings;
});

wp.domReady( function() {

	Object.keys( mrwEditorOptions.variationsBlacklist ).forEach( function( block ) {
		mrwEditorOptions.variationsBlacklist[block].forEach( function( variation ) {
			wp.blocks.unregisterBlockStyle( block, variation );
		});
	});

	if ( mrwEditorOptions.featureBlacklist.indexOf( 'prevent-fullscreen' ) !== -1 ) {

		const isFullscreenMode = wp.data.select( 'core/edit-post' ).isFeatureActive( 'fullscreenMode' );

		if ( isFullscreenMode ) {
		    wp.data.dispatch( 'core/edit-post' ).toggleFeature( 'fullscreenMode' );
		}

	}

});
