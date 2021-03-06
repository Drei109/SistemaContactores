$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    },
    error: function(xmlHttpRequest, textStatus, errorThrow) {
        messageResponse({
            message: xmlHttpRequest.responseJSON.message,
            type: "error"
        });
    },
    statusCode: {
        404: function() {
            messageResponse({
                message: "No Se encuentra la Direccion.(404)",
                type: "error"
            });
        },
        405: function() {
            messageResponse({
                message: "Metodo no Permitido.(GET,POST,PUT,DELETE)(405)",
                type: "error"
            });
        },
        500: function() {
            messageResponse({
                message: "Error Interno.(500)",
                type: "error"
            });
        }
    }
});

// Setting datatable defaults
$.extend($.fn.dataTable.defaults, {
    autoWidth: false,
    dom: '<"datatable-header"fl><"datatable-scroll"t><"datatable-footer"ip>',
    language: {
        search: '<span>Buscar:</span> _INPUT_',
        searchPlaceholder: '...',
        lengthMenu: '<span>Mostrar:</span> _MENU_',
        paginate: {
            'first': 'First',
            'last': 'Last',
            'next': $('html').attr('dir') == 'rtl' ? '&larr;' : '&rarr;',
            'previous': $('html').attr('dir') == 'rtl' ? '&rarr;' : '&larr;'
        },
        emptyTable: "No hay Data que Mostrar",
        infoEmpty: "Mostrando 0 al 0 de 0 Registros",
        infoFiltered: "(Filtrado de _MAX_ Registro(s))",
        info: "Mostrando _START_ al _END_ de _TOTAL_ Registros",
        loadingRecords: "Cargando...",
        processing: "Procesando...",
        zeroRecords: "No Se encontro Coincidencias"
    }
});
//////////////////////////////////

function refresh(estate) {
    //console.warn("estado_refresh", estate);
    window.location.reload(estate);
}

function redirect(site) {
    window.location.href = basePath + site;
}
//////////////////////////////////
function block_general(block) {
    $(block).block({
        message: '<i class="icon-spinner4 spinner"></i>',
        overlayCSS: {
            backgroundColor: '#fff',
            opacity: 0.8,
            cursor: 'wait'
        },
        css: {
            width: 16,
            border: 0,
            padding: 0,
            backgroundColor: 'transparent'
        }
    });
}

function unblock(block) {
    $(block).unblock();
}

////////////////////////////////////////////////////////////
function messageResponse(obj) {
    var defaults = {
        message: null,
        type: null,
        timeOut: 2500,
        progressBar: true,
        closeWith: null,
        modal: false
    }

    var opciones = $.extend({}, defaults, obj);
    var theme = null;
    switch (opciones.type) {
        case 'success':
            theme = ' alert alert-success alert-styled-left p-0';
            break;
        case 'error':
            theme = ' alert alert-danger alert-styled-left p-0';
            break;
        case 'warning':
            theme = ' alert alert-warning alert-styled-left p-0';
            break;
        case 'info':
            theme = ' alert bg-info text-white alert-styled-left p-0';
            break;
        case 'alert':
            theme = {};
            break;
        default:
            theme = ' alert bg-info alert-styled-left p-0';
            break;
    }
    new Noty({
        theme: theme,
        text: opciones.message,
        type: opciones.type,
        progressBar: opciones.progressBar,
        timeout: opciones.timeOut,
        closeWith: opciones.closeWith,
        modal: opciones.modal
    }).show();
}

////////////////////////////////////////

function validar_Form(obj) {
    if (!$().validate) {
        console.warn('Advertencia - validate.min.js no esta definido.');
        return;
    }
    // Initialize
    var defaults = {
        contenedor: null,
        nameVariable: "",
        ignore: 'input[type=hidden], .select2-search__field',
        rules: {},
        messages: {}
    }

    var opciones = $.extend({}, defaults, obj);

    if (opciones.contenedor == null) {
        console.warn('Advertencia - contenedor no esta definido.');
        return;
    }

    var objt = "_objetoForm";
    this[objt + '_' + opciones.nameVariable] = $(opciones.contenedor).validate({
        ignore: opciones.ignore, // ignore hidden fields
        errorClass: 'validation-invalid-label',
        successClass: 'validation-valid-label',
        validClass: 'validation-valid-label',
        highlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        unhighlight: function(element, errorClass) {
            $(element).removeClass(errorClass);
        },
        success: function(label) {
            label.addClass('validation-valid-label').text('Correcto.'); // remove to hide Success message
        },

        // Different components require proper error label placement
        errorPlacement: function(error, element) {

            // Unstyled checkboxes, radios
            if (element.parents().hasClass('form-check')) {
                error.appendTo(element.parents('.form-check').parent());
            }

            // Input with icons and Select2
            else if (element.parents().hasClass('form-group-feedback') || element.hasClass('select2-hidden-accessible')) {
                error.appendTo(element.parent());
            }

            // Input group, styled file input
            else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                error.appendTo(element.parent().parent());
            }

            // Input group, styled file input
            else if (element.parent().is('.uniform-uploader, .uniform-select') || element.parents().hasClass('input-group')) {
                error.appendTo(element.parent().parent());
            }

            // Other elements
            else {
                error.insertAfter(element);
            }
        },
        submitHandler: function(form) { // for demo
            return false;
        },
        rules: opciones.rules,
        messages: opciones.messages
    });

}

/////////////////////////////////////////

function limpiar_form(obj) {
    var defaults = {
        contenedor: null,
    }

    var opciones = $.extend({}, defaults, obj);
    if (opciones.contenedor == null) {
        console.warn('Advertencia - contenedor no fue declarado.');
        return;
    };

    $(opciones.contenedor + " input,select,textarea").val("");
}

