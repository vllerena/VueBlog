import Vue from "vue";
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 100,
        deleteModalObj : {
            showDeleteModal: false,
            deleteUrl : '',
            data : null,
            deletingIndex: -1,
            isDeleted : false,
        },
    },
    getters: {
        getCounter(state){
            return state.counter
        },
        getDeleteModalObj(state){
            return state.deleteModalObj
        },
    },
    mutations: {
        changeTheCounter(state, data){
            state.counter += data
        },
        setDeleteModal(state, data){
            state.deleteModalObj = {
                showDeleteModal: false,
                deleteUrl: '',
                data: null,
                deletingIndex: -1,
                isDeleted: data,
            }
        },
        setDeletingModalObj(state, data){
            state.deleteModalObj = data
        },
    },
    actions: {
        changeCounterAction({commit}, data){
            commit('changeTheCounter', data)
        }
    }
})
