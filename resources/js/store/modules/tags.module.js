import axios from "axios";

export default{
    namespaced: true,
    state: {
        tagList: {
            loading: false,
            tags: [],
            errorMessage: null,
        }
    },
    mutations: {
        GET_TAGS_REQUEST: function(state){
            state.tagList.loading = true;
        },
        GET_TAGS_SUCCESS: function (state, payload) {
            state.tagList.loading = false;
            state.tagList.tags = payload.tags;
        },
        GET_TAGS_FAILED: function (state, payload) {
            state.tagList.loading = false;
            state.tagList.errorMessage = payload.error;
        },
    },
    actions: {
        getTags: async function ({commit}){
            try {
                commit("GET_TAGS_REQUEST");
                const res = await axios.get('admin/tag-list');
                // console.log(res.data);
                commit("GET_TAGS_SUCCESS", {tags: res.data});
            } catch (error) {
                commit("GET_TAGS_FAILED", {error: error});
            }
        }
    }
}