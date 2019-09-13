var ListarView = function() {

    var _componentes = function() {
        $(document).on("click", ".btn_recargar", function() {
            $.ajax({
                type: 'POST',
                url: basePath + '/PuntoVentas/Sincronizar',
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                beforeSend: function () {
                    block_general("body");
                },
                complete: function () {
                    unblock("body");
                },
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta === true) {
                        //toastr.success("Se Sincronizo Correctamente", "Mensaje Servidor");
                        _Listado();
                    } else {
                        //toastr.error(response.mensaje, "Mensaje Servidor");
                        _Listado();
                    }
                }
            });
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
            ajaxUrl: "/Turno/Listar",
            tableNameVariable: "turnos",
            tableHeaderCheck:false,
            table: ".datatable",
            reportTitle: "Listado de Turnos",
            tableColumns: [
                {
                    data: "idlocal",
                    title: "CC"
                },
                {
                    data: "nombre",
                    title: "Punto de Venta"
                },
                {
                    data: "horainicio",
                    title: "Hora Incio"
                },
                {
                    data: "horafin",
                    title: "Hora Fin"
                },
                {
                    data: "diasemana",
                    title: "Día"
                },                    
                {
                    data: "tipo",
                    title: "Tipo"
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
    };
}();

document.addEventListener('DOMContentLoaded', function() {
    ListarView.init();
});