/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
CKEDITOR.editorConfig = function(config) {
    config.allowedContent = true;
    // Define changes to the default configuration here.
    config.extraPlugins = 'uploadimage,image,video,clipboard,table,justify,codesnippet'; // Add plugins as needed
    config.toolbarGroups = [
        { name: 'clipboard', groups: [ 'clipboard', 'undo' ] },
        { name: 'editing', groups: [ 'find', 'selection', 'editing' ] },
        { name: 'links', groups: [ 'links' ] },
        { name: 'insert', groups: [ 'insert', 'video' ] },
        { name: 'forms', groups: [ 'forms' ] },
        { name: 'tools', groups: [ 'tools' ] },
        { name: 'document', groups: [ 'mode', 'document', 'doctools' ] },
        { name: 'others', groups: [ 'others' ] },
        '/',
        { name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ] },
        { name: 'paragraph', groups: [ 'align', 'list', 'indent', 'blocks', 'bidi', 'paragraph', 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] }, // Add more groups as needed. ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] }
    ];

    // Ensure toolbar includes specific buttons for image, video, and alignment.
    config.removeButtons = 'Underline,Subscript,Superscript';  // Remove "Subscript" and "Superscript" buttons
    config.format_tags = 'p;h1;h2;h3;pre';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.height = 300;

    // File browser settings (if using Laravel File Manager).
    config.filebrowserBrowseUrl = '/admin/laravel-filemanager?editor=ckeditor&type=Files';
    config.filebrowserUploadUrl = '/admin/laravel-filemanager/upload?editor=ckeditor&type=Files&_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    config.filebrowserImageBrowseUrl = '/admin/laravel-filemanager?type=Images';
    config.filebrowserImageUploadUrl = '/admin/laravel-filemanager/upload?type=Images&_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    config.uploadUrl = '/admin/laravel-filemanager/upload?editor=ckeditor&type=Files';
    config.removePlugins = 'image2';

    config.attributes = [ 'left', 'center', 'right' ];
};


