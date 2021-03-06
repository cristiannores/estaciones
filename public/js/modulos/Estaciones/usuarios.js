/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
  $('#tabla_usuarios').DataTable({
      language: {
          processing: "Procesando...",
          search: "Buscar&nbsp;:",
          lengthMenu: "_MENU_ registros por pagina",
          info: "Mostrando _START_ de _END_ de un total de  _TOTAL_ registros",
          infoEmpty: "Mostrando 0 de un total de 0 elementos",
          infoFiltered: "(filtr&eacute; de _MAX_ &eacute;l&eacute;ments au total)",
          infoPostFix: "",
          loadingRecords: "Cargando...",
          zeroRecords: "Ningun registro coincide con la busqueda",
          emptyTable: "No se encontraron registros",
          paginate: {
              first: "Primera página",
              previous: "Anterior",
              next: "Siguiente",
              last: "Ultima página"
          },
          aria: {
              sortAscending: ": activer pour trier la colonne par ordre croissant",
              sortDescending: ": activer pour trier la colonne par ordre décroissant"
          }
      }

  });
});
    
//Capturo los eventos de el mantenedor de usuarios
$("#editar_usuario").on("click",function(){
    editarUsuario();
});
$("#listar_estaciones").on("click",function(){
    listarEstaciones();
});
$("#habilitar_usuario").on("click",function(){
    habilitarUsuario();
})
$("#btn-agregar-usuario").on("click",function(){
    agregarUsuario();
});


// FUNCIONES MANTENEDOR 

/**
 * Agrega un usuario 
 * @returns ajax
 */
function agregarUsuario(){
     $.ajax({
        url: '/estaciones/usuarios/agregar-usuario',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_usuario").html(resp);   
            $('#modal-agregar-usuario').modal();
        },
        complete: function (jqXHR, textStatus) {
           
        }
        ,error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("error");
        }
    });
}
/**
 * Lista las estaciones del usuario
 * @returns ajax
 */
function listarEstaciones(){
    $.ajax({
        url: '/estaciones/usuarios/listar-estaciones',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_usuario").html(resp);   
            $('#modal-listar-estaciones').modal();
        },
        complete: function (jqXHR, textStatus) {
           
        }
        ,error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("error");
        }
    });
}
/**
 * Habilito el usuario 
 * @returns ajax
 */
function habilitarUsuario(){
    $.ajax({
        url: '/estaciones/usuarios/habilitar-usuario',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_usuario").html(resp);   
            $('#modal-habilitar-usuario').modal();
        },
        complete: function (jqXHR, textStatus) {
           
        }
        ,error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("error");
        }
    });
}
/**
 * Edicion de usuario 
 * @returns ajax
 */
function editarUsuario(){
    $.ajax({
        url: '/estaciones/usuarios/editar-usuario',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_usuario").html(resp);   
            $('#modal-editar-usuario').modal();
        },
        complete: function (jqXHR, textStatus) {
           
        }
        ,error: function (jqXHR, textStatus, errorThrown) {
            console.log(jqXHR);
            console.log(textStatus);
            console.log(errorThrown);
            console.log("error");
        }
    });
}
/**
 * Refrescar tabla
 * @returns tabla 
 */
function reloadTabla(){
    
}






