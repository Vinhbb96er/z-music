<template>
    <header class="header-style-3">
        <div class="header-1st-row">
            <div class="container">
                <div class="breaking-news-column">
                    <strong>Breaking News:</strong>
                    <div class="brk-slider">
                        <div class="news_items">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        </div>
                        <div class="news_items">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        </div>
                        <div class="news_items">
                            <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-2st-row ">
            <div class="container">
                <div class="pull-left">
                    <div class="social-icons">
                        <strong>FOLLOW US:</strong>
                        <ul>
                            <li><a href=""><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-linkedin" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-youtube" aria-hidden="true"></i></a></li>
                            <li><a href=""><i class="fa fa-soundcloud" aria-hidden="true"></i></a></li>
                        </ul>
                    </div>
                </div>
                <div class="center-logo">
                    <div class="logo">
                        <h1>
                            <a href="#">
                                <img class="logo-light" src="frontend/images/logo-light.png" alt="logo here">
                                <img class="logo-drak" src="frontend/images/logo-dark.png" alt="logo here">
                            </a>
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
                                <li>
                                    <a href="#"><i class="fa fa-user"></i> {{ $t('auth.my_profile') }}</a>
                                </li>
                                <li>
                                    <a href="#"><i class="fa fa-heart"></i> {{ $t('auth.my_favourite_list')}}</a>
                                </li>
                                <li>
                                    <a href="#"><i class="icon-music"></i> {{ $t('auth.music_management') }}</a>
                                </li>
                                <li>
                                    <a href="#" @click.prevent="logout"><i class="fa fa-sign-out"> {{ $t('auth.logout')}}</i> </a>
                                </li>
                            </ul>
                            <!--/ End dropdown menu -->
                        </li>
                        <li v-else class="login-register">
                            <a href="#" data-toggle="modal" data-target="#login-register1">login / register</a>
                        </li>
                    </ul>
                    <div id="kode-responsive-navigation" class="dl-menuwrapper">
                        <button class="dl-trigger"></button>
                        <ul class="dl-menu">
                            <li class="menu-item">
                                <a href="index.html">Home</a>
                                <ul class="dl-submenu">
                                    <li><a href="light-index.html">Home Light</a></li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="artist.html">artist</a>
                                <ul class="dl-submenu">
                                    <li><a href="artist.html">artist</a></li>
                                    <li><a href="artist-blog.html">artist 02</a></li>
                                    <li><a href="event-organiser.html">artist 03</a></li>
                                    <li><a href="dj.html">dj</a></li>
                                </ul>
                            </li>
                            <li class="menu-item">
                                <a href="#">event</a>
                                <ul class="dl-submenu">
                                    <li>
                                        <a href="event-list.html">event list</a>
                                    </li>
                                    <li>
                                        <a href="event-list-2.html">event list 02</a>
                                    </li>
                                    <li>
                                        <a href="event-list-3.html">event list 03</a>
                                    </li>
                                    <li>
                                        <a href="event-detail.html">event detail</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item "><a href="#">music</a>
                                <ul class="dl-submenu">
                                    <li>
                                        <a href="video.html">video</a>
                                    </li>
                                    <li>
                                        <a href="video-list.html">video list</a>
                                    </li>
                                    <li>
                                        <a href="video-detail.html">video detail</a>
                                    </li>
                                    <li>
                                        <a href="mp3-list.html">mp3 list</a>
                                    </li>
                                    <li>
                                        <a href="music-artist-albums.html">music artist albums</a>
                                    </li>
                                    <li>
                                        <a href="music-albums.html">music albums</a>
                                    </li>
                                    <li>
                                        <a href="masonry-gallary.html">masonry gallary</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item "><a href="#">blog</a>
                                <ul class="dl-submenu">
                                    <li>
                                        <a href="blog-detail.html">blog-detail</a>
                                    </li>
                                    <li>
                                        <a href="blog-detail-02.html">blog-detail 02</a>
                                    </li>
                                    <li>
                                        <a href="blog-detail-leftsidebar.html">blog-left-sidebar</a>
                                    </li>
                                    <li>
                                        <a href="blog-right-sidebar.html">blog-right-sidebar</a>
                                    </li>
                                    <li>
                                        <a href="blog-full.html">blog full</a>
                                    </li>
                                    <li>
                                        <a href="blog-medium.html">blog medium</a>
                                    </li>
                                    <li>
                                        <a href="blog-small.html">blog small</a>
                                    </li>
                                    <li>
                                        <a href="masonry-blog.html">masonry small</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item"><a href="#">pages</a>
                                <ul class="dl-submenu">
                                    <li>
                                        <a href="shop.html">shop</a>
                                    </li>
                                    <li>
                                        <a href="shop-items.html">shop items</a>
                                    </li>
                                    <li>
                                        <a href="shop-listing.html">shop listing</a>
                                    </li>
                                    <li>
                                        <a href="headers.html">headers</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="contact-us.html">contact us</a></li>
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
                            <li class="active"><a href="index.html">home</a>
                                <ul class="sub-menu children">
                                   <li><a href="light-index.html">Home Light</a></li>
                                </ul>
                            </li>
                            <li><a href="artist.html">artist</a>
                                <ul class="sub-menu children">
                                    <li><a href="artist.html">artist</a></li>
                                    <li><a href="artist-blog.html">artist 02</a></li>
                                    <li><a href="event-organiser.html">artist 03</a></li>
                                    <li><a href="dj.html">dj</a></li>
                                </ul>
                            </li>
                            <li class="menu-item ">
                                <a href="#">event</a>
                                <ul class="sub-menu children">
                                    <li>
                                        <a href="event-list.html">event list</a>
                                    </li>
                                    <li>
                                        <a href="event-list-2.html">event list 02</a>
                                    </li>
                                    <li>
                                        <a href="event-list-3.html">event list 03</a>
                                    </li>
                                    <li>
                                        <a href="event-detail.html">event detail</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item "><a href="#">music</a>
                                <ul class="sub-menu children">
                                    <li>
                                        <a href="dj.html">dj</a>
                                    </li>
                                    <li>
                                        <a href="video.html">video</a>
                                    </li>
                                    <li>
                                        <a href="video-list.html">video list</a>
                                    </li>
                                    <li>
                                        <a href="video-detail.html">video detail</a>
                                    </li>
                                    <li>
                                        <a href="mp3-list.html">mp3 list</a>
                                    </li>
                                    <li>
                                        <a href="music-artist-albums.html">music artist albums</a>
                                    </li>
                                    <li>
                                        <a href="music-albums.html">music albums</a>
                                    </li>
                                    <li>
                                        <a href="masonry-gallary.html">masonry gallary</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item "><a href="#">blog</a>
                                <ul class="sub-menu children">
                                    <li>
                                        <a href="blog-detail.html">blog detail</a>
                                    </li>
                                    <li>
                                        <a href="blog-detail-leftsidebar.html">blog left sidebar</a>
                                    </li>
                                    <li>
                                        <a href="blog-right-sidebar.html">blog right sidebar</a>
                                    </li>
                                    <li>
                                        <a href="blog-full.html">blog full</a>
                                    </li>
                                    <li>
                                        <a href="blog-medium.html">blog medium</a>
                                    </li>
                                    <li>
                                        <a href="blog-small.html">blog small</a>
                                    </li>
                                    <li>
                                        <a href="masonry-blog.html">masonry small</a>
                                    </li>
                                </ul>
                            </li>
                            <li class="menu-item ">
                                <a href="">page</a>
                                <ul class="sub-menu children">
                                    <li>
                                        <a href="shop.html">shop</a>
                                    </li>
                                    <li>
                                        <a href="shop-items.html">shop items</a>
                                    </li>
                                    <li>
                                        <a href="shop-listing.html">shop listing</a>
                                    </li>
                                    <li>
                                        <a href="headers.html">headers</a>
                                    </li>
                                </ul>
                            </li>
                            <li><a href="contact-us.html">contact us</a></li>
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
        computed: {
            ...mapGetters(['authenticated', 'user'])
        },
        methods: {
            ...mapActions(['getAuth', 'logout'])
        },
        created() {
            this.getAuth();
        }
    }
</script>
<style>

</style>
