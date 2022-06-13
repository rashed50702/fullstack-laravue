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
        }
    }
}