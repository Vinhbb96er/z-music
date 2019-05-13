import {get, post, makePathByParams} from '../../api/base_api.js'

const state = {
    sliderItems: [],
    newAlbums: [],
    mediaHot: [],
    mediaNew: [],
    mediaDetailData: null,
    mediaComments: {},
    mediaSuggest: []
}

const getters = {
    sliderItems(state) {
        return state.sliderItems;
    },
    newAlbums(state) {
        return state.newAlbums;
    },
    mediaHot(state) {
        return state.mediaHot;
    }
    ,
    mediaNew(state) {
        return state.mediaNew;
    },
    mediaDetailData(state) {
        return state.mediaDetailData;
    },
    mediaSuggest(state) {
        return state.mediaSuggest;
    },
    mediaComments(state) {
        return state.mediaComments;
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
    },
    setMediaDetailData(state, payload) {
        state.mediaDetailData = payload;
    },
    setMediaSuggest(state, payload) {
        state.mediaSuggest = payload;
    },
    setMediaComments(state, payload) {
        state.mediaComments = payload;
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
    },
    getMediaDetail({commit, dispatch}, data) {
        return new Promise((resolve, reject) => {
            get(`media/${data.id}/show?type=${data.type}`)
                .then(res => {
                    commit('setMediaDetailData', res.data);
                    let kindIds = [];
                    res.data.kinds.forEach((kind) => {
                        kindIds.push(kind.id);
                    });

                    let mediaId = res.data.id;
                    let type = res.data.type;
                    let size = 10;

                    if (data.type == window.Laravel.setting.album.media_type) {
                        mediaId = [];

                        res.data.media.forEach((music) => {
                            mediaId.push(music.id);
                        });

                        type = window.Laravel.setting.media.type.music;
                        size = 9;
                    }

                    dispatch('getMediaSuggest', {
                        type: type,
                        artist: res.data.user_id,
                        region: res.data.region_id,
                        media_id: mediaId,
                        kind: kindIds,
                        size: size
                    });

                    resolve();
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getMediaComments({commit, dispatch}, data) {
        return new Promise((resolve, reject) => {
            let mediaId = data.id;
            delete data.id;
            get(makePathByParams(`media/${mediaId}/comment`, data))
                .then(res => {
                    commit('setMediaComments', res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getMediaSuggest({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('media/suggest', data))
                .then(res => {
                    commit('setMediaSuggest', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    upViewMedia({commit}, id) {
        return new Promise((resolve, reject) => {
            post(`media/${id}/up-view`)
                .then(res => {
                    resolve(res.data);
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
