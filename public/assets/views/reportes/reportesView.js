var ListarView = function() {
   
    var _componentes = function() {

        $(document).on("click", ".btn_recargar", function() {
            refresh({estate:true, time:0});
        });

        $(function() {
            $('input[name="txt_fecha_inicio"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: false,
                autoUpdateInput: false,
                minYear: 1901,
                locale:{
                    "format": "YYYY-MM-DD",
                    "separator": "-",
                }                                        
            });

            $('input[name="txt_fecha_final"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: false,
                autoUpdateInput: false,
                minYear: 1901,
                locale:{
                    "format": "YYYY-MM-DD",
                    "separator": "-",
                }                                        
            });
            
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