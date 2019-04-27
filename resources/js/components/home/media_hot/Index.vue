<template>
    <div class="new-album-wrap mg-40 media-filter-element">
        <!--Heading Start-->
        <div class="msl-black title-style-2">
            <div class="msl-heading light-color ">
                <h5><span>{{ $t('home.hot_media') }}</span></h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Music Album Wrap Start-->
        <div class="music-album-wrap">
            <ul class="nav-tabs music-album-nav">
                <li :class="{active: tabName == 'MusicHot'}">
                    <a @click.prevent="tabName = 'MusicHot'" href="#">{{ $t('music.name') }}</a>
                </li>
                <li :class="{active: tabName == 'MusicVideoHot'}">
                    <a @click.prevent="tabName = 'MusicVideoHot'" href="#">{{ $t('music_video.name') }}</a>
                </li>
                <li :class="{active: tabName == 'AlbumHot'}">
                    <a @click.prevent="tabName = 'AlbumHot'" href="#">{{ $t('album.name') }}</a>
                </li>
            </ul>
        </div>
        <!--Music Album Wrap End-->
        <!--Music Album Contant Start-->
        <div class="tab-content">
            <components :is="tabName"></components>

        </div>
        <!--Music Album Contant End-->
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'
    import MusicHot from './Music.vue'
    import MusicVideoHot from './MusicVideo.vue'
    import AlbumHot from './Album.vue'

    export default {
        data() {
            return {
                tabName: 'MusicHot'
            };
        },
        components: {
            MusicHot,
            MusicVideoHot,
            AlbumHot
        },
        methods: {
            ...mapActions(['getPopularRegions'])
        },
        created() {
            this.getPopularRegions();
        }
    }
</script>
<style>

</style>
