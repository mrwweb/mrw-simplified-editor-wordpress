wp.hooks.addFilter( 'blocks.registerBlockType', 'hideBlocks', ( blockSettings, blockName ) => {

	if ( -1 < mrwEditorOptions.disabledBlocks.indexOf( blockName ) ) {
		return Object.assign({}, blockSettings, {
			supports: Object.assign( {}, blockSettings.supports, {inserter: false} )
		});
	}

	return blockSettings;
});

wp.domReady( function() {

	Object.keys( mrwEditorOptions.disabledVariations ).forEach( function( block ) {
		mrwEditorOptions.disabledVariations[block].forEach( function( variation ) {
			wp.blocks.unregisterBlockStyle( block, variation );
		});
	});

});
