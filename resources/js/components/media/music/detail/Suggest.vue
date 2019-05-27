<template>
    <aside class="right-bar-element">
        <!--Widget Artist Start-->
        <div class="widget widget-artist no-border no-padding">
            <div class="msl-black">
                <div class="msl-heading light-color ranking-header-title">
                    <h5>
                        <span>
                            {{ $t('home.maybe_you_interested') }}
                            <a href="#" @click.prevent="playAll">
                                <i class="icon-multimedia-1 icon" :title="$t('playlist.play_all')"></i>
                            </a>
                        </span>
                    </h5>
                </div>
            </div>
            <div class="artists-rank-list" v-if="mediaSuggest.length">
                <div class="artists-rank" v-for="music in mediaSuggest" :key="music.id" @click="playingMusic({id: music.id})">
                    <figure class="backgroud-image-show" :style="{backgroundImage: `url(${music.cover_image})`}">
                        <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                    </figure>
                    <div class="text-overflow">
                        <h6>
                            <router-link tag="a" :to="{name: 'musicDetail', params: {id: music.id, type: type}}">{{ music.name }}</router-link>
                        </h6>
                        <p>
                            <router-link tag="a" :to="{name: 'profileShow', params: {id: music.user.id}}" class="artist-name">
                                {{ music.user.name }}
                            </router-link>
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </aside>
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
            };
        },
        computed: {
            ...mapGetters(['mediaSuggest', 'checkPlayingMusic'])
        },
        methods: {
            ...mapActions(['playingMusic', 'addMusicToPlaylist']),
            playAll() {
                let musicIds = [];

                this.mediaSuggest.forEach((music) => {
                    musicIds.push(music.id);
                });

                this.addMusicToPlaylist({id: musicIds, type: this.type});
            }
        }
    }
</script>
<style scoped>

</style>
