<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid 19 Tracker</title>
    <link
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:200,200i,300,300i,400,400i,600,600i,700,700i,900,900i"
        rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Merriweather:300,300i,400,400i,700,700i,900,900i"
        rel="stylesheet">
        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>

    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/c3.css">

</head>

<body>
    <div class="container">
        <div class="country-list">
            <div class="country-list-bg"></div>
            <div class="country-list-content">
                <h1>Tracking Coronavirus COVID-19</h1>
                <p>The first case of the new Coronavirus COVID-19 was recorded on 31 December in Wuhan, China (<a
                        href="" target="_blank">WHO</a>). Since then, 335,955 confirmed cases have been recorded
                    worldwide. This visualization shows the near real-time status based on data from the <a href=""
                        target="_blank">Center for Systems Science and Engineering (CSSE)</a> at Johns Hopkins
                    University and <a href="" target="_blank">DXY</a>. Data currently available on the following zoom
                    levels: City level - US, Canada and Australia; Province level - China; Country level - other
                    countries. </p>
            <table id="country_list" class="table table-hover">
                <tr>
                    <th></th>
                    <th>Confirmed</th>
                    <th>Death</th>
                <tr>

            </table>
   
            </div>
     </div>
        <div class="map">

         <div id="map" style="width: 100%; height: 100vh;"></div>
        </div>
        <div class="country-detail">
        <h1 id="countryName"></h1>
        <div class="country-summary">
            <div class="total-death">
                <h2 id="death"></h2>
                <p>Total Death</p>
            </div>
            <div class="total-recovered">
                <h2 id="recovered"></h2>
                <p>Total Recovered</p>
            </div>
        </div>
        <div id="donut"></div>
        <div id='summaryTable' style="margin: 2rem">
        </div>
        <div>
        <a class="btnDetail" href="detail.html" target="_blank">More Detail Data</a>
</div>
        </div>
    </div>
<?php
    
    
    function all_country_list(){
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://coronavirus-monitor.p.rapidapi.com/coronavirus/cases_by_country.php",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET",
        CURLOPT_HTTPHEADER => array(
          "x-rapidapi-host: coronavirus-monitor.p.rapidapi.com",
          "x-rapidapi-key: 7341296eb8msh5dc5fabdd040449p14cc9bjsn1ba24667d2f0"
        ),
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);

      //$response =json_decode($response);

      echo $response;
     }
    
       
    
    ?>
    
      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="js/d3.min.js"></script>





  <script src="js/c3.min.js"></script>
    <script>
        window.addEventListener('load', function () {
            let countries_data = <?php echo all_country_list(); ?> ;
            let countryName = countries_data.countries_stat;
            let countryUl = document.getElementById('country_list');
            let totalConfirmed = 0;
            let totalDeath = 0;
            let totalRecovered = 0;
            let totalActive = 0;

            countryName.forEach(function (name) {
            $('#country_list').append(`<tr style="cursor:pointer"><td><h5 onClick="javascript:CountryDetail('${name.country_name.toUpperCase()}','${name.deaths}',${name.active_cases})"><strong>${name.country_name.toUpperCase()}</strong></h5></td>
            <td><h4>${name.cases}</h4></td> <td><h4 style="color:red">${name.deaths}</h4></td></tr>`);
            totalConfirmed += parseInt(name.cases);
            totalDeath += parseInt(name.deaths);
            totalActive += parseInt(name.active_cases)
            totalRecovered += parseInt(name.total_recovered);
           
            }); document.getElementById('countryName').innerHTML = "WORLD";//+totalConfirmed;
            document.getElementById('death').innerHTML = totalDeath;
            document.getElementById('recovered').innerHTML = parseInt(totalRecovered);
            summaryChart(totalActive, totalDeath, totalRecovered, 'Global Summary')
           // console.log('yonas')
            console.log(countries_data)
        });

        function CountryDetail(countryName, death, recover, active) {
            console.log(active)
            let countryTitle = document.getElementById('countryName');
            let countryDeaths = document.getElementById('death') ;
            let countryRecovered = document.getElementById('recovered') ;

            countryTitle.textContent = countryName;
            countryDeaths.textContent = death;
            countryRecovered.textContent = recover ;

            initMap();
            summaryChart(active, death, recover, countryName );
            summaryTable(active, death, recover, countryName );
        }
    </script>

<script>
      function initMap() {
        var map = new google.maps.Map(document.getElementById('map'), {
          zoom: 5,
          center: {lat: -34.397, lng: 150.644}
        });
        var geocoder = new google.maps.Geocoder();
/*
        document.getElementById('submit').addEventListener('click', function() {
          geocodeAddress(geocoder, map);
        });
        */

        geocodeAddress(geocoder, map);
      }

      function geocodeAddress(geocoder, resultsMap) {
        var address = document.getElementById('countryName').textContent;//document.getElementById('address').value;
        geocoder.geocode({'address': address}, function(results, status) {
          if (status === 'OK') {
            resultsMap.setCenter(results[0].geometry.location);
            var marker = new google.maps.Marker({
              map: resultsMap,
              position: results[0].geometry.location
            });
          } else {
            console.log('Geocode was not successful for the following reason: ' + status);
          }
        });
      }
    </script>


    <script>
      function summaryChart(active, death, recovered,title){
console.log('yonas', active, death, recovered, title);

       
        var chart = c3.generate({
          bindto: '#donut',
    data: {
      columns: [['Active cases',active], ['Total Death', death], ['Total Recovered',recovered]],
        type : 'donut'
        
    },
    color: {
                            pattern: ['#F7A600', '#dc3545','#51AF32']
                        },
    donut: {
      label: {
                                format: function (value, ratio, id) {
                                    return value;
                                }
                            },
        title: title
    }
});



      }

      function summaryTable(active, death, recovered,title){
        let template = `<table class="table"><tr><td>Active Cases: </td><td>${active}</td></tr>
        <tr><td>Total Recovered: </td><td>${recovered}</td></tr>
        <tr><td>Total Death: </td><td>${death}</td></tr></table>`;

        document.getElementById("summaryTable").innerHTML = template;

      }
    </script>

</body>

</html>