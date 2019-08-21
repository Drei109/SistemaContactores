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
            simpleAjaxDataTable({
                uniform: true,
                ajaxUrl: "Destinatarios/" + id + "/SalasNoAsignadas",
                tableNameVariable: "destinatarios",
                tablePaging: false,
                tableHeaderCheck:true,
                table: ".datatable-salas",
                tableColumns: [
                    {
                    data: "tiene",
                    title: "",
                    "bSortable": false,
                    "render": function(value) {
                        var check = '<input type="checkbox" class="form-check-input-styled-info chk_id datatable_salas_chk" data-destinatario-id="' + id + '" name="" value="'+ value +'">';
                        if(value === 1){
                            check = '<input type="checkbox" class="form-check-input-styled-info chk_id  datatable_salas_chk" data-destinatario-id="' + id + '" name="" checked value="'+ value +'">';
                        }
                        return check;
                        }
                    },
                    {
                        data: "id",
                        title: "ID",
                        className: "s_id"
                    },
                    {
                        data: "cc_id",
                        title: "CC_ID"
                    },
                    {
                        data: "nombre",
                        title: "Nombre"
                    },
                    {
                        data: "ubigeo",
                        title: "Ubigeo"
                    }
                ]
            })
            // $(".modal-content").append('<div class="modal-footer pt-3"><button type="button" class="btn btn-link" data-dismiss="modal">Cerrar</button><button type="button" class="btn bg-primary btn_guardar_salas">Guardar Cambios</button></div>');
        });

        $(document).on("click", ".btn_guardar_salas", function() {
            var id = $(".datatable-salas>tbody>tr:first>td:first>div>span>input").data("destinatario-id");
            var data_salas = {};
            data_salas["id"] = id;
            var selected = [];

            $('.datatable_salas_chk:checked').each(function() {
                selected.push($(this).parents('tr').find('.s_id').html());
            });

            data_salas["salas_id"] = selected;
            
            if(data_salas != null){
                responseSimple({
                    url: "Destinatarios/"+ id + "/ReasignarSalas",
                    refresh: false,
                    data: JSON.stringify(data_salas),
                    callBackSuccess: function(response) {
                        //console.info(response);
                        $('#cerrar_modal').click();
                        // ListarView.init_Listado();
                    }
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
                    title: "ID"                    
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
                            '<button type="button" class="dropdown-item btn border-transparent btn_ver_salas" data-toggle="modal" data-target="#modal_scrollable" data-id="' + value + '"><i class="icon-store2"></i> Locales </button>' +
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