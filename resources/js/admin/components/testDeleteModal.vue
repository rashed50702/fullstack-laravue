<template>
    <div>
        <Modal v-model="deletingModal" width="360">
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
                <Button type="error" size="large" long>Delete</Button>
            </template>
        </Modal>
    </div>
</template>
<script>
export default{
    data(){
        return{
            deletingModal: true
        }
    }
}
</script>