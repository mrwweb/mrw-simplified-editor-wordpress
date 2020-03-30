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

});
