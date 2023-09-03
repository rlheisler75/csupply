$(document).ready(function () {

    $(function () {
        $("[rel='tooltip']").tooltip();
    });


    getExistingData(0, 1000);
});



function getExistingData(start, limit) {
    $.ajax({
        url: '../php/ajax_reports.php',
        method: 'POST',
        dataType: 'text',
        data: {
            key: 'getExistingData',
            start: start,
            limit: limit
        }, success: function (responce) {
            if (responce != "reachedMax") {
                $('tbody').append(responce);
                start += limit;
                getExistingData(start, limit);
            } else
                $(".table").DataTable({

                    responsive: true,
                    dom: 'lfBrtip',
                    buttons: [{
                        extend: 'copy',
                        exportOptions: {

                            columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9]
                            //specify which column you want to print

                        }
                    }, {
                        extend: 'csv',
                        exportOptions: {

                            columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9]
                            //specify which column you want to print

                        }
                    },
                    {
                        extend: 'excel',
                        exportOptions: {

                            columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9]
                            //specify which column you want to print

                        }
                    }, {
                        extend: 'pdf',
                        exportOptions: {

                            columns: [0,1, 2, 3, 4, 5, 6, 7, 8, 9]
                            //specify which column you want to print

                        }
                    }, {
                        extend: 'print',
                        exportOptions: {
                            stripHtml: false,
                            columns: [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]
                            //specify which column you want to print

                        }
                    }],
                    "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                    "columnDefs": [{
                        "targets": 'no-sort',
                        "orderable": false,
                    }]
                });
        }
    });
}








