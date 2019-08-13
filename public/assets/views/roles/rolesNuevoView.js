var rolesNuevoView = function() {

    //
    // Setup module components
    //

    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh(true);
        });

        $(document).on("click", ".btn_regresar", function() {
            redirect({site:"Roles"});
        });

        $(document).on("click", ".btn_limpiar", function() {
            limpiar_form({
                contenedor: '#formulario_nuevo_rol',
            });
            _objetoForm_formNuevoRol.resetForm();
        });

        $(document).on("click", ".btn_guardar", function() {
            $("#formulario_nuevo_rol").submit();
            if (_objetoForm_formNuevoRol.valid()) {
                var dataForm = $('#formulario_nuevo_rol').serializeFormJSON();
                responseSimple({
                    url: "RolesGuardarNuevo",
                    data: JSON.stringify(dataForm),
                    refresh: false,
                    callBackSuccess: function(response) {
                        if(response.respuesta){
                            limpiar_form({
                                contenedor: '#formulario_nuevo_rol',
                            });
                            _objetoForm_formNuevoRol.resetForm();
                        }
                        
                    }
                });
            } else {
                messageResponse({
                    message: "Complete los campos Obligatorios",
                    type: "error"
                })
            }
        });
    };

    // Basic Datatable examples
    var _metodos = function() {
        validar_Form({
            nameVariable: 'formNuevoRol',
            contenedor: '#formulario_nuevo_rol',
            rules: {
                nombre: {
                    required: true
                },

            },
            messages: {
                nombre: {
                    required: 'Nombre de Rol es Requerido'
                },
            }
        });

    };


    //
    // Return objects assigned to module
    //
    return {
        init: function() {
            _metodos();
            _componentes();
        }
    }
}();

// Initialize module
// ------------------------------

document.addEventListener('DOMContentLoaded', function() {
    rolesNuevoView.init();
});