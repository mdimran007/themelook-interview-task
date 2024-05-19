(function ($) {
    "use strict";
    $("#orderListTable").DataTable({
        pageLength: 10,
        ordering: false,
        serverSide: true,
        processing: true,
        responsive: true,
        searching: false,
        paging: true,
        language: {
            paginate: {
                previous: "Previous",
                next: "Next",
            },
            searchPlaceholder: "Search event",
            search: "<span class='searchIcon'><i class='fa-solid fa-magnifying-glass'></i></span>",
        },
        ajax: $("#order-list-route").val(),
        dom: '<>tr<"tableBottom"<"row align-items-center"<"col-sm-6"<"tableInfo"i>><"col-sm-6"<"tablePagi"p>>>><"clear">',
        columns: [
            {"data": 'DT_RowIndex', "name": 'DT_RowIndex', searchable: false},
            {"data": "order_id", "name": "orders.order_id"},
            {"data": "customer_name", "name": "orders.customer_name"},
            {"data": "total", "name": "orders.total"},
            {"data": "status", "name": "status"},
            {"data": "created_at", "name": "created_at"},
            {"data": "action"}
        ]

    });
})(jQuery)
