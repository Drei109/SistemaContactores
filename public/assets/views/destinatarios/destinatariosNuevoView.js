var NuevoView = function() {
    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true,time:0});
        });

        $(document).on("click", ".btn_regresar", function() {
            redirect({site:"Destinatarios", time:0});
        });

        $(document).on("click", ".btn_limpiar", function() {
            limpiar_form({
                contenedor: '#formulario_nuevo',
            });
            _objetoForm_formNuevo.resetForm();
        });

        $(document).on("click", ".btn_guardar", function() {
            $("#formulario_nuevo").submit();
            if (_objetoForm_formNuevo.valid()) {
                var dataForm = $('#formulario_nuevo').serializeFormJSON();
                responseSimple({
                    url: "Destinatarios/Guardar",
                    data: JSON.stringify(dataForm),
                    refresh: false,
                    callBackSuccess: function(response) {
                        if(response.respuesta){
                            limpiar_form({
                                contenedor: '#formulario_nuevo',
                            });
                            _objetoForm_formNuevo.resetForm();
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
            nameVariable: 'formNuevo',
            contenedor: '#formulario_nuevo',
            rules: {
                nombre: {
                    required: true
                },

            },
            messages: {
                nombre: {
                    required: 'El campo es Requerido'
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

document.addEventListener('DOMContentLoaded', function() {
    NuevoView.init();
});