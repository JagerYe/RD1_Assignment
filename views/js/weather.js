function weatherInit(params) {

    $("#mainShow").html(getWeatherMenuView());

    //change 監聽器
    $("#selectWeatherLocation").change(() => {
        changeWeatherSelect();
    });

    $("#selectTime").change(() => {
        changeWeatherSelect();
    });

}

function getNowWeather() {
    if ($("#selectWeatherLocation").val() == null) {
        setTimeout(getNowWeather, 10);
        return;
    }
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/weather/getCityNow?city=${$("#selectWeatherLocation").val()}`
    }).then(function (e) {
        let jsonArr = JSON.parse(e);
        $("#funtionShow").html(getOneCityTitleView(jsonArr["0"]._cityName));
        $("#showAWeather").html(getOneWeatherView(jsonArr["0"]._startTime,
            jsonArr["0"]._minT,
            jsonArr["0"]._maxT,
            jsonArr["0"]._pop)
        );
    });
}

function getTwoDaysWeather() {
    if ($("#selectWeatherLocation").val() == null) {
        setTimeout(getTwoDaysWeather, 10);
        return;
    }
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/weather/getCityTwoDays?city=${$("#selectWeatherLocation").val()}`
    }).then(function (e) {
        let jsonArr = JSON.parse(e);
        let showDate = new Array();
        let first = true;
        $("#funtionShow").html(getOneCityTitleView(jsonArr["0"]._cityName));
        for (let item of jsonArr) {
            if (!first && item._startTime.search("06:") < 0 && item._startTime.search("18:") < 0) {
                continue;
            }
            first = false;
            let number = (item._startTime.search("06:") >= 0) ? item._startTime.search("06:") : item._startTime.search("18:");
            let index = item._startTime.substring(number, number + 2);
            showDate.push({
                _startTime: item._startTime,
                _minT: item._minT,
                _maxT: item._maxT,
                _pop: item._pop,
                _uvi: item._uvi
            });
            if ((index >= 18 || index < 6) && showDate.length < 2) {
                $("#showAWeather").append(getOneDayWeatherView(showDate['0']));
                showDate = new Array();
            } else if (showDate.length >= 2) {
                $("#showAWeather").append(getOneDayWeatherView(showDate['1'], showDate['0']));
                showDate = new Array();
            }

        }

    });
}

function getAWeekWeather() {
    if ($("#selectWeatherLocation").val() == null) {
        setTimeout(getAWeekWeather, 10);
        return;
    }
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/weather/getCityAWeek?city=${$("#selectWeatherLocation").val()}`
    }).then(function (e) {
        let jsonArr = JSON.parse(e);
        let showDate = new Array();
        let first = true;
        $("#funtionShow").html(getOneCityTitleView(jsonArr["0"]._cityName));
        for (let item of jsonArr) {
            if (!first && item._startTime.search("06:") < 0 && item._startTime.search("18:") < 0) {
                continue;
            }
            first = false;
            let number = (item._startTime.search("06:") >= 0) ? item._startTime.search("06:") : item._startTime.search("18:");
            let index = item._startTime.substring(number, number + 2);
            showDate.push({
                _startTime: item._startTime,
                _minT: item._minT,
                _maxT: item._maxT,
                _pop: item._pop,
                _uvi: item._uvi
            });
            if ((index >= 18 || index < 6) && showDate.length < 2) {
                $("#showAWeather").append(getOneDayWeatherView(showDate['0']));
                showDate = new Array();
            } else if (showDate.length >= 2) {
                $("#showAWeather").append(getOneDayWeatherView(showDate['1'], showDate['0']));
                showDate = new Array();
            }

        }
    });
}

function changeWeatherSelect() {
    let updateAims;
    switch ($("#selectTime").val()) {
        case "now":
            setTimeout(getNowWeather,1);
            updateAims = "updateNowWeather";
            break;
        case "twoDays":
            setTimeout(getTwoDaysWeather,1);
            updateAims = "updateTwoDaysWeather";
            break;
        case "aWeek":
            setTimeout(getAWeekWeather,1);
            updateAims = "updateAWeekWeather";
            break;
    }
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/autoUpdate/${updateAims}?loacationName=${$("#selectWeatherLocation").val()}`
    });
}
