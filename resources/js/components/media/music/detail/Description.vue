<template>
    <div class="tab-pane active">
        <div class="artist-bio" v-if="music">
            <!--Heading 3 Start-->
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-user"></i>{{ $t('artist.name') }}</h4>
                </div>
            </div>
            <div class="artist-content">
                <router-link tag="a" :to="{name: 'profileShow', params: {id: music.user.id}}">
                    <figure class="backgroud-image-show" :style="{backgroundImage: `url('${music.user.avatar}')`}"></figure>
                </router-link>
                <div>
                    <router-link tag="a" :to="{name: 'profileShow', params: {id: music.user.id}}" class="artist-title">
                        {{ music.user.name }}
                    </router-link>
                    <div class="follower-info">{{ music.user.followers_count }} {{ $t('artist.followers') }}</div>
                    <template v-if="!checkIsAuthUser(music.user.id)">
                        <button class="btn btn-primary btn-follow" v-if="user && checkFollowed(music.user.id, user.followings)" @click="follow(music.user.id)">
                            {{ $t('button.followed') }}
                        </button>
                        <button class="btn btn-success btn-follow" v-else @click="follow(music.user.id)">
                            {{ $t('button.follow') }}
                        </button>
                    </template>
                </div>
            </div>
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-music"></i>{{ $t('music.lyrics') }}</h4>
                </div>
            </div>
            <div class="text lyrics-content">
                <div class="lyrics-header">
                    <div>{{ $t('music.contribute_by') }} <span class="contributer">{{ music.lyrics_contributer_name }}</span></div>
                    <div class="btn-contribute-lyrics">
                        <a href="#">
                            <i class="fa fa-file-text-o"></i>
                            {{ $t('button.contribute_lyrics') }}
                        </a>
                    </div>
                </div>
                <p>{{ music.lyrics }}</p>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        computed: {
            ...mapGetters({
                music: 'mediaDetailData',
                user: 'user',
                checkFollowed: 'checkFollowed',
                checkIsAuthUser: 'checkIsAuthUser'
            })
        },
        methods: {
            ...mapActions(['follow'])
        }
    }
</script>
<style scoped>

</style>
