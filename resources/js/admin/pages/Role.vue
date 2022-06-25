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
                            <Icon type="ios-grid"></Icon> Roles
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
                        <th>Role Name</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>

                    <!-- TABLE ITEMS -->
                    <tr v-for="(item, i) in items" :key="item.id" v-if=" items.length">
                        <td>{{ i + 1 }}</td>
                        <td class="_table_name">{{ item.roleName }}</td>
                        <td>{{ item.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button" @click="showEditModal(item, i)"
                                v-if="isUpdatePermitted">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button"
                                @click="showDeletingModal(item, i)" :loading="item.isDeleting"
                                v-if="isDeletePermitted">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!--Adding Modal-->
        <Modal v-model="modal" title="Add Role" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Role Name">
                    <Input v-model="formData.roleName"></Input>
                </FormItem>

                <footer class="text-right">
                    <Button type="default" size="small" @click="modal = false">Cancel</Button>
                    <Button type="success" size="small" class="ml-2" @click="savingData" :disabled="isSaving"
                        :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
                </footer>
            </Form>
        </Modal>


        <!--Editing Modal-->
        <Modal v-model="editModal" title="Edit Role" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Role Name">
                    <Input v-model="formDataEdit.roleName"></Input>
                </FormItem>
                <footer class="text-right">
                    <Button type="default" size="small" @click="editModal = false">Cancel</Button>
                    <Button type="success" size="small" class="ml-2" @click="updatingData" :disabled="isSaving"
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
            items: [],
            formData: {
                roleName: ''
            },
            formDataEdit: {
                roleName: ''
            },
            index: -1,
            deletingModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1
        }
    },

    async created() {
        const res = await this.callAPI('get', 'admin/role-list');
        if (res.status == 200) {
            this.items = res.data;
        } else {
            this.err();
        }
    },
    methods: {
        async savingData() {
            if (this.formData.roleName.trim() == '')
                return this.err('Role name is required');

            const res = await this.callAPI('post', 'admin/save-role', this.formData)
            if (res.status === 201) {
                this.items.unshift(res.data);
                this.success("Role saved successfully!");
                this.modal = false;
                this.formData.roleName = '';
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
            if (this.formDataEdit.roleName.trim() == '')
                return this.err('Role name is required');

            const res = await this.callAPI('post', 'admin/update-role', this.formDataEdit)

            if (res.status === 200) {
                if (res.data.status === 422) {
                    let errors = res.data.errors;
                    for (let field of Object.keys(errors)) {
                        this.err(errors[field]);
                    }
                } else {
                    this.items[this.index].roleName = this.formDataEdit.roleName;
                    this.success("Role updated successfully!");
                    this.editModal = false;
                }
            } else {
                this.err("Oops!", "Something went wrong!");
            }
        },

        showEditModal(item, index) {
            let obj = {
                id: item.id,
                roleName: item.roleName
            }
            this.formDataEdit = obj;
            this.editModal = true;
            this.index = index;
        },

        showDeletingModal(item, i) {
            const deleteModalObj = {
                deletingModal: true,
                deleteUrl: '/admin/delete-role',
                data: item,
                deletingIndex: i,
                isDeleted: false
            }
            this.$store.commit('setDeletingModalObj', deleteModalObj);
        }
    },
    components: {
        deleteModal
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    },
    watch: {
        getDeleteModalObj(obj) {
            if (obj.isDeleted) {
                this.items.splice(obj.deletingIndex, 1);
            }
        }
    }
}
</script>