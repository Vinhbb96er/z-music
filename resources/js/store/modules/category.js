import {get, makePathByParams} from '../../api/base_api.js'

const state = {
    popularRegions: [],
    topViewCategories: [],
    allRegions: [],
    allKinds: [],
    allTags: []
}

const getters = {
    popularRegions(state) {
        return state.popularRegions;
    },
    topViewCategories(state) {
        var categories = state.topViewCategories;
        var randArr = [1, 2, 3, 4, 5, 6];

        categories.map((item) => {
            var randIndex = Math.floor(Math.random() * (randArr.length - 1));
            item.background = `gradient-background-${randArr[randIndex]}`;
            randArr.splice(randIndex, 1);
        });

        return categories;
    },
    allRegions(state) {
        return state.allRegions;
    },
    allKinds(state) {
        return state.allKinds;
    },
    allTags(state) {
        return state.allTags;
    }
}

const mutations = {
    setPopularRegions(state, payload) {
        state.popularRegions = payload;
    },
    setTopViewCategories(state, payload) {
        state.topViewCategories = payload;
    },
    setAllRegions(state, payload) {
        state.allRegions = payload;
    },
    setAllKinds(state, payload) {
        state.allKinds = payload;
    },
    setAllTags(state, payload) {
        state.allTags = payload;
    }
}

const actions = {
    getPopularRegions({commit}) {
        return new Promise((resolve, reject) => {
            get('category/region/popular')
                .then(res => {
                    commit('setPopularRegions', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getTopViewCategories({commit}, data) {
        return new Promise((resolve, reject) => {
            get(makePathByParams('category/top-view', data))
                .then(res => {
                    commit('setTopViewCategories', res.data.data);
                })
                .catch(err => {
                    reject(err);
                });
        });
    },
    getAllCategories({commit}, type) {
        return new Promise((resolve, reject) => {
            get(`category/${type}/all`)
                .then(res => {
                    switch(type) {
                        case window.Laravel.setting.category_type.region:
                            commit('setAllRegions', res.data);
                            break;
                        case window.Laravel.setting.category_type.kind:
                            commit('setAllKinds', res.data);
                            break;
                        case window.Laravel.setting.category_type.tag:
                            commit('setAllTags', res.data);
                            break;
                    }

                    resolve(true);
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
