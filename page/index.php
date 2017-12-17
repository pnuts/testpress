<?php get_header() ?>
<div id="main">
    <?php
    get_partial('part/subheader', array(
        'title' => 'All Test',
    ));
    get_partial('part/test-list', array(
        'tests' => array()
    ));
    ?>
</div>
<?php get_footer() ?>