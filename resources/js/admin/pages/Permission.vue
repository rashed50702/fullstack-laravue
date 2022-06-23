<template>
    <div class="content">
        <div class="_1adminOverveiw_table_recent _box_shadow _border_radious _mar_b30 _p20">
            <Breadcrumb>
                <Row>
                    <Col span="12">
                    <BreadcrumbItem to="/">
                        <Icon type="ios-home-outline"></Icon> Home
                    </BreadcrumbItem>
                    <BreadcrumbItem to="/components/breadcrumb">
                        <Icon type="logo-buffer"></Icon> Role Permissions
                    </BreadcrumbItem>
                    <BreadcrumbItem>
                        <Icon type="ios-cafe"></Icon> Breadcrumb
                    </BreadcrumbItem>
                    </Col>
                    <Col span="12">
                    <Row>
                        <Col span="16">
                        <Select placeholder="Select Role" class="float-right"
                            style="max-width: 300px;padding-right: 5px;" v-model="role.id"
                            @on-change="onRoleChange">
                            <Option v-if="items.length" v-for="(r, i) in items" :value="r.id" :key="r.i">
                                {{r.roleName}}
                            </Option>
                        </Select>
                        </Col>
                        <Col span="8">
                        <Button type="success" long :disabled="isSaving" :loading="isSaving" @click="savingData">{{
                            isSaving ? 'SAVING...' :
                            'SAVE' }}</Button>
                        </Col>
                    </Row>
                    </Col>
                </Row>
            </Breadcrumb>

            <!-- Table -->
            <div class="mt-2">
                <table class="table table-bordered table-hover">
                    <!-- TABLE TITLE -->
                    <thead>
                        <tr>
                            <th>Resource Name</th>
                            <th>Read</th>
                            <th>Write</th>
                            <th>Update</th>
                            <th>Delete</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(resource, i) in resources" :key="i">
                            <td class="bold">{{resource.resourceName}}</td>
                            <td>
                                <Checkbox v-model="resource.read"></Checkbox>
                            </td>
                            <td>
                                <Checkbox v-model="resource.write"></Checkbox>
                            </td>
                            <td>
                                <Checkbox v-model="resource.update"></Checkbox>
                            </td>
                            <td>
                                <Checkbox v-model="resource.delete"></Checkbox>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <!-- Table End -->

        </div>
    </div>
</template>

<script>

export default {
    data() {
        return {
            role: {
                id: null
            },
            items: [],
            defaultResources: [
                {resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/'},
                {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                { resourceName: 'Categories', read: false, write: false, update: false, delete: false, name: 'categories'},
                { resourceName: 'Admin Users', read: false, write: false, update: false, delete: false, name: 'admin-users'},
                { resourceName: 'Roles', read: false, write: false, update: false, delete: false, name: 'roles'},
                { resourceName: 'Role Permissions', read: false, write: false, update: false, delete: false, name: 'role-permissions'},
            ],
            resources: [
                { resourceName: 'Home', read: false, write: false, update: false, delete: false, name: '/' },
                { resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags' },
                { resourceName: 'Categories', read: false, write: false, update: false, delete: false, name: 'categories' },
                { resourceName: 'Admin Users', read: false, write: false, update: false, delete: false, name: 'admin-users' },
                { resourceName: 'Roles', read: false, write: false, update: false, delete: false, name: 'roles' },
                { resourceName: 'Role Permissions', read: false, write: false, update: false, delete: false, name: 'role-permissions' },
            ],
            isSaving: false,
        }
    },

    async created() {
        const res = await this.callAPI('get', 'admin/role-list');
        if (res.status == 200) {
            this.items = res.data;
            if(res.data.length){
                this.role.id = res.data[0].id;
                if(res.data[0].permission){
                    this.resources = JSON.parse(res.data[0].permission)
                }
            }
        } else {
            this.err();
        }

    },
    methods: {
        async savingData(){
            let data = JSON.stringify(this.resources);
            const res = await this.callAPI('post', 'admin/saving-permissions', {'permission' : data, id: this.role.id});
            if (res.status === 200) {
                this.success("Permissions assigned successfully!");
                let index = this.items.findIndex(item => item.id == this.role.id);
                this.items[index].permission = data;
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

        onRoleChange(){
            let index = this.items.findIndex(item => item.id == this.role.id);
            let permission = this.items[index].permission;
            if(!permission){
                this.resources = this.defaultResources;
            }else{
                this.resources = JSON.parse(permission);
            }
        }
    },
}
</script>