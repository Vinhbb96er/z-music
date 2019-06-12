<template>
    <div class="kode-comment-form edit-media-content">
        <div class="msl-black">
            <div class="heading3">
                <!-- <h4><i class="fa fa-upload"></i>{{ $t('media.upload_title') }}</h4> -->
                <h4><i class="fa fa-upload"></i>Chỉnh sửa Bài hát/Video</h4>
            </div>
        </div>
        <form @submit.prevent class="comment-form light_bg">
            <div class="kode-textarea" v-if="mediaDetailData">
                <div class="form-group kf_commet_field">
                    <label class="input-title">{{ $t('media.song_name') }}:</label>
                    <input type="text" class="form-control input-text"
                        :placeholder="$t('media.song_name_placeholder')"
                        name="name" v-model="uploadData.name"
                        v-validate="'required|max:255'"
                        :data-vv-as="$t('media.song_name')"
                        :class="{'box-error': errors.has('name')}">
                    <span class="error">{{ errors.first('name') }}</span>
                </div>
                <div class="form-group kf_commet_field">
                    <label class="input-title">{{ $t('media.cover_image') }}:</label>
                    <div class="cover-image-content">
                        <div class="backgroud-image-show cover-image" :style="{backgroundImage: `url('${mediaDetailData.cover_image}')`}">
                        </div>
                        <input type="file"
                            class="form-control input-text text-width-auto"
                            name="cover_image" ref="cover_image"
                            @change="handleImageUpload()"
                            v-validate="'ext:jpg,png,jpeg'"
                            :data-vv-as="$t('media.cover_image')"
                            :class="{'box-error': errors.has('cover_image')}">
                        <span class="error">{{ errors.first('cover_image') }}</span>
                    </div>
                </div>
                <div class="form-group kf_commet_field">
                    <label class="input-title">{{ $t('media.region') }}:</label>
                    <select class="form-control input-text text-width-auto" name="region" v-model="uploadData.region_id">
                        <option value="0">{{ $t('media.choose_region') }}</option>
                        <option v-for="region in allRegions" :value="region.id">{{ region.name }}</option>
                    </select>
                    <span class="error"></span>
                </div>
                <div class="form-group kf_commet_field">
                    <label class="input-title">{{ $t('media.kinds') }}:</label>
                    <input type="text" class="form-control input-text tag-input kind" :placeholder="$t('media.kind_placeholder')" data-role="tagsinput" name="kinds">
                    <span class="error"></span>
                </div>
                <div class="form-group kf_commet_field">
                    <label class="input-title">{{ $t('media.tags') }}:</label>
                    <input type="text" class="form-control input-text tag-input tag" :placeholder="$t('media.tag_placeholder')" data-role="tagsinput" name="tags">
                    <span class="error"></span>
                </div>
                <div class="form-group kf_commet_field">
                    <label class="input-title">{{ $t('media.lyrics') }}:</label>
                    <textarea class="form-control input-text" :placeholder="$t('media.lyrics_placeholder')" name="lyrics" v-model="uploadData.lyrics"></textarea>
                    <span class="error"></span>
                </div>
                <div class="form-group kf_commet_field file-content">
                    <label class="input-title">{{ $t('media.karaoke_lyrics') }}:</label>
                    <audio controls class="form-control file-audio" v-if="mediaType == 1"></audio>
                    <video class="file-audio" v-else controls></video>
                    <div class="text-center btn-edit-lyrics">
                        <template v-if="editKaraoke">
                            <button class="btn btn-success btn-sm" @click.prevent="saveKaraokeLyrics"><i class="fa fa-check"></i></button>
                            <button class="btn btn-primary btn-sm" @click.prevent="addKaraokeLyrics"><i class="fa fa-plus"></i></button>
                        </template>
                        <button class="btn btn-info btn-sm" @click.prevent="editKaraokeLyrics" v-else><i class="fa fa-pencil"></i></button>
                    </div>
                    <div class="content" v-if="!editKaraoke">
                        <div class="lyrics" v-if="karaokeLyrics.length">
                            <div v-for="item in karaokeLyrics">
                                {{ item.line }}
                            </div>
                        </div>
                        <div v-else>Chưa có Karaoke</div>
                    </div>
                    <div v-if="editKaraoke" class="karaoke-edit-block">
                        <div class="karaoke-edit-content" v-for="(item, index) in karaokeLyricsEdit">
                            <div class="text-content">
                                <label>Lời:</label>
                                <input type="text" class="form-control input-line" v-model="item.line">
                            </div>
                            <div class="time-content">
                                <label>Thời gian hiển thị:</label>
                                <input type="text" class="form-control input-time" v-model="item.time">
                            </div>
                            <div class="button-content">
                                <button class="btn btn-danger btn-xs"><i class="fa fa-close" @click.stop.prevent="removeKaraokeLyrics(index)"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-comment-group">
                    <button class="submit btn-1 theme-bg btn-reset" @click.stop.prevent="cancel">{{ $t('button.cancel') }}</button>
                    <button type="submit" class="submit btn-1 btn-comment" @click.stop.prevent="submitUpload">{{ $t('button.save') }}</button>
                </div>
            </div>
        </form>
    </div>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
        props: {
            mediaId: {
                require: true
            },
            mediaType: {
                require: true
            },
            cancel: {
                type: Function
            }
        },
        data() {
            return {
                uploadData: {
                    name: null,
                    type: 1,
                    file: '',
                    cover_image: '',
                    region_id: 0,
                    kinds: null,
                    tags: null,
                    lyrics: '',
                },
                type: {
                    region: window.Laravel.setting.category_type.region,
                    kind: window.Laravel.setting.category_type.kind,
                    tag: window.Laravel.setting.category_type.tag
                },
                editKaraoke: false,
                karaokeLyricsEdit: [],
                karaokeLyrics: [],
                duration: 0
            };
        },
        computed: {
            ...mapGetters(['allRegions', 'allKinds', 'allTags', 'mediaDetailData']),
        },
        methods: {
            ...mapActions(['getAllCategories', 'uploadMedia', 'getMediaDetail', 'updateMedia']),
            handleFileUpload() {
                this.uploadData.file = this.$refs.file.files[0];
            },
            handleImageUpload() {
                this.uploadData.cover_image = this.$refs.cover_image.files[0];
            },
            submitUpload() {
                this.uploadData.kinds = $('.user-detail .tag-input.kind').val();
                this.uploadData.tags = $('.user-detail .tag-input.tag').val();
                this.uploadData.id = this.mediaId;
                this.uploadData.karaoke_lyrics = JSON.stringify(this.karaokeLyrics);

                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        confirmInfo({message: this.$t('message.confirm_update_media')}, () => {
                            showAnimationLoader();
                            this.updateMedia(this.uploadData)
                                .then(isSuccess => {
                                    hideAnimationLoader();

                                    if (isSuccess) {
                                        alertSuccess({message: this.$t('message.update_media_success')});
                                    } else {
                                        alertDanger({message: this.$t('message.update_media_failed')});
                                    }

                                    this.cancel();
                                })
                                .catch(err => {
                                    hideAnimationLoader();
                                    alertDanger({message: this.$t('message.update_media_failed')});
                                });
                        });
                    }
                });
            },
            editKaraokeLyrics() {
                $('.file-audio')[0].pause();
                $('.file-audio')[0].currentTime = 0;
                var data = [];

                this.karaokeLyrics.forEach(function (item) {
                    let time = item.time;
                    let hours = Math.floor(item.time / 3600);
                    let minutes = Math.floor((time - hours * 3600) / 60);
                    let seconds = Math.floor(time - (minutes * 60));

                    data.push({
                        line: item.line,
                        time: `${hours < 10 ? '0' : ''}${hours}:${minutes < 10 ? '0' : ''}${minutes}:${seconds < 10 ? '0' : ''}${seconds}`
                    })
                });

                this.karaokeLyricsEdit = data;
                this.editKaraoke = true;
            },
            addKaraokeLyrics() {
                this.karaokeLyricsEdit.push({
                    time: '00:00:00',
                    line: ''
                });
            },
            removeKaraokeLyrics(index) {
                this.karaokeLyricsEdit.splice(index, 1);
            },
            saveKaraokeLyrics() {
                this.editKaraoke = false;
                var data = [];

                this.karaokeLyricsEdit.forEach((item) => {
                    let timeArr = item.time.split(':');
                    let time = parseInt(timeArr[0]) * 3600 + parseInt(timeArr[1]) * 60 + parseInt(timeArr[2]);

                    data.push({
                        line: item.line,
                        time: time
                    })
                });

                this.karaokeLyrics = data;
                this.loadKaraoke();
            },
            loadKaraoke() {
                var karaokeList = this.karaokeLyrics;
                var currentLine = '';

                $('.file-audio').on('timeupdate', function() {
                    if (!karaokeList) {
                        return;
                    }

                    var currentTime = this.currentTime;
                    var past = karaokeList.filter(function (item) {
                        return item.time < currentTime;
                    });

                    if (past.length != currentLine) {
                        currentLine = past.length;
                        $('.edit-media-content .lyrics div').removeClass('highlighted');
                        $(`.edit-media-content .lyrics div:nth-child(${past.length})`).addClass('highlighted');
                        alignKaraokeLyrics($('.edit-media-content .content'));
                    }
                });
            }
        },
        created() {
            this.getAllCategories(this.type.region);

            this.getMediaDetail({
                type: this.mediaType,
                id: this.mediaId
            }).then(() => {
                this.getAllCategories(this.type.kind).then(() => {
                    $('.user-detail .tag-input.kind').tagsinput({
                        itemValue: 'id',
                        itemText: 'name',
                        typeaheadjs: {
                            name: 'kinds',
                            displayKey: 'name',
                            source: (query, syncResults) => {
                                syncResults(this.allKinds);
                            }
                        }
                    });

                    this.mediaDetailData.kinds.forEach((item) => {
                        $('.user-detail .tag-input.kind').tagsinput('add', {
                            id: item.id,
                            name: item.name
                        });
                    });
                });

                this.getAllCategories(this.type.tag).then(() => {
                    $('.user-detail .tag-input.tag').tagsinput({
                        itemValue: 'id',
                        itemText: 'name',
                        typeaheadjs: {
                            name: 'tags',
                            displayKey: 'name',
                            source: (query, syncResults) => {
                                syncResults(this.allTags);
                            }
                        }
                    });

                    this.mediaDetailData.tags.forEach((item) => {
                        $('.user-detail .tag-input.tag').tagsinput('add', {
                            id: item.id,
                            name: item.name
                        });
                    });
                });

                this.karaokeLyrics = this.mediaDetailData.karaoke_lyrics ? this.mediaDetailData.karaoke_lyrics : [];
                $('.file-audio')[0].src = this.mediaDetailData.url;

                this.uploadData = {
                    name: this.mediaDetailData.name,
                    cover_image: '',
                    region_id: this.mediaDetailData.region.id,
                    kinds: null,
                    tags: null,
                    lyrics: this.mediaDetailData.lyrics,
                };

                this.loadKaraoke();

                var audio = $('.file-audio')[0];
                audio.onloadedmetadata = () => {
                    this.duration = audio.duration;
                };

                // $('.input-time').datetimepicker({
                //     format: 'hh:mm:ss',
                //     sideBySide: true
                // });
            });
        }
    }
