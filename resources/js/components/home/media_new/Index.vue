<template>
    <div class="new-album-wrap mg-40 media-filter-element">
        <!--Heading Start-->
        <div class="msl-black title-style-2">
            <div class="msl-heading light-color ">
                <h5><span>{{ $t('home.new_media') }}</span></h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Music Album Wrap Start-->
        <div class="music-album-wrap">
            <ul class="nav-tabs music-album-nav">
                <li :class="{active: tabName == 'MusicNew'}">
                    <a @click.prevent="tabName = 'MusicNew'" href="#">{{ $t('music.name') }}</a>
                </li>
                <li :class="{active: tabName == 'MusicVideoNew'}">
                    <a @click.prevent="tabName = 'MusicVideoNew'" href="#">{{ $t('music_video.name') }}</a>
                </li>
                <li :class="{active: tabName == 'AlbumNew'}">
                    <a @click.prevent="tabName = 'AlbumNew'" href="#">{{ $t('album.name') }}</a>
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
    import MusicNew from './Music.vue'
    import MusicVideoNew from './MusicVideo.vue'
    import AlbumNew from './Album.vue'

    export default {
        data() {
            return {
                tabName: 'MusicNew'
            };
        },
        components: {
            MusicNew,
            MusicVideoNew,
            AlbumNew
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
