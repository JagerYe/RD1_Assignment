export class Rainfall {
    constructor(stationId, cityName, locationName, rain = "", hour_24 = "0") {
        this._stationId = stationId;
        this._rain = rain;
        this._cityName = cityName;
        this._locationName = locationName;
        this._hour_24 = hour_24;
    }

    get hour_24() {
        return this._hour_24;
    }
    set hour_24(hour_24) {
        this._hour_24 = hour_24;
    }

    get locationName() {
        return this._locationName;
    }
    set locationName(locationName) {
        this._locationName = locationName;
    }

    get cityName() {
        return this._cityName;
    }
    set cityName(cityName) {
        this._cityName = cityName;
    }

    get rain() {
        return this._rain;
    }
    set rain(rain) {
        this._rain = rain;
    }

    get stationId() {
        return this._stationId;
    }
    set stationId(stationId) {
        this._stationId = stationId;
    }
}