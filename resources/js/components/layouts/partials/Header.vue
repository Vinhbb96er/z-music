<template>
    <header class="header-style-3">
        <div class="header-1st-row">
            <div class="container">
                <div class="breaking-news-column">
                    <!-- <strong>Breaking News:</strong> -->
                    <!-- <div class="brk-slider">
                        <div class="news_items">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        </div>
                        <div class="news_items">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        </div>
                        <div class="news_items">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        </div>
                    </div> -->
                </div>
            </div>
        </div>
        <div class="header-2st-row ">
            <div class="container">
                <div class="pull-left">
                    <div class="social-icons">
                        <ul>
                            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                    <form @submit.prevent="search">
                        <div class="container-search">
                            <input type="text" :placeholder="$t('home.search_placeholder')" v-model="keyword">
                            <div class="search"></div>
                        </div>
                    </form>
                </div>
                <div class="center-logo">
                    <div class="logo">
                        <h1>
                            <router-link :to="{name: 'home'}" tag="a">
                                <img class="logo-light" src="frontend/images/logo-light.png">
                                <img class="logo-drak" src="frontend/images/logo-dark.png">
                            </router-link>
                        </h1>
                    </div>
                </div>
                <div class="pull-right">
                    <ul class="user-menu">
                        <li class="dropdown navbar-profile" v-if="authenticated">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                <div class="meta" v-if="user">
                                    <img :src="user.avatar" class="avatar">
                                    </span>
                                    <div class="user-info">
                                        <span>{{ user.name }}</span>
                                        <span class="caret"></span>
                                    </div>
                                </div>
                            </a>
                            <!-- Start dropdown menu -->
                            <ul class="dropdown-menu animated">
                                <router-link tag="li" :to="{name: 'profile'}">
                                    <a href="#"><i class="fa fa-user"></i> {{ $t('auth.my_profile') }}</a>
                                </router-link>
                                <li>
                                    <a href="#"><i class="fa fa-heart"></i> {{ $t('auth.my_favourite_list')}}</a>
                                </li>
                                <li>
                                    <a href="#" @click.prevent="logout"><i class="fa fa-sign-out"> {{ $t('auth.logout')}}</i> </a>
                                </li>
                            </ul>
                            <!--/ End dropdown menu -->
                        </li>
                        <li v-else class="login-register">
                            <a href="#" data-toggle="modal" data-target="#login-register1">{{ $t('home.login_register') }}</a>
                        </li>
                    </ul>
                    <div id="kode-responsive-navigation" class="dl-menuwrapper">
                        <button class="dl-trigger"></button>
                        <ul class="dl-menu">
                            <li class="menu-item">
                                <router-link tag="a" :to="{name: 'home'}">{{ $t('home.home') }}</router-link>
                            </li>
                            <li class="menu-item">
                                <router-link tag="a" :to="{name: 'categoryKind', params: {id: 'all'}}">{{ $t('home.kind') }}</router-link>
                                <ul class="dl-submenu">
                                    <li v-for="kind in allKinds">
                                        <router-link tag="a" :to="{name: 'categoryKind', params: {id: kind.id}}">{{ kind.name }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <router-link tag="a" :to="{name: 'categoryRegion', params: {id: 'all'}}">{{ $t('home.region') }}</router-link>
                                <ul class="dl-submenu">
                                    <li v-for="region in allRegions">
                                        <router-link tag="a" :to="{name: 'categoryRegion', params: {id: region.id}}">{{ region.name }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a @click.prevent>{{ $t('home.ranking') }}</a>
                                <ul class="dl-submenu">
                                    <li>
                                        <a href="event-list.html">event list</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item ">
                                <router-link tag="a" :to="{name: 'searchArtist'}">{{ $t('artist.name') }}</router-link>
                            </li>
                            <li class="menu-item ">
                                <router-link tag="a" :to="{name: 'categoryTopic', params: {id: 'all'}}">{{ $t('home.topic') }}</router-link>
                                <ul class="dl-submenu">
                                    <li v-for="topic in allTags">
                                        <router-link tag="a" :to="{name: 'categoryTopic', params: {id: topic.id}}">{{ topic.name }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#">Liên hệ</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-2st-row align-center-nav">
            <div class="container">
                <div class="fst-navigation">
                    <nav class="navigation-1">
                        <ul>
                            <li class="menu-item">
                                <router-link tag="a" :to="{name: 'home'}">{{ $t('home.home') }}</router-link>
                            </li>
                            <li class="menu-item">
                                <router-link tag="a" :to="{name: 'categoryKind', params: {id: 'all'}}">{{ $t('home.kind') }}</router-link>
                                <ul class="dl-submenu">
                                    <li v-for="kind in allKinds">
                                        <router-link tag="a" :to="{name: 'categoryKind', params: {id: kind.id}}">{{ kind.name }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <router-link tag="a" :to="{name: 'categoryRegion', params: {id: 'all'}}">{{ $t('home.region') }}</router-link>
                                <ul class="dl-submenu">
                                    <li v-for="region in allRegions">
                                        <router-link tag="a" :to="{name: 'categoryRegion', params: {id: region.id}}">{{ region.name }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a @click.prevent>{{ $t('home.ranking') }}</a>
                                <ul class="dl-submenu">
                                    <li>
                                        <router-link tag="a" :to="{name: 'musicRanking'}">{{ $t('music.name') }}</router-link>
                                    </li>
                                    <li>
                                        <router-link tag="a" :to="{name: 'videoRanking'}">{{ $t('music_video.name') }}</router-link>
                                    </li>
                                    <li>
                                        <router-link tag="a" :to="{name: 'albumRanking'}">{{ $t('album.name') }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item ">
                                <router-link tag="a" :to="{name: 'searchArtist'}">{{ $t('artist.name') }}</router-link>
                            </li>
                            <li class="menu-item ">
                                <router-link tag="a" :to="{name: 'categoryTopic', params: {id: 'all'}}">{{ $t('home.topic') }}</router-link>
                                <ul class="dl-submenu">
                                    <li v-for="topic in allTags">
                                        <router-link tag="a" :to="{name: 'categoryTopic', params: {id: topic.id}}">{{ topic.name }}</router-link>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="#">Liên hệ</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </header>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        data() {
            return {
                keyword: '',
            }
        },
        computed: {
            ...mapGetters([
                'authenticated',
                'user',
                'allRegions',
                'allKinds',
                'allTags'
            ])
        },
        methods: {
            ...mapActions(['getAuth', 'logout', 'getAllCategories']),
            search() {
                if (this.keyword) {
                    this.$router.push({
                        name: 'search',
                        query: {
                            keyword: this.keyword
                        }
                    })
                }
            }
        },
        created() {
            this.getAuth();

            this.getAllCategories(window.Laravel.setting.category_type.region);
            this.getAllCategories(window.Laravel.setting.category_type.kind);
            this.getAllCategories(window.Laravel.setting.category_type.tag);
        }
    }
</script>
<style>

</style>
