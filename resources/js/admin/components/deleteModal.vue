<template>
    <div>
        <Modal v-model="getDeleteModalObj.deletingModal" width="360"
        :mask-closable="false"
        :closable="false">
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
export default{
    data(){
        return {
            isDeleting: false
        }
    },
    methods:{
        async deleteData() {
            // this.$store.commit('setDeleteModal');
            
            this.isDeleting = true;
            const res = await this.callAPI('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data);
            if (res.status === 200) {
                this.success("Data has been deleted successfully!");
                this.$store.commit('setDeleteModal', true);
            } else {
                this.err("Something went wrong");
                this.$store.commit('setDeleteModal', false);
            }
        },
    },
    computed:{
        ...mapGetters(['getDeleteModalObj'])
    }
};
</script>