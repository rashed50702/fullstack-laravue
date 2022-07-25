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
                <div v-if="tagState.loading">
                    <Spinner />
                </div>
                <div v-if="!tagState.loading && tagState.errorMessage">
                    <p>{{tagState.errorMessage}}</p>
                </div>
                <table class="table" v-if="!tagState.loading && tagState.tags.length > 0">
                    <!-- TABLE TITLE -->
                    <tr>
                        <th>#</th>
                        <th>Tag Name</th>
                        <th>Created At</th>
                        <th class="text-center">Action</th>
                    </tr>

                    <!-- TABLE ITEMS -->
                    <tr v-for="(tag, i) in tagState.tags" :key="tag.id" v-if="tagState.tags.length">
                        <td>{{ i + 1 }}</td>
                        <td class="_table_name">{{ tag.tagName }}</td>
                        <td>{{ tag.created_at }}</td>
                        <td class="text-center">
                            <button class="_btn _action_btn edit_btn1" type="button">Edit</button>
                            <button class="_btn _action_btn make_btn1 ml-2" type="button">Delete</button>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</template>

<script>
import Spinner from "../../components/Spinner.vue";
import { mapGetters } from 'vuex';

export default {

    created() {
        this.$store.dispatch("tagsModule/getTags");
    },

    
    // computed: {
    //     ...mapGetters(['getTagsState','getDeleteModalObj'])
    // },

    computed: mapGetters({
        tagState: "getTagsState",
        getDeleteModalObj: "getDeleteModalObj"
    }),
    
    components:{
        Spinner
    }
    
}
</script>