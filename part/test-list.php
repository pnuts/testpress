<div id="test-list" class="ctrl test-list">
    <div v-for="test in testList">
        <div class="test-item" v-bind:class="test.status">
            <div class="statistics">
                <div class="days">
                    <span>{{ test.days ? test.days : 'Not' }}</span>test
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
</div>

<script type="application/javascript">
    window.testList = [
        {
            title: 'How to reload widget component after ajax jQuery Mobile',
            status: 'waitinng',
            days: 0,
            votes: 2,
            categories: [
                { alias: 'hostucan', name: 'HostUCan' }
            ],
            tags: [
                { alias: 'content', name: 'Content' },
                { alias: 'data', name: 'Data' },
                { alias: 'style', name: 'Style' }
            ],
            author: { name: 'Pnuts' },
            date: { last_test: '2017-12-12 05:21' }
        },

        {
            title: 'How to reload widget component after ajax jQuery Mobile',
            status: 'passed',
            days: 10,
            votes: 2,
            categories: [
                { alias: 'hostucan', name: 'HostUCan' }
            ],
            tags: [
                { alias: 'content', name: 'Content' },
                { alias: 'data', name: 'Data' },
                { alias: 'style', name: 'Style' }
            ],
            author: { name: 'Pnuts' },
            date: { last_test: '2017-12-12 05:21' }
        },

        {
            title: 'How to reload widget component after ajax jQuery Mobile',
            status: 'just-passed',
            days: 0,
            votes: 2,
            categories: [
                { alias: 'hostucan', name: 'HostUCan' }
            ],
            tags: [
                { alias: 'content', name: 'Content' },
                { alias: 'data', name: 'Data' },
                { alias: 'style', name: 'Style' }
            ],
            author: { name: 'Pnuts' },
            date: { last_test: '2017-12-12 05:21' }
        },

        {
            title: 'How to reload widget component after ajax jQuery Mobile',
            status: 'failed',
            days: 10,
            vote: 2,
            categories: [
                { alias: 'hostucan', name: 'HostUCan' }
            ],
            tags: [
                { alias: 'content', name: 'Content' },
                { alias: 'data', name: 'Data' },
                { alias: 'style', name: 'Style' }
            ],
            author: { name: 'Pnuts' },
            date: { last_test: '2017-12-12 05:21' }
        }
    ];
    window.app = new Vue({
        el: '#test-list',
        data: {
            testList: testList
        }
    });
</script>
