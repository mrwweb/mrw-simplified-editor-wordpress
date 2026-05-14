/*
 * Hide blocks from the inserter
 *
 * Unregistering them crashes the editor if they are present in existing content
 */
wp.hooks.addFilter( 'blocks.registerBlockType', 'hideBlocks', ( blockSettings, blockName ) => {

	if ( -1 < mrwEditorOptions.hiddenBlocks.indexOf( blockName ) ) {
		return Object.assign({}, blockSettings, {
			supports: Object.assign( {}, blockSettings.supports, {inserter: false} )
		});
	}

	if ( blockName === 'core/heading' && Array.isArray( blockSettings.variations ) ) {
		const hiddenLevels = [];
		[ 1, 5, 6 ].forEach( ( level ) => {
			if ( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'heading-' + level ) ) {
				hiddenLevels.push( 'h' + level );
			}
		} );
		if ( hiddenLevels.length > 0 ) {
			return Object.assign( {}, blockSettings, {
				variations: blockSettings.variations.map( ( variation ) => {
					/* Fully hide heading levels from the editor */
					if ( -1 < hiddenLevels.indexOf( variation.name ) ) {
						return Object.assign( {}, variation, { scope: [] } );
					}
					/* Hide all heading variations from the inserter  */
					else if ( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'heading-variations' ) ) {
						return Object.assign( {}, variation, { scope: [ 'transform' ] } );
					}
				} )
			} );
		}
	}

	return blockSettings;
});

wp.domReady( function() {

	/*
	 * Hide Embed Variations
	 */
	mrwEditorOptions.hiddenEmbeds.forEach((embed) => {
		wp.blocks.unregisterBlockVariation('core/embed', embed);
	});

	/*
	 * Hide Social Links
	 */
	mrwEditorOptions.hiddenSocialLinks.forEach((link) => {
		wp.blocks.unregisterBlockVariation('core/social-link', link);
	});

	/*
	 * Hide Block Styles
	 */
	Object.keys( mrwEditorOptions.hiddenStyles ).forEach( function( block ) {

		mrwEditorOptions.hiddenStyles[block].forEach( function( style ) {
			wp.blocks.unregisterBlockStyle( block, style );
		});

	});

	/* Hide Fit Text Blocks */
	if( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'fit-text-paragraph' ) ) {
		wp.blocks.unregisterBlockVariation( 'core/paragraph', 'stretchy-paragraph' );
	}
	if( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'fit-text-heading' ) ) {
		wp.blocks.unregisterBlockVariation( 'core/heading', 'stretchy-heading' );
	}

	/* Remove Inline Footnote insert button in block toolbar if Footnote block is hidden */
	if( -1 < mrwEditorOptions.hiddenBlocks.indexOf( 'core/footnotes' ) ) {
		wp.richText.unregisterFormatType( 'core/footnote' );
	}

	/* Remove other inline formatting options */
	if( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'highlight' ) ) {
		wp.richText.unregisterFormatType( 'core/text-color' );
	}

	if( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'inline-image' ) ) {
		wp.richText.unregisterFormatType( 'core/image' );
	}

	if( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'inline-code' ) ) {
		wp.richText.unregisterFormatType( 'core/code' );
	}

	if( -1 < mrwEditorOptions.hiddenSettings.indexOf( 'keyboard' ) ) {
		wp.richText.unregisterFormatType( 'core/keyboard' );
	}

});
