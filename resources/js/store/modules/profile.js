import {get, post, makePathByParams} from '../../api/base_api.js';

const state = {
    profileData: {},
}

const getters = {
    profileData(state) {
        return state.profileData;
    }
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
}

export default {
    state,
    getters,
    mutations,
    actions
}
