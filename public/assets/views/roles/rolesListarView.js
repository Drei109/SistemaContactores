var rolesListarView = function() {

    //
    // Setup module components
    //

    var _componentes = function() {
        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true, time:0});
        });

        $(document).on("click", ".btn_nuevo", function() {
            redirect({site:"RolesNuevo", time:0});
        });

        $(document).on("click", ".btn_eliminar", function() {
            var id_rol = $(".datatable-roles:checked").length;
            if (id_rol > 0) {
                var dataForm = {
                    id_rol: id_rol,
                };
                responseSimple({
                    url: "RolesEliminar",
                    refresh: false,
                    data: JSON.stringify(dataForm),
                    callBackSuccess: function(response) {
                        console.info(response);
                        rolesListarView.init_ListadoRoles();

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

        $(document).on("click", ".btn_estado", function() {
            var id_rol = $(this).data("id");
            var estado = $(this).data("estado");
            if (estado == 1) {
                estado = 0;
            } else {
                estado = 1;
            }
            if (id_rol > 0) {
                var dataForm = {
                    id_rol: id_rol,
                    estado: estado
                };
                responseSimple({
                    url: "RolesCambiarEstado",
                    refresh: false,
                    data: JSON.stringify(dataForm),
                    callBackSuccess: function(response) {
                        //console.info(response);
                        if(response.respuesta){
                            refresh(true);
                        }
                    }
                });
            }
        });

        $(document).on("click", ".btn_editar", function() {
            var id_rol = $(this).data("id");
            redirect({site:"RolesRegistro/" + id_rol});
        });
    };

    // Basic Datatable examples
    var _ListadoRoles = function() {
        if (!$().DataTable) {
            console.warn('Advertencia - datatables.min.js no esta declarado.');
            return;
        }

        // Basic datatable
        simpleAjaxDataTable({
            uniform: true,
            ajaxUrl: "RolesListarJson",
            tableNameVariable: "roles",
            tableHeaderCheck:true,
            table: ".datatable-roles",
            tableColumns: [{
                    data: "id_rol",
                    title: "",
                    "bSortable": false,
                    "render": function(value) {
                        var check = '<input type="checkbox" class="form-check-input-styled-info chk_id_rol datatable-roles" data-id="' + value + '" name="">';
                        return check;
                    }
                },
                {
                    data: "id_rol",
                    title: "ID",
                },
                {
                    data: "nombre",
                    title: "Nombre"
                },
                {
                    data: "descripcion",
                    title: "Descripcion"
                },
                {
                    data: "estado",
                    title: "Estado",
                    "render": function(value) {
                        var estado = value;
                        var mensaje_estado = "";
                        if (estado == true) {
                            estado = "success";
                            mensaje_estado = "Activo";
                        } else {
                            estado = "danger";
                            mensaje_estado = "InActivo";
                        }
                        var span = '<span class="badge badge-' + estado + '">' + mensaje_estado + '</span>';
                        return span;
                    }

                },
                {
                    data: 'id_rol',
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
                            '<a href="#" class="dropdown-item btn_estado" data-id="' + value + '" data-estado="' + oData.estado + '"><i class="icon-circles"></i> Cambiar Estado</a>' +
                            '</div>' +
                            '</div>' +
                            '</div>';
                        return botones;
                    }
                }
            ]
        })

    };

    //
    // Return objects assigned to module
    //
    return {
        init: function() {
            _componentes();
            _ListadoRoles();
        },
        init_ListadoRoles: function() {
            _ListadoRoles();
        },
    }
}();


// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    rolesListarView.init();
});