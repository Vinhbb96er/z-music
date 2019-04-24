import {get} from '../../api/base_api.js'

const state = {
    sliderItems: [],
    newAlbums: []
}

const getters = {
    sliderItems(state) {
        return state.sliderItems;
    },
    newAlbums(state) {
        return state.newAlbums;
    }
}

const mutations = {
    setSliders(state, payload) {
        state.sliderItems = payload;
    },
    setNewAlbums(state, payload) {
        state.newAlbums = payload;
    }
}

const actions = {
    getSliders({commit}) {
        return new Promise((resolve, reject) => {
            get('home/slider')
                .then(res => {
                    commit('setSliders', res.data.data);
                })
                .catch(err => {
                    reject(err)
                });
        });
    },
    getNewAlbums({commit}) {
        return new Promise((resolve, reject) => {
            get('home/new-albums')
                .then(res => {
                    commit('setNewAlbums', res.data.data);
                })
                .catch(err => {
                    reject(err)
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
