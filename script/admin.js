jQuery(function($) {
    if($('body.post-type-post').length) {
        CodeMirror.fromTextArea($('#content')[0], {
            mode:  "javascript",
            lineNumbers: true,
            matchBrackets: true
        });
    }
});