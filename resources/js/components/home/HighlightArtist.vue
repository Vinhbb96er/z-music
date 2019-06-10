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
                    <router-link tag="a" :to="{name: 'profileShow', params: {id: artist.id}}" class="artist-avatar">
                        <figure class="backgroud-image-show" :style="{backgroundImage: `url(${artist.avatar})`}"></figure>
                    </router-link>
                    <h6 class="artist-info">
                        <router-link tag="a" :to="{name: 'profileShow', params: {id: artist.id}}">
                            {{ artist.name }}
                        </router-link>
                        <template v-if="!checkIsAuthUser(artist.id)">
                            <button class="btn btn-primary btn-follow" v-if="user && checkFollowed(artist.id, user.followings)" @click="follow(artist.id)">
                                {{ $t('button.followed') }}
                            </button>
                            <button class="btn btn-success btn-follow" v-else @click="follow(artist.id)">
                                {{ $t('button.follow') }}
                            </button>
                        </template>
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
            ...mapGetters(['artistRanking', 'checkIsAuthUser', 'user', 'checkFollowed'])
        },
        methods: {
            ...mapActions(['getArtistRanking', 'follow'])
        },
        created() {
            this.getArtistRanking({
                type: this.type
            });
        },
        updated() {
            if (!$('.artist-slider').hasClass('slick-slider')) {
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
    }
</script>
<style>

</style>
