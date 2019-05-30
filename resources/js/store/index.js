import Vue from 'vue'
import Vuex from 'vuex'
import Media from './modules/media.js'
import Category from './modules/category.js'
import Ranking from './modules/ranking.js'
import Playlist from './modules/playlist.js'
import Auth from './modules/auth.js'
import Profile from './modules/profile.js'

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
        Auth,
        Media,
        Category,
        Ranking,
        Playlist,
        Profile
    }
})
