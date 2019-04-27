import {get} from '../../api/base_api.js'

const state = {
    popularRegions: []
}

const getters = {
    popularRegions(state) {
        return state.popularRegions;
    }
}

const mutations = {
    setPopularRegions(state, payload) {
        state.popularRegions = payload;
    }
}

const actions = {
    getPopularRegions({commit}) {
        return new Promise((resolve, reject) => {
            get('region/popular')
                .then(res => {
                    commit('setPopularRegions', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    }
}

export default {
    state,
    getters,
    mutations,
    actions
}
