/**
 * Local Business Directory - Frontend AJAX Search + Gallery Carousel
 */
(function ($) {
    'use strict';

    var currentPage = 1;
    var searchTimer = null;

    $(document).on('submit', '#lbd-search-form', function (e) {
        e.preventDefault();
        currentPage = 1;
        performSearch();
    });

    $(document).on('change', '#lbd-search-rubro, #lbd-search-categoria, #lbd-search-zona', function () {
        currentPage = 1;
        performSearch();
    });

    $(document).on('input', '#lbd-search-keyword', function () {
        clearTimeout(searchTimer);
        var self = this;
        searchTimer = setTimeout(function () {
            currentPage = 1;
            performSearch();
        }, 400);
    });

    function performSearch() {
        var $grid = $('#lbd-results-grid');
        var $info = $('#lbd-results-info');
        var $count = $('#lbd-results-count');
        var $pagination = $('#lbd-pagination');

        var data = {
            action: 'lbd_search_businesses',
            nonce: lbdFrontend.nonce,
            keyword: $('#lbd-search-keyword').val() || '',
            rubro: $('#lbd-search-rubro').val() || '',
            categoria: $('#lbd-search-categoria').val() || '',
            zona: $('#lbd-search-zona').val() || '',
            page: currentPage,
            per_page: 12
        };

        $grid.css('opacity', '0.5');

        $.post(lbdFrontend.ajaxUrl, data, function (response) {
            if (response.success) {
                $grid.html(response.data.html).css('opacity', '1');
                $count.text(response.data.total);
                $info.show();
                renderPagination(response.data.total_pages, response.data.current_page);
            } else {
                $grid.html('<div class="lbd-no-results"><p>Error al buscar negocios.</p></div>').css('opacity', '1');
                $info.hide();
            }
        }).fail(function () {
            $grid.css('opacity', '1');
        });
    }

    function renderPagination(totalPages, currentPageNum) {
        var $pagination = $('#lbd-pagination');
        $pagination.empty();

        if (totalPages <= 1) return;

        $pagination.append(
            $('<button>').text('← Anterior')
                .prop('disabled', currentPageNum <= 1)
                .on('click', function () {
                    currentPage = currentPageNum - 1;
                    performSearch();
                    $('html, body').animate({ scrollTop: $('#lbd-results-grid').offset().top - 20 }, 300);
                })
        );

        for (var i = 1; i <= totalPages; i++) {
            (function (page) {
                $pagination.append(
                    $('<button>').text(page)
                        .toggleClass('active', page === currentPageNum)
                        .on('click', function () {
                            currentPage = page;
                            performSearch();
                            $('html, body').animate({ scrollTop: $('#lbd-results-grid').offset().top - 20 }, 300);
                        })
                );
            })(i);
        }

        $pagination.append(
            $('<button>').text('Siguiente →')
                .prop('disabled', currentPageNum >= totalPages)
                .on('click', function () {
                    currentPage = currentPageNum + 1;
                    performSearch();
                    $('html, body').animate({ scrollTop: $('#lbd-results-grid').offset().top - 20 }, 300);
                })
        );
    }

    /* ===== Gallery Carousel ===== */
    $(document).ready(function () {
        $('.lbd-gallery-carousel').each(function () {
            var $carousel = $(this);
            var $track = $carousel.find('.lbd-gallery-track');
            var $items = $carousel.find('.lbd-gallery-item');
            var $dots = $carousel.find('.lbd-gallery-dot');
            var total = $items.length;
            var current = 0;

            function getItemWidth() {
                return $items.first().outerWidth(true);
            }

            function goTo(index) {
                if (index < 0) index = 0;
                if (index >= total) index = total - 1;
                current = index;

                $items.removeClass('active');
                $items.eq(current).addClass('active');

                $dots.removeClass('active');
                $dots.eq(current).addClass('active');

                var itemW = getItemWidth();
                var trackW = $track.parent().width();
                var offset = (trackW / 2) - (itemW / 2) - (current * itemW);
                $track.css('transform', 'translateX(' + offset + 'px)');
            }

            $carousel.on('click', '.lbd-gallery-next', function () {
                goTo(current + 1);
            });

            $carousel.on('click', '.lbd-gallery-prev', function () {
                goTo(current - 1);
            });

            $carousel.on('click', '.lbd-gallery-dot', function () {
                goTo($(this).data('index'));
            });

            $items.on('click', function () {
                var idx = $(this).data('index');
                if (idx !== current) {
                    goTo(idx);
                }
            });

            /* Touch / Swipe */
            var touchStartX = 0;
            var touchDeltaX = 0;
            var isTouching = false;

            $track.on('touchstart', function (e) {
                touchStartX = e.originalEvent.touches[0].clientX;
                touchDeltaX = 0;
                isTouching = true;
                $track.css('transition', 'none');
            });

            $track.on('touchmove', function (e) {
                if (!isTouching) return;
                touchDeltaX = e.originalEvent.touches[0].clientX - touchStartX;
                var itemW = getItemWidth();
                var trackW = $track.parent().width();
                var baseOffset = (trackW / 2) - (itemW / 2) - (current * itemW);
                $track.css('transform', 'translateX(' + (baseOffset + touchDeltaX) + 'px)');
            });

            $track.on('touchend', function () {
                if (!isTouching) return;
                isTouching = false;
                $track.css('transition', '');
                if (Math.abs(touchDeltaX) > 50) {
                    if (touchDeltaX < 0) goTo(current + 1);
                    else goTo(current - 1);
                } else {
                    goTo(current);
                }
            });

            /* Mouse drag */
            var mouseStartX = 0;
            var mouseDeltaX = 0;
            var isMouseDragging = false;

            $track.on('mousedown', function (e) {
                mouseStartX = e.clientX;
                mouseDeltaX = 0;
                isMouseDragging = true;
                $track.css('transition', 'none');
                e.preventDefault();
            });

            $(document).on('mousemove', function (e) {
                if (!isMouseDragging) return;
                mouseDeltaX = e.clientX - mouseStartX;
                var itemW = getItemWidth();
                var trackW = $track.parent().width();
                var baseOffset = (trackW / 2) - (itemW / 2) - (current * itemW);
                $track.css('transform', 'translateX(' + (baseOffset + mouseDeltaX) + 'px)');
            });

            $(document).on('mouseup', function () {
                if (!isMouseDragging) return;
                isMouseDragging = false;
                $track.css('transition', '');
                if (Math.abs(mouseDeltaX) > 50) {
                    if (mouseDeltaX < 0) goTo(current + 1);
                    else goTo(current - 1);
                } else {
                    goTo(current);
                }
            });

            /* Init */
            goTo(0);
        });
    });

})(jQuery);