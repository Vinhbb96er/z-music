import {get, makePathByParams} from '../../api/base_api.js'

const state = {
    sliderItems: [],
    newAlbums: [],
    mediaHot: [],
    mediaNew: []
}

const getters = {
    sliderItems(state) {
        return state.sliderItems;
    },
    newAlbums(state) {
        return state.newAlbums;
    },
    mediaHot() {
        return state.mediaHot;
    }
    ,
    mediaNew() {
        return state.mediaNew;
    }
}

const mutations = {
    setSliders(state, payload) {
        state.sliderItems = payload;
    },
    setNewAlbums(state, payload) {
        state.newAlbums = payload;
    },
    setMediaHot(state, payload) {
        state.mediaHot = payload;
    },
    setMediaNew(state, payload) {
        state.mediaNew = payload;
    }
}

const actions = {
    getSliders({commit}) {
        return new Promise((resolve, reject) => {
            get('media/slider')
                .then(res => {
                    commit('setSliders', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getNewAlbums({commit}) {
        return new Promise((resolve, reject) => {
            get('media/new-albums')
                .then(res => {
                    commit('setNewAlbums', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getMediaHot({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('media/hot', data))
                .then(res => {
                    commit('setMediaHot', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getMediaNew({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('media/new', data))
                .then(res => {
                    commit('setMediaNew', res.data.data);
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
