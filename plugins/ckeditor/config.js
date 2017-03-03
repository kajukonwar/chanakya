/**
 * @license Copyright (c) 2003-2017, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	// config.language = 'fr';
	// config.uiColor = '#AADC6E';

	    config.toolbar = 'CustomToolbar';
        config.toolbar_CustomToolbar =[
	
	[ 'Source', 'Cut', 'Copy', 'Paste', 'PasteText', 'PasteFromWord', '-', 'Undo', 'Redo' ],
	[ 'Find', 'Replace', '-', 'SelectAll', '-'],
	'/',
	[ 'Styles','Format','Font','FontSize','Bold', 'Italic', 'Underline'],

	[ 'TextColor','BGColor' ],

	[ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock','NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 
	'-',  '-','CreateDiv'],
	
	[ 'Image','Table', 'HorizontalRule', 'SpecialChar', 'PageBreak'],
	];

};
