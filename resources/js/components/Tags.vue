<template>
	<div class="content">
		<div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
			<p class="_title0">Tags
				<Button type="default" size="small" @click="modal = true">
					<Icon type="ios-add" />Add New
				</Button>
			</p>
			<div class="_overflow _table_div">
				<table class="table">
					<!-- TABLE TITLE -->
					<tr>
						<th>#</th>
						<th>Tag Name</th>
						<th>Created At</th>
						<th class="text-center">Action</th>
					</tr>

					<!-- TABLE ITEMS -->
					<tr v-for="(tag, index) in tags" :key="tag.id" v-if="tags.length">
						<td>{{index + 1}}</td>
						<td class="_table_name">{{tag.tagName}} - {{tag.id}}</td>
						<td>{{tag.created_at}}</td>
						<td class="text-center">
							<button class="_btn _action_btn edit_btn1" type="button">Edit</button>
							<button class="_btn _action_btn make_btn1 ml-2" type="button">Delete</button>
						</td>
					</tr>
				</table>
			</div>
		</div>

		<!--Modal-->

		<Modal v-model="modal" title="Add Tag" :mask-closable="false" :closable="false" footer-hide>
			<Form>
				<FormItem label="Tag Name">
					<Input v-model="formData.tagName"></Input>
				</FormItem>
			</Form>

			<footer class="text-right">
				<Button type="default" size="small" @click="modal = false">Cancel</Button>
				<Button type="success" size="small" class="ml-2" @click="savingData" :disabled="isSaving"
					:loading="isSaving">{{isSaving ? 'Saving...' : 'Save'}}</Button>
			</footer>
		</Modal>

	</div>
</template>

<script>
export default{
	data(){
		return{
			modal: false,
			isSaving: false,
			tags: [],
			formData: {
				tagName: ''
			}
		}
	},

	async created() {
		const res = await this.callAPI('get', 'tag-list');
		if (res.status == 200) {
			this.tags = res.data;
		}else{
			this.err();
		}
	},
	methods:{
		async savingData(){
			if (this.formData.tagName.trim() == '')
				return this.error('Tag name is required');
			const res = await this.callAPI('post', 'tags', this.formData)
			if (res.status == 201) {
				this.tags.unshift(res.data);
				this.success("Tag saved successfully!");
				this.modal = false;
				this.formData.tagName = '';
			} else {
				this.err();
			}
		},


	}
}
</script>