var ListarView = function() {

    var _componentes = function() {
        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true, time:0});
        });

        $(document).on("click", ".btn_nuevo", function() {
            var id = $("#txt_id").val();
            redirect({site:"Destinatarios/"+ id + "/Nuevo", time:0});
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
            ajaxUrl: "Destinatarios/" + $("#txt_id").val() + "/VerSalas",
            tableNameVariable: "destinatarios",
            tableHeaderCheck:true,
            table: ".datatable",
            tableColumns: [
                {
                data: "pivot.id",
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
                    data: "direccion",
                    title: "Direccion"
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