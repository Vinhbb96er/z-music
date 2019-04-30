<template>
    <div class="highlight-artist-element">
        <!--Heading Start-->
        <div class="msl-black title-style-2">
            <div class="msl-heading light-color ">
                <h5>
                    <span>{{ $t('home.highlight_artist') }}</span>
                    <span class="line"></span>
                </h5>
            </div>
        </div>
        <!--Heading End-->
        <div class="artist-slider">
            <div v-for="artist in artistRanking" :key="artist.id">
                <div class="artist-item">
                    <a href="#" class="artist-avatar">
                        <figure class="backgroud-image-show" :style="{backgroundImage: `url(${artist.avatar})`}"></figure>
                    </a>
                    <h6 class="artist-info">
                        <a href="#">{{ artist.name }}</a>
                        <button class="btn btn-success btn-follow">{{ $t('button.follow') }}</button>
                    </h6>
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
                size: 10
            };
        },
        computed: {
            ...mapGetters(['artistRanking'])
        },
        methods: {
            ...mapActions(['getArtistRanking'])
        },
        created() {
            this.getArtistRanking({
                type: this.type
            });
        },
        updated() {
            $('.artist-slider').slick({
                infinite: true,
                slidesToShow: 4,
                centerMode: true,
                arrows: true,
                dots: true,
                centerPadding: '20px',
                autoplay: true,
                speed: 1000,
                autoplaySpeed: 3000
            });
        }
    }
</script>
<style>

</style>
