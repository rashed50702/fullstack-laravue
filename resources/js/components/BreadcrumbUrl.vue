<template>
    <div>
        <div class="ivu-breadcrumb">
            <span><a href="/" target="_self" class="ivu-breadcrumb-item-link"><i
                        class="ivu-icon ivu-icon-ios-home-outline"></i> Home </a>
                <span class="ivu-breadcrumb-item-separator">/</span></span>
            <span><a href="/components/breadcrumb" target="_self" class="ivu-breadcrumb-item-link"><i
                        class="ivu-icon ivu-icon-logo-buffer"></i> Components </a>
                <span class="ivu-breadcrumb-item-separator">/</span></span>

            <span >
                <span class="ivu-breadcrumb-item-link">
                    <i class="ivu-icon ivu-icon-ios-cafe"></i> ok
                </span>
            </span>
        </div>

        <br>
        <br>
        <br>
        <br>
        <br>
        <br>
        <BreadcrumbItem to="/">
            <Icon type="ios-home-outline"></Icon> Home
        </BreadcrumbItem>
        <span v-for="(up, i) in $store.state.userPermission" :key="i">
            <BreadcrumbItem v-if="up.name == urlSegment">
                <Icon :type="up.iconType"></Icon> {{up.resourceName}}
            </BreadcrumbItem>
        </span>
        <BreadcrumbItem>
            <Icon type="ios-cafe"></Icon> Breadcrumb
        </BreadcrumbItem>

        <Breadcrumb>
            <BreadcrumbItem to="/">
                <Icon type="ios-home-outline"></Icon> Home
            </BreadcrumbItem>
            <BreadcrumbItem>ok</BreadcrumbItem>
            <BreadcrumbItem>ok</BreadcrumbItem>
            <span v-for="(up, i) in $store.state.userPermission" :key="i">
                <BreadcrumbItem v-if="up.name == urlSegment">
                    <Icon :type="up.iconType"></Icon> {{up.resourceName}}
                </BreadcrumbItem>

            </span>
        </Breadcrumb>
        <Breadcrumb>
            <BreadcrumbItem>ok</BreadcrumbItem>
            <span v-for="(up, i) in $store.state.userPermission" :key="i">
                <span v-if="up.name == urlSegment">
                    <BreadcrumbItem>ok</BreadcrumbItem>
                </span>
            </span>
        </Breadcrumb>

    </div>
</template>
<script>
// import { mapGetters } from 'vuex';

export default{
    data(){
        return {
            urlSegment: '',
            breadcrumbUrl: ''
        }
    },
    created(){
        // this.urlSegment = window.location.href.split('/').pop();

        // console.log(this.$store.state.userPermission);
        // let b = this.$store.state.userPermission;
        
        // const numbers = [45, 4, 9, 16, 25];

        // let txt = "";
        // for (let x in numbers) {
        //     txt = x;
        //     console.log(txt); 
        // }


        // for (let x in b){
        //     console.log(x.resourceName);
        //     // if(k.name == this.urlSegment){
        //     //     this.breadcrumbUrl = k.name;
        //     //     // console.log(this.breadcrumbUrl);
        //     // }
        // }
        
    },

    // computed: {
    //     ...mapGetters(['getUserPermission'])
    // }
    
}
</script>