</script>
<style scoped>
    .type-tab .nav-tabs {
        margin-bottom: 25px;
        margin-left: 7px;
    }

    .type-tab .nav-tabs li a {
        font-size: 12px;
    }

    .edit-media-content .cover-image-content .cover-image {
        width: 200px;
        height: 100px;
        display: inline-block;
        margin-bottom: 5px;
    }

    .edit-media-content .cover-image-content input {
        margin-left: 120px;
    }

    .edit-media-content .file-content {
        overflow: auto;
        margin-bottom: 30px;
    }

    .edit-media-content .file-content .file-audio {
        width: 73%;
        overflow: auto;
        float: left;
        margin-bottom: 20px;
    }

    .edit-media-content .content {
        padding-left: 120px;
        text-align: center;
        overflow: auto;
        max-height: 200px;
    }

    .edit-media-content .content::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.3);
        background-color: #a0a0a0;
    }

    .edit-media-content .content::-webkit-scrollbar {
        width: 2px;
        background-color: #F5F5F5;
    }

    .edit-media-content .content::-webkit-scrollbar-thumb {
        background-color: #f5253f;
        border-radius: 10px;
    }

    .edit-media-content .content .lyrics {
        min-height: 100px;
        width: calc(100% - 40px);
        margin: 0 20px;
        text-align: center;
        transition: all .25s;
        position: relative;
    }

    .edit-media-content .content .lyrics > div {
        position: relative;
        font-size: 15px;
        line-height: 35px;
        color: #fff;
        transition: all .25s;
    }

    .edit-media-content .content .lyrics > div:before {
        content: attr(note);
        position: absolute;
        top: 0px;
        left: 50%;
        -webkit-transform: translate(-50%, -50%);
        transform: translate(-50%, -50%);
        font-size: 18px;
    }

    .edit-media-content .content .lyrics > div.highlighted {
        color: #ecdb0c;
        font-size: 17px;
        font-weight: bold;
    }

    .edit-media-content .karaoke-edit-block {
        max-height: 275px;
        overflow: auto;
        padding: 0 5px 0 120px;
        margin-top: 20px;
    }

    .edit-media-content .karaoke-edit-block::-webkit-scrollbar-track {
        -webkit-box-shadow: inset 0 0 6px rgba(255, 255, 255, 0.3);
        background-color: #a0a0a0;
    }

    .edit-media-content .karaoke-edit-block::-webkit-scrollbar {
        width: 2px;
        background-color: #F5F5F5;
    }

    .edit-media-content .karaoke-edit-block::-webkit-scrollbar-thumb {
        background-color: #f5253f;
        border-radius: 10px;
    }

    .edit-media-content .btn-edit-lyrics {
        margin-top: 2px;
    }

    .edit-media-content .karaoke-edit-content {
        margin-bottom: 10px;
        display: flex;
    }

    .edit-media-content .karaoke-edit-content:last-child {
        margin-bottom: 0;
    }

    .edit-media-content .karaoke-edit-content label {
        color: #fff;
        margin-bottom: 5px;
    }

    .edit-media-content .karaoke-edit-content input {
        color: #f1f1f1;
    }

    .edit-media-content .karaoke-edit-content .time-content {
        width: 25%;
    }

    .edit-media-content .karaoke-edit-content .text-content {
        width: 68%;
        padding-right: 15px;
    }

    .edit-media-content .karaoke-edit-content .button-content {
        margin: 32px 0 0 15px;
    }

    .edit-media-content .karaoke-edit-content .time-content input::-webkit-datetime-edit-ampm-field {
        display: none;
    }

    .edit-media-content .karaoke-edit-content .time-content input::-webkit-clear-button {
        -webkit-appearance: none;
        -moz-appearance: none;
        -o-appearance: none;
        -ms-appearance:none;
        appearance: none;
        margin: -10px;
    }

</style>
