<?php get_header() ?>
<div class="default-layout">
	<div id="main">
		<?php
		get_partial('part/subheader', array(
			'title' => 'All Test',
		));
		get_partial('part/test-list');
		?>
	</div>
	<div id="side">
		<div v-show="Object.keys(selectedTests).length" id="selected-test-block" class="block">
            <h4>Selected Tests</h4>
			<button class="btn btn-sm">Run Tests</button>
			<ul id="selected-test-list">
				<li v-for="testId in Array.from(window.selectedTestIds)" v-if="selectedTests[testId]">
					<a href="">{{ selectedTests[testId].title }}</a>
					<span @click="unselect(selectedTests[testId])"></span>
				</li>
			</ul>
		</div>
	</div>
</div>
<script type="application/javascript">
window.$ = jQuery;
$(function() {
    window.selectedApp = new Vue({
        el: '#selected-test-block',
        data: {
            selectedTests: testListApp.selectedTests,
            selectedTestIds: testListApp.selectedTestIds
        },
        'methods': {
            unselect: function (test) {
                testListApp.revertStatus(test);
            }
        }
    });

    updateTestList(data1);
});
</script>
<?php get_footer() ?>