<template>
    <div class="highlight-artist-element search-artist">
        <div class="artist-slider">
            <div class="artist-item" v-for="artist in data" :key="artist.id">
                <router-link tag="a" :to="{name: 'profileShow', params: {id: artist.id}}" class="artist-avatar">
                    <figure class="backgroud-image-show" :style="{backgroundImage: `url(${artist.avatar})`}"></figure>
                </router-link>
                <h6 class="artist-info">
                    <router-link tag="a" :to="{name: 'profileShow', params: {id: artist.id}}">
                        {{ artist.name }}
                    </router-link>
                    <p class="followers">{{ artist.followers_count }} {{ $t('artist.followers') }}</p>
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
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        props: {
            data: {
                required: true,
                type: Array
            }
        },
        computed: {
            ...mapGetters(['checkIsAuthUser', 'checkIsAuthUser', 'user', 'checkFollowed'])
        },
        methods: {
            ...mapActions(['follow'])
        },
    }
</script>
<style scoped>
    .search-artist .artist-slider {
        display: grid;
        grid-template-columns: 25% 25% 25% 25%;
        padding: 5px;
    }

    .search-artist .artist-slider .artist-item {
        margin: 5px 20px 10px;
        height: auto;
    }

    .search-artist .followers {
        font-weight: lighter;
        font-size: 13px;
        color: #ccc;
        margin-bottom: 0;
    }
</style>
