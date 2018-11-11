///prototypo para formato de hora
String.prototype.toHHMMSS = function () {
    var sec_num = parseInt(this, 10); // don't forget the second param
    var hours   = Math.floor(sec_num / 3600);
    var minutes = Math.floor((sec_num - (hours * 3600)) / 60);
    var seconds = sec_num - (hours * 3600) - (minutes * 60);

    if (hours   < 10) {hours   = "0"+hours;}
    if (minutes < 10) {minutes = "0"+minutes;}
    if (seconds < 10) {seconds = "0"+seconds;}
    return hours+':'+minutes+':'+seconds;
}


		$(document).ready(function(){

			update();
			DigitalUpdate();

			setInterval(function(){
				update();

			},60000);


			// setInterval(function(){
			// 	DigitalUpdate();

			// },300000);


			
			function update(){
				if($("#sheet").length)
				{
					console.log('update');
					$.get('live.php',{},function(data){
						data.reverse();
						fill(data);
					})
				}

			}

			function DigitalUpdate(){
					///selectores
				if($("#tablaSensorDigital").length){
					////existe
					device = $("#tablaSensorDigital").attr("device");
					console.log('digital_update: '+device);
					$.get('graphapi.php',{device_id:device,type:"digital"},function(data)
					{
						// data.reverse();
						fillRegistroDigital(data);
					})
				}
			}

			function fillRegistroDigital(data)
			{
				
				var tabla = $("#tablaSensorDigital");
				tabla.hide("fade");
				tabla.html("");//limpio


				for (var i = data.length - 1; i >= 0; i--) {
					
					var reg = data[i];

					// convertir a los estados de Martin
					var state;
					var clase;

					switch(parseInt(reg.binario))
					{
					case 2:
					if(state!=1)
						{
							obs = "Vacia+Alta"
							clase="info"
						}
						else
							{
													clase="danger"
								obs = "Anomalia Detectada (Vacia+Alta)";
							}

					state = 0;
					break;
					case 6:
					if(state!=2)
						{
							obs = "Ocupada+Alta"
							clase="success"
						}
						else
							{
					clase="danger"
								obs = "Anomalia Detectada (Ocupada+Alta)";
							}

					state = 1;
					break;
					case 7:
					if(state!=3)
						{
							obs = "Bajando"
							clase="warning"
						}
						else
							{
					clase="danger"
								obs = "Anomalia Detectada (Bajando)";
							}

					state = 2;
					break;
					case 5:
					if(state!=4)
						{clase="active"
							obs = "Ocupada+Baja"
							
						}
						else
							{
					clase="danger"
								obs = "Anomalia Detectada (Ocupada+Baja)";
							}

					state = 3;
					break;
					case 1:
					if(state!=5)
						{clase="info"
							obs = "Vacia+Baja"
							
						}
						else
							{
					clase="danger"
								obs = "Anomalia Detectada (Vacia+Baja)";
							}

					state = 4;
					break;
					case 3:
					if(state!=0)
						{
							clase="active"
							obs = "Subiendo"
							
						}
						else
							{
					clase="danger"
								obs = "Anomalia Detectada (Subiendo)";
							}

					state = 5;
					break;
					default:
					obs = "Error";
						clase="danger"
					state = null;
					break;

					}

					///corregir la fecha 
					
					tabla.append('<tr class="'+clase+'"><td><b>'+reg.fecha+'</b></td><td>'+reg.d1+'</td><td>'+reg.d2+'</td><td>'+reg.d3+'</td><td>'+state+'</td><td>'+obs+'</td><td>'+(reg.duracion+"").toHHMMSS()+' </td></tr>')
				
				}

				tabla.show("fade");
				bindfilter();



			}

			function fill(data)
			{
				var sheet = $("#sheet");
				sheet.hide("fade");
				sheet.html("");//limpio


				for (var i = data.length - 1; i >= 0; i--) {
					
					var reg = data[i];
					sheet.append('<tr><td><b>'+reg.timestamp+'</b></td><td>'+reg.topic+'</td><td>'+reg.payload+'</td></tr>')
				
				}

				sheet.show("fade");
			}

			// bind filter

			function bindfilter(){
				 $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#tablaSensorDigital tr").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
			}

		})