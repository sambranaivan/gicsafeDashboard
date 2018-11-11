
		$(document).ready(function(){

			update();


			setInterval(function(){
				update();

			},60000);


			function update(){
				console.log('update');
				$.get('live.php',{},function(data){
					console.log(data);
					data.reverse();
					fill(data);
				})
			}

			function fill(data)
			{
				var sheet = $("#sheet");
				sheet.hide("fade");
				sheet.html("");//limpio


				for (var i = data.length - 1; i >= 0; i--) {
					sheet.append('<div class="row"></div>');
					var row = sheet.last();
					var reg = data[i];
					row.append('<div class="col-md-2">'+reg.timestamp+'</div>')
					row.append('<div class="col-md-3">'+reg.topic+'</div>')
					row.append('<div class="col-md-7">'+reg.payload+'</div>')
				}

				sheet.show("fade");

			}

		})