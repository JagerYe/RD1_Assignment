function weatherInit(params) {

    $("#mainShow").html(getWeatherMenuView());

    //change 監聽器
    $("#selectLocation").change(() => {
        changeWeatherSelect();
    });

    $("#selectTime").change(() => {
        changeWeatherSelect();
    });

}

function getNowWeather() {
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/weather/getCityNow?city=${$("#selectLocation").val()}`
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
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/weather/getCityTwoDays?city=${$("#selectLocation").val()}`
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
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/weather/getCityAWeek?city=${$("#selectLocation").val()}`
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
            getNowWeather();
            updateAims = "updateNowWeather";
            break;
        case "twoDays":
            getTwoDaysWeather();
            updateAims = "updateTwoDaysWeather";
            break;
        case "aWeek":
            getAWeekWeather();
            updateAims = "updateAWeekWeather";
            break;
    }
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/autoUpdate/${updateAims}?loacationName=${$("#selectLocation").val()}`
    });
}
