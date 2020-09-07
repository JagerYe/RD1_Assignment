function getOneWeatherView(startTime, minT, maxT, pop) {
    return `<div class="col border border-secondary">
                <h5>${getTimeStr(startTime)}</h5>
                <p>${minT} - ${maxT} °C</p>
                <p>${pop} %</p>
            </div>`;
}

function getOneDayWeatherView(showDate1, showDate2 = null) {
    if (showDate2 === null) {
        return `<div class="border">
                    <div class="weatherDayHeight">
                        <h5></h5>
                        <p></p>
                        <p></p>
                    </div>
                    <hr>
                    <div class="weatherDayHeight gray">
                        <h5>${getTimeStr(showDate1._startTime)}</h5>
                        <p>${showDate1._minT} - ${showDate1._maxT} °C</p>
                        <p>${showDate1._pop} %</p>
                    </div>
                    <hr>
                    <h5>紫外線指數：夜深了</h5>
                </div>`;
    }
    return `<div class="border">
                <div class="weatherDayHeight">
                    <h5>${getTimeStr(showDate2._startTime)}</h5>
                    <p>${showDate2._minT} - ${showDate2._maxT} °C</p>
                    <p>${showDate2._pop} %</p>
                </div>
                <hr>
                <div class="weatherDayHeight gray">
                    <h5>${getTimeStr(showDate1._startTime)}</h5>
                    <p>${showDate1._minT} - ${showDate1._maxT} °C</p>
                    <p>${showDate1._pop} %</p>
                </div>
                <hr>
                <h5>紫外線指數：${(showDate2._uvi) ? showDate2._uvi : showDate1._uvi}</h5>
            </div>`;
}

function getOneCityTitleView(cityName) {
    return `<h2>${cityName}</h2>
            <img src="/RD1_Assignment/views/img/city/${cityName}.jpg">
            <div class="row" id="showAWeather"></div>`;
}

function getTimeStr(time) {
    let strArr = time.split(" ");
    if (strArr["1"] >= "06:00:00" && strArr["1"] < "18:00:00") {
        return strArr["0"] + "白天";
    } else {
        return strArr["0"] + "晚上";
    }
    // if(time)
}