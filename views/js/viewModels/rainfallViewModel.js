function getOneStationView(cityName, stationName, rain, hour_24) {
    return `<h2>${cityName} ${stationName}</h2>
            <img src="/RD1_Assignment/views/img/${cityName}.jpg">
            <div class="row" id="showARainfall">
                <div class="col">
                    <div>1小時累積雨量</div>
                    <div>${rain}</div>
                </div>
                <div class="col">
                    <div>24小時累積雨量</div>
                    <div>${hour_24}</div>
                </div>
            </div>`;
}