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
                    <Select placeholder="Select Role" class="float-right" style="max-width: 300px;">
                        <Option v-if="items.length" v-for="(r, i) in items" :value="r.id" :key="r.i">{{r.roleName}}
                        </Option>
                    </Select>
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
            items: [],
            resources: [
                {resourceName: 'Tags', read: false, write: false, update: false, delete: false, name: 'tags'},
                { resourceName: 'Categories', read: false, write: false, update: false, delete: false, name: 'categories'},
                { resourceName: 'Admin Users', read: false, write: false, update: false, delete: false, name: 'AdminUser'},
                { resourceName: 'Roles', read: false, write: false, update: false, delete: false, name: 'role'},
                { resourceName: 'Role Permissions', read: false, write: false, update: false, delete: false, name: 'Permission'},
            ],
            isSaving: false,
        }
    },

    async created() {
        const res = await this.callAPI('get', 'admin/role-list');
        if (res.status == 200) {
            this.items = res.data;
        } else {
            this.err();
        }

        console.log(this.$route);
    },
    methods: {
        
    },
}
</script>