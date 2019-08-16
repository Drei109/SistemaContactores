var ListarView = function() {

    var _componentes = function() {
        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true, time:0});
        });

        $(document).on("click", ".btn_nuevo", function() {
            redirect({site:"Destinatarios/Nuevo", time:0});
        });

        $(document).on("click", ".btn_eliminar", function() {
            var id = $(".datatable_chk:checked").length;
            var selected = [];

            if (id > 0) {
                $('.datatable_chk:checked').each(function() {
                    selected.push($(this).attr('value'));
                });
                responseSimple({
                    url: "Destinatarios/Eliminar",
                    refresh: false,
                    data: JSON.stringify(selected),
                    callBackSuccess: function(response) {
                        console.info(response);
                        ListarView.init_Listado();
                    }
                });
            }
            else{
                 messageResponse({
                        message: "No hay Registros Seleccionados",
                        type: "warning"
                    });
            }
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
            fullUrl: "http://localhost:90/apiRegistro/registro/read.php",
            tableNameVariable: "destinatarios",
            tableHeaderCheck:true,
            table: ".datatable",
            tableColumns: [
                {
                    data: "local_id",
                    title: "Local"                    
                },
                {
                    data: "tipo",
                    title: "Estado"
                },
                {
                    data: "fecha_encendido",
                    title: "Fecha de encendido"
                },
                {
                    data: "fecha_apagado",
                    title: "Fecha de apagado"
                }                
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
});