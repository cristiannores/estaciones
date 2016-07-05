$(document).ready(function () {
   var form = $('#form-login');
   $(form).formValidation({
       framework: 'bootstrap',
       fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    emailAddress: {
                        message: 'Direccion de correo electronica inocrrecta'
                    }
                }
            },
           
            password: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        min: 6,
                        max: 20,
                        message: 'La contraseña debe tener entre 6 y 20 caracteres como máximo'
                    },
                    identical: {
                        field: 'confirmPassword',
                        message: 'Las contraseñas deben ser identicas'
                    }
                }
            },
           
            
        }
   }).on('success.form.fv', function (e) {
        e.preventDefault();
        var $form = $(e.target),
        fv = $form.data('formValidation');
        iniciaSesion($form);
    });
    
    
     $('.button-checkbox').each(function () {

        // Settings
        var $widget = $(this),
            $button = $widget.find('button'),
            $checkbox = $widget.find('input:checkbox'),
            color = $button.data('color'),
            settings = {
                on: {
                    icon: 'glyphicon glyphicon-check'
                },
                off: {
                    icon: 'glyphicon glyphicon-unchecked'
                }
            };

        // Event Handlers
        $button.on('click', function () {
            $checkbox.prop('checked', !$checkbox.is(':checked'));
            $checkbox.triggerHandler('change');
            updateDisplay();
        });
        $checkbox.on('change', function () {
            updateDisplay();
        });

        // Actions
        function updateDisplay() {
            var isChecked = $checkbox.is(':checked');

            // Set the button's state
            $button.data('state', (isChecked) ? "on" : "off");

            // Set the button's icon
            $button.find('.state-icon')
                .removeClass()
                .addClass('state-icon ' + settings[$button.data('state')].icon);

            // Update the button's color
            if (isChecked) {
                $button
                    .removeClass('btn-default')
                    .addClass('btn-' + color + ' active');
            }
            else {
                $button
                    .removeClass('btn-' + color + ' active')
                    .addClass('btn-default');
            }
        }

        // Initialization
        function init() {

            updateDisplay();

            // Inject the icon if applicable
            if ($button.find('.state-icon').length == 0) {
                $button.prepend('<i class="state-icon ' + settings[$button.data('state')].icon + '"></i>');
            }
        }
        init();
    });
   
   
   
   // Formulario de registro 
   
   var form = $('#registro-form');
   $(form).formValidation({
       framework: 'bootstrap',
       fields: {
            email: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    emailAddress: {
                        message: 'Direccion de correo electronica inocrrecta'
                    }
                }
            },
            username :{
               validators: {
                   notEmpty: {
                        message: 'Campo requerido'
                    },
               }  
            },
            nombre :{
               validators: {
                   notEmpty: {
                        message: 'Campo requerido'
                    },
               }  
            },
            apellido :{
               validators: {
                   notEmpty: {
                        message: 'Campo requerido'
                    },
               }  
            },
            password: {
                validators: {
                    notEmpty: {
                        message: 'Campo requerido'
                    },
                    stringLength: {
                        min: 6,
                        max: 20,
                        message: 'La contraseña debe tener entre 6 y 20 caracteres como máximo'
                    },
                    identical: {
                        field: 'password_confirmation',
                        message: 'Las contraseñas deben ser identicas'
                    }
                }
            },
           
            
        }
   }).on('success.form.fv', function (e) {
        e.preventDefault();
        var $form = $(e.target),
        fv = $form.data('formValidation');
        
        registrarUser($form);
    });
});

var registrarUser = function($form){
    $body = $("body");
    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize(),
        datatype: 'json',
        beforeSend: function (xhr) {
            $body.addClass("loading");
            $body.addClass("modal");
        },
        success: function (resp) {
            $body.removeClass("loading");
            $body.removeClass("modal");
            console.log(resp);
            if(resp.codigo == 1){
                toastr.success(resp.mensaje);
                 window.setTimeout(function(){
                     toastr.success("Será redirigido al login");
                }, 2000);
                window.setTimeout(function(){
                    window.location.href = "/";
                }, 5000);
            }else{
                toastr.error(resp.mensaje);
            }              
             
        },
        complete: function (jqXHR, textStatus) {
            $body.removeClass("loading");
            $body.removeClass("modal");
        }
        ,error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("error");
        }
    });
}




var iniciaSesion = function($form){
    $body = $("body");
    $.ajax({
        url: $form.attr('action'),
        type: 'POST',
        data: $form.serialize(),
        datatype: 'json',
        beforeSend: function (xhr) {
            $body.addClass("loading");
            $body.addClass("modal");
        },
        success: function (resp) {
            
            
            $body.removeClass("loading");
            $body.removeClass("modal");
            
            if(resp.code == 1){
                location.href = "/estaciones/";
            }else{
                toastr.error(resp.message);
            }              
             
        },
        complete: function (jqXHR, textStatus) {
            $body.removeClass("loading");
            $body.removeClass("modal");
        }
        ,error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("error");
        }
    });
}