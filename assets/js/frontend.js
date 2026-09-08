/**
 * Local Business Directory - Frontend AJAX Search + Gallery Carousel + Lightbox
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

    /* ===== Gallery Carousel (Infinite Loop) ===== */
    $(document).ready(function () {
        $('.lbd-gallery-carousel').each(function () {
            var $carousel = $(this);
            var $track = $carousel.find('.lbd-gallery-track');
            var $dotsContainer = $carousel.find('.lbd-gallery-dots');
            var $origItems = $carousel.find('.lbd-gallery-item:not(.lbd-clone)');
            var realCount = $origItems.length;
            if (realCount === 0) return;

            var realImages = [];
            $origItems.each(function (i) {
                $(this).attr('data-real-index', i);
                realImages.push($(this).find('img').attr('src'));
            });

            var CLONE_COUNT = 2;
            for (var c = 0; c < CLONE_COUNT; c++) {
                $origItems.last().clone().removeClass('active').addClass('lbd-clone').attr('data-real-index', $origItems.last().index()).prependTo($track);
                $origItems.first().clone().removeClass('active').addClass('lbd-clone').attr('data-real-index', 0).appendTo($track);
            }

            var $allItems = $track.children();
            var total = $allItems.length;
            var currentReal = 0;
            var wrapperIndex = CLONE_COUNT;

            function rebuildDots() {
                $dotsContainer.empty();
                for (var d = 0; d < realCount; d++) {
                    var $dot = $('<span class="lbd-gallery-dot"></span>').attr('data-index', d);
                    if (d === currentReal) $dot.addClass('active');
                    $dotsContainer.append($dot);
                }
            }
            rebuildDots();

            function goTo(realIndex, animate) {
                if (animate === undefined) animate = true;
                currentReal = realIndex;
                wrapperIndex = currentReal + CLONE_COUNT;

                var itemW = $allItems.first().outerWidth(true);
                var gap = parseInt($track.css('gap')) || 20;
                var trackW = $carousel.width();
                var px = (trackW - itemW) / 2 - (wrapperIndex * (itemW + gap));

                if (!animate) $track.css('transition', 'none');
                $track.css('transform', 'translateX(' + px + 'px)');
                if (!animate) $track[0].offsetHeight;

                $allItems.removeClass('active');
                $allItems.eq(wrapperIndex).addClass('active');

                $dotsContainer.find('.lbd-gallery-dot').removeClass('active');
                $dotsContainer.find('.lbd-gallery-dot').eq(currentReal).addClass('active');
            }

            $track.on('transitionend', function () {
                if (currentReal < 0) {
                    $track.css('transition', 'none');
                    currentReal = realCount - 1;
                    wrapperIndex = currentReal + CLONE_COUNT;
                    goTo(currentReal, false);
                } else if (currentReal >= realCount) {
                    $track.css('transition', 'none');
                    currentReal = 0;
                    wrapperIndex = currentReal + CLONE_COUNT;
                    goTo(currentReal, false);
                }
            });

            $carousel.on('click', '.lbd-gallery-next', function (e) {
                e.stopPropagation();
                goTo(currentReal + 1);
            });

            $carousel.on('click', '.lbd-gallery-prev', function (e) {
                e.stopPropagation();
                goTo(currentReal - 1);
            });

            $carousel.on('click', '.lbd-gallery-dot', function (e) {
                e.stopPropagation();
                goTo(parseInt($(this).data('index')));
            });

            var didDrag = false;

            $track.on('click', '.lbd-gallery-item', function (e) {
                if (didDrag) return;
                e.stopPropagation();
                var realIdx = parseInt($(this).data('real-index'));
                if (isNaN(realIdx)) return;
                openLightbox(realIdx, realImages);
            });

            /* Touch */
            var touchStartX = 0, touchDeltaX = 0, isTouching = false;

            $track.on('touchstart', function (e) {
                touchStartX = e.originalEvent.touches[0].clientX;
                touchDeltaX = 0;
                isTouching = true;
                didDrag = false;
                $track.css('transition', 'none');
            });

            $track.on('touchmove', function (e) {
                if (!isTouching) return;
                touchDeltaX = e.originalEvent.touches[0].clientX - touchStartX;
                if (Math.abs(touchDeltaX) > 5) didDrag = true;
                var itemW = $allItems.first().outerWidth(true);
                var gap = parseInt($track.css('gap')) || 20;
                var trackW = $carousel.width();
                var basePx = (trackW - itemW) / 2 - (wrapperIndex * (itemW + gap));
                $track.css('transform', 'translateX(' + (basePx + touchDeltaX) + 'px)');
            });

            $track.on('touchend', function () {
                if (!isTouching) return;
                isTouching = false;
                $track.css('transition', '');
                if (touchDeltaX < -50) goTo(currentReal + 1);
                else if (touchDeltaX > 50) goTo(currentReal - 1);
                else goTo(currentReal);
            });

            /* Mouse drag */
            var mouseStartX = 0, mouseDeltaX = 0, isMouseDragging = false;

            $track.on('mousedown', function (e) {
                mouseStartX = e.clientX;
                mouseDeltaX = 0;
                isMouseDragging = true;
                didDrag = false;
                $track.css('transition', 'none');
                e.preventDefault();
            });

            $(document).on('mousemove.lbdCarousel', function (e) {
                if (!isMouseDragging) return;
                mouseDeltaX = e.clientX - mouseStartX;
                if (Math.abs(mouseDeltaX) > 5) didDrag = true;
                var itemW = $allItems.first().outerWidth(true);
                var gap = parseInt($track.css('gap')) || 20;
                var trackW = $carousel.width();
                var basePx = (trackW - itemW) / 2 - (wrapperIndex * (itemW + gap));
                $track.css('transform', 'translateX(' + (basePx + mouseDeltaX) + 'px)');
            });

            $(document).on('mouseup.lbdCarousel', function () {
                if (!isMouseDragging) return;
                isMouseDragging = false;
                $track.css('transition', '');
                if (mouseDeltaX < -50) goTo(currentReal + 1);
                else if (mouseDeltaX > 50) goTo(currentReal - 1);
                else goTo(currentReal);
            });

            goTo(0);
        });

        /* ===== Lightbox ===== */
        function openLightbox(index, images) {
            if (!images || images.length === 0) return;
            var lbIndex = index;

            var $lb = $(
                '<div class="lbd-lightbox">' +
                    '<button class="lbd-lb-close">&times;</button>' +
                    '<button class="lbd-lb-prev">&#8249;</button>' +
                    '<button class="lbd-lb-next">&#8250;</button>' +
                    '<div class="lbd-lb-img-wrap"><img class="lbd-lb-img" src="" alt=""></div>' +
                    '<div class="lbd-lb-counter"></div>' +
                '</div>'
            );
            $('body').append($lb).css('overflow', 'hidden');

            function showImg(i) {
                lbIndex = i;
                $lb.find('.lbd-lb-img').attr('src', images[lbIndex]);
                $lb.find('.lbd-lb-counter').text((lbIndex + 1) + ' / ' + images.length);
            }
            showImg(lbIndex);

            function closeLB() {
                $lb.remove();
                $('body').css('overflow', '');
                $(document).off('keydown.lbdLB');
            }

            $lb.on('click', '.lbd-lb-close', closeLB);
            $lb.on('click', '.lbd-lb-prev', function () { showImg(lbIndex > 0 ? lbIndex - 1 : images.length - 1); });
            $lb.on('click', '.lbd-lb-next', function () { showImg(lbIndex < images.length - 1 ? lbIndex + 1 : 0); });
            $lb.on('click', function (e) { if (e.target === this) closeLB(); });

            $(document).on('keydown.lbdLB', function (e) {
                if (e.key === 'Escape') closeLB();
                if (e.key === 'ArrowLeft') showImg(lbIndex > 0 ? lbIndex - 1 : images.length - 1);
                if (e.key === 'ArrowRight') showImg(lbIndex < images.length - 1 ? lbIndex + 1 : 0);
            });
        }
    });

})(jQuery);
