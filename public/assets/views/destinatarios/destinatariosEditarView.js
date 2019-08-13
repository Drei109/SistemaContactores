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
                contenedor: '#formulario',
            });
            _objetoForm_formNuevo.resetForm();
        });

        
        //Populate Form
        $.ajax({
            url: "/Destinatarios/Ver/" + $("#txt_id").val(),
            dataType: "json",
            success: function(data) {
                $("#txt_nombre").val(data.objeto.nombre);   
                $("#txt_correo").val(data.objeto.correo);
            }
          });

        $(document).on("click", ".btn_guardar", function() {
            $("#formulario").submit();
            if (_objetoForm_formNuevo.valid()) {
                var dataForm = $('#formulario').serializeFormJSON();
                responseSimple({
                    url: "Destinatarios/Actualizar",
                    data: JSON.stringify(dataForm),
                    refresh: false,
                    callBackSuccess: function(response) {
                        if(response.respuesta){
                            limpiar_form({
                                contenedor: '#formulario',
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
            contenedor: '#formulario',
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