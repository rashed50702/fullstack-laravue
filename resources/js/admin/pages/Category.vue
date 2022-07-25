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
                            <Icon type="ios-list-box"></Icon> Categories
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
                        <th>Icon Image</th>
                        <th>Category Name</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>

                    <!-- TABLE ITEMS -->
                    <tr v-for="(category, i) in categories" :key="i" v-if="categories.length">
                        <td>{{ i + 1 }}</td>
                        <td class="table_image">
                            <img :src="category.iconImage" alt="Image" v-if="category.iconImage">
                            <img src="/uploads/default.png" alt="Image" v-else>
                        </td>
                        <td class="_table_name">{{ category.categoryName }}</td>
                        <td>{{ category.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button" @click="showEditModal(category, i)"
                                v-if="isUpdatePermitted">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button"
                                @click="showDeletingModal(category, i)" :loading="category.isDeleting"
                                v-if="isDeletePermitted">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>

        <!--Adding Modal-->
        <Modal v-model="modal" title="Add Category" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Category Name">
                    <Input v-model="formData.categoryName"></Input>
                </FormItem>

                <Upload type="drag" :headers="{ 'x-csrf-token': token, 'X-Requested-With':'XMLHttpRequest'}"
                    :on-success="handleSuccess" :on-error="handleError" :format="['jpg','jpeg','png']"
                    :on-format-error="handleFormatError" :max-size="2048" :on-exceeded-size="handleMaxSize"
                    ref="clearUpload" action="admin/category-img-upload">
                    <div style="padding: 20px 0">
                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                        <p>Click or drag files here to upload</p>
                    </div>
                </Upload>
                <div class="demo-upload-list" v-if="formData.iconImage">
                    <img :src="`${formData.iconImage}`" alt="Image" />
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage"></Icon>
                    </div>
                </div>
                <div class="image_thumb">

                </div>

                <footer class="text-right">
                    <Button type="default" size="small" @click="modal = false">Cancel</Button>
                    <Button type="success" size="small" class="ml-2" @click="savingData" :disabled="isSaving"
                        :loading="isSaving">{{ isSaving ? 'Saving...' : 'Save' }}</Button>
                </footer>
            </Form>


        </Modal>


        <!--Editing Modal-->
        <Modal v-model="editModal" title="Edit Category" :mask-closable="false" :closable="false" footer-hide>
            <Form>
                <FormItem label="Category Name">
                    <Input v-model="formDataEdit.categoryName"></Input>
                </FormItem>
        
                <Upload type="drag" :headers="{ 'x-csrf-token': token, 'X-Requested-With':'XMLHttpRequest'}"
                    :on-success="handleSuccess" :on-error="handleError" :format="['jpg','jpeg','png']"
                    :on-format-error="handleFormatError" :max-size="2048" :on-exceeded-size="handleMaxSize"
                    v-show="isIconImageNew" ref="clearUploadEdit" action="admin/category-img-upload">
                    <div style="padding: 20px 0">
                        <Icon type="ios-cloud-upload" size="52" style="color: #3399ff"></Icon>
                        <p>Click or drag files here to upload</p>
                    </div>
                </Upload>
                <div class="demo-upload-list" v-if="formDataEdit.iconImage">
                    <img :src="`${formDataEdit.iconImage}`" alt="Image" />
                    <div class="demo-upload-list-cover">
                        <Icon type="ios-trash-outline" @click="deleteImage(false)"></Icon>
                    </div>
                </div>
                <div class="image_thumb">

                </div>
                <footer class="text-right">
                    <Button type="default" size="small" @click="closeEditModal">Cancel</Button>
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
            categories: [],
            formData: {
                iconImage: '',
                categoryName: ''
            },
            formDataEdit: {
                iconImage: '',
                categoryName: ''
            },
            index: -1,
            deletingModal: false,
            deleteItem: {},
            isDeleting: false,
            deletingIndex: -1,
            token: '',
            isIconImageNew: false,
            isEditingItem: false
        }
    },

    async created() {
        this.token = window.Laravel.csrfToken;
        const res = await this.callAPI('get', 'admin/categories-list');
        if (res.status == 200) {
            this.categories = res.data;
        } else {
            this.err();
        }
    },
    methods: {
        handleSuccess(res, file) {
            res = `/uploads/${res}`;
            if (this.isEditingItem){
                return this.formDataEdit.iconImage = res;
            }
            this.formData.iconImage = res;
        },
        handleError(res, file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: `${file.errors.file.length ? file.errors.file[0]: 'Something went wrong!'}`
            });
        },
        handleFormatError(file) {
            this.$Notice.warning({
                title: 'The file format is incorrect',
                desc: 'File format of ' + file.name + ' is incorrect, please select jpg or png.'
            });
        },
        handleMaxSize(file) {
            this.$Notice.warning({
                title: 'Exceeding file size limit',
                desc: 'File  ' + file.name + ' is too large, no more than 2M.'
            });
        },

        async deleteImage(isAdd = true){
            let image;
            if(!isAdd){//for editing...
                this.isIconImageNew = true;
                image = this.formDataEdit.iconImage;
                this.formDataEdit.iconImage = '';
                this.$refs.clearUploadEdit.clearFiles();
            }else{
                image = this.formData.iconImage;
                this.formData.iconImage = '';
                this.$refs.clearUpload.clearFiles();
            }
            
            const res = await this.callAPI('post', 'admin/delete-image', {imageName:image});
            if(res.status != 200){
                this.formData.iconImage = image;
                this.err();
            }
            console.log(res);
        },

        async savingData() {
            if (this.formData.categoryName.trim() == '')
                return this.err('Category name is required');
            if (this.formData.iconImage.trim() == '')
                return this.err('Icon image is required');
            this.formData.iconImage = `${this.formData.iconImage}`;

            const res = await this.callAPI('post', 'admin/category-save', this.formData)
            if (res.status === 201) {
                this.categories.unshift(res.data);
                this.success("Category saved successfully!");
                this.modal = false;
                this.formData.categoryName = '';
                this.formData.iconImage = '';
                this.$refs.clearUpload.clearFiles();
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
            if (this.formDataEdit.categoryName.trim() == '')
                return this.err('Category name is required');
            if (this.formDataEdit.iconImage.trim() == '')
                return this.err('Icon image is required');

            this.formDataEdit.iconImage = `${this.formDataEdit.iconImage}`;

            const res = await this.callAPI('post', 'admin/category-update', this.formDataEdit)

            if (res.status === 200) {
                if (res.data.status === 422) {
                    let errors = res.data.errors;
                    for (let field of Object.keys(errors)) {
                        this.err(errors[field]);
                    }
                } else {
                    this.categories[this.index].categoryName = this.formDataEdit.categoryName;
                    this.success("Category updated successfully!");
                    this.editModal = false;
                }
            } else {
                this.err("Oops!", "Something went wrong!");
            }
        },

        showEditModal(category, index) {
            // let obj = {
            //     id: category.id,
            //     categoryName: category.categoryName,
            //     iconImage: category.iconImage
            // }
            if(category.iconImage == null){
                this.isIconImageNew = true;
            }
            this.formDataEdit = category;
            this.editModal = true;
            this.index = index;
            this.isEditingItem = true;
        },

        closeEditModal(){
            this.isEditingItem = false;
            this.editModal = false;

        },

        showDeletingModal(category, i) {
            const deleteModalObj = {
                deletingModal: true,
                deleteUrl: 'admin/delete-category',
                data: category,
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
                this.categories.splice(obj.deletingIndex, 1);
            }
        }
    }
}
</script>
<style>
.demo-upload-list {
    display: inline-block;
    width: 100px;
    height: 100px;
    text-align: center;
    line-height: 100px;
    border: 1px solid transparent;
    border-radius: 4px;
    overflow: hidden;
    background: #fff;
    position: relative;
    box-shadow: 0 1px 1px rgba(0, 0, 0, .2);
    margin-right: 4px;
}
    
.demo-upload-list img {
    width: 100%;
    height: 100%;
}
    
.demo-upload-list-cover {
    display: none;
    position: absolute;
    top: 0;
    bottom: 0;
    left: 0;
    right: 0;
    background: rgba(0, 0, 0, .6);
}
    
.demo-upload-list:hover .demo-upload-list-cover {
    display: block;
}
    
.demo-upload-list-cover i {
    color: #fff;
    font-size: 20px;
    cursor: pointer;
    margin: 0 2px;
}
</style>