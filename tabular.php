<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid - 19 Tracker</title>
    <link rel="icon" 
      type="image/png" 
      href="img/favicon.png">
    <link href="https://fonts.googleapis.com/css2?family=Barlow&family=Roboto&display=swap" rel="stylesheet">


        <link rel="stylesheet" href="https://unpkg.com/leaflet@1.6.0/dist/leaflet.css"
  integrity="sha512-xwE/Az9zrjBIphAcBb3F6JVqxf46+CDLwfLMHloNu6KEQCAWi6HcDUbeOfBIptF7tcCzusKFjFw2yuvEpDL9wQ=="
  crossorigin=""/>


    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="css/c3.css">
    <style>
      #country {
 
  border-collapse: collapse;
  width: 100%;
}

#country_list-table td, #country_list-table th {
  border: 1px solid #ddd;
  border-collapse: collapse;
  padding: 8px;
}

#country_list-table tr:nth-child(even){background-color: #f2f2f2;}

#country_list-table tr:hover {background-color: #ddd;}

#country_list-table th {
  padding-top: 12px;
  padding-bottom: 12px;
  text-align: left;
 
 
}

#country_list-table th {
  position: sticky;
  top: -1px;
  background: white;
}
      </style>

</head>

<body>
  
    <div  class="container"><nav class="header">
        <img class="d-block mx-auto mb-4" src="img/favicon.png" alt="" width="42" height="42"><h1>COVID-19 Tracker</h1>
         </nav>
        <div class="country-list">
        
            <div class="country-list-content">
               
                <div class="infoTile info" style="width: 272px;">
                <h2 class="title" title="Total Confirmed Cases">Total Confirmed Cases</h2>
             
                <div id="cases" class="confirmed"></div>
                <div class="infoTileData">
                    <h2 class="legend">
                        <div class="color" style="background: rgb(244, 195, 99);"></div>
                        <div class="description">Active cases</div>
                        <div id="active" class="total">799,419</div>
                    </h2>
                    <h2 class="legend">
                        <div class="color" style="background: rgb(96, 187, 105);"></div>
                        <div class="description">Recovered cases</div>
                        <div id="recovered" class="total">225,422</div>
                    </h2>
                        <h2 class="legend">
                            <div class="color" style="background: #DE3700;"></div>
                            <div class="description">Fatal cases</div>
                            <div id="deaths" class="total">58,243</div>
                    </h2>
                </div>
            </div>
                    
                      <!--  <input type="text" id="txtSearch" onkeyup="searhTable()" placeholder="Filter country" title="Type in a country name">-->

                       
                      <div id="donut" class="donut-tabular"></div>
   
            </div>
     </div>
        <div class="map">
        
        <input type="text" class="form-control" id="txtSearch" onkeyup="searhTable()" placeholder="Filter country" title="Type in a country name">
       <br><ul class="view">
                    
                    <li><a id="tabular-btn" href="index.php" >Interactive view</a></li>
                </ul> <table  data-sticky-header="true" data-sticky-header-offset-y="60" id="country_list-table" class="table table-hover sticky-header table-striped table-bordered">
                <tr>
                    <th>Country, Other</th>
                    <th>Total Cases</th>
                    <th>New Cases</th>
                    <th>Total Deaths</th>
                    <th>New Deths</th>
                    <th>Total Recovered</th>
                    <th>Active Cases</th>
                    <th>Serious, Critical Cases</th>
                    <th>Tot Cases/ 1M pop</th>
                    <th>Deaths/ 1M pop</th>
                   
                <tr>

            </table>
        
        </div>
</div>
 
