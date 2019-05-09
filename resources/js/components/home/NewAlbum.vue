<template>
    <div class="new-album-wrap mg-40">
        <!--Heading Start-->
        <div class="msl-black title-style-2">
            <div class="msl-heading light-color ">
                <h5>
                    <span>{{ $t('home.new_releases_albums') }}</span>
                    <span class="line"></span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <div class="new-album-slider-4 bottom-arrow msl-black">
            <div class="col-md-4" v-for="album in newAlbums" :key="album.id">
                <!--New Album Thumb Start-->
                <div class="new-album-thumb">
                    <figure class="album-image">
                        <img src="#" :style="{backgroundImage: `url(${album.cover_image})`}">
                    </figure>
                    <div class="new-album-caption">
                        <a href="#" class="new-album fa fa-play" @click.prevent="addMusicToPlaylist({id: album.id, type: type})" :title="$t('playlist.add_to_playlist')"></a>
                        <h5><a href="#">{{ album.name }}</a></h5>
                        <h6>{{ album.user.name }}</h6>
                        <p>{{ album.region.name }}</p>
                        <p>{{ album.kinds_text }}</p>
                        <ul class="blog-meta-list">
                            <li>
                                <a href="javascript::void(0);">
                                    <i class="fa fa-music"></i> <span>{{ album.media.length }} {{ $t('album.track') }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::void(0);">
                                    <i class="fa fa-play"></i> <span>{{ album.views }}</span>
                                </a>
                            </li>
                            <li>
                                <a href="javascript::void(0);">
                                    <i class="fa fa-heart"></i> <span>{{ album.likes.length }}</span>
                                </a>
                            </li>
                        </ul>
                        <div class="clear"></div>
                        <div class="album-rate theme-font">{{ album.created_at_date }}</div>
                        <div class="album-rate absolute">{{ album.created_at_date }}</div>
                    </div>
                </div>
                <!--New Album Thumb End-->
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
                type: window.Laravel.setting.album.media_type,
            }
        },
        computed: {
            ...mapGetters(['newAlbums'])
        },
        methods: {
            ...mapActions(['getNewAlbums', 'addMusicToPlaylist']),
        },
        created() {
            this.getNewAlbums();
        },
        updated() {
            $('.new-album-slider-4').slick({
                centerMode: false,
                arrows: true,
                dots: true,
                centerPadding: '0px',
                slidesToShow: 3,
                autoplay: true,
                autoplaySpeed: 3000,
                responsive: [
                    {
                        breakpoint: 1200,
                        settings: {
                            arrows: true,
                            centerMode: false,
                            centerPadding: '0px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 768,
                        settings: {
                            arrows: true,
                            centerMode: true,
                            centerPadding: '0px',
                            slidesToShow: 2
                        }
                    },
                    {
                        breakpoint: 481,
                        settings: {
                            arrows: true,
                            centerMode: true,
                            centerPadding: '0px',
                            slidesToShow: 1
                        }
                    }
                ]
            });
        }
    }
</script>
<style>

</style>
