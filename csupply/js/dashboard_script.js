$(document).ready(function () {


    // useed to alow tooltips
    $(function () {
        $("[rel='tooltip']").tooltip();
    });

    //gets Month and Year for Monthly PO Value card
    $(function () {
        var today = new Date();
        var m = today.toLocaleString('default', { month: 'short' })
        var date = m + '-' + today.getFullYear();
        $("#curdate").html(date);
    });

    //gets Year for YTD PO Value card
    $(function () {
        var today = new Date();

        var date = today.getFullYear();
        $("#curyear").html(date);
    });

    //gets total Monthly PO Value card
    function monthlyPoValue() {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'montlyPoVal'

            }, success: function (responce) {

                $("#mPoVal").html(responce);
            }
        });
    }



    //Gets stockouts
    function stockouts() {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'stockouts'

            }, success: function (responce) {

                $('#stockOuts').html(responce);
            }
        });
    }

    //Gets overtock
    function overstocked() {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'overstocked'

            }, success: function (responce) {

                $('#overStocked').html(responce);
            }
        });
    }



    //gets YTD PO Value card
    function ytdPoVal() {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'YTDPO'

            }, success: function (responce) {

                $("#ytdPoVal").html(responce);
            }
        });
    }

    ytdPoVal();



    //make the chart for monthly po value
    function getcharts() {


        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'json',
            data: {
                key: 'anualPoVal'

            }, success: function (responce) {
               
                const data1 = responce.poValue;
              
                const labels = responce.month;


                var today = new Date();
                var cyear = today.getFullYear();
                const ctx = document.getElementById('monthlypovalchart').getContext('2d');
                const monthlypovalchart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: cyear,
                            data: data1,

                            backgroundColor: [
                                
                                '#0d6efd', '#000807', '#FFC107', '#4cb944', '#f06543'

                            ],
                            borderColor: [
                                '#0d6efd', '#000807', '#FFC107', '#4cb944', '#f06543'
                            ],
                            borderWidth: 1
                        }],


                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } //end get charts
        }
        )
    }; 
    //make the chart for last years monthly po value
    function getchartsPY() {


        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'json',
            data: {
                key: 'anualPoValPY'

            }, success: function (responce) {

                const data1 = responce.poValuePY;

                const labels = responce.monthPY;


                var today = new Date();
                var cyear = today.getFullYear();
                const ctx = document.getElementById('lastyearpovalchart').getContext('2d');
                const lastyearpovalchart = new Chart(ctx, {
                    type: 'line',
                    data: {
                        labels: labels,
                        datasets: [{
                            label: cyear-1,
                            data: data1,

                            backgroundColor: [
                                '#960200', '#241e4e', '#ce6c47', '#ffd046', '#eadaa2'
                            ],
                            borderColor: [
                                '#960200', '#241e4e', '#ce6c47', '#ffd046', '#eadaa2'
                                
                            ],
                            borderWidth: 1
                        }],


                    },
                    options: {
                        scales: {
                            y: {
                                beginAtZero: true
                            }
                        }
                    }
                });
            } //end get charts
        }
        )
    }; 

    function getOverStocked(start, limit) {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'overstockedList',
                start: start,
                limit: limit
            }, success: function (responce) {
                if (responce != "reachedMax") {
                    $('#overstockTableBody').append(responce);
                    start += limit;
                    getOverStocked(start, limit);
                } else
                    $('#overstockedTable').DataTable({

                        responsive: true,
                        dom: 'lfrtip',
                        
                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                        
                    });
            }
        });
    }

    function getStockouts(start, limit) {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'stockoutList',
                start: start,
                limit: limit
            }, success: function (responce) {
                if (responce != "reachedMax") {
                    $('#stockoutTableBody').append(responce);
                    start += limit;
                    getStockouts(start, limit);
                } else
                    $("#stockoutTable").DataTable({

                        responsive: true,
                        dom: 'lfrtip',

                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                    });
            }
        });
    }  

    function getcurntMonthPoValuestList(start, limit) {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'curntMonthPoValuestList',
                start: start,
                limit: limit
            }, success: function (responce) {
                if (responce != "reachedMax") {
                    $('#curntMonthPoValuestListTableBody').append(responce);
                    start += limit;
                    getcurntMonthPoValuestList(start, limit);
                } else
                    $("#curntMonthPoValuestListTable").DataTable({

                        responsive: true,
                        dom: 'lfrtip',

                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                    });
            }
        });
    }  

    function getYTDPoValuestList(start, limit) {
        $.ajax({
            url: '../php/ajax_dashboard.php',
            method: 'POST',
            dataType: 'text',
            data: {
                key: 'YTDPoValuestList',
                start: start,
                limit: limit
            }, success: function (responce) {
                if (responce != "reachedMax") {
                    $('#YTDPoValuestListTableBody').append(responce);
                    start += limit;
                    getYTDPoValuestList(start, limit);
                } else
                    $("#YTDPoValuestListTable").DataTable({

                        responsive: true,
                        dom: 'lfrtip',

                        "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],

                    });
            }
        });
    }  

    getchartsPY()
    getcharts();
    monthlyPoValue();
    stockouts();
    overstocked();
    getOverStocked(0, 1000);
    getStockouts(0, 1000);
    getcurntMonthPoValuestList(0, 1000);
    getYTDPoValuestList(0, 1000);


}) //End of doc ready

function showOverstockTable() {
    $('#YTDMonthPoValuestList').prop("hidden", !this.checked);
    $('#showHideStockout').prop("hidden", !this.checked);
    $('#showHidecurntMonthPoValuestList').prop("hidden", !this.checked);
    $('#showHideOverstock').removeAttr('hidden');
    
}

function showStockoutTable() {
    $('#YTDMonthPoValuestList').prop("hidden", !this.checked);
    
    $('#showHidecurntMonthPoValuestList').prop("hidden", !this.checked);
    $('#showHideOverstock').prop("hidden", !this.checked);
    $('#showHideStockout').removeAttr('hidden');

}

function showgetcurntMonthPoValuestList() {
    $('#YTDMonthPoValuestList').prop("hidden", !this.checked);
  
    $('#showHideStockout').prop("hidden", !this.checked);
    $('#showHideOverstock').prop("hidden", !this.checked);
    $('#showHidecurntMonthPoValuestList').removeAttr('hidden');
}

function showYTDPoValuestList() {
    $('#YTDMonthPoValuestList').removeAttr('hidden');
    $('#showHidecurntMonthPoValuestList').prop("hidden", !this.checked);
    $('#showHideStockout').prop("hidden", !this.checked);
    $('#showHideOverstock').prop("hidden", !this.checked);
}
