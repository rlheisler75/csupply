$(document).ready(function () {

    $(function () {
        $("[rel='tooltip']").tooltip();
    });

    $(function () {
        $('#sdatepicker').datepicker();
    });

    $(function () {
        $('#edatepicker').datepicker();
    });
    
   
});

function checktable(start, limit) {
    var start = start;
    var limit = limit;

    if ($.fn.dataTable.isDataTable('#transactionsTable')) {
        table = $('#transactionsTable').DataTable();
        table.clear().destroy();
         getExistingData(start, limit)
    }
    else {
        getExistingData(start, limit)
}

    function getExistingData(start, limit) {
        var sdate = $("#sdate");
        var edate = $("#edate");

        if (isNotEmpty(sdate) && isNotEmpty(edate)) {


            $.ajax({
                url: '../php/ajax_summary_transfer_transactions',
                method: 'POST',
                dataType: 'text',
                data: {
                    key: 'getExistingData',
                    start: start,
                    limit: limit,
                    sdate: sdate.val(),
                    edate: edate.val()
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

                                    columns: [0, 1, 2]
                                    //specify which column you want to print

                                }
                            }, {
                                extend: 'csv',
                                exportOptions: {

                                    columns: [0, 1, 2]
                                    //specify which column you want to print

                                }
                            },
                            {
                                extend: 'excel',
                                exportOptions: {

                                    columns: [0, 1, 2]
                                    //specify which column you want to print

                                }
                            }, {
                                extend: 'pdf',
                                messageTop: 'Report for ' + sdate.val() + ' to ' + edate.val() + '!',
                                exportOptions: {

                                    columns: [0, 1, 2]
                                    //specify which column you want to print

                                }
                            }, {
                                extend: 'print',
                                messageTop: 'Report for '+sdate.val()+' to '+edate.val()+'!',
                                exportOptions: {
                                    stripHtml: false,
                                    columns: [0, 1, 2]
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
    }

}

// Valadation of form fields
function isNotEmpty(caller) {
    if (caller.val() == '') {
        caller.css('border', '2px solid red');
        return false;
    } else
        caller.css('border', '');
    return true;
}
function isNotSelected(caller) {
    if (caller.val() == null) {
        caller.css('border', '2px solid red');
        return false;
    } else
        caller.css('border', '');
    return true;
}








