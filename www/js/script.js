
$(document).ready(function() {



// fillCities('origen');
// fillCities('destino');
});

/*
function fillCities(idSelect)
  {
    $('#'+idSelect).empty()
    //var dropDown = document.getElementById("carId");
    //var carId = dropDown.options[dropDown.selectedIndex].value;
    $.ajax({
            type: "GET",
            url: "http://127.0.0.1:5000/ciudades",
            headers: {
	            //'x-auth-token': localStorage.accessToken,
	            "Content-Type": "application/json"
        	  },
	        dataType: 'json',
            //data: { 'carId': carId  },
            success: function(data){
                console.log(data);
                data = data.ciudades
                // Parse the returned json data
                //var opts = $.parseJSON(data);
                // Use jQuery's each to iterate over the opts value
                $.each(data, function(i, d) {
                    console.log(i +' ->' + d)
                    // You will need to alter the below to get the right values from your json object.  Guessing that d.id / d.modelName are columns in your carModels data
                    $('#'+idSelect).append('<option value="' + d.id + '">' + d.nombre + '</option>');
                });
            }
        });

  }
*/