/*
 * Hide Blocks
 */
wp.hooks.addFilter( 'blocks.registerBlockType', 'hideBlocks', ( blockSettings, blockName ) => {

	if ( -1 < mrwEditorOptions.hiddenBlocks.indexOf( blockName ) ) {
		return Object.assign({}, blockSettings, {
			supports: Object.assign( {}, blockSettings.supports, {inserter: false} )
		});
	}

	return blockSettings;
});

wp.domReady( function() {

	/*
	 * Hide Embed Variations
	 */
	wp.blocks.getBlockVariations('core/embed').forEach(function (embed) {

		if ( -1 !== mrwEditorOptions.hiddenEmbeds.indexOf(embed.name) ) {
			wp.blocks.unregisterBlockVariation('core/embed', embed.name );
		}

	});

	/*
	 * Hide Block Styles
	 */
	Object.keys( mrwEditorOptions.hiddenStyles ).forEach( function( block ) {

		mrwEditorOptions.hiddenStyles[block].forEach( function( style ) {
			wp.blocks.unregisterBlockStyle( block, style );
		});

	});

	/* Remove Inline Footnote inserted in block toolbar if Footnote block is hidden */
	if( mrwEditorOptions.hiddenBlocks.indexOf( 'core/footnotes' ) ) {
		wp.richText.unregisterFormatType('core/footnote');
	}

});
