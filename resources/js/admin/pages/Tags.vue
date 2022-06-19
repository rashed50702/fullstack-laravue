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
                    <tr v-for="(tag, i) in tags" :key="tag.id" v-if=" tags.length">
                        <td>{{ i + 1 }}</td>
                        <td class="_table_name">{{ tag.tagName }} - {{ tag.id }}</td>
                        <td>{{ tag.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button"
                                @click="showEditModal(tag, i)">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button"
                                @click="showDeletingModal(tag, i)" :loading="tag.isDeleting">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!--Adding Modal-->
        <Modal v-model="modal" title="Add Tag" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Tag Name">
                    <Input v-model="formData.tagName"></Input>
                </FormItem>
            </Form>

            <footer class="text-right">
                <Button type="default" size="small" @click="modal = false">Cancel</Button>
                <Button type="success" size="small" class="ml-2" @click="savingData" :disabled="isSaving"
                    :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
            </footer>
        </Modal>


        <!--Editing Modal-->
        <Modal v-model="editModal" title="Edit Tag" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Tag Name">
                    <Input v-model="formDataEdit.tagName"></Input>
                </FormItem>
            </Form>

            <footer class="text-right">
                <Button type="default" size="small" @click="editModal = false">Cancel</Button>
                <Button type="success" size="small" class="ml-2" @click="updatingData" :disabled="isSaving"
                    :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
            </footer>
        </Modal>

        <!-- Deleting Modal -->
        <deleteModal></deleteModal>

    </div>
</template>

<script>
import deleteModal from '../components/deleteModal.vue';
import { mapGetters } from 'vuex';

export default {
    data() {
        return {
            modal: false,
            editModal: false,
            isSaving: false,
            tags: [],
            formData: {
                tagName: ''
            },
            formDataEdit: {
                tagName: ''
            },
            index: -1,
            deletingModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1
        }
    },

    async created() {
        const res = await this.callAPI('get', 'tag-list');
        if (res.status == 200) {
            this.tags = res.data;
        } else {
            this.err();
        }
    },
    methods: {
        async savingData() {
            if (this.formData.tagName.trim() == '')
                return this.err('Tag name is required');

            const res = await this.callAPI('post', 'tags', this.formData)
            if (res.status === 201) {
                this.tags.unshift(res.data);
                this.success("Tag saved successfully!");
                this.modal = false;
                this.formData.tagName = '';
            } else {
                if (res.status === 422) {
                    let errors = res.data.errors;
                    for (let field of Object.keys(errors)) {
                        this.err(errors[field]);
                    }
                } else {
                    this.err("Oops!", "Something went wrong!");
                }
            }
        },

        async updatingData() {
            if (this.formDataEdit.tagName.trim() == '')
                return this.err('Tag name is required');

            const res = await this.callAPI('post', 'tag-edit', this.formDataEdit)

            if (res.status === 200) {
                if (res.data.status === 422) {
                    let errors = res.data.errors;
                    for (let field of Object.keys(errors)) {
                        this.err(errors[field]);
                    }
                } else {
                    this.tags[this.index].tagName = this.formDataEdit.tagName;
                    this.success("Tag updated successfully!");
                    this.editModal = false;
                }
            } else {
                this.err("Oops!", "Something went wrong!");
            }
        },

        showEditModal(tag, index) {
            let obj = {
                id: tag.id,
                tagName: tag.tagName
            }
            this.formDataEdit = obj;
            this.editModal = true;
            this.index = index;
        },

        showDeletingModal(tag, i) {
            const deleteModalObj = {
                deletingModal: true,
                deleteUrl: '/delete-tag',
                data: tag,
                deletingIndex: i,
                isDeleted: false
            }
            this.$store.commit('setDeletingModalObj', deleteModalObj);            
        }
    },
    components:{
        deleteModal
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch:{
        getDeleteModalObj(obj){
            if (obj.isDeleted){
                this.tags.splice(obj.deletingIndex,1);
            }
        }
    }
}
</script>