<?php
    
    
    function all_country_list(){
      $curl = curl_init();

      curl_setopt_array($curl, array(
        CURLOPT_URL => "https://corona.lmao.ninja/countries?sort=cases",
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_FOLLOWLOCATION => true,
        CURLOPT_ENCODING => "",
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => "GET"
        
      ));
      
      $response = curl_exec($curl);
      $err = curl_error($curl);
      
      curl_close($curl);

      //$response =json_decode($response);

      echo $response;
     }
    
     function Get_Global(){
        $curl = curl_init();
  
        curl_setopt_array($curl, array(
          CURLOPT_URL => "https://corona.lmao.ninja/all",
          CURLOPT_RETURNTRANSFER => true,
          CURLOPT_FOLLOWLOCATION => true,
          CURLOPT_ENCODING => "",
          CURLOPT_MAXREDIRS => 10,
          CURLOPT_TIMEOUT => 30,
          CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
          CURLOPT_CUSTOMREQUEST => "GET"
          
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

            let global_data = <?php echo Get_Global(); ?> ;
             document.getElementById('cases').innerHTML = global_data.cases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
             document.getElementById('deaths').innerHTML = global_data.deaths.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
             document.getElementById('recovered').innerHTML = global_data.recovered.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
             document.getElementById('active').innerHTML = global_data.active.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");


            let totalConfirmed = 0;
            let totalDeath = 0;
            let totalRecovered = 0;
            let totalActive = 0;
         
         
            let checkColor = (num,type)=>{
             if(num > 0 && type==='d'){
                 return `style="background: red; color:white;"`;
             } else if(num > 0 && type==='c'){
              return `style="background: #FFEEAA; color:black;"`;
             }

         }

            countries_data.forEach(function (name) {
                $('#country').append(`
                
                <div class="areas">
                    <div id="${name.countryInfo._id}" class="area" onClick="return CountryDetail('${name.country}', '${name.deaths}', '${name.recovered}', '${name.active}', '${name.countryInfo.lat}', '${name.countryInfo.long}')">
                
                            <div class="areaName" title="${name.country}">
                            <img src="${name.countryInfo.flag}" style="width:30px; height: 30px; border-radius: 50%;"><span>${name.country}</span></div>
                            <div class="areaTotal">
                                <div class="secondaryInfo">${name.cases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</div>
                            </div>
                
                    </div>
                </div>`);

                $('#country_list-table').append(`
                <tr style="cursor:pointer">
                <td>${name.country}</td>
                <td>${name.cases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td ${checkColor(name.todayCases,"c")}>${Number(name.todayCases)>0?"+"+name.todayCases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","):""}</td>
                <td>${name.deaths.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td ${checkColor(name.todayDeaths,"d")}>${Number(name.todayDeaths)>0?"+"+name.todayDeaths.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","):""}</td>
                <td>${name.recovered.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>${name.active.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>${name.critical.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</td>
                <td>${name.casesPerOneMillion ==null?"": name.casesPerOneMillion}</td>
                <td>${name.deathsPerOneMillion== null? "": name.deathsPerOneMillion}</td>
               
                
                </tr>`);
     
              


         //       $('#country_list').append(`<tr style="cursor:pointer"><td><img src="${name.countryInfo.flag}" style="width:30px; height: 30px; border-radius: 50%;"></td><td><span onClick="return CountryDetail('${name.country}', '${name.deaths}', '${name.recovered}', '${name.active}', '${name.countryInfo.lat}', '${name.countryInfo.long}')">${name.country}</span></td>
     //       <td>${name.cases}</td> </tr>`);

     
            //<td><h4>${name.cases}</h4></td> <td><h4 style="color:red">${name.deaths}</h4></td></tr>`);
  
            totalConfirmed += parseInt(name.cases);
            totalDeath += parseInt(name.deaths);
            totalActive += parseInt(name.active)
            totalRecovered += parseInt(name.recovered);
            });
          //  document.getElementById('countryName').innerHTML = "Global";//+totalConfirmed;
        //    document.getElementById('death').innerHTML = totalDeath;
         //   document.getElementById('recovered').innerHTML = parseInt(totalRecovered);
            summaryChart(totalActive, totalDeath, totalRecovered, 'Global Summary')
    
            
        });

      
     
      

            
    </script>
      <script>
      function summaryChart(active, death, recovered,title){


       
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
                                    return value.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
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

<script>
function searhTable() {
  var input, filter, table, tr, td, i, txtValue;
  input = document.getElementById("txtSearch");
  filter = input.value.toUpperCase();
  table = document.getElementById("country_list-table");
  tr = table.getElementsByTagName("tr");
  for (i = 0; i < tr.length; i++) {
    td = tr[i].getElementsByTagName("td")[0];
    if (td) {
      txtValue = td.textContent || td.innerText;
      if (txtValue.toUpperCase().indexOf(filter) > -1) {
        tr[i].style.display = "";
      } else {
        tr[i].style.display = "none";
      }
    }       
  }
}
</script>

</body>

</html>