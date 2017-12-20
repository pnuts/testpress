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
    <div v-show="selectedTests.length" id="selected-test-block" class="block">
        <h4>Selected Tests</h4>
        <button class="btn btn-sm">Run Tests</button>
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
        el: '#selected-test-block',
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