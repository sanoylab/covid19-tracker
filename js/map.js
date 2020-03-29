var mapboxAccessToken = "pk.eyJ1IjoiZXhwZXJ0c2Fub3kiLCJhIjoiY2s4OWNwZXkzMDVuZDNldnU3Y3N0N3IxcyJ9.B28AhJkQznwv8poyiLqz3A";
var map = L.map('mapid').setView([37.8, -96], 4);

L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=' + mapboxAccessToken, {
    id: 'mapbox/light-v9',
  
    tileSize: 512,
    zoomOffset: -1
}).addTo(map);

L.geoJson(statesData).addTo(map);

