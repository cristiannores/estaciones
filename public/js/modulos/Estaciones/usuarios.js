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
    
