import {get, makePathByParams} from '../../api/base_api.js'

const state = {
    musicRanking: [],
    videoRanking: [],
    albumRanking: [],
    artistRanking: [],
}

const getters = {
    musicRanking(state) {
        return state.musicRanking;
    },
    videoRanking(state) {
        return state.videoRanking;
    },
    albumRanking(state) {
        return state.albumRanking;
    },
    artistRanking(state) {
        return state.artistRanking;
    }
}

const mutations = {
    setMusicRanking(state, payload) {
        state.musicRanking = payload;
    },
    setVideoRanking(state, payload) {
        state.videoRanking = payload;
    },
    setAlbumRanking(state, payload) {
        state.albumRanking = payload;
    },
    setArtistRanking(state, payload) {
        state.artistRanking = payload;
    }
}

const actions = {
    getMusicRanking({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('ranking/media', data))
                .then(res => {
                    commit('setMusicRanking', res.data.data);
                })
                .catch(err => {
                    reject(err)
                });
        });
    },
    getVideoRanking({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('ranking/media', data))
                .then(res => {
                    commit('setVideoRanking', res.data.data);
                })
                .catch(err => {
                    reject(err)
                });
        });
    },
    getAlbumRanking({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('ranking/media', data))
                .then(res => {
                    commit('setAlbumRanking', res.data.data);
                })
                .catch(err => {
                    reject(err)
                });
        });
    },
    getArtistRanking({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('ranking/artist', data))
                .then(res => {
                    commit('setArtistRanking', res.data.data);
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
