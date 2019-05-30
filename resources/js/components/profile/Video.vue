<template>
    <div class="tab-pane active">
        <div class="artist-bio no-margin" v-if="mediaSearch">
            <div class="msl-black">
                <div class="heading3">
                    <h4>
                        <i class="fa fa-music"></i>{{ $t('music_video.list_video') }}
                    </h4>
                </div>
            </div>
            <div>
                <div class="media-filter-element" v-if="mediaSearch.data">
                    <div class="tab-pane active">
                        <!--Music Album Inner Wrap Start-->
                        <div class="album-inner">
                            <!--Music Album Inner Nav End-->
                            <div class="grid-container">
                                <router-link class="grid-item" v-for="video in videoSlice.largeItem" tag="div" :to="{name: 'videoDetail', params: {id: video.id}}" :key="video.id">
                                    <div class="msl-featured-thumb video-list-thumb">
                                        <figure>
                                            <img src="#" :style="{backgroundImage: `url(${video.cover_image})`}">
                                            <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                                            <div class="text">
                                                <!--Featured Title Start-->
                                                <h4 class="featured-title">
                                                    <router-link tag="a" :to="{name: 'videoDetail', params: {id: video.id}}">
                                                        {{ video.name }}
                                                    </router-link>
                                                </h4>
                                                <!--Featured Title End-->
                                                <!--Featured Meta Start-->
                                                <div class="blog-post-meta">
                                                    <div class="blog-info blog-admin music-icon-group">
                                                        <template v-if="checkIsAuthUser(id)">
                                                            <a href="#" class="mp3-icon" :title="$t('button.edit')" @click.stop.prevent>
                                                                <i class="fa fa-pencil"></i>
                                                            </a>
                                                            <a href="#" class="mp3-icon" :title="$t('playlist.remove')" @click.stop.prevent>
                                                                <i class="fa fa-trash"></i>
                                                            </a>
                                                        </template>
                                                        <template v-else>
                                                            <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                                                <i class="fa fa-heart-o"></i>
                                                            </a>
                                                            <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.stop.prevent>
                                                                <i class="fa fa-download"></i>
                                                            </a>
                                                        </template>
                                                    </div>
                                                </div>
                                            </div>
                                        </figure>
                                    </div>
                                </router-link>
                            </div>
                            <div class="grid-container-small">
                                <router-link class="grid-item" v-for="video in videoSlice.smallItem" tag="div" :to="{name: 'videoDetail', params: {id: video.id}}" :key="video.id">
                                    <div class="msl-featured-thumb video-list-thumb">
                                        <figure>
                                            <img src="#" :style="{backgroundImage: `url(${video.cover_image})`}">
                                            <a class="video-play" href="#"><i class="icon-multimedia-1"></i></a>
                                        </figure>
                                        <div class="text">
                                            <h4 class="featured-title" :title="video.name">
                                                <router-link tag="a" :to="{name: 'videoDetail', params: {id: video.id}}">
                                                    {{ video.name }}
                                                </router-link>
                                            </h4>
                                            <div class="blog-info blog-admin music-icon-group">
                                                <template v-if="checkIsAuthUser(id)">
                                                    <a href="#" class="mp3-icon" :title="$t('button.edit')" @click.stop.prevent>
                                                        <i class="fa fa-pencil"></i>
                                                    </a>
                                                    <a href="#" class="mp3-icon" :title="$t('playlist.remove')" @click.stop.prevent>
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </template>
                                                <template v-else>
                                                    <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                                        <i class="fa fa-heart-o"></i>
                                                    </a>
                                                    <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.stop.prevent>
                                                        <i class="fa fa-download"></i>
                                                    </a>
                                                </template>
                                            </div>
                                        </div>
                                    </div>
                                </router-link>
                            </div>
                        </div>
                    </div>
                    <pagination :pageData="mediaSearch" :loadPageFunc="loadVideo"></pagination>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    import Pagination from '../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.video,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                },
                id: this.$route.params.id,
                size: 10
            }
        },
        components: {
            Pagination
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id ? to.params.id : this.profileData.id;
                this.searchMedia({
                    type: this.type,
                    user: this.id,
                    size: this.size
                });
            }
        },
        computed: {
            ...mapGetters([
                'profileData',
                'checkPlayingMusic',
                'mediaSearch',
                'checkIsAuthUser'
            ]),
            videoSlice() {
                return {
                    largeItem: this.mediaSearch.data.slice(0, 2),
                    smallItem: this.mediaSearch.data.slice(2)
                }
            }
        },
        methods: {
            ...mapActions(['playingMusic', 'searchMedia', 'addMusicToPlaylist']),
            loadVideo(page) {
                this.searchMedia({
                    type: this.type,
                    user: this.id,
                    size: this.size,
                    page: page
                });
            }
        },
        created() {
            if (this.id == undefined) {
                this.id = this.profileData.id;
            }

            this.searchMedia({
                type: this.type,
                user: this.id,
                size: this.size
            });
        }
    }
</script>
<style scoped>
    .play-all .icon {
        font-size: 22px;
        font-weight: bold;
        color: #fff !important;
        line-height: 0;
        top: 2px;
        margin-left: 5px;
    }

    .play-all:hover .icon {
        color: #db152e !important;
    }

    .user-detail .grid-container-small .grid-item {
        margin-bottom: 15px;
    }

    .user-detail .grid-item .music-icon-group .mp3-icon {
        width: 24px;
        padding: 4px 5px;
        border-radius: 4px;
        text-align: center;
    }

    .user-detail .blog-post-meta .music-icon-group .mp3-icon i {
        margin: 0;
    }

    .user-detail .grid-container-small .text {
        height: 100px;
    }

    .user-detail .grid-container .text {
        width: 100%;
    }

    .user-detail .grid-container .blog-post-meta .music-icon-group {
        float: right;
    }

    .user-detail .grid-container-small .music-icon-group {
        position: absolute;
        bottom: 10px;
        right: 14px;
    }
</style>
