<template>
    <div class="tab-pane active">
        <div class="artist-bio no-margin" v-if="album">
            <!--Heading 3 Start-->
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-user"></i>{{ $t('artist.name') }}</h4>
                </div>
            </div>
            <div class="artist-content">
                <router-link tag="a" :to="{name: 'profileShow', params: {id: album.user.id}}">
                    <figure class="backgroud-image-show" :style="{backgroundImage: `url('${album.user.avatar}')`}"></figure>
                </router-link>
                <div>
                    <router-link tag="a" :to="{name: 'profileShow', params: {id: album.user.id}}" class="artist-title">
                        {{ album.user.name }}
                    </router-link>
                    <div class="follower-info">{{ album.user.followers_count }} {{ $t('artist.followers') }}</div>
                    <template v-if="!checkIsAuthUser(album.user.id)">
                        <button class="btn btn-primary btn-follow" v-if="user && checkFollowed(album.user.id, user.followings)" @click="follow(album.user.id)">
                            {{ $t('button.followed') }}
                        </button>
                        <button class="btn btn-success btn-follow" v-else @click="follow(album.user.id)">
                            {{ $t('button.follow') }}
                        </button>
                    </template>
                </div>
            </div>
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-music"></i>{{ $t('album.list_song') }}</h4>
                </div>
            </div>
            <div>
                <div class="album-list-thumb-outer">
                    <div class="album-play-list album-header">
                        <ul>
                            <li>
                                <div class="play-list-title">
                                    <i class="icon-multimedia-1"></i> <span class="index">#</span>
                                    <h6>{{ $t('media.song_name') }}</h6>
                                </div>
                                <div class="music-icon-group text-center">
                                    <h6>{{ $t('media.action') }}</h6>
                                </div>
                            </li>
                        </ul>
                    </div>
                    <div class="album-play-list">
                        <ul>
                            <li v-for="(music, index) in album.media" :key="music.id"  @click.prevent="playingMusic({id: music.id, type: type})">
                                <div class="play-list-title">
                                    <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                                    <template v-else>
                                        <i class="icon-multimedia-1"></i>
                                        <span class="index">#{{ index + 1 }}</span>
                                    </template>
                                    <h6>{{ music.name }}</h6>
                                </div>
                                <div class="music-icon-group text-right">
                                    <a href="#" class="mp3-icon" :title="$t('playlist.like')" @click.stop.prevent>
                                        <i class="fa fa-heart-o"></i>
                                    </a>
                                    <router-link @click.stop tag="a" class="mp3-icon" :to="{name: 'musicDetail', params: {id: music.id}}" :title="$t('home.view_detail')">
                                        <i class="fa fa-info"></i>
                                    </router-link>
                                    <a href="#" class="mp3-icon" :title="$t('playlist.download')" @click.stop.prevent="downloadMedia(music.id)">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.music,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            }
        },
        computed: {
            ...mapGetters({
                album: 'mediaDetailData',
                checkPlayingMusic: 'checkPlayingMusic',
                user: 'user',
                checkFollowed: 'checkFollowed',
                checkIsAuthUser: 'checkIsAuthUser'
            })
        },
        methods: {
            ...mapActions(['playingMusic', 'downloadMedia', 'follow'])
        }
    }
</script>
<style>

</style>
