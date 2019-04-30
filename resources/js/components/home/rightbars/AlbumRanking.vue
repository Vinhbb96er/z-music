<template>
    <div class="widget widget-artist no-border no-padding">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <a href="#">
                            {{ $t('album.album_ranking') }}
                            <i class="icon-multimedia-1 icon"></i>
                        </a>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Artist Rank List Start-->
        <div class="artists-rank-list">
            <!--Artist Rank End-->
            <div class="artists-rank" v-for="(album, index) in albumRanking"  :key="album.id">
                <span class="rank-no">{{ index + 1 }}</span>
                <figure class="backgroud-image-show" :style="{backgroundImage: `url(${album.cover_image})`}"></figure>
                <div class="text-overflow">
                    <h6><a href="#">{{ album.name }}</a></h6>
                    <p>{{ album.user.name }}</p>
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
                type: window.Laravel.setting.album.media_type,
                size: 5
            };
        },
        computed: {
            ...mapGetters(['albumRanking'])
        },
        methods: {
            ...mapActions(['getAlbumRanking'])
        },
        created() {
            this.getAlbumRanking({
                type: this.type,
                size: this.size
            });
        }
    }
</script>
<style scoped>

</style>
