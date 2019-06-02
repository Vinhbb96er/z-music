import Vue from 'vue'
import VueRouter from 'vue-router'

import HomeIndex from '../components/home/Index.vue'

import MusicIndex from '../components/media/music/Index.vue'
import MusicDetail from '../components/media/music/detail/Index.vue'

import VideoIndex from '../components/media/video/Index.vue'
import VideoDetail from '../components/media/video/detail/Index.vue'

import AlbumIndex from '../components/media/album/Index.vue'
import AlbumDetail from '../components/media/album/detail/Index.vue'

import Profile from '../components/profile/Profile.vue'
import ProfileIndex from '../components/profile/Index.vue'

import Search from '../components/media/Search.vue'
import SearchMusic from '../components/media/music/search/Search.vue'
import SearchVideo from '../components/media/video/search/Search.vue'
import SearchAlbum from '../components/media/album/search/Search.vue'
import SearchArtist from '../components/profile/search/Search.vue'

import CategoryRegion from '../components/category/region/Index.vue'
import CategoryRegionMusic from '../components/category/region/Music.vue'
import CategoryRegionVideo from '../components/category/region/Video.vue'
import CategoryRegionAlbum from '../components/category/region/Album.vue'

import CategoryKind from '../components/category/kind/Index.vue'
import CategoryKindMusic from '../components/category/kind/Music.vue'
import CategoryKindVideo from '../components/category/kind/Video.vue'
import CategoryKindAlbum from '../components/category/kind/Album.vue'

import CategoryTopic from '../components/category/topic/Index.vue'
import CategoryTopicMusic from '../components/category/topic/Music.vue'
import CategoryTopicVideo from '../components/category/topic/Video.vue'
import CategoryTopicAlbum from '../components/category/topic/Album.vue'

Vue.use(VueRouter)

const routes = [
    {
        path: '/',
        name: 'home',
        component: HomeIndex
    },
    {
        path: '/music',
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
    },
    {
        path: '/profile',
        component: Profile,
        children: [
            {
                path: '',
                name: 'profile',
                component: ProfileIndex
            },
            {
                path: ':id',
                name: 'profileShow',
                component: ProfileIndex
            }
        ]
    },
    {
        path: '/search',
        component: Search,
        name: 'search'
    },
    {
        path: '/search/music',
        component: SearchMusic,
        name: 'searchMusic'
    },
    {
        path: '/search/video',
        component: SearchVideo,
        name: 'searchVideo'
    },
    {
        path: '/search/album',
        component: SearchAlbum,
        name: 'searchAlbum'
    },
    {
        path: '/search/artist',
        component: SearchArtist,
        name: 'searchArtist'
    },

    {
        path: '/category/region/:id',
        component: CategoryRegion,
        name: 'categoryRegion'
    },
    {
        path: '/category/region/:id/music',
        component: CategoryRegionMusic,
        name: 'categoryRegionMusic'
    },
    {
        path: '/category/region/:id/video',
        component: CategoryRegionVideo,
        name: 'categoryRegionVideo'
    },
    {
        path: '/category/region/:id/album',
        component: CategoryRegionAlbum,
        name: 'categoryRegionAlbum'
    },

    {
        path: '/category/kind/:id',
        component: CategoryKind,
        name: 'categoryKind'
    },
    {
        path: '/category/kind/:id/music',
        component: CategoryKindMusic,
        name: 'categoryKindMusic'
    },
    {
        path: '/category/kind/:id/video',
        component: CategoryKindVideo,
        name: 'categoryKindVideo'
    },
    {
        path: '/category/kind/:id/album',
        component: CategoryKindAlbum,
        name: 'categoryKindAlbum'
    },

    {
        path: '/category/topic/:id',
        component: CategoryTopic,
        name: 'categoryTopic'
    },
    {
        path: '/category/topic/:id/music',
        component: CategoryTopicMusic,
        name: 'categoryTopicMusic'
    },
    {
        path: '/category/topic/:id/video',
        component: CategoryTopicVideo,
        name: 'categoryTopicVideo'
    },
    {
        path: '/category/topic/:id/album',
        component: CategoryTopicAlbum,
        name: 'categoryTopicAlbum'
    }
];

export const router = new VueRouter({
    routes
})
