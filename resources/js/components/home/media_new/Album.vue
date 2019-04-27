<template>
    <div class="tab-pane active">
        <!--Music Album Inner Wrap Start-->
        <div class="album-inner">
            <!--Music Album Inner Nav Start-->
            <h4 class="heading-2 media-header-title">
                <a href="#">
                    {{ $t('album.album_new') }} <i class="fa fa-angle-right"></i>
                </a>
            </h4>
            <ul class="nav-tabs msl-tab-nav">
                <li class="region-title" @click.prevent="region = 0" :class="{active: region == 0}">
                    <a href="#">{{ $t('home.selective') }}</a>
                </li>
                <li v-for="popularRegion in popularRegions" :key="popularRegion.id" class="region-title" @click.prevent="region = popularRegion.id"
                    :class="{active: region == popularRegion.id}">
                    <a href="#">{{ popularRegion.name }}</a>
                </li>
            </ul>
            <!--Music Album Inner Nav End-->
            <div class="tab-content">
                <div class="tab-pane active" v-for="album in mediaNew" :key="album.id">
                    <div class="album-outer">
                        <!--Music Album List Thumb Start-->
                        <div class="album-list-thumb-outer">
                            <div class="album-list-thumb">
                                <div class="thumb" :style="{backgroundImage: `url(${album.cover_image})`}">
                                </div>
                                <div class="title">
                                    <div>
                                        <h5>{{ album.name }}</h5>
                                        <p>{{ album.user.name }}</p>
                                    </div>
                                </div>
                                <div class="album-no">
                                    <div>
                                        <p>{{ album.kinds_text }}</p>
                                    </div>
                                </div>
                                <div class="album-date">
                                    <div>
                                        <p>{{ album.created_at_date }}</p>
                                    </div>
                                </div>
                                <div class="clic-btn-wrap">
                                    <div class="clic-btn">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            </div>
                            <div class="album-play-list">
                                <ul>
                                    <li v-for="music in album.media" :key="music.id">
                                        <div class="play-list-title">
                                            <i class="icon-multimedia-1"></i>
                                            <h6>{{ music.name }}</h6>
                                        </div>
                                        <div class="play-list-icon">
                                            <span class="icon-cross"></span>
                                            <span class="icon-arrows-4"></span>
                                        </div>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <!--Music Album List Thumb End-->
                    </div>
                </div>
            </div>
        </div>
        <!--Music Album Inner Wrap End-->
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                type: window.Laravel.setting.album.media_type,
                region: 0,
                size: window.Laravel.setting.media_filter_size.album
            }
        },
        watch: {
            region() {
                this.getMediaNew({
                    type: this.type,
                    region: this.region,
                    size: this.size
                });
            }
        },
        computed: {
            ...mapGetters(['popularRegions', 'mediaNew'])
        },
        methods: {
            ...mapActions(['getMediaNew'])
        },
        created() {
            this.getMediaNew({
                type: this.type,
                region: this.region,
                size: this.size
            });
        },
    }
</script>
<style>

</style>
