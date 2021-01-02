wp.hooks.addFilter( 'blocks.registerBlockType', 'hideBlocks', ( blockSettings, blockName ) => {

	if ( -1 < mrwEditorOptions.hiddenBlocks.indexOf( blockName ) ) {
		return Object.assign({}, blockSettings, {
			supports: Object.assign( {}, blockSettings.supports, {inserter: false} )
		});
	}

	return blockSettings;
});

wp.domReady( function() {

	Object.keys( mrwEditorOptions.hiddenStyles ).forEach( function( block ) {
		mrwEditorOptions.hiddenStyles[block].forEach( function( style ) {
			wp.blocks.unregisterBlockStyle( block, style );
		});
	});

});
