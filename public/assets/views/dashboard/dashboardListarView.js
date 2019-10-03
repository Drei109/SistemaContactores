var user_id = $('#user_id').val();
var ListarView = function () {

    var _componentes = function () {

        $(document).on("click", ".btn_recargar", function () {
            refresh({
                estate: true,
                time: 0
            });
        });

        $(document).on("click", ".clean-txt", function () {
            $(this).siblings("input").val("");
        });

        var ctx = $('#myChart');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [10, 10, 10, 10],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(153, 102, 255, 1)',
                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }],

                labels: [
                    'Abrió tarde',
                    'Abrió temprano',
                    'Abrió a tiempo',
                    'Aún no abre'
                ]
            },
            options: {
                legend: {
                    display: true,
                    position: 'right',
                },
                title: {
                    display: true,
                    text: 'Estado Locales',
                    position: 'top',
                }
            }
        });
        ctx.data('graph', myDoughnutChart);



        var seguimientoCtx = $('#seguimientoChart');

        $.ajax({
            type: 'POST',
            url: '/Dashboard/SeguimientoLocales/' + user_id,
            success: function (data) {
                console.log(data.data);
                createSeguimientoCanvas(seguimientoCtx, data.data);
            }
        })
    };

    // Basic Datatable examples
    var _Listado = function () {
        if (!$().DataTable) {
            console.warn('Advertencia - datatables.min.js no esta declarado.');
            return;
        }

        //cargarDataTable();
    };

    return {
        init: function () {
            _componentes();
            _Listado();
        },
        init_Listado: function () {
            _Listado();
        },
    }
}();

document.addEventListener('DOMContentLoaded', function () {
    ListarView.init();
    update();
});

$(document).ready(function () {
    $('#collapse-navbar').click();
});

function cargarDataTable() {
    // Basic datatable
    simpleAjaxDataTable({
        uniform: true,
        ajaxUrl: "Dashboard/Listar/" + user_id,
        tableNameVariable: "registros",
        tableHeaderCheck: false,
        table: "#datatable",
        reportTitle: "Reporte de estado de locales",
        loader: false,
        tableColumns: [{
                data: "cc_id",
                title: "CC"
            },
            {
                data: "nombre",
                title: "Punto de Venta"
            },
            // {
            //     data: "MAC",
            //     title: "MAC"
            // },
            {
                data: "tipo",
                title: "Tipo"
            },
            {
                data: "fecha_encendido",
                title: "Fecha de encendido"
            },
            {
                data: "fecha_apagado",
                title: "Fecha de apagado",
                render: function (data, type, row) {
                    if (row.estado === "Encendido") {
                        return "";
                    } else {
                        return data;
                    }
                }
            },
            {
                data: "dia",
                title: "Día"
            },
            {
                data: "estado",
                title: "Estado"
            },
            {
                data: "mensaje_hora_inicio",
                title: "Mensaje de hora de inicio"
            },
            {
                data: "mensaje_hora_fin",
                title: "Mensaje de hora de fin",
                render: function (data, type, row) {
                    if (row.estado === "Encendido") {
                        return "";
                    } else {
                        return data;
                    }
                }
            },
        ],
        createdRow: function (row, data, dataIndex) {
            switch (data.mensaje_hora_inicio) {
                case "Abrió tarde":
                    $(row.cells[7]).addClass('bg-chart-red');
                    break;
                case "Abrió temprano":
                    $(row.cells[7]).addClass('bg-chart-yellow');
                    break;
                case "Abrió a tiempo":
                    $(row.cells[7]).addClass('bg-chart-green');
                    break;
                case "No Abrió":
                    $(row.cells[7]).addClass('bg-chart-blue');
                    break;
            }

            switch (data.mensaje_hora_fin) {
                case "Cerró tarde":
                    $(row.cells[8]).addClass('bg-chart-yellow');
                    break;
                case "Cerró temprano":
                    $(row.cells[8]).addClass('bg-chart-red');
                    break;
                case "Cerró a tiempo":
                    $(row.cells[8]).addClass('bg-chart-green');
                    break;
                case "No Cerró":
                    $(row.cells[8]).addClass('bg-chart-blue');
                    break;
            }
        }
    })
}

function update() {
    var chart = $('#myChart').data('graph');
    var user_id = $('#user_id').val();

    let apagado = 0;
    let encendido = 0;
    let abrioTarde = 0;
    let abrioTemprano = 0;
    let abrioATiempo = 0;
    let aunNoAbre = 0;

    $.ajax({
        type: 'POST',
        url: '/Dashboard/Listar/' + user_id,
        success: function (data) {

            $.each(data.data, function (k, item) {
                switch (item.estado) {
                    case 'Apagado':
                        apagado++;
                        break;
                    case 'Encendido':
                        encendido++;
                }
                switch (item.mensaje_hora_inicio) {
                    case 'Abrió tarde':
                        abrioTarde++;
                        break;
                    case 'Abrió temprano':
                        abrioTemprano++;
                        break;
                    case 'Aún no abre':
                        aunNoAbre++;
                        break;
                    case 'No Abrió':
                        aunNoAbre++;
                        break;
                    case 'Abrió a tiempo':
                        abrioATiempo++;
                        break;
                }
            });

            $("#apagados").html(apagado);
            $("#encendidos").html(encendido);

            chart.data.datasets[0].data[0] = abrioTarde;
            chart.data.datasets[0].data[1] = abrioTemprano;
            chart.data.datasets[0].data[2] = abrioATiempo;
            chart.data.datasets[0].data[3] = aunNoAbre;
            chart.update();

            cargarDataTable();
            //var table = $('#datatable').DataTable();
            //table.ajax.reload();

            window.setTimeout(update, 30000); //milliseconds
        },
        error: function (XMLHttpRequest, textStatus, errorThrown) {
            window.setTimeout(update, 10000);
        }
    })
};

function epoch_to_hh_mm_ss(epoch) {
    let timestamp = moment.unix(epoch);
    return timestamp.format("HH:mm:ss");
    return new Date(epoch * 1000).toISOString().substr(12, 7)
}

function createSeguimientoCanvas(ctx, data) {
    let dataset = [];
    for (let i = 0; i < data.length; i++) {
        let obj = {
            label: data[i].nombre,
            fill: false,
            data: data[i].data
        };
        dataset.push(obj);
    }

    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['', '', '', ''],
            datasets: dataset
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                yAxes: [{
                    ticks: {
                        userCallback: function (v) {
                            return epoch_to_hh_mm_ss(v)
                        },
                        stepSize: 60 * 60
                    }
                }]
            },
            tooltips: {
                callbacks: {
                    label: function (tooltipItem, data) {
                        return data.datasets[tooltipItem.datasetIndex].label + ': ' + epoch_to_hh_mm_ss(tooltipItem.yLabel)
                    }
                }
            }
        }
    });

}
