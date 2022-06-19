<template>
    <div class="content">
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
            <p class="_title0">Admin Users
                <Button type="default" size="small" @click="modal = true">
                    <Icon type="ios-add" />Add New
                </Button>
            </p>
            <div class="_overflow _table_div">
                <table class="table">
                    <!-- TABLE TITLE -->
                    <tr>
                        <th>#</th>
                        <th>Full Name</th>
                        <th>Email</th>
                        <th>User Type</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>

                    <!-- TABLE ITEMS -->
                    <tr v-for="(user, i) in users" :key="user.id" v-if="users.length">
                        <td>{{ i + 1 }}</td>
                        <td class="_table_name">{{ user.fullName }}</td>
                        <td>{{ user.email }}</td>
                        <td>{{ user.userType }}</td>
                        <td>{{ user.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button"
                                @click="showEditModal(user, i)">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button"
                                @click="showDeletingModal(user, i)" :loading="user.isDeleting">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!--Adding Modal-->
        <Modal v-model="modal" title="Add Admin USer" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Full Name">
                    <Input type="text" v-model="formData.fullName" placeholder="Enter your name"></Input>
                </FormItem>
                <FormItem label="E-mail">
                    <Input type="email" v-model="formData.email" placeholder="Enter your e-mail"></Input>
                </FormItem>
                <FormItem label="Password">
                    <Input type="password" v-model="formData.password" placeholder="Enter your e-mail"></Input>
                </FormItem>
                <FormItem label="User Type">
                    <Select placeholder="Select User Type" v-model="formData.userType">
                        <Option value="Admin">Admin</Option>
                        <Option value="Editor">Editor</Option>
                        <Option value="Publisher">Publisher</Option>
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
            users: [],
            formData: {
                fullName: '',
                email: '',
                password: '',
                userType: '',
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
        const res = await this.callAPI('get', 'admin-user-list');
        if (res.status == 200) {
            this.users = res.data;
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
            if (this.formData.userType.trim() == '')
                return this.err('User type is required');

            const res = await this.callAPI('post', 'save-admin-user', this.formData)
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