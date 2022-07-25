import { createStore } from 'vuex'
import tagsModule from './store/modules/tags.module'

export default createStore({
    state: {
        deleteModalObj: {
            deletingModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false
        },
        user: false,
        userPermission: null,
        tagsState: tagsModule.state
    },

    modules:{
        tagsModule
    },

    getters: {
        getDeleteModalObj(state){
            return state.deleteModalObj;
        },
        getUserPermission(state){
            return state.userPermission;
        },
        getTagsState(state){
            return state.tagsState.tagList;
        }
    },

    mutations: {
        setDeleteModal(state, data){
            const deleteModalObj= {
                deletingModal: false,
                deleteUrl: '',
                data: null,
                deletingIndex: state.deleteModalObj.deletingIndex,
                isDeleted: data
            }

            state.deleteModalObj = deleteModalObj;
        },
        setDeletingModalObj(state, data){
            state.deleteModalObj = data
        },

        setUpdateUser(state, data){
            state.user = data
        },
        setUserPermission(state, data){
            state.userPermission = data
        }
    },
}); 