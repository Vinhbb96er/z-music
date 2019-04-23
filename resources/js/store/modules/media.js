import {get} from '../../api/base_api.js'

const state = {
    sliderItems: []
}

const getters = {
    sliderItems(state) {
        return state.sliderItems;
    }
}

const mutations = {
    setSliders(state, payload) {
        state.sliderItems = payload;
    }
}

const actions = {
    getSliders({commit}) {
        return new Promise((resolve, reject) => {
            get(`home/get-slider`)
                .then(res => {
                    commit('setSliders', res.data.data);
                })
                .catch(err => {
                    reject(err)
                });
        })
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
