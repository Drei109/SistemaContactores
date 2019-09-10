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

        $(document).on("click", ".btn_editar", function() {
            var id = $(this).data("id");
            redirect({site:"PuntoVentas/Editar/" + id, time:0});
        });

        $(document).on("click", ".btn_editar_macs", function() {
            var id = $(this).data("id");
            $('#cc_id').val(id);

            simpleAjaxDataTable({
                uniform: true,
                ajaxUrl: "PuntoVentas/" + id + "/ListarMacs",
                tableNameVariable: "macs",
                tablePaging: false,
                tableHeaderCheck:false,
                table: ".datatable-macs",
                tableButtons: "",
                tableDom: "",
                tableColumns: [
                    {
                        data: "MAC",
                        title: "MAC"
                    },
                    {
                        data: 'id',
                        title: "Acciones",
                        width: 100,
                        className: 'text-center',
                        "bSortable": false,
                        "render": function(value, type, oData, meta) {
                            var botones = '<a href="#" class="btn btn-icon btn-sm bg-danger-400 eliminar_mac" data-id="' + value + '"><i class="icon-cross"></i></a>';
                            return botones;
                        }
                    }
                ]
            })
        });

        $(document).on("click", "#agregar_mac", function() {
            if($('#txt_mac_nueva').val().length !== 0){
                var mac = $('#txt_mac_nueva').val();
                var t = $('.datatable-macs').DataTable();
                t.row.add({
                    'MAC' : mac,
                    'id' : 0
                }).draw(false);

                $('.datatable-macs > tbody:last-child').append('<tr><td></td><td>' + mac + '</td><td></td></tr>');
                $('#txt_mac_nueva').val('');
            }
        });

        $(document).on("click", ".eliminar_mac", function() {
            var t = $('.datatable-macs').DataTable();
            t.row($(this).parents('tr')).remove().draw();
        });

        $(document).on("click", ".btn_guardar_macs", function() {
            var t = $('.datatable-macs').DataTable();
            var data = t.rows().data().toArray();
            var object = {};
            object.id = $('#cc_id').val();
            object.data = data;
            console.log(object);

            responseSimple({
                url: "PuntoVentas/"+ object.id + "/AsignarMacs",
                refresh: false,
                data: JSON.stringify(object),
                callBackSuccess: function(response) {
                    $('#cerrar_modal_horas').click();
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
            ajaxUrl: "PuntoVentas/Listar",
            tableNameVariable: "salas",
            tableHeaderCheck:false,
            table: ".datatable",
            reportTitle: "Listado de Locales",
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
                    data: "Ubigeo",
                    title: "Ubigeo"
                },
                {
                    data: 'cc_id',
                    title: "Acciones",
                    width: 100,
                    className: 'text-center no-export',
                    "bSortable": false,
                    "render": function(value, type, oData, meta) {
                        var botones = '<div class="list-icons">' +
                            '<div class="dropdown">' +
                            '<a href="#" class="list-icons-item" data-toggle="dropdown">' +
                            '<i class="icon-menu9"></i>' +
                            '</a>' +
                            '<div class="dropdown-menu dropdown-menu-right">' +
                            // '<a href="#" class="dropdown-item btn_editar" data-id="' + value + '"><i class="icon-hammer"></i> Editar</a>' +
                            '<button type="button" class="dropdown-item btn border-transparent btn_editar_macs" data-toggle="modal" data-target="#modal_scrollable_horas" data-id="' + value + '"><i class="icon-mail5"></i> MACs </button>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        return botones;
                    }
                }
            ]
        });

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