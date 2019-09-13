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

    };

    return {
        init: function() {
            _componentes();
            _Listado();
        },
        init_Listado: function() {
            _Listado();
        },
    }
}();

document.addEventListener('DOMContentLoaded', function() {
    ListarView.init();
    $('#collapse-navbar').click();
});