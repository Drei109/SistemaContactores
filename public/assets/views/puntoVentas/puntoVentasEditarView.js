var NuevoView = function() {
    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true,time:0});
        });

        $(document).on("click", ".btn_regresar", function() {
            redirect({site:"PuntoVentas", time:0});
        });

        $(document).on("click", ".btn_limpiar", function() {
            limpiar_form({
                contenedor: '#formulario',
            });
            _objetoForm_formNuevo.resetForm();
        });

        
        //Populate Form
        $.ajax({
            url: "/PuntoVentas/Ver/" + $("#txt_id").val(),
            dataType: "json",
            success: function(data) {
                $("#txt_nombre").val(data.registro.nombre);  
                $("#txt_cc_id").val(data.registro.cc_id);
            }
          });

        $(document).on("click", ".btn_guardar", function() {
            $("#formulario").submit();
            if (_objetoForm_formNuevo.valid()) {
                var dataForm = $('#formulario').serializeFormJSON();
                responseSimple({
                    url: "PuntoVentas/Actualizar",
                    data: JSON.stringify(dataForm),
                    refresh: false,
                    callBackSuccess: function(response) {
                        if(response.respuesta){
                            limpiar_form({
                                contenedor: '#formulario',
                            });
                            redirect({site:"PuntoVentas", time:0});
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