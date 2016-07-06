/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
$(document).ready(function () {
  $('#tabla_estaciones').DataTable({
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
$("#editar_estacion").on("click",function(){
    editarEstacion();
});
$("#habilitar_estacion").on("click",function(){
    habilitarEstacion();
})
$("#btn-agregar-estacion").on("click",function(){
    agregarEstacion();
});


// FUNCIONES MANTENEDOR 

/**
 * Agrega una estacion 
 * @returns ajax
 */
function agregarEstacion(){
     $.ajax({
        url: '/estaciones/estaciones/agregar-estacion',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_estacion").html(resp);   
            $('#modal-agregar-estacion').modal();
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
 * Habilito el estacion 
 * @returns ajax
 */
function habilitarEstacion(){
    $.ajax({
        url: '/estaciones/estaciones/habilitar-estacion',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_estacion").html(resp);   
            $('#modal-habilitar-estacion').modal();
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
function editarEstacion(){
    $.ajax({
        url: '/estaciones/estaciones/editar-estacion',
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#modal_estacion").html(resp);   
            $('#modal-editar-estacion').modal();
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






