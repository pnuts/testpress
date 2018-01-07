<?php get_header() ?>
<div class="default-layout">
	<div id="main">
        <subheader
                :title="title"
                :error_count="360"
        ></subheader>
        <test-list
                :testlist="testlist"
        ></test-list>
        <pager
                :total="10"
        ></pager>
	</div>
    <div id="side">
        <selected-tests-sidebar
                :selected_tests="selected_tests"
        ></selected-tests-sidebar>
    </div>
</div>
<?php get_partial('component/pager'); ?>
<?php get_partial('component/subheader'); ?>
<?php get_partial('component/test-list'); ?>
<?php get_partial('component/selected-tests-sidebar'); ?>
<script type="application/javascript">
window.$ = jQuery;
window.bus = new Vue();

$(function() {
    let session_id = $('#session_id').attr('content');
    let selected_test_ids = localStorage.getObject('selected_test_ids', new Set(), session_id);

    function save_selected_test_ids() {
        localStorage.setObject('selected_test_ids', selected_test_ids, session_id);
    }

    window.mainApp = new Vue({
        el: '#main',
        data: {
            title: "All Test",
            testlist: [],
            selected_test_ids: selected_test_ids
        },
    });

    window.sideApp = new Vue({
        el: '#side',
        data: {
            selected_tests: {}
        }
    });

    let test_map = {};

    bus.$on('set_testlist', function (testlist) {
        for(test of testlist) {
            test_map[test.id] = test;
            if(selected_test_ids.has(test.id)) {
                test.selected = true;
            }
        }
        mainApp.testlist = testlist;
    });

    bus.$on('select_test', function(test) {
        test_map[test.id].selected = true;
        selected_test_ids.add(test.id);
        sideApp.selected_tests.push(test);
        save_selected_test_ids();
    });

    bus.$on('unselect_test', function(test) {
        test_map[test.id].selected = false;
        for(let i in  sideApp.selected_tests) {
            if(sideApp.selected_tests[i].id === test.id) {
                sideApp.selected_tests.splice(i, 1);
                break;
            }
        }
        selected_test_ids.delete(test.id);
        save_selected_test_ids();
    });

    bus.$emit('set_testlist', data1);

    function get_selected_tests(selected_test_ids) {
        sideApp.selected_tests = JSON.parse(JSON.stringify(data1));
    }
    get_selected_tests(selected_test_ids);
});
</script>
<?php get_footer() ?>