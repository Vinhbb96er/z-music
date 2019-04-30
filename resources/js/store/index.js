import Vue from 'vue'
import Vuex from 'vuex'
import Media from './modules/media.js'
import Category from './modules/category.js'
import Ranking from './modules/ranking.js'

Vue.use(Vuex);

export const store = new Vuex.Store({
    state: {

    },
    getters: {

    },
    mutations: {

    },
    actions: {

    },
    modules: {
        Media,
        Category,
        Ranking
    }
})
