var ListarView = function() {
   
    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true, time:0});
        });

        $(document).on("click", ".clean-txt", function() {
            $(this).siblings("input").val("");
        });

        $(function() {
            $('input[name="txt_fecha_inicio"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: false,
                autoUpdateInput: true,
                minYear: 1901,
                locale:{
                    "format": "YYYY-MM-DD",
                    "separator": "-",
                }                                        
            });

            $('input[name="txt_fecha_final"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: false,
                autoUpdateInput: true,
                minYear: 1901,
                locale:{
                    "format": "YYYY-MM-DD",
                    "separator": "-",
                }                                        
            });
            
        });

        $("#txt_sala_id").autocomplete({
            source: function(request, response) {
                $.ajax({
                  type: "POST",
                  url: "PuntoVentas/Busqueda",
                  dataType: "json",
                  data: {
                    query: request.term
                  },
                  success: function(data) {
                    response($.map(data.data, function(item) {
                      return {
                        label: item.cc_id + ": " +item.nombre,
                        value: item.cc_id
                      }
                    }))
                  }
                })
              },
            minLength: 0,
          });

        $("#txt_sala_id").focus(function() {
            $(this).autocomplete("search", $(this).val());
        });

        $(document).on("click", "#btn_buscar", function() {
            var txt_sala_id = $("#txt_sala_id").val();
            var txt_fecha_inicio = $("#txt_fecha_inicio").val();
            var txt_fecha_final = $("#txt_fecha_final").val();
            var data = {};

            if(txt_sala_id){
                data.local_id = parseInt(txt_sala_id);
            }
            if(txt_fecha_inicio){
                data.fecha_encendido = txt_fecha_inicio;
            }
            if(txt_fecha_final){
                data.fecha_apagado = txt_fecha_final;
            }

            console.log(data);

            simpleAjaxDataTable({
                uniform: true,
                ajaxUrl: "Registro/Buscar",
                ajaxDataSend: data,
                tableNameVariable: "registros",
                tableHeaderCheck:false,
                table: ".datatable",
                tableColumns: [
                    {
                        data: "id",
                        title: "ID"                    
                    },
                    {
                        data: "local_id",
                        title: "Local"                    
                    },
                    {
                        data: "tipo",
                        title: "Estado"
                    },
                    {
                        data: "fecha_encendido",
                        title: "Fecha de encendido"
                    },
                    {
                        data: "fecha_apagado",
                        title: "Fecha de apagado"
                    }                
                ]
            })
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
            ajaxUrl: "Registro",
            tableNameVariable: "registros",
            tableHeaderCheck:false,
            table: ".datatable",
            tableColumns: [
                {
                    data: "id",
                    title: "ID"                    
                },
                {
                    data: "local_id",
                    title: "Local"                    
                },
                {
                    data: "tipo",
                    title: "Estado"
                },
                {
                    data: "fecha_encendido",
                    title: "Fecha de encendido"
                },
                {
                    data: "fecha_apagado",
                    title: "Fecha de apagado"
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