jQuery(function($) {
    CodeMirror.fromTextArea($('#content')[0], {
        mode:  "javascript",
        lineNumbers: true,
        matchBrackets: true
    });
});