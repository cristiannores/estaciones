/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */


$(document).ready(function () {
  $('#contenedor_grafico').highcharts({
        chart: {
            type: 'line'
        },
        title: {
            text: 'Promedio mensual de temperaturas'
        },
        subtitle: {
            text: 'Estaciones.cl'
        },
        xAxis: {
            categories: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Agost', 'Sep', 'Oct', 'Nov', 'Dic']
        },
        yAxis: {
            title: {
                text: 'Temperature (°C)'
            }
        },
        plotOptions: {
            line: {
                dataLabels: {
                    enabled: true
                },
                enableMouseTracking: false
            }
        },
        series: [{
            name: 'Concepcion',
            data: [7.0, 6.9, 9.5, 14.5, 18.4, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6]
        }, {
            name: 'Santiago',
            data: [3.9, 4.2, 5.7, 8.5, 11.9, 15.2, 17.0, 16.6, 14.2, 10.3, 6.6, 4.8]
        }]
    });
});

var mostrarGrafico = function(tipoGrafico){
    switch (tipoGrafico)
    {
        case 1 : 
         mostrarDiv("/Estaciones/menu/temperatura-chart");
        ; 
    }
}


var mostrarDiv = function(accion){
    $.ajax({
        url: accion,
        type: 'POST',
        datatype: 'html',
        beforeSend: function (xhr) {
           
         
        },
        success: function (resp) {
            $("#contenedor_grafico").html(resp);             
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