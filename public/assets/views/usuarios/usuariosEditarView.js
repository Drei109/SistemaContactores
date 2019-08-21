var NuevoView = function() {
    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true,time:0});
        });

        $(document).on("click", ".btn_regresar", function() {
            redirect({site:"users", time:0});
        });

        $(document).on("click", ".btn_limpiar", function() {
            limpiar_form({
                contenedor: '#formulario_nuevo',
            });
            _objetoForm_formNuevo.resetForm();
        });
        
    };

    var _metodos = function() {
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