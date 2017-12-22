jQuery(function($) {
    if($('body.post-type-post').length) {
        CodeMirror.fromTextArea($('#content')[0], {
            mode:  "php",
            lineNumbers: true,
            matchBrackets: true
        });
    }
});