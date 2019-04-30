<template>
    <div class="widget widget-artist">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <a href="#">
                            {{ $t('music.music_ranking') }}
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
            <div class="artists-rank" v-for="(music, index) in musicRanking"  :key="music.id">
                <span class="rank-no">{{ index + 1 }}</span>
                <figure class="backgroud-image-show" :style="{backgroundImage: `url(${music.cover_image})`}"></figure>
                <div class="text-overflow">
                    <h6><a href="#">{{ music.name }}</a></h6>
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
                size: 5
            };
        },
        computed: {
            ...mapGetters(['musicRanking'])
        },
        methods: {
            ...mapActions(['getMusicRanking'])
        },
        created() {
            this.getMusicRanking({
                type: this.type,
                size: this.size
            });
        }
    }
</script>
<style scoped>

</style>
