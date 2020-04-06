<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Covid - 19 Tracker</title>
    <link rel="icon" 
      type="image/png" 
      href="img/favicon.png">
    <style>
    .summary{
      display: flex;
      justify-content: center;
    }
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }

      
.legend .description {
  font-weight: 600;
}
.legend .total {
  color: #DE3700;
  display: flex;
  align-items: center;
}
.infoTile .title {
  margin-bottom: 0px;
  font-size: 16px;
  line-height: 22px;
}
.infoTile{
  margin: 15px 0px;
 
  padding: 2rem 1rem;

  margin: 0 auto;
}
.infoTile .confirmed {
  font-size: 32px;
  color: #DE3700;
  font-weight: bold;
  line-height: 40px;
}
.legend {
  display: grid;
  padding-top: 16px;
  grid-template-columns: 8px auto min-content;
  align-items: center;
  grid-gap: 16px 8px;
  font-size: 13px;
  line-height: 20px;
}
.legend .color {
  width: 8px;
  height: 8px;
  border-radius: 8px;
}

th {
  position: sticky;
  top: -1px;
  background: white;
}
@media only screen and (max-width: 600px) {
.flag{display:none;}
}

#flag{
  width: 50px;
  height: 50px;;
  border-radius: 50%;
  margin-right: 15px;
}
    </style>
     <link rel="stylesheet" href="css/c3.css">
     <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

</head>
<body class="bg-light">
    <div class="container">
  <div class="py-12 text-center">
 <a href="index.html">Go back to interactive view</a>
    <h2>Covid-19 Tracker</h2>
    <div class="row">
    <div class="infoTile" >
                <h2 class="title" title="Total Confirmed Cases">Coronavirus Cases:</h2>             
                <div id="cases" class="confirmed" style="color:#aaa"></div><br>
                <h2 class="title" title="Total Confirmed Cases">Active Cases</h2> 
                <div id="active" class="confirmed" style="color: rgb(244, 195, 99)">799,419</div><br>
                <h2 class="title" title="Total Confirmed Cases">Recovered Cases</h2> 
                <div id="recovered" class="confirmed" style="color: green;">225,422</div><br>
                <h2 class="title" title="Total Confirmed Cases">Death</h2> 
                <div id="deaths" class="confirmed">58,243</div>
                
        </div>
  <div>
        

  <div class="row" style="padding-top: 15px;">
    
    <div class="col-md-12 col-sm-12 order-md-1">

             



    <input type="text" class="form-control" id="txtSearch" onkeyup="searhTable()" placeholder="Filter country" title="Type in a country name">
       <br> <table data-sticky-header="true" data-sticky-header-offset-y="60" id="country_list-table" class="table table-hover sticky-header table-striped table-bordered">
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
                    <th>Total Tests</th>
                    <th>Tests/ 1M pop</th>
                   
                <tr>

            </table>
      
    </div>
  </div>



   




</div>


<div class="modal fade" tabindex="-1" role="dialog" id="detailView" aria-labelledby="exampleModalLongTitle" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLongTitle">  <img src="" id="flag" /><h1 id="country-detail"></h1></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true" style="font-size: 47px;">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <h1 id="country-detail"><h1>
      <div class="infoTile" >
    
                <h2 class="title" title="Total Confirmed Cases">Coronavirus Cases:</h2>             
                <div id="totalCase-detail" class="confirmed" style="color:#aaa"></div><br>
                <h2 class="title" title="Total Confirmed Cases">Active Cases</h2> 
                <div id="active-detail" class="confirmed" style="color: rgb(244, 195, 99)">799,419</div><br>
                <h2 class="title" title="Total Confirmed Cases">Recovered Cases</h2> 
                <div id="recovered-detail" class="confirmed" style="color: green;">225,422</div><br>
                <h2 class="title" title="Total Confirmed Cases">Death</h2> 
                <div id="death-detail" class="confirmed">58,243</div><br>
                <h2 class="title" title="Total Confirmed Cases">New Cases</h2> 
                <div id="newCase-detail" class="confirmed"  style="color:#aaa">58,243</div><br>
                <h2 class="title" title="Total Confirmed Cases">New Death</h2> 
                <div id="newDeath-detail" class="confirmed">58,243</div><br>
                <h2 class="title" title="Total Confirmed Cases">Total Test</h2> 
                <div id="totalTest-detail" class="confirmed"  style="color:#aaa">58,243</div>
                
        </div>
            

      </div>
     
    </div>
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

      <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>




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
                
                
             

                $('#country_list-table').append(`
                <tr style="cursor:pointer">
                <td style="text-align:left; color:#337ab7"><img class="img-responsive flag" style="width: 30px; height: 30px; border-radius: 50%" src="${name.countryInfo.flag}"> 
                
                <b><a onClick="return CountryDetail('${name.countryInfo.flag}','${name.country}','${name.cases}','${name.active}','${name.recovered}','${name.deaths}','${name.todayCases}','${name.todayDeaths}','${name.tests}')">${name.country}</a></b></td>
                <td><b>${name.cases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></td>
                <td ${checkColor(name.todayCases,"c")}><b>${Number(name.todayCases)>0?"+"+name.todayCases.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","):""}</b></td>
                <td><b>${name.deaths.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></td>
                <td ${checkColor(name.todayDeaths,"d")}><b>${Number(name.todayDeaths)>0?"+"+name.todayDeaths.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ","):""}</b></td>
                <td><b>${name.recovered.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></td>
                <td><b>${name.active.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></td>
                <td><b>${name.critical.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></td>
                <td><b>${name.casesPerOneMillion ==null?"": name.casesPerOneMillion}</b></td>
                <td><b>${name.deathsPerOneMillion== null? "": name.deathsPerOneMillion}</b></td>
                <td><b>${name.tests.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",")}</b></td>
                <td><b>${name.testsPerOneMillion ==null?"": name.casesPerOneMillion}</b></td>
                
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

        function CountryDetail(flag, country, totalCase, active, recovered, death, newCase, newDeath, totalTest) {

          $('#detailView').modal('toggle');

          document.getElementById("flag").src = flag;

           
            let countryDetail = document.getElementById('country-detail');
            let totalCaseDetail = document.getElementById('totalCase-detail') ;
            let activeDetail = document.getElementById('active-detail') ;
            let recoveredDetail = document.getElementById('recovered-detail') ;
            let deathDetail = document.getElementById('death-detail') ;
            let newCaseDetail = document.getElementById('newCase-detail') ;
            let newDeathDetail = document.getElementById('newDeath-detail') ;
            let totalTestDetail = document.getElementById('totalTest-detail') ;
           
            countryDetail.textContent = country;
            totalCaseDetail.textContent = totalCase.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
            activeDetail.textContent = active.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
            recoveredDetail.textContent = recovered.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
            deathDetail.textContent = death.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
            newCaseDetail.textContent = "+"+newCase.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
            newDeathDetail.textContent = "+"+newDeath.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
            totalTestDetail.textContent = totalTest.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",") ;
          
                      

        }
        function onEachFeature(feature, layer) {
            // does this feature have a property named popupContent?
            layer.on('mouseover', function(){

            });
            if (feature.properties && feature.properties.popupContent) {
                layer.on('mouseover', function() { layer.openPopup(); });
                layer.on('mouseout', function() { layer.closePopup(); });
                layer.bindPopup(feature.properties.popupContent);
            }
        }
        

            
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