<template>
    <div class="tab-pane active">
        <div class="kode-comments" v-if="commentData">
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-comments-o"></i>{{ commentData.total }} {{ $t('media.comments') }}</h4>
                </div>
            </div>
            <!--Heading End-->
            <ul id="kode-comment" class="comment">
                <li v-for="comment in commentData.data" :key="comment.id">
                    <div class="comment_item">
                        <!-- Kode Comment Form Start -->
                        <div class="kode-author">
                            <figure class="backgroud-image-show">
                                <img class="backgroud-image-show" :style="{backgroundImage: `url('${comment.user.avatar}')`}">
                            </figure>
                            <div class="kode-author-content">
                                <div class="kode-author-head">
                                    <h5><a href="#">{{ comment.user.name }}</a></h5>
                                    <span>{{ comment.created_at }}</span>
                                </div>
                                <p>{{ comment.content }}</p>
                                <a class="comment-reply-link" href="#">Reply</a>
                            </div>
                        </div>
                        <!-- Kode Comment Form End -->
                    </div>
                    <ul class="children" v-if="comment.replies.length">
                        <li v-for="reply in comment.replies" :key="reply.id">
                            <div class="comment_item">
                                <!-- Kode Comment Form Start -->
                                <div class="kode-author">
                                    <figure>
                                        <img class="backgroud-image-show" :style="{backgroundImage: `url('${reply.user.avatar}')`}">
                                    </figure>
                                    <div class="kode-author-content">
                                        <div class="kode-author-head">
                                            <h5><a href="#">{{ reply.user.name }}</a></h5>
                                            <span>{{ reply.created_at }}</span>
                                        </div>
                                        <p>reply.content</p>
                                        <a class="comment-reply-link" href="#">Reply</a>
                                    </div>
                                </div>
                                <!-- Kode Comment Form End -->
                            </div>
                        </li>
                    </ul>
                </li>
            </ul>
            <pagination :pageData="commentData" :loadPageFunc="loadComment"></pagination>
        </div>
        <div class="kode-comment-form">
            <div class="msl-black">
                <div class="heading3">
                    <h4><i class="fa fa-comment-o"></i>{{ $t('media.add_comment') }}</h4>
                </div>
            </div>
            <!--Heading End-->
            <p></p>
            <form method="post" id="commentform" class="comment-form light_bg">
                <figure class="backgroud-image-show" style="background-image: url(https://lorempixel.com/100/100/?50171);"></figure>
                <div class="kode-textarea">
                    <textarea placeholder="Type Your Comments" name="comment"></textarea>
                    <div class="btn-comment-group">
                        <button type="reset"  class="submit btn-1 theme-bg">{{ $t('button.cancel') }}</button>
                        <button type="reset"  class="submit btn-1 btn-comment">{{ $t('button.comment') }}</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    import Pagination from '../../../layouts/partials/Pagination.vue'

    export default {
        data() {
            return {
                type: window.Laravel.setting.media.type.video,
                id: this.$route.params.id,
            }
        },
        components: {
            Pagination
        },
        watch: {
            '$route'(to, from) {
                this.id = to.params.id;

                this.getMediaComments({
                    type: this.type,
                    id: this.id,
                    page: 1
                });
            }
        },
        computed: {
            ...mapGetters({
                commentData: 'mediaComments'
            })
        },
        methods: {
            ...mapActions(['getMediaComments']),
            loadComment(page) {
                this.getMediaComments({
                    type: this.type,
                    id: this.id,
                    page: page
                });
            }
        },
        created() {
            this.getMediaComments({
                type: this.type,
                id: this.id,
                page: 1
            });
        }
    }
</script>
<style scoped>

</style>
