<div id="test-list" class="ctrl test-list">
    <div v-for="test in testList"
         class="test-item"
         :key="test.id"
         :class="classname(test)"
         @click="revertStatus(test)">
        <div class="statistics">
            <div class="status">
                <span>{{ test.days }}</span>days
            </div>
            <div class="votes">
                <span>{{ test.votes }}</span>votes
            </div>
        </div>
        <div class="summary">
            <h3><a href="javascript:void(0)">{{ test.title }}</a></h3>
            <div class="categories">
                <a v-for="category in test.categories" :href="category.alias">{{ category.name }}</a>
            </div>
            <div class="tags">
                <a v-for="tag in test.tags" :href="tag.alias">{{ tag.name }}</a>
            </div>
            <div class="info">Last test at <b>{{ test.date.last_test }}</b> by <a href="javascript:void(0)">Pnuts</a></div>
        </div>
    </div>
</div>
<div id="pager" class="ctrl pager">
    <div class="links">
		<a>prev</a>
		<a>1</a>
		<strong class="current">2</strong>
		<a>3</a>
		<span>...</span>
		<a>100</a>
		<a>next</a>
    </div>
</div>
<script type="application/javascript">
    var sessionId = $('#session_id').attr('content');
    Storage.prototype.setObject = function (key, value, salt) {
        this.setItem(key, CryptoJS.AES.encrypt(JSON.stringify(value), salt).toLocaleString());
    };

    Storage.prototype.getObject = function (key, defaultValue = null, salt) {
        var data = this.getItem(key);
        if (data === null) {
            return defaultValue;
        }
        try {
            return JSON.parse(CryptoJS.AES.decrypt(data, salt).toString(CryptoJS.enc.Utf8));
        } catch (e) {
            return defaultValue;
        }
    };
    var selectedTestIds = new Set(localStorage.getObject('selectedTestIds', [], sessionId));
    window.testListApp = new Vue({
        el: '#test-list',
        data: {
            testList: [],
            selectedTests: {},
            selectedTestIds: selectedTestIds
        },
        methods: {
            classname: function(test) {
                return test.status + (test.auto ? ' auto-test' : ' ')
                    + (test.selected ? ' selected' : ' ')
                    + (test.reviewer === 'pnuts' ? ' reviewed_by_me' : ' ');
            },
            revertStatus: function(test) {
                test.selected = !test.selected;
                if(test.selected) {
                    this.$set(this.selectedTests, test.id, test);
                    this.selectedTestIds.add(test.id);
                } else {
                    this.$delete(this.selectedTests, test.id);
                    this.selectedTestIds.delete(test.id);
                }
                localStorage.setObject('selectedTestIds', Array.from(this.selectedTestIds), sessionId);
            },
            preventDefault: function(e) {
                e.preventDefault();
                return false;
            }
        }
    });

    window.updateTestList = function(datas) {
        testListApp.testList = [];
        for(var i in datas) {
            var data = datas[i];
            data.selected = this.selectedTestIds.has(data.id);
            testListApp.testList.push(data);

            if(data.selected) {
                testListApp.$set(testListApp.selectedTests, data.id, data);
            } else {
                testListApp.$delete(testListApp.selectedTests, data.id);
            }
        }
    };
</script>
