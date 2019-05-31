$(document).ready(function () {
    $('.btn-block-store, .btn-active-store').on('click', function () {
        var dataId = $('#store-id').val();
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
