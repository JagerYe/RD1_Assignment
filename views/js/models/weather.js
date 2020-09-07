export class Weather {
    constructor(
        startTime,
        cityName,
        endTime,
        wx = "",
        t = "",
        minT = "",
        maxT = "",
        aT = "",
        pop = "",
        rh = "",
        ci = "",
        wS = "",
        wD = "",
        uvi = ""
    ) {
        this._startTime = startTime;
        this._wx = wx;
        this._cityName = cityName;
        this._minT = minT;
        this._maxT = maxT;
        this._endTime = endTime;
        this._aT = aT;
        this._t = t;

        this._pop = pop;
        this._rh = rh;
        this._ci = ci;
        this._wS = wS;
        this._wD = wD;
        this._uvi = uvi;
    }

    get uvi() {
        return this._uvi;
    }
    set uvi(uvi) {
        this._uvi = uvi;
    }

    get wD() {
        return this._wD;
    }
    set wD(wD) {
        this._wD = wD;
    }

    get wS() {
        return this._wS;
    }
    set wS(wS) {
        this._wS = wS;
    }

    get ci() {
        return this._ci;
    }
    set ci(ci) {
        this._ci = ci;
    }

    get rh() {
        return this._rh;
    }
    set rh(rh) {
        this._rh = rh;
    }

    get pop() {
        return this._pop;
    }
    set pop(pop) {
        this._pop = pop;
    }

    get t() {
        return this._t;
    }
    set t(t) {
        this._t = t;
    }

    get aT() {
        return this._aT;
    }
    set aT(aT) {
        this._aT = aT;
    }

    get endTime() {
        return this._endTime;
    }
    set endTime(endTime) {
        this._endTime = endTime;
    }

    get maxT() {
        return this._maxT;
    }
    set maxT(maxT) {
        this._maxT = maxT;
    }

    get minT() {
        return this._minT;
    }
    set minT(minT) {
        this._minT = minT;
    }

    get cityName() {
        return this._cityName;
    }
    set cityName(cityName) {
        this._cityName = cityName;
    }

    get wx() {
        return this._wx;
    }
    set wx(wx) {
        this._wx = wx;
    }

    get startTime() {
        return this._startTime;
    }
    set startTime(startTime) {
        this._startTime = startTime;
    }
}