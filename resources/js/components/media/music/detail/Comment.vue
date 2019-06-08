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
                                    <h5>
                                        <router-link tag="a" :to="{name: 'profileShow', params: {id: comment.user.id}}">
                                            {{ comment.user.name }}
                                        </router-link>
                                    </h5>
                                    <span>{{ comment.created_at }}</span>
                                </div>
                                <p>{{ comment.content }}</p>
                                <a role="button" class="comment-reply-link" @click.prevent="replyComment(comment.id, comment.user.name)">Trả lời</a>
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
                                            <h5>
                                                <router-link tag="a" :to="{name: 'profileShow', params: {id: reply.user.id}}">
                                                    {{ reply.user.name }}
                                                </router-link>
                                            </h5>
                                            <span>{{ reply.created_at }}</span>
                                        </div>
                                        <p>{{ reply.content }}</p>
                                        <a role="button" class="comment-reply-link" @click.prevent="replyComment(comment.id, reply.user.name)">Trả lời</a>
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
                <figure class="backgroud-image-show" :style="{backgroundImage: `url(${authenticated ? user.avatar : '/frontend/images/user_avatar_default.png'})`}"></figure>
                <div class="kode-textarea">
                    <div class="reply-content" v-if="reply_id">
                        Trả lời: <strong>@{{ reply_name }}</strong>
                        <button class="btn btn-danger btn-sm" @click="clearReply">
                            <i class="fa fa-close"></i>
                        </button>
                    </div>
                    <textarea placeholder="Type Your Comments" name="comment" v-model="commentContent" id="comment"></textarea>
                    <div class="btn-comment-group">
                        <button type="reset" @click="clearComment" class="submit btn-1 theme-bg">{{ $t('button.cancel') }}</button>
                        <button @click.prevent="submitComment" class="submit btn-1 btn-comment">{{ $t('button.comment') }}</button>
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
                type: window.Laravel.setting.media.type.music,
                id: this.$route.params.id,
                commentContent: '',
                page: 1,
                reply_id: 0,
                reply_name: ''
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
                commentData: 'mediaComments',
                authenticated: 'authenticated',
                user: 'user'
            })
        },
        methods: {
            ...mapActions(['getMediaComments', 'commentMedia']),
            loadComment(page) {
                this.page = page;
                this.getMediaComments({
                    type: this.type,
                    id: this.id,
                    page: page
                });
            },
            submitComment() {
                if (!this.authenticated) {
                    $('#login-register1').modal('show');

                    return;
                }

                confirmInfo({message: 'Bạn có chắc chắn muốn bình luận không'}, () => {
                    this.commentMedia({
                        type: this.type,
                        id: this.id,
                        content: this.commentContent,
                        reply_id: this.reply_id,
                        page: this.page
                    }).then(res => {
                        this.clearComment();
                    }).catch(err => {
                        reject(err);
                    });
                });
            },
            replyComment(id, name) {
                this.reply_id = id;
                this.reply_name = name;
                $('#comment').focus();
            },
            clearReply() {
                this.reply_id = 0,
                this.reply_name = '';
            },
            clearComment() {
                this.commentContent = '';
                this.clearReply();
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
