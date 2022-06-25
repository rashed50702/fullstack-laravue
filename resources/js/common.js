import { mapGetters } from 'vuex';

export default{
    data(){
        return{

        }
    },

    methods:{
        callAPI(method, url, dataObj) {
            try {
                return axios({
                    method: method,
                    url: url,
                    data: dataObj
                });

            } catch (e) {
                return e.response
            }
        },
        info(desc, title = "info") {
            this.$Notice.info({
                title: title,
                desc: desc
            });
        },
        success(desc, title = "Success!") {
            this.$Notice.success({
                title: title,
                desc: desc
            });
        },
        warning(desc, title = "Warning!") {
            this.$Notice.warning({
                title: title,
                desc: desc
            });
        },
        err(desc, title = "Error!") {
            this.$Notice.error({
                title: title,
                desc: desc
            });
        },

        checkUserPermission(key){
            if(!this.userPermisson) return true;
            let isPermitted = false;
            for(let p of this.userPermisson){
                if(this.$route.name == p.name){
                    if(p[key]){
                        isPermitted = true;
                        break;
                    }else{
                        break;
                    }
                }
            }
            return isPermitted;
        }
    },

    computed:{
        ...mapGetters({
            'userPermisson': 'getUserPermission'
        }),
        isReadPermitted(){
            return this.checkUserPermission('read');
        },
        isWritePermitted(){
            return this.checkUserPermission('write');
        },
        isUpdatePermitted(){
            return this.checkUserPermission('update');
        },
        isDeletePermitted(){
            return this.checkUserPermission('delete');
        }
    }
}