import { createStore } from 'vuex'

export default createStore({
    state: {
        counter: 1000,
        deleteModalObj: {
            deletingModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
            isDeleted: false
        },
    },

    getters: {
        getCounter(state){
            return state.counter
        },
        getDeleteModalObj(state){
            return state.deleteModalObj;
        }
    },

    mutations: {
        changeTheCounter(state, data){
            // console.log(data);
            state.counter += data;
        },
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
        }
    },

    actions: {
        changeCounterAction({commit}, data){
            commit('changeTheCounter', data);
        }
    }
}); 