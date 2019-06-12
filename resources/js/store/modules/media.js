import {get, post, put, del, makePathByParams} from '../../api/base_api.js'
import axios from 'axios'
import {i18n} from '../../lang/index.js'

const state = {
    sliderItems: [],
    newAlbums: [],
    mediaHot: [],
    mediaNew: [],
    mediaDetailData: null,
    mediaComments: {},
    mediaSuggest: [],
    mediaSearch: null,
    favouriteList: null,
    listVideoView: []
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
    },
    mediaSearch(state) {
        return state.mediaSearch;
    },
    checkLiked: state => (mediaId, mediaIdLikes) => {
        var check = false;

        mediaIdLikes.forEach(function (item) {
            if (item == mediaId) {
                check = true;
            }
        });

        return check;
    },
    favouriteList(state) {
        return state.favouriteList;
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
    },
    setMediaSearch(state, payload) {
        state.mediaSearch = payload;
    },
    setFavouriteList(state, payload) {
        state.favouriteList = payload;
    },
    setListVideoView(state, id) {
        state.listVideoView.push(id);
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
    getMediaDetail({commit, dispatch, state}, data) {
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

                    let videoList = '';

                    if (data.type == 2 && state.listVideoView.length) {
                        videoList = state.listVideoView.join(',');
                    }

                    dispatch('getMediaSuggest', {
                        type: type,
                        artist: res.data.user_id,
                        region: res.data.region_id,
                        media_id: mediaId,
                        kind: kindIds,
                        size: size,
                        video_list: videoList
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
    upViewMedia({commit}, data) {
        return new Promise((resolve, reject) => {
            post(`media/${data.id}/up-view`, data)
                .then(res => {
                    resolve(res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    searchMedia({commit, state}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('media/search', data))
                .then(res => {
                    commit('setMediaSearch', res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    uploadMedia({commit, state}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
            let formData = new FormData(data);

            for(var key in data) {
                formData.append(key, data[key]);
            }

            post('media', formData)
                .then(res => {
                    resolve(res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    updateMedia({commit, state}, data) {
        return new Promise((resolve, reject) => {
            axios.defaults.headers.common['Content-Type'] = 'multipart/form-data';
            let formData = new FormData(data);

            for(var key in data) {
                formData.append(key, data[key]);
            }

            post(`media/${data.id}/update`, formData)
                .then(res => {
                    resolve(res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    deleteMedia({commit, state}, id) {
        return new Promise((resolve, reject) => {
            del(`media/${id}/delete`)
                .then(res => {
                    resolve(res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    likeMedia({commit, state, rootState, dispatch}, data) {
        if (!rootState.Auth.authenticated) {
            $('#login-register1').modal('show');

            return;
        }

        return new Promise((resolve, reject) => {
            post('media/like', data)
                .then(res => {
                    if (state.mediaDetailData) {
                        state.mediaDetailData.likes_count = res.data.like;
                    }

                    var mediaIndex = null;
                    rootState.Playlist.playlist.forEach(function (item, index) {
                        if (item.id == data.id) {
                            mediaIndex = index;

                            return ;
                        }
                    });

                    if (mediaIndex != null) {
                        rootState.Playlist.playlist[mediaIndex].likes_count = res.data.like;
                    }

                    if (rootState.Auth.user) {
                        rootState.Auth.user.like_data = res.data.like_data;
                    }

                    flashMessage(i18n.t('message.success'));
                })
                .catch(err => {
                    reject(err);
                    flashMessage(i18n.t('message.failed'), 'danger');
                });
        });
    },
    downloadMedia({commit}, id) {
        return new Promise((resolve, reject) => {
            get(`media/${id}/download`)
                .then(res => {
                    window.location.href = res.data;
                    flashMessage(i18n.t('message.success'));
                })
                .catch(err => {
                    reject(err);
                    flashMessage(i18n.t('message.failed'), 'danger');
                });
        });
    },
    addFavouriteList({commit, rootState}, id) {
        if (!rootState.Auth.authenticated) {
            $('#login-register1').modal('show');

            return;
        }

        return new Promise((resolve, reject) => {
            post(`media/${id}/add-favourite`)
                .then(res => {
                    flashMessage(i18n.t('message.success'));
                })
                .catch(err => {
                    reject(err);
                    flashMessage(i18n.t('message.failed'), 'danger');
                });
        });
    },
    removeFavouriteList({commit, state}, id) {
        return new Promise((resolve, reject) => {
            post(`media/${id}/remove-favourite`)
                .then(res => {
                    let index;
                    state.favouriteList.data.forEach((media, i) => {
                        if (media.id == id) {
                            index = i;
                        }
                    });

                    state.favouriteList.data.splice(index, 1);
                    flashMessage(i18n.t('message.success'));
                })
                .catch(err => {
                    reject(err);
                    flashMessage(i18n.t('message.failed'), 'danger');
                });
        });
    },
    getFavouriteList({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('media/favourite-list', data))
                .then(res => {
                    commit('setFavouriteList', res.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    commentMedia({commit, state, rootState, dispatch}, data) {
        return new Promise((resolve, reject) => {
            post('media/comment', data)
                .then(res => {
                    flashMessage(i18n.t('message.success'));
                    let params = {
                        type: data.type,
                        id: data.id,
                    }

                    if (data.reply_id) {
                        params.page = data.page
                    }

                    dispatch('getMediaComments', params);

                    resolve(true);
                })
                .catch(err => {
                    reject(err);
                    flashMessage(i18n.t('message.failed'), 'danger');
                });
        });
    },
    reportMedia({commit, state, rootState, dispatch}, data) {
        return new Promise((resolve, reject) => {
            post('media/report', data)
                .then(res => {
                    flashMessage(i18n.t('message.success'));
                    resolve(true);
                })
                .catch(err => {
                    reject(err);
                    flashMessage(i18n.t('message.failed'), 'danger');
                });
        });
    },
}

export default {
    state,
    getters,
    mutations,
    actions
}
