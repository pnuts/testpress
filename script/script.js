jQuery(function($) {
    $('.test-list .test-item').click(function(e) {
        $(this).toggleClass('selected');
    });
    $('.test-list .test-item a').click(function(e) {
        e.preventDefault();
        return false;
    });
});