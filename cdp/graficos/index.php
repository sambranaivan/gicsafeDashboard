<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CONTADOR DE PASAJEROS</title>
    <link rel="stylesheet" href="../../assets/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="../../assets/css/styles.css">
    <link rel="stylesheet" href="https://code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!-- Highcharts import -->
    <script src="https://code.highcharts.com/highcharts.js"></script>
</head>

<body>
    <div class="container-fluid">
        <nav class="navbar navbar-default">
            <div class="container-fluid">
                <div class="navbar-header"><a class="navbar-brand navbar-link" href="#">Contador de Pasajeros</a>
                    <button class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navcol-1"><span class="sr-only">Toggle navigation</span><span class="icon-bar"></span><span class="icon-bar"></span><span class="icon-bar"></span></button>
                </div>
               <div class="collapse navbar-collapse" id="navcol-1">
                    <ul class="nav navbar-nav">
                        <li role="presentation"><a href="../">Inicio </a></li>
                        <li role="presentation"><a href="../../monitor">Monitor de Barreras </a></li>
                        <li role="presentation"><a href="../../cdp">Contador de Pasajeros</a></li>
                        <li class="active"  role="presentation"><a href="#">Gráficos</a></li>
                    </ul>
                </div>
            </div>
        </nav>

    <div class="row">
        <div class="col col-md-4">
            <h3 class="text-muted text-center">Sensor 1: Sensibilidad Máxima</h3>
            <div class="col col-md-12" id="graph1">Cargando ...</div>    
        </div>
        <div class="col col-md-4">
            <h3 class="text-muted text-center">Sensor 2: Sensibilidad Máxima</h3>
            <div class="col col-md-12" id="graph2">Cargando ...</div>    
        </div>
        <div class="col col-md-4">
            <h3 class="text-muted text-center">Sensor 3: Sensibilidad Mínima</h3>
            <div class="col col-md-12" id="graph3">Cargando ...</div>    
        </div>
        
        
        
        <div class="col col-md-12" id="graph4">Cargando ...</div>
    </div>
       


       </div>
    <script src="../../assets/js/jquery.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.min.js"></script>
    <script src="../../assets/bootstrap/js/bootstrap.min.js"></script>
    <script type="text/javascript">
        $(function () { 

   

  function createChart(divId,Chart,name)
  {
    console.log("Chart");
    console.log(Chart);

    var myChart = Highcharts.chart(divId, {
        chart: {
            type: 'line'
        },
        title: {
            text: 'N Celulares Censados'
        },
         line: {
        dataLabels: {
            enabled: true
        }
    },
        xAxis: {
    type: 'datetime',
    dateTimeLabelFormats: {
      day: "%e. %b",
      month: "%b '%y",
      year: "%Y"
    }
  }, time: {
        timezoneOffset: 3 * 60
   },
        series: [{
            name:name,
            data: Chart
        }]
    });
  }  


function createChartAll(divId,Chart)
  {
    console.log("Chart");
    console.log(Chart);

    var myChart = Highcharts.chart(divId, {
        chart: {
            type: 'line'
        },
        title: {
            text: 'N Celulares Censados'
        },
         line: {
        dataLabels: {
            enabled: true
        }
    },
        xAxis: {
    type: 'datetime',
    dateTimeLabelFormats: {
      day: "%e. %b",
      month: "%b '%y",
      year: "%Y"
    }
  }, time: {
        timezoneOffset: 3 * 60
   },
        series: [{
            name:'Sensor 1',
            data: Chart[0]},{
            name:'Sensor 2',
            data: Chart[1]},{
            name:'Sensor 3',
            data: Chart[2],
            
        }]
    });
  }  
    // consulta
    $.get('get.php?filter=hour',{},function(data){
        // console.log(var r = data);
                    // console.log(data);
                    data.reverse();
                    var info = new Array(
                        new Array(new Array(),new Array()),
                        new Array(new Array(),new Array()),
                        new Array(new Array(),new Array()))

                    data.forEach(function(e){
                        var payload = JSON.parse(e.payload);
                        var topic = e.topic.split('/');
                        var N = (payload.N);
                        var P = (payload.P);
                        var C = (topic[4]);

                        
                        D = new Date(e.timestamp);
                        D = D.getTime();
                        // D = D.setTime();
                        // console.log(N,P,C);
                        switch(C){
                            case 'C_2':
                            info[0][0].push([D,N]);
                            info[0][1].push([D,P]);
                            break;
                            case 'C_3':
                            info[1][0].push([D,N]);
                            info[1][1].push([D,P]);
                            break;
                            case 'C_4':
                            info[2][0].push([D,N]);
                            info[2][1].push([D,P]);
                            break;
                            default:
                            console.log("ERROR DEFAULT");
                            break;
                        }

                        
                    })
                    console.log(info);
                         
                    createChart('graph1',info[0][0],'Sensor 1');
                    createChart('graph2',info[1][0],'Sensor 2');
                    createChart('graph3',info[2][0],'Sensor 3');
                    createChartAll('graph4',[info[0][0],info[1][0],info[2][0]]);


                })

});
    </script>
    
</body>

</html>