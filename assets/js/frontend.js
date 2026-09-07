/**
 * Local Business Directory - Frontend AJAX Search
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

        // Previous
        $pagination.append(
            $('<button>').text('← Anterior')
                .prop('disabled', currentPageNum <= 1)
                .on('click', function () {
                    currentPage = currentPageNum - 1;
                    performSearch();
                    $('html, body').animate({ scrollTop: $('#lbd-results-grid').offset().top - 20 }, 300);
                })
        );

        // Page numbers
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

        // Next
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

})(jQuery);