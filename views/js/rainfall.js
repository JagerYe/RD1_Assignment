function rainfallInit() {
    $("#mainShow").html(getRainfallMenuView());

    //各式change事件
    $("#selectRainfallLocation").change(() => {
        getStation();
        $("#selectStation").empty();//這須事先清除，否則會誤抓上一個縣市
        getRainfall();
    });

    $("#selectStation").change(() => {
        getRainfall();
    });
}

//抓取觀測站
function getStation() {
    // 等待city抓取成功
    let location = $("#selectRainfallLocation").val();
    if (location == null) {
        setTimeout(getStation, 10);
        return;
    }

    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/rainfall/getCityObservatory?stationName=${location}`
    }).then(function (e) {
        $("#selectStation").empty();
        let jsonArr = JSON.parse(e);
        for (let item of jsonArr) {
            $("#selectStation").append(`<option value="${item._stationId}">${item._locationName}</option>`);
        }

    });
}

//抓取該觀測站資料
function getRainfall() {
    let id = $("#selectStation").val();
    if (id == null) {
        setTimeout(getRainfall, 10);
        return;
    }

    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/rainfall/getOne?id=${id}`
    }).then(function (e) {
        let jsonObj = JSON.parse(e);
        $("#funtionShow").html(getOneStationView(
            jsonObj._cityName,
            jsonObj._locationName,
            jsonObj._rain,
            jsonObj._hour_24
        ));

        doUpdateDB(jsonObj._locationName);
    });
}

function doUpdateDB(locationName) {
    $.ajax({
        type: "GET",
        url: `/RD1_Assignment/autoUpdate/updateRainfall?loacationName=${locationName}`
    });
}