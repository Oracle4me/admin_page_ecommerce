// Global language config
window.dataTableLang = {
    paginate: {
        previous: "<i class='mdi mdi-chevron-left'></i>",
        next: "<i class='mdi mdi-chevron-right'></i>"
    },
    processing: "Loading...",
    search: "Cari:",
    lengthMenu: "Tampilkan _MENU_ data",
    info: "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
    infoEmpty: "Tidak ada data",
    zeroRecords: "Data tidak ditemukan",
};

// Data table reusble initialization
window.initDataTable = (selector, options = {}) => {
    if (!$(selector).length) return;

    const defaultOptions = {
        processing: true,
        serverSide: false,
        language: window.dataTableLang,
        drawCallback: function () {
            $('.dataTables_paginate > .pagination').addClass('pagination-rounded');
        },
        autoWidth: true,
        // columnDefs: [{
        //                 width: '10%',
        //                 targets: 0
        //             }, 
        //             {
        //                 width: '30%',
        //                 targets: 1
        //             }, 
        //             {
        //                 width: '40%',
        //                 targets: 2
        //             }, 
        //             {
        //                 width: '20%',
        //                 targets: 3
        //             } 
        //         ]
    };

    return $(selector).DataTable({
        ...defaultOptions,
        ...options
    });
};

$(document).ready(function () {
    // initDataTable('#dataTable');
    initDataTable('#datatable-buttons', {
        lengthChange: false,
        buttons: ['copy', 'print', 'pdf']
    })?.buttons()
        .container()
        .appendTo('#datatable-buttons_wrapper .col-md-6:eq(0)');

    initDataTable('#selection-datatable', {
        select: { style: 'multi' }
    });

    initDataTable('#key-datatable', {
        keys: true
    });

    initDataTable('#complex-header-datatable', {
        columnDefs: [{ visible: false, targets: -1 }]
    });

    initDataTable('#state-saving-datatable', {
        stateSave: true
    });
});
