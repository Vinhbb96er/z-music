<template>
    <div class="tab-pane active">
        <div class="kode-comment-form">
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-upload"></i>{{ $t('auth.followings_list') }}</h4>
                </div>
            </div>
            <div class="highlight-artist-element search-artist" v-if="followings">
                <div class="artist-slider">
                    <div class="artist-item" v-for="artist in followings.data">
                        <router-link tag="a" :to="{name: 'profileShow', params: {id: artist.id}}" class="artist-avatar">
                            <figure class="backgroud-image-show" :style="{backgroundImage: `url(${artist.avatar})`}"></figure>
                        </router-link>
                        <h6 class="artist-info">
                            <router-link tag="a" :to="{name: 'profileShow', params: {id: artist.id}}">
                                {{ artist.name }}
                            </router-link>
                            <p class="followers">1 {{ $t('artist.followers') }}</p>
                            <button class="btn btn-primary btn-follow" v-if="user && checkFollowed(artist.id, user.followings)" @click="follow(artist.id)">
                                {{ $t('button.followed') }}
                            </button>
                            <button class="btn btn-success btn-follow" v-else @click="follow(artist.id)">
                                {{ $t('button.follow') }}
                            </button>
                        </h6>
                    </div>
                </div>
                <pagination :pageData="followings" :loadPageFunc="loadFollowing"></pagination>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    import Pagination from '../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                size: 9
            };
        },
        components: {
            Pagination
        },
        computed: {
            ...mapGetters(['followings', 'user', 'checkFollowed'])
        },
        methods: {
            ...mapActions(['getFollowings', 'follow']),
            loadFollowing(page) {
                this.getFollowings({
                    size: this.size,
                    page: page
                });
            },
        },
        created() {
            this.getFollowings({
                size: this.size
            });
        }
    }
</script>
<style scoped>
    .artist-slider {
        display: grid;
        grid-template-columns: 33.33% 33.33% 33.33%;
        padding: 5px;
    }

    .artist-slider .artist-item {
        height: auto;
        margin: 10px;
    }

    .followers {
        font-weight: lighter;
        font-size: 13px;
        color: #ccc;
        margin-bottom: 0;
    }
</style>
