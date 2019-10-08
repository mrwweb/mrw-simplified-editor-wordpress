/*
the officially supported way crashes the editor if any blacklisted blocks are used.
window.addEventListener('load', function() {
	var i, blacklist;

	blacklist = mrwSimpleOptions.blacklist;

	for( i = 0; i < blacklist.length; i++ ) {
		wp.blocks.unregisterBlockType( blacklist[i] );
	}
});*/

wp.hooks.addFilter( 'blocks.registerBlockType', 'hideBlocks', ( blockSettings, blockName ) => {
	if ( -1 < hiddenBlocks.indexOf( blockName ) ) {
		return Object.assign({}, blockSettings, {
			supports: Object.assign({}, blockSettings.supports, {inserter: false})
		});
	}

	return blockSettings;
});