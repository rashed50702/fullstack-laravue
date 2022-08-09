<template>
    <div class="content">
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
            <Breadcrumb class="mb-2">
                <Row>
                    <Col span="12">
                    <Breadcrumb>
                        <BreadcrumbItem to="/">
                            <Icon type="ios-home-outline"></Icon> Home
                        </BreadcrumbItem>
                        <BreadcrumbItem>
                            <Icon type="ios-pricetags"></Icon> Tags
                        </BreadcrumbItem>
                    </Breadcrumb>
                    </Col>
                    <Col span="12" class="text-right">
                    <Button type="default" size="small" @click="modal = true" v-if="isWritePermitted">
                        <Icon type="ios-add" />Add New
                    </Button>
                    </Col>
                </Row>
            </Breadcrumb>
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
                        <td class="_table_name">{{ tag.tagName }}</td>
                        <td>{{ tag.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button" @click="showEditModal(tag, i)"
                                v-if="isUpdatePermitted">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button"
                                @click="showDeletingModal(tag, i)" :loading="tag.isDeleting"
                                v-if="isDeletePermitted">Delete</button>
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

                <footer class="text-right">
                    <Button type="default" size="small" @click="modal = false">Cancel</Button>
                    <Button type="success" size="small" class="ml-2" @click="savingData" :disabled="isSaving"
                        :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
                </footer>
            </Form>
        </Modal>


        <!--Editing Modal-->
        <Modal v-model="editModal" title="Edit Tag" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Tag Name">
                    <Input v-model="formDataEdit.tagName"></Input>
                </FormItem>
                <footer class="text-right">
                    <Button type="default" size="small" @click="editModal = false">Cancel</Button>
                    <Button type="success" size="small" class="ml-2" @click="updatingData(formDataEdit.id)" :disabled="isSaving"
                        :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
                </footer>
            </Form>
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
        const res = await this.callAPI('get', 'admin/tag-list');
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
            
            await this.callAPI('post', 'admin/tags', this.formData)
                .then(response => {
                    this.tags.unshift(response.data);
                    this.success("Tag saved successfully!");
                    this.modal = false;
                    this.formData.tagName = '';
                })
                .catch(error => {
                    if (error.response.status === 422){
                        let errors = error.response.data.errors;
                        for (let field of Object.keys(errors)) {
                            this.err(errors[field]);
                        }
                    }else{
                        this.err("Something went wrong!", "Oops!");
                    }
                });
        },

        async updatingData(id) {
            if (this.formDataEdit.tagName.trim() == '')
                return this.err('Tag name is required');

            await this.callAPI('put', 'admin/tag-edit/'+id, this.formDataEdit)
                .then(response => {
                    this.tags[this.index].tagName = this.formDataEdit.tagName;
                    this.success("Tag updated successfully!");
                    this.editModal = false;
                })
                .catch(error => {
                    if (error.response.status === 422) {
                        let errors = error.response.data.errors;
                        for (let field of Object.keys(errors)) {
                            this.err(errors[field]);
                        }
                    } else {
                        this.err("Something went wrong!", "Oops!");
                    }
                });
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
                deleteUrl: '/admin/delete-tag',
                data: {id:tag.id},
                deletingIndex: i,
                isDeleted: false,
                deletingItemMsg: 'Tag'
            }
            this.$store.commit('setDeletingModalObj', deleteModalObj);            
        }
    },
    components:{
        deleteModal,
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