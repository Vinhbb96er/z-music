import Vue from 'vue'
import VueRouter from 'vue-router'

import HomeIndex from '../components/home/Index.vue'

import MusicIndex from '../components/media/music/Index.vue'
import MusicDetail from '../components/media/music/detail/Index.vue'

import VideoIndex from '../components/media/video/Index.vue'
import VideoDetail from '../components/media/video/detail/Index.vue'

import AlbumIndex from '../components/media/album/Index.vue'
import AlbumDetail from '../components/media/album/detail/Index.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'homepage',
        component: HomeIndex
    },
    {
        path: '/music',
        name: 'music',
        component: MusicIndex,
        children: [
            // {
            //     path: '',
            //     name: 'musicList',
            //     component: MusicList
            // },
            {
                path: ':id',
                name: 'musicDetail',
                component: MusicDetail
            },
            // {
            //     path: ':id/edit',
            //     name: 'musicEdit',
            //     component: MusicEdit
            // }
        ]
    },
    {
        path: '/video',
        name: 'video',
        component: VideoIndex,
        children: [
    //         {
    //             path: '',
    //             name: 'videoIndex',
    //             component: VideoIndex
    //         },
            {
                path: ':id',
                name: 'videoDetail',
                component: VideoDetail
            },
    //         {
    //             path: ':id/edit',
    //             name: 'videoEdit',
    //             component: VideoEdit
    //         }
        ]
    },
    {
        path: '/album',
        name: 'album',
        component: AlbumIndex,
        children: [
    //         {
    //             path: '',
    //             name: 'albumIndex',
    //             component: AlbumIndex
    //         },
            {
                path: ':id',
                name: 'albumDetail',
                component: AlbumDetail
            },
    //         {
    //             path: ':id/edit',
    //             name: 'albumEdit',
    //             component: AlbumEdit
    //         }
        ]
    }
];

export const router = new VueRouter({
    routes
})
