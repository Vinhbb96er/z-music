$(document).ready(function () {
    var form = $('#form-shipper');
    var validator = form.validate({
        debug: false,
        rules: {
            name: {
                required: true,
                minlength: 6,
                maxlength: 255,
            },

            email: {
                required: true,
                email: true,
                minlength: 6,
                maxlength: 255,
            },

            address: {
                required: true,
            },

            phone: {
                required: true
            },

            identity_number: {
                required: true
            }

        },
        messages: {
            name: {
                required: Lang.get('validation.required', {
                    'attribute': Lang.get('lang.name')
                }),
                minlength: Lang.get('validation.min.string', {
                    'attribute': Lang.get('lang.name'),
                    'min': 6
                }),
                maxlength: Lang.get('validation.max.string', {
                    'attribute': Lang.get('lang.name'),
                    'max': 255
                }),
            },
            email: {
                required: Lang.get('validation.required', {
                    'attribute': Lang.get('lang.email')
                }),
                email: Lang.get('validation.email', {
                    'attribute': Lang.get('lang.email')
                }),
                minlength: Lang.get('validation.min.string', {
                    'attribute': Lang.get('lang.email'),
                    'min': 6
                }),
                maxlength: Lang.get('validation.max.string', {
                    'attribute': Lang.get('lang.email'),
                    'max': 255
                }),
            },
            address: {
                required: Lang.get('validation.required', {
                    'attribute': Lang.get('lang.address')
                }),
            },
            phone: {
                required: Lang.get('validation.required', {
                    'attribute': Lang.get('lang.phone')
                }),
            },
            identity_number: {
                required: Lang.get('validation.required', {
                    'attribute': Lang.get('lang.identity_number')
                }),
            },
        },
        highlight: function (element) {
            $(element).addClass('danger');
            $(element).removeClass('primarys');
        },
        unhighlight: function (element) {
            $(element).removeClass('danger');
            $(element).addClass('primarys');
        }
    });

    $('#btn-register').click(function () {
        if (form.valid()) {
            confirmInfo({message: $(this).data('msg')}, function () {
                $('#form-shipper').submit();
            });
        }
    });

    $('.btn-block-shipper, .btn-active-shipper').on('click', function () {
        var dataId = $('#shipper-id').val();
        var url = $(this).data('url');
        var msg = $(this).data('msg');

        confirmInfo({message: msg}, function () {
            $.ajax({
                url: url,
                method: 'POST',
                data: {
                    dataId: dataId
                }
            }).done(function (data) {
                if (data.success) {
                    alertSuccess({message: data.message}, function () {
                        location.reload();
                    });
                } else {
                    alertDanger({message: data.message}, function () {
                        location.reload();
                    });
                }
            });
        });
    });

});
