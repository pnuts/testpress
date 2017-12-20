<div id="test-list" class="ctrl test-list">
    <div v-for="test in testList"
         class="test-item"
         v-bind:key="test.id"
         v-bind:class="classname(test)"
         v-on:click="select(test)">
        <div class="statistics">
            <div class="status" v-if="test.auto">
                <span>Auto</span>test
            </div>
            <div v-else class="status">
                <span>{{ test.days }}</span>days
            </div>
            <div class="votes">
                <span>{{ test.votes }}</span>votes
            </div>
        </div>
        <div class="summary">
            <h3><a href="javascript:void(0)">{{ test.title }}</a></h3>
            <div class="categories">
                <a v-for="category in test.categories" v-bind:href="category.alias">{{ category.name }}</a>
            </div>
            <div class="tags">
                <a v-for="tag in test.tags" v-bind:href="tag.alias">{{ tag.name }}</a>
            </div>
            <div class="info">Last test at <b>{{ test.date.last_test }}</b> by <a href="javascript:void(0)">Pnuts</a></div>
        </div>
    </div>
</div>
<script type="application/javascript">
    window.testList = [];
    window.selectedTests = [];
    window.testListApp = new Vue({
        el: '#test-list',
        data: {
            testList: testList
        },
        methods: {
            classname: function(test) {
                return test.status + (test.auto ? ' auto-test' : ' ') + (test.selected ? ' selected' : ' ');
            },
            select: function(test) {
                test.selected = !test.selected;
                if(test.selected) {
                    selectedTests.push(test);
                } else {
                    selectedTests.splice(selectedTests.indexOf(test), 1);
                }
            },
            preventDefault: function(e) {
                e.preventDefault();
                return false;
            }
        }
    });
</script>
