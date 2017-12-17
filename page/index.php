<?php get_header() ?>
<div id="main">
    <?php
    get_partial('part/subheader', array(
        'title' => 'All Test',
    ));
    get_partial('part/test-list');
    ?>
</div>
<?php get_footer() ?>