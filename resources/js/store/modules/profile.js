import {get, post, makePathByParams} from '../../api/base_api.js';
import {i18n} from '../../lang/index.js'

const state = {
    profileData: {},
}

const getters = {
    profileData(state) {
        return state.profileData;
    },
    checkFollowed: state => (userId, userFollowings) => {
        var check = false;

        userFollowings.forEach(function (user) {
            if (user.id == userId) {
                check = true;
            }
        });

        return check;
    },
}

const mutations = {
    setProfileData(state, payload) {
        state.profileData = payload;
    }
}

const actions = {
    getProfile({commit}, id) {
        return new Promise((resolve, reject) => {
            let url = 'profile';

            if (id) {
                url += `/${id}`;
            }

            get(url)
                .then((res) => {
                    commit('setProfileData', res.data);
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },
    follow({commit, state, rootState, dispatch}, id) {
        if (!rootState.Auth.authenticated) {
            $('#login-register1').modal('show');

            return;
        }

        return new Promise((resolve, reject) => {
            post(`profile/${id}/follow`)
                .then(res => {
                    if (rootState.Auth.user) {
                        rootState.Auth.user.followings = res.data.followings;
                    }

                    if (rootState.Media.mediaDetailData) {
                        rootState.Media.mediaDetailData.user.followers_count = res.data.followers_count;
                    }

                    if (state.profileData && state.profileData.id == id) {
                        state.profileData.followers_count = res.data.followers_count;
                    }

                    flashMessage(i18n.t('message.success'));
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
