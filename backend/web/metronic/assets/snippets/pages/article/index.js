"use strict";
var ArticleIndexDataTable = function() {

    var table;

    var dataTable;

    var filters;

    var initAction = function () {
        $('#ArticleTableReset').on('click', function () {
            for (var i in filters) {
                filters[i].element.val('');
            }

            dataTable.clear()
                .state.clear();

            window.location.reload();
        });
    }

    var initFilters = function () {
        filters = {
            Title: {
                element: $('#ArticleFilterTitle').on('change', function () {
                    dataTable.draw();
                })
            }
        };
    }

    var getFiltersAjax = function () {
        var dataColumns = [], i, val;

        for (i in filters) {
            val = filters[i].element.val();
            if (val !== undefined && val !== null && val !== '') {
                dataColumns.push({
                    data: i,
                    search: {value: val, and: true}
                });
            }
        }

        return dataColumns.length === 0 ? {} : {columns: dataColumns};
    }

    var getFilters = function () {
        var dataFilters = {}, i, val;

        for (i in filters) {
            val = filters[i].element.val();
            if (val !== undefined && val !== null && val !== '') {
                dataFilters[i] = val;
            }
        }

        return Object.keys(dataFilters).length === 0 ? {} : {filters: dataFilters};
    }

    var setFilters = function (data) {
        if (data !== null && data.filters !== undefined) {
            for (var i in filters) {
                if (data.filters.hasOwnProperty(i)) {
                    filters[i].element.val(data.filters[i]);
                }
            }
        }
    }

    var initTable = function() {
        table = $('#ArticleIndexTable');

        dataTable = table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            stateSave: true,
            stateSaveCallback: function(settings, data) {
                localStorage.setItem('DataTables_' + settings.sInstance, JSON.stringify($.extend({}, data, getFilters())))
            },
            stateLoadCallback: function(settings) {
                var data = JSON.parse(localStorage.getItem('DataTables_' + settings.sInstance));
                setFilters(data);
                return data;
            },
            ajax: {
                url: '/article/list',
                data: function (data) {
                    return $.extend({}, data, getFiltersAjax());
                },
            },
            columns: [
                {data: 'Id'},
                {data: 'Title'},
                {data: 'Slug'},
                {data: 'CreatedAt'},
                {data: 'UpdatedAt'},
                {data: 'Actions'},
            ],
            columnDefs: [
                {
                    targets: -1,
                    orderable: false,
                    render: function(data, type, full, meta) {
                        return `
                            <a href="/article/update?id=` + full.Id + `" class="m-portlet__nav-link btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" title="Редагувати">
                              <i class="la la-edit"></i>
                            </a>
                            <span class="dropdown">
                                <a href="#" class="btn m-btn m-btn--hover-brand m-btn--icon m-btn--icon-only m-btn--pill" data-toggle="dropdown" aria-expanded="true">
                                  <i class="la la-ellipsis-h"></i>
                                </a>
                                <div class="dropdown-menu dropdown-menu-right">
                                    <a class="dropdown-item" href="/article/update?id=` + full.Id + `"><i class="la la-edit"></i> Редагувати</a>
                                    <a class="dropdown-item" data-method="post" data-confirm="Вы уверены что хотите удалить эту новость?" href="/article/delete?id=` + full.Id + `"><i class="la la-user-times"></i> Видалити</a>
                                </div>
                            </span>`;
                    },
                    className: 'text-right',
                },
            ],
        });
    };

    return {
        init: function() {
            initFilters();
            initTable();
            initAction();
        },
    };

}();

jQuery(document).ready(function() {
    ArticleIndexDataTable.init();
});