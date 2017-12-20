<?php get_header() ?>
<div id="main">
    <?php
    get_partial('part/subheader', array(
        'title' => 'All Test',
    ));
    get_partial('part/test-list');
    ?>
</div>
<div id="side">
    <div v-if="selected-test-list" id="selected-test-block" class="block">
        <h4>Selected Tests</h4>
        <ul id="selected-test-list">
            <li
                v-if="test.selected"
                v-for="test in selectedTests"
            >
                <a href="">{{ test.title }}</a>
                <span v-on:click="unselect(test)"></span>
            </li>
        </ul>
    </div>
</div>
<script type="application/javascript">
    window.selectMapApp = new Vue({
        el: '#selected-test-list',
        data: {
            selectedTests: selectedTests
        },
        'methods': {
            unselect: function (test) {
                testListApp.select(test);
            }
        }
    });
    testListApp.testList = data1;
    window.$ = jQuery;
</script>
<?php get_footer() ?>