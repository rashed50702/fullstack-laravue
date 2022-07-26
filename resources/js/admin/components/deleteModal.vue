<template>
    <div>
        <Modal v-model="getDeleteModalObj.deletingModal" width="360" :mask-closable="false" :closable="false">
            <template #header>
                <p style="color:#f60;text-align:center">
                    <Icon type="ios-information-circle"></Icon>
                    <span>Delete confirmation</span>
                </p>
            </template>
            <div style="text-align:center">
                <p>Are you sure you want to delete {{getDeleteModalObj.deletingItemMsg}}?</p>
            </div>
            <template #footer>
                <Button type="default" size="small" :loading="isDeleting" :disabled="isDeleting"
                    @click="closeModal">Close</Button>
                <Button type="error" size="small" :loading="isDeleting" :disabled="isDeleting"
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
            this.isDeleting = true;

            try {
                const res = await this.callAPI('post', this.getDeleteModalObj.deleteUrl, this.getDeleteModalObj.data);
                if (res.status === 200) {
                    this.success(this.getDeleteModalObj.deletingItemMsg + " has been deleted successfully!");
                    this.$store.commit('setDeleteModal', true);
                } else {
                    this.err("Something went wrong");
                    this.$store.commit('setDeleteModal', false);
                }
                this.isDeleting = false;
            } catch (error) {
                this.err("Something went wrong!", "Oops!");
                this.isDeleting = false;
                // console.log(error);
            }
            
            
        },

        closeModal(){
            this.$store.commit('setDeleteModal', false);
        }
    },
    computed:{
        ...mapGetters(['getDeleteModalObj'])
    }
};
</script>