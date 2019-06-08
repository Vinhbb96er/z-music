import {get, post, makePathByParams} from '../../api/base_api.js'
import axios from 'axios'

const state = {
    authenticated: false,
    user: null,
}

const getters = {
    authenticated(state) {
        return state.authenticated;
    },
    user(state) {
        return state.user;
    },
    checkIsAuthUser: state => (userId) => {
        return state.user && state.user.id == userId;
    }
}

const mutations = {
    setAuthenticated(state, data) {
        var token = data.auth.access_token;
        state.authenticated = true;
        state.user = data.user;
        localStorage.setItem('access_token', token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    removeAuthenticated(state) {
        state.authenticated = false;
        state.user = null;
        localStorage.removeItem('access_token');
        axios.defaults.headers.common['Authorization'];
    },
    checkAuthenticated(state) {
        var token = localStorage.getItem('access_token');
        state.authenticated = Boolean(token);
        axios.defaults.headers.common['Authorization'] = `Bearer ${token}`;
    },
    setUser(state, data) {
        state.user = data;
    }
}

const actions = {
    login({commit, state}, data) {
        return new Promise((resolve, reject) => {
            post('login', data)
                .then((res) => {
                    commit('setAuthenticated', res.data);
                    resolve(state.authenticated);
                    location.reload();
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },
    logout({commit, state}) {
        return new Promise((resolve, reject) => {
            post('logout', {token: localStorage.getItem('access_token')})
                .then((res) => {
                    commit('removeAuthenticated');
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },
    refreshToken({commit, state}) {
        return new Promise((resolve, reject) => {
            get('token/refresh')
                .then((res) => {
                    localStorage.setItem('access_token', res.data);
                    resolve(true);
                })
                .catch((err) => {
                    reject(err);
                });
        });
    },
    getAuth({commit, state, dispatch}) {
        return new Promise((resolve, reject) => {
            commit('checkAuthenticated');

            if (state.authenticated) {
                get('auth')
                    .then((res) => {
                        commit('setUser', res.data);
                    })
                    .catch((err) => {
                        dispatch('refreshToken')
                            .then((isSuccess) => {
                                dispatch('getAuth');
                            })
                            .catch((err) => {
                                commit('removeAuthenticated');
                            });
                        reject(err);
                    });
            } else {
                commit('removeAuthenticated');
            }
        });
    },
    register({commit}, data) {
        return new Promise((resolve, reject) => {
            post('register', data)
                .then((res) => {
                    commit('setAuthenticated', res.data);
                    resolve(state.authenticated);
                })
                .catch((err) => {
                    reject(false);
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
