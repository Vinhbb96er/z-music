<template>
    <form @submit.prevent="submitUpload" class="comment-form light_bg">
        <div class="kode-textarea">
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
                <label class="input-title">{{ $t('media.type') }}:</label>
                <div class="forms">
                    <label for="rdo1">
                        <input type="radio" name="type" value="1" v-model="uploadData.type" checked id="rdo1">
                        <span class="rdo"></span>
                        <span>{{ $t('music.name') }}</span>
                    </label>
                    <label for="rdo2">
                        <input type="radio" name="type" v-model="uploadData.type" value="2" id="rdo2">
                        <span class="rdo"></span>
                        <span>{{ $t('music_video.name') }}</span>
                    </label>
                </div>
                <span class="error"></span>
            </div>
            <div class="form-group kf_commet_field">
                <label class="input-title">{{ $t('media.file') }}:</label>
                <input type="file" ref="file" v-if="uploadData.type == 1"
                    class="form-control input-text text-width-auto"
                    name="file" @change="handleFileUpload()"
                    v-validate="'required|ext:mp3,ogg,oga,mogg,wma'"
                    :data-vv-as="$t('media.file')"
                    :class="{'box-error': errors.has('file')}">
                <input type="file" ref="file" v-else
                    class="form-control input-text text-width-auto"
                    name="file" @change="handleFileUpload()"
                    v-validate="'required|ext:mp4,flv,wmv,avi,mov'"
                    :data-vv-as="$t('media.file')"
                    :class="{'box-error': errors.has('file')}">
                <span class="error">{{ errors.first('file') }}</span>
            </div>
            <div class="form-group kf_commet_field">
                <label class="input-title">{{ $t('media.cover_image') }}:</label>
                <input type="file"
                    class="form-control input-text text-width-auto"
                    name="cover_image" ref="cover_image"
                    @change="handleImageUpload()"
                    v-validate="'required|ext:jpg,png,jpeg'"
                    :data-vv-as="$t('media.cover_image')"
                    :class="{'box-error': errors.has('cover_image')}">
                <span class="error">{{ errors.first('cover_image') }}</span>
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
            <div class="btn-comment-group">
                <button type="reset" class="submit btn-1 theme-bg btn-reset" @click="clearData">{{ $t('button.cancel') }}</button>
                <button type="submit" class="submit btn-1 btn-comment">{{ $t('button.upload') }}</button>
            </div>
        </div>
    </form>
</template>
<script>
    import {mapGetters} from 'vuex'
    import {mapActions} from 'vuex'

    export default {
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
                }
            };
        },
        computed: {
            ...mapGetters(['allRegions', 'allKinds', 'allTags'])
        },
        methods: {
            ...mapActions(['getAllCategories', 'uploadMedia']),
            handleFileUpload() {
                this.uploadData.file = this.$refs.file.files[0];
            },
            handleImageUpload() {
                this.uploadData.cover_image = this.$refs.cover_image.files[0];
            },
            submitUpload() {
                this.uploadData.kinds = $('.user-detail .tag-input.kind').val();
                this.uploadData.tags = $('.user-detail .tag-input.tag').val();

                this.$validator.validateAll().then(valid => {
                    if (valid) {
                        confirmInfo({message: this.$t('message.confirm_upload_media')}, () => {
                            showAnimationLoader();
                            this.uploadMedia(this.uploadData)
                                .then(isSuccess => {
                                    hideAnimationLoader();

                                    if (isSuccess) {
                                        this.clearData();
                                        alertSuccess({message: this.$t('message.upload_media_success')});
                                    } else {
                                        alertDanger({message: this.$t('message.upload_media_failed')});
                                    }
                                })
                                .catch(err => {
                                    hideAnimationLoader();
                                    alertDanger({message: this.$t('message.upload_media_failed')});
                                });
                        });
                    }
                });
            },
            clearData() {
                this.uploadData = {
                    name: null,
                    type: 1,
                    file: '',
                    cover_image: '',
                    region_id: 0,
                    kinds: null,
                    tags: null,
                    lyrics: '',
                };

                $('.user-detail .btn-reset').click();
                $('.user-detail .tag-input.kind').tagsinput('removeAll');
                $('.user-detail .tag-input.tag').tagsinput('removeAll');

                this.$validator.reset();
            }
        },
        created() {
            this.getAllCategories(this.type.region);

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
            });
        }
    }
</script>
<style scoped>

</style>
