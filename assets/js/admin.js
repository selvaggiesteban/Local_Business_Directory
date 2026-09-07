/**
 * Local Business Directory - Admin Scripts
 */
(function ($) {
    'use strict';

    // Logo Upload
    $('#lbd-upload-logo').on('click', function (e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Seleccionar Logo',
            button: { text: 'Usar este logo' },
            multiple: false
        });

        frame.on('select', function () {
            var attachment = frame.state().get('selection').first().toJSON();
            $('#lbd_logo').val(attachment.id);
            $('#lbd-logo-preview').html(
                '<img src="' + attachment.url + '" class="lbd-logo-preview" alt="Logo preview">'
            );
        });

        frame.open();
    });

    $('#lbd-remove-logo').on('click', function (e) {
        e.preventDefault();
        $('#lbd_logo').val('');
        $('#lbd-logo-preview').html('');
    });

    // Gallery Upload
    $('#lbd-add-gallery').on('click', function (e) {
        e.preventDefault();
        var frame = wp.media({
            title: 'Agregar Imágenes a la Galería',
            button: { text: 'Agregar imágenes' },
            multiple: true
        });

        frame.on('select', function () {
            var attachments = frame.state().get('selection').toJSON();
            var $grid = $('#lbd-gallery-preview');

            attachments.forEach(function (attachment) {
                var index = Date.now() + Math.random();
                var html = '<div class="lbd-gallery-item" data-index="' + index + '">' +
                    '<img src="' + attachment.url + '" alt="Gallery image">' +
                    '<button type="button" class="remove-gallery" data-index="' + index + '">&times;</button>' +
                    '<input type="hidden" name="lbd_gallery[]" value="' + attachment.id + '">' +
                    '</div>';
                $grid.append(html);
            });
        });

        frame.open();
    });

    $(document).on('click', '.remove-gallery', function (e) {
        e.preventDefault();
        $(this).closest('.lbd-gallery-item').remove();
    });

})(jQuery);