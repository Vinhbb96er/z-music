<template>
    <div id="report-form" class="modal fade" role="dialog">
        <div class="modal-dialog">
            <!-- Modal content-->
            <div class="modal-content">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class="ms-login-form">
                    <div class="form-content">
                        <div class="ms_width_off50 report-content">
                            <form @submit.prevent="submitReport" data-vv-scope="form-login">
                                <div class="form-group kf_commet_field">
                                    <label class="input-title">Chọn nội dung báo cáo:</label>
                                    <div class="forms">
                                        <label for="rdo1">
                                            <input type="radio" name="type" value="Nội dung không phù hợp"  checked id="rdo1" v-model="content">
                                            <span class="rdo"></span>
                                            <span>Nội dung không phù hợp</span>
                                        </label>
                                        <label for="rdo2">
                                            <input type="radio" name="type" value="Vi phạm bản quyền" id="rdo2" v-model="content">
                                            <span class="rdo"></span>
                                            <span>Vi phạm bản quyền</span>
                                        </label>
                                        <label for="rdo3">
                                            <input type="radio" name="type" value="Không phát được" id="rdo3" v-model="content">
                                            <span class="rdo"></span>
                                            <span>Không phát được</span>
                                        </label>
                                        <label for="rdo4">
                                            <input type="radio" name="type" value="Không tải được" id="rdo4" v-model="content">
                                            <span class="rdo"></span>
                                            <span>Không tải được</span>
                                        </label>
                                        <label for="rdo5">
                                            <input type="radio" name="type" value="Chất lượng kém" id="rdo5" v-model="content">
                                            <span class="rdo"></span>
                                            <span>Chất lượng kém</span>
                                        </label>
                                        <label for="rdo6">
                                            <input type="radio" name="type" value="Thông tin chưa chính xác" id="rdo6" v-model="content">
                                            <span class="rdo"></span>
                                            <span>Thông tin chưa chính xác</span>
                                        </label>
                                    </div>
                                    <span class="error"></span>
                                </div>
                                <div class="text-right">
                                    <button type="submit" class="btn btn-info">Gửi</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>
<script>
    import {mapActions} from 'vuex'
    import {mapGetters} from 'vuex'

    export default {
        data() {
            return {
                content: 'Nội dung không phù hợp'
            };
        },
        props: {
            reportFunc: {
                required: true,
                type: Function
            }
        },
        computed: {
            ...mapGetters(['authenticated'])
        },
        methods: {
            ...mapActions(['reportMedia']),
            submitReport() {
                confirmInfo({message: 'Bạn có chắc chắn muốn báo cáo không'}, () => {
                    this.reportFunc(this.content, () => {
                        $('#report-form').modal('hide');
                        this.content = 'Nội dung không phù hợp';
                    });
                });
            }
        }
    }
</script>
<style scoped>
    .report-content {
        width: 100%;
    }

    .report-content .input-title {
        color: #fff;
        font-size: 22px;
    }

    .forms > label {
        width: 100%;
        margin: 5px 15px;
    }
</style>