/////////////////////////////////////////

function simpleDataTable(obj) {

    var defaults = {
        uniform: false,
        tableNameVariable: "",
        table: "table",
        tableColumnsData: [],
        tableColumns: [],
        tablePaging: true,
        tableOrdering: true,
        tableInfo: true,
        tableLengthChange: true,
        tableHeaderCheck: false
    }

    var opciones = $.extend({}, defaults, obj);
    var objt = "_objetoDatatable";
    this[objt + '_' + opciones.tableNameVariable] = $(opciones.table).DataTable({
        "bDestroy": true,
        "scrollCollapse": true,
        "scrollX": false,
        "autoWidth": false,
        "bProcessing": true,
        "bDeferRender": true,
        "paging": opciones.tablePaging,
        "ordering": opciones.tableOrdering,
        "info": opciones.tableInfo,
        "lengthChange": opciones.tableLengthChange,
        data: opciones.tableColumnsData,
        columns: opciones.tableColumns,
        "initComplete": function() {
            var api = this.api();
            if (opciones.tableHeaderCheck) {
                $(api.column(0).header()).html('<input type="checkbox" name="header_chk_all" data-children="' + opciones.table + '" class="form-check-input-styled-info chk_all">');
            }
            if (opciones.uniform) {
                // Info
                if ($('input[type=checkbox]').length > 0) {
                    $('input[type=checkbox]').uniform({
                        wrapperClass: 'border-info-600 text-info-800'
                    });
                }
            }
        }
    });
}

function simpleAjaxDataTable(obj) {

    var defaults = {
        ajaxUrl: null,
        ajaxDataSend: {},
        tableColumnsData: [],
        tableColumns: [],
        tableHeaderCheck: false
    }
    var opciones = $.extend({}, defaults, obj);
    if (opciones.ajaxUrl == null) {
        console.warn('Advertencia - url no fue declarado.');
        return;
    };

    var url = basePath + opciones.ajaxUrl;
    $.ajax({
        url: url,
        type: "POST",
        contentType: "application/json",
        data: JSON.stringify(opciones.ajaxDataSend),
        beforeSend: function() {
            block_general("body");
        },
        complete: function() {
            unblock("body");
        },
        success: function(response) {
            opciones.tableColumnsData = response.data;
            simpleDataTable(opciones);
        },
        error: function(xmlHttpRequest, textStatus, errorThrow) {
            console.warn('Message :', xmlHttpRequest.responseJSON.message);
        }
    });
}

//////////////////////////////////////////////////
$(document).on("click", ".chk_all", function() {
    var children = ($(this).data("children")).substring(1);
    var checkboxsNotCheck = $("input." + children + ":checkbox:not(:checked)");
    var checkboxCheck = $("input." + children + ":checkbox:checked");
    var elementos = [];

    if ($(this).is(':checked')) {
        $.each(checkboxsNotCheck, function(index, value) {
            elementos.push($(this).data("id"));
            $(this).click();
        });
    } else {
        $.each(checkboxCheck, function(index, value) {
            elementos.push($(this).data("id"));
            $(this).click();
        });
    }
    //console.info(elementos);
});


//////////////////////////////////////////////////

function responseSimple(obj) {
    var defaults = {
        url: null,
        type: "POST",
        data: [],
        refresh: true,
        redirect: false,
        redirectUrl: null,
        callBackBeforeSend: null,
        callBackSComplete: null,
        callBackSuccess: function() {
            console.warn("funcion vacio finalizada");
        },
        time: 2000,
        loader: true
    }

    var opciones = $.extend({}, defaults, obj);
    if (opciones.url == null) {
        console.warn('Advertencia - url no fue declarado.');
        return;
    };

    var url = basePath + opciones.url;
    $.ajax({
        url: url,
        type: opciones.type,
        contentType: "application/json",
        data: opciones.data,
        beforeSend: function() {
            if (opciones.loader) {
                block_general("body");
            }
            if (opciones.callBackBeforeSend != null) {
                opciones.callBackBeforeSend();
            }
        },
        complete: function() {
            if (opciones.loader) {
                unblock("body");
            }
            if (opciones.callBackSComplete != null) {
                opciones.callBackSComplete();
            }
        },
        success: function(response) {
            var respuesta = response.respuesta;
            var mensaje = response.mensaje;

            if (opciones.redirect) {
                if (opciones.redirectUrl == null) {
                    console.warn('Advertencia - redirectUrl no fue declarado.');
                    return;
                };
                redirect(redirectUrl);
            } else {

                if (respuesta) {
                    messageResponse({
                        message: mensaje,
                        type: "success"
                    });
                } else {
                    messageResponse({
                        message: mensaje,
                        type: "error"
                    });
                }

                if (opciones.refresh) {
                    setTimeout(function() {
                        refresh(true);
                    }, 2000);
                } else {
                    opciones.callBackSuccess(response);
                }
            }
        },
        error: function(xmlHttpRequest, textStatus, errorThrow) {
            console.warn('Message :', xmlHttpRequest.responseJSON.message);
        }
    });
}

//////////////////////////////////////////////////////////////////////////////

$.fn.serializeFormJSON = function() {

    var o = {};
    var a = this.serializeArray();
    $.each(a, function() {
        if (o[this.name]) {
            if (!o[this.name].push) {
                o[this.name] = [o[this.name]];
            }
            o[this.name].push(this.value || '');
        } else {
            o[this.name] = this.value || '';
        }
    });
    return o;
}