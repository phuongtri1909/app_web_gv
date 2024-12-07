/**
 * @license Copyright (c) 2003-2023, CKSource Holding sp. z o.o. All rights reserved.
 * For licensing, see https://ckeditor.com/legal/ckeditor-oss-license
 */
CKEDITOR.editorConfig = function(config) {
    config.allowedContent = true;
    config.forcePasteAsPlainText = false;
    // Thêm các plugin cho kích cỡ chữ và màu chữ
    config.extraPlugins = 'uploadimage,image,video,clipboard,table,justify,font,colorbutton,codesnippet,pastefromword';

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
        { name: 'paragraph', groups: [ 'align', 'list', 'indent', 'blocks', 'bidi', 'paragraph' ] },
        { name: 'styles', groups: [ 'styles' ] },
        { name: 'colors', groups: [ 'colors' ] },
        { name: 'font', groups: [ 'Font', 'FontSize', 'TextColor', 'BGColor' ] }
    ];

    config.removeButtons = 'Underline,Subscript,Superscript';
    config.format_tags = 'p;h1;h2;h3;pre';
    config.removeDialogTabs = 'image:advanced;link:advanced';
    config.height = 300;

    config.fontSize_sizes = '8/8px;10/10px;12/12px;14/14px;16/16px;18/18px;24/24px;36/36px;48/48px;72/72px';

    // File browser settings (if using Laravel File Manager).
    config.filebrowserBrowseUrl = '/admin/laravel-filemanager?editor=ckeditor&type=Files';
    config.filebrowserUploadUrl = '/admin/laravel-filemanager/upload?editor=ckeditor&type=Files&_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    config.filebrowserImageBrowseUrl = '/admin/laravel-filemanager?type=Images';
    config.filebrowserImageUploadUrl = '/admin/laravel-filemanager/upload?type=Images&_token=' + document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    config.uploadUrl = '/admin/laravel-filemanager/upload?editor=ckeditor&type=Files';
    config.removePlugins = 'image2';

    // Kích hoạt plugin màu sắc
    config.colorButton_enableMore = true;
};



