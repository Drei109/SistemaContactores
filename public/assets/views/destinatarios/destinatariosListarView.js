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

        $(document).on("click", ".btn_editar", function() {
            var id = $(this).data("id");
            redirect({site:"Destinatarios/Editar/" + id, time:0});
        });

        $(document).on("click", ".btn_ver_salas", function() {
            var id = $(this).data("id");
            redirect({site:"Destinatarios/"+ id+ "/Salas", time:0});
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
            ajaxUrl: "Destinatarios/Listar",
            tableNameVariable: "destinatarios",
            tableHeaderCheck:true,
            table: ".datatable",
            tableColumns: [
                {
                data: "id",
                title: "",
                "bSortable": false,
                "render": function(value) {
                    var check = '<input type="checkbox" class="form-check-input-styled-info chk_id datatable_chk" value="' + value + '" name="">';
                    return check;
                    }
                },
                {
                    data: "id",
                    title: "ID",
                },
                {
                    data: "nombre",
                    title: "Nombre"
                },
                {
                    data: "correo",
                    title: "Correo"
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
                            '<a href="#" class="dropdown-item btn_ver_salas" data-id="' + value + '"><i class="icon-store2"></i> Salas</a>' +
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