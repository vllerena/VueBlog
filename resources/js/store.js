import Vue from "vue";
import Vuex from 'vuex'

Vue.use(Vuex)

export default new Vuex.Store({
    state: {
        counter: 100,
        deleteModalObj: {
            showDeleteModal: false,
            deleteUrl: '',
            data: null,
            deletingIndex: -1,
        }
    },
    getters: {
        getCounter(state){
            return state.counter
        },
        getDeleteModalObj(state){
            return state.deleteModalObj
        }
    },
    mutations: {
        changeTheCounter(state, data){
            state.counter += data
        }
    },
    actions: {
        changeCounterAction({commit}, data){
            commit('changeTheCounter', data)
        }
    }
})
export const strict = false
export const state = () => ({

})

export const getters = {

}

export const mutations = {

}

export const actions = {

}

