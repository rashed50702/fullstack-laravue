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
                            <Icon type="ios-contacts"></Icon> Contacts
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
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>User Role</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>

                    <!-- TABLE ITEMS -->
                    <tr v-for="(user, i) in users" :key="user.id" v-if="users.length">
                        <td>{{ i + 1 }}</td>
                        <td class="_table_name">{{ user.fullName }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.role ? user.role.roleName : '' }}</td>
                        <td>{{ user.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button" @click="showEditModal(user, i)"
                                v-if="isUpdatePermitted">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button"
                                @click="showDeletingModal(user, i)" :loading="user.isDeleting"
                                v-if="isDeletePermitted">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!--Adding Modal-->
        <Modal v-model="modal" title="Add Admin USer" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem>
                    <Input type="text" v-model="formData.fullName" placeholder="Enter full name"></Input>
                </FormItem>
                <FormItem>
                    <Input type="email" v-model="formData.email" placeholder="Enter e-mail"></Input>
                </FormItem>
                <FormItem>
                    <Input type="password" v-model="formData.password" placeholder="Enter password"></Input>
                </FormItem>
                <FormItem>
                    <Select placeholder="Select User Type" v-model="formData.role_id">
                        <Option v-if="roles.length" v-for="(r, i) in roles" :value="r.id" :key="r.i">{{r.roleName}}
                        </Option>
                    </Select>
                </FormItem>
                <footer class="text-right">
                    <Button type="default" size="small" @click="modal = false">Cancel</Button>
                    <Button type="success" size="small" class="ml-2" @click="savingData" :disabled="isSaving"
                        :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
                </footer>
            </Form>
        </Modal>


        <!--Editing Modal-->
        <Modal v-model="editModal" title="Edit Admin User" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem>
                    <Input type="text" v-model="formDataEdit.fullName" placeholder="Enter full name"></Input>
                </FormItem>
                <FormItem>
                    <Input type="email" v-model="formDataEdit.email" placeholder="Enter e-mail"></Input>
                </FormItem>
                <FormItem>
                    <Input type="password" v-model="formDataEdit.password" placeholder="Enter password"></Input>
                </FormItem>
                <FormItem>
                    <Select placeholder="Select User Type" v-model="formDataEdit.role_id">
                        <Option v-if="roles.length" v-for="(r, i) in roles" :value="r.id" :key="r.i">{{r.roleName}}
                        </Option>
                    </Select>
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
            users: [],
            roles: [],
            formData: {
                fullName: '',
                email: '',
                password: '',
                role_id: null,
            },
            formDataEdit: {
                fullName: '',
                email: '',
                role_id: null,
            },
            index: -1,
            deletingModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1
        }
    },

    async created() {
        const [res, resRole] = await Promise.all([
            this.callAPI('get', 'admin/admin-user-list'),
            this.callAPI('get', 'admin/role-list'),
        ]);

        if (res.status == 200) {
            this.users = res.data;
        } else {
            this.err();
        }

        if (resRole.status == 200) {
            this.roles = resRole.data;
        } else {
            this.err();
        }
    },
    methods: {
        async savingData() {
            if (this.formData.fullName.trim() == '')
                return this.err('Full name is required');
            if (this.formData.email.trim() == '')
                return this.err('Email is required');
            if (this.formData.password.trim() == '')
                return this.err('Password is required');
            if (!this.formData.role_id)
                return this.err('Role is required');

            const res = await this.callAPI('post', 'admin/save-admin-user', this.formData)
            if (res.status === 201) {
                this.users.unshift(res.data);
                this.success("Admin user saved successfully!");
                this.modal = false;
            } else {
                if (res.data.status === 422) {
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
            if (this.formDataEdit.fullName.trim() == '')
                return this.err('Full name is required');
            if (this.formDataEdit.email.trim() == '')
                return this.err('Email is required');
            if (!this.formDataEdit.role_id)
                return this.err('Role is required');

            const res = await this.callAPI('post', 'admin/update-admin-user', this.formDataEdit)

            if (res.status === 200) {
                if (res.data.status === 422) {
                    let errors = res.data.errors;
                    for (let field of Object.keys(errors)) {
                        this.err(errors[field]);
                    }
                } else {
                    this.users[this.index] = this.formDataEdit;
                    this.success("Data updated successfully!");
                    this.editModal = false;
                }
            } else {
                this.err("Oops!", "Something went wrong!");
            }
        },

        showEditModal(user, index) {
            let obj = {
                id: user.id,
                fullName: user.fullName,
                email: user.email,
                role_id: user.role_id,
            }
            this.formDataEdit = obj;
            this.editModal = true;
            this.index = index;
        },

        showDeletingModal(user, i) {
            const deleteModalObj = {
                deletingModal: true,
                deleteUrl: 'admin/delete-admin-user',
                data: {id:user.id},
                deletingIndex: i,
                isDeleted: false,
                deletingItemMsg: 'Admin User'
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
                this.tags.splice(obj.deletingIndex, 1);
            }
        }
    }
}
</script>