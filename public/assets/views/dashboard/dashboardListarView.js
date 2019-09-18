
var ListarView = function() {
   
    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true, time:0});
        });

        $(document).on("click", ".clean-txt", function() {
            $(this).siblings("input").val("");
        });
        
    };

    // Basic Datatable examples
    var _Listado = function() {
        if (!$().DataTable) {
            console.warn('Advertencia - datatables.min.js no esta declarado.');
            return;
        }

        // Basic datatable
        simpleAjaxDataTable({
            uniform: true,
            ajaxUrl: "Dashboard/Listar",
            tableNameVariable: "registros",
            tableHeaderCheck:false,
            table: ".datatable",
            reportTitle: "Reporte de estado de locales",
            tableColumns: [
                {
                    data: "cc_id",
                    title: "CC"                    
                },
                {
                    data: "nombre",
                    title: "Punto de Venta"
                },
                {
                    data: "MAC",
                    title: "MAC"
                },
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
                    title: "Fecha de apagado"
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
                    title: "Mensaje de hora de fin"
                },             
            ]
        })

        var ctx = $('#myChart');
        var myDoughnutChart = new Chart(ctx, {
            type: 'doughnut',
            data: {
                datasets: [{
                    data: [10, 10, 10, 10],
                    backgroundColor: [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                        'rgba(255, 159, 64, 0.2)'
                    ],
                    borderColor: [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
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
                    position:'right',
                },
                title: {
                    display: true,
                    text: 'Estado Locales',
                    position:'top',
                }
            }
        });
        ctx.data('graph', myDoughnutChart);
    };

    return {
        init: function() {
            _componentes();
            _Listado();
            $('#collapse-navbar').click();
        },
        init_Listado: function() {
            _Listado();
            $('#collapse-navbar').click();
        },
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    ListarView.init();
    update();
});

function update() {
    var table = $("datatable").DataTable();
    var chart = $('#myChart').data('graph');

    let apagado = 0;
    let encendido = 0;
    let abrioTarde = 0;
    let abrioTemprano = 0;
    let abrioATiempo = 0;
    let aunNoAbre = 0;

    $.ajax({
      type: 'POST',
      url: '/Dashboard/Listar',
      success: function(data) {
             
        $.each(data.data, function(k,item) {
            switch(item.estado){
                case 'Apagado':
                    apagado++;
                    break;
                case 'Encendido':
                    encendido++;
            }    
            switch(item.mensaje_hora_inicio){
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


        table.ajax.reload();
        window.setTimeout(update, 60000); //milliseconds
      },
      error: function (XMLHttpRequest, textStatus, errorThrown) {                
        window.setTimeout(update, 10000);
      }
  })};