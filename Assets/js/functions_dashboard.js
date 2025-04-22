 // Obtener los datos desde el script PHP
 fetch(' '+base_url+'/Dashboard/getHorasPorMesControlador')
 .then(response => response.text())  // Cambiar a text para inspección inicial
 .then(data => {
     console.log(data);  // Verifica el contenido de la respuesta
     try {
         let jsonData = JSON.parse(data);
         var meses = jsonData.map(item => item.numeroficha);
         var horas = jsonData.map(item => item.avancehorascompetencia);
 
         // Inicializar el gráfico
         var myChart = echarts.init(document.getElementById('main'));
 
         // Configuración del gráfico
         var option = {
            //  title: {
            //      text: 'Horas Trabajadas por Mes'
            //  },
             tooltip: {},
             xAxis: {
                 type: 'category',
                 data: meses
             },
             yAxis: {
                 type: 'value'
             },
             series: [{
                 name: 'Horas',
                 type: 'bar',
                 data: horas
             }]
         };
 
         // Aplicar la configuración
         myChart.setOption(option);
     } catch (e) {
         console.error("Error parsing JSON:", e);
     }
 });

  // Obtener los datos desde el script PHP
  fetch(' '+base_url+'/Dashboard/getHorasPorInstructor')
  .then(response => response.text())  // Cambiar a text para inspección inicial
  .then(data => {
      console.log(data);  // Verifica el contenido de la respuesta
      try {
          let jsonData = JSON.parse(data);
          var meses = jsonData.map(item => item.nombres);
          var horas = jsonData.map(item => item.instructor);
  
          // Inicializar el gráfico
          var myChart = echarts.init(document.getElementById('mainInstructores'));
  
          // Configuración del gráfico
          var option = {
             //  title: {
             //      text: 'Horas Trabajadas por Mes'
             //  },
              tooltip: {},
              xAxis: {
                  type: 'category',
                  data: meses
              },
              yAxis: {
                  type: 'value'
              },
              series: [{
                  name: 'Horas',
                  type: 'bar',
                  data: horas,
                  itemStyle: {
                    color: '#008F51'
                }
              }]
          };
  
          // Aplicar la configuración
          myChart.setOption(option);
      } catch (e) {
          console.error("Error parsing JSON:", e);
      }
  });