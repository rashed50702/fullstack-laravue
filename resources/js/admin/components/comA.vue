<template>
    <div>
        <Modal :value="getDeleteModalObj.deletingModal" width="360">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p>Are you sure you want to delete?.</p>
            </div>
            <template #footer>
                <Button type="error" size="large" long :loading="isDeleting" :disabled="isDeleting"
                    @click="deleteData">Delete</Button>
            </template>
        </Modal>
    </div>
</template>

<script>
import { mapGetters } from 'vuex';
export default {
    data() {
        return {
            isDeleting: false
        }
    },
    methods: {
        async deleteData() {
            this.$store.commit('setDeleteModal');
            // this.isDeleting = true;
            // const res = await this.callAPI('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data);
            // if (res.status === 200) {
            //     this.tags.splice(this.deletingIndex, 1);
            //     this.success("Tag has been deleted successfully!");
            // } else {
            //     this.err("Something went wrong");
            // }
            // this.isDeleting = false;
            // this.deletingModal = false;
        },
    },
    computed: {
        ...mapGetters(['getDeleteModalObj'])
    }
};
</script>