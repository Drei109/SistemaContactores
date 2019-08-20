var ListarView = function() {

    var _componentes = function() {
        $(document).on("click", ".btn_recargar", function() {
            $.ajax({
                type: 'POST',
                url: basePath + '/PuntoVentas/Sincronizar',
                data: {
                    '_token': $('input[name=_token]').val(),
                },
                success: function (response) {
                    var respuesta = response.respuesta;
                    if (respuesta === true) {
                        toastr.success("Se Sincronizo Correctamente", "Mensaje Servidor");
                        _Listado();
                    } else {
                        toastr.error(response.mensaje, "Mensaje Servidor");
                    }
                }
            });
        });

        $(document).on("click", ".btn_editar", function() {
            var id = $(this).data("id");
            redirect({site:"Salas/Editar/" + id, time:0});
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
            ajaxUrl: "PuntoVentas/Listar",
            tableNameVariable: "salas",
            tableHeaderCheck:true,
            table: ".datatable",
            tableColumns: [
                {
                    data: "id",
                    title: "ID",
                },
                {
                    data: "cc_id",
                    title: "CC_ID",
                },
                {
                    data: "nombre",
                    title: "Nombre"
                },
                {
                    data: "razonSocial",
                    title: "Empresa"
                },
                {
                    data: "Ubigeo",
                    title: "Ubigeo"
                },
                {
                    data: 'id',
                    title: "Acciones",
                    width: 100,
                    className: 'text-center',
                    "bSortable": false,
                    "render": function(value, type, oData, meta) {
                        var botones = '<div class="list-icons">' +
                            '<div class="dropdown">' +
                            '<a href="#" class="list-icons-item" data-toggle="dropdown">' +
                            '<i class="icon-menu9"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            '<a href="#" class="dropdown-item btn_editar" data-id="' + value + '"><i class="icon-hammer"></i> Editar</a>' +
                            // '<a href="#" class="dropdown-item btn_estado" data-id="' + value + '" data-estado="' + oData.estado + '"><i class="icon-circles"></i> Cambiar Estado</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        return botones;
                    }
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