<template>
    <div class="widget widget-artist no-border no-padding">
        <!--Heading Start-->
        <div class="msl-black">
            <div class="msl-heading light-color ranking-header-title">
                <h5>
                    <span>
                        <router-link tag="a" :to="{name: 'albumRanking'}">{{ $t('album.album_ranking') }}</router-link>
                    </span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <!--Artist Rank List Start-->
        <div class="artists-rank-list">
            <!--Artist Rank End-->
            <div class="artists-rank" v-for="(album, index) in albumRanking.data"  :key="album.id" @click="addMusicToPlaylist({id: album.id, type: type})">
                <span class="rank-no">{{ index + 1 }}</span>
                <figure class="backgroud-image-show" :style="{backgroundImage: `url(${album.cover_image})`}"></figure>
                <div class="text-overflow">
                    <h6>
                        <router-link tag="a" :to="{name: 'albumDetail', params: {id: album.id}}">{{ album.name }}</router-link>
                    </h6>
                    <p>
                        <router-link tag="a" :to="{name: 'profileShow', params: {id: album.user.id}}" class="artist-name">
                            {{ album.user.name }}
                        </router-link>
                    </p>
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
            ...mapActions(['getAlbumRanking', 'addMusicToPlaylist'])
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
