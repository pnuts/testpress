<?php extract($args); ?>
<script type="x-template" id="<?= isset($id) ? $id : 'pager-template' ?>">
	<div class="ctrl pager" v-if="current > 0 && current <= total && total > 1">
		<div class="links">
			<a v-if="current > 1" @click="showPage(current - 1)" @click="showPage(current - 1)">prev</a>
			<span v-if="current > 2">...</span>
			<template v-for="i in 5">
				<a v-if="i != 3 && current - 3 + i > 0 && current - 3 + i < total"
				   @click="showPage(current - 3 + i)">{{ current - 3 + i }}</a>

				<strong v-if="i == 3 && current <= total">{{ current }}</strong>
			</template>
			<span v-if="total - current > 2">...</span>
			<a @click="showPage(total)" v-if="current > total">{{ total }}</a @click="showPage(total)">
			<a v-if="current < total" @click="showPage(current + 1)">next</a>
		</div>
	</div>
</script>