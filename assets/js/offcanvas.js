const $ = require('jquery');

$(function () {
    'use strict'

    $('[data-toggle="offcanvas"]').on('click', function () {
        $('.offcanvas-collapse').toggleClass('open')
    });

    $('.pagination a').on('click', function (event) {
        event.preventDefault();

        const $pageNumber = $('#request_search_page');
        const $button = $(event.target).closest('a');
        let page = parseInt($pageNumber.val());

        if ($button.hasClass('previous-page-button')) {
            page -= 1;
        } else {
            page += 1;
        }

        $pageNumber.val(page);
        $pageNumber.closest('form').submit();
    })

})