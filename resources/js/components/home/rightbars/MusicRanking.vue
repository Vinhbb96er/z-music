<template>
    <div class="widget widget-artist">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <a href="#">
                            {{ $t('music.music_ranking') }}
                        </a>
                        <a href="#" @click.prevent="playAll">
                            <i class="icon-multimedia-1 icon" :title="$t('playlist.play_all')"></i>
                        </a>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Artist Rank List Start-->
        <div class="artists-rank-list">
            <!--Artist Rank End-->
            <div class="artists-rank" v-for="(music, index) in musicRanking"  :key="music.id" @click="playingMusic({id: music.id, type: type})">
                <span class="rank-no">{{ index + 1 }}</span>
                <figure class="backgroud-image-show" :style="{backgroundImage: `url(${music.cover_image})`}">
                    <img :src="images.music_playing" class="playing-icon" v-if="checkPlayingMusic(music.id)">
                </figure>
                <div class="text-overflow">
                    <h6>
                        <router-link tag="a" :to="{name: 'musicDetail', params: {id: music.id, type: type}}">
                            {{ music.name }}
                        </router-link>
                    </h6>
                    <p>{{ music.user.name }}</p>
                </div>
            </div>
            <!--Artist Rank End-->
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
                size: 5,
                images: {
                    music_playing: window.Laravel.setting.images.music_playing
                }
            };
        },
        computed: {
            ...mapGetters(['musicRanking', 'checkPlayingMusic'])
        },
        methods: {
            ...mapActions(['getMusicRanking', 'playingMusic', 'addMusicToPlaylist']),
            playAll() {
                let musicIds = [];

                this.musicRanking.forEach((music) => {
                    musicIds.push(music.id);
                });

                this.addMusicToPlaylist({id: musicIds, type: this.type});
            }
        },
        created() {
            this.getMusicRanking({
                type: this.type,
                size: this.size
            });
        }
    }
</script>
<style>

</style>
