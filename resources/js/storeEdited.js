import { createApp } from 'vue'
import { createStore } from 'vuex'

export default createStore({
    state:{
        deleteModalObj: {
            deletingModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false
        }
    },

    getters:{
        getDeleteModalObj(state){
            return state.deleteModalObj
        }
    },

    mutations:{
        setDeleteModal(state){
            state.deleteModalObj.isDeleted = true;
        },
        setDeletingModalObj(state, data){
            state.deleteModalObj = data;
        }
    },
    
    actions:{

    }
});