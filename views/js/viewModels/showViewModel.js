function getWeatherMenuView() {
    return `<h1>請選擇縣市及時間範圍：</h1>
            <select id="selectWeatherLocation"></select>
            <select id="selectTime">
                <option value="now">現在天氣狀況</option>
                <option value="twoDays">未來兩天</option>
                <option value="aWeek">未來一週</option>
            </select>
            <div id="funtionShow"></div>`;
}

function getRainfallMenuView() {
    return `<h1>請選擇各縣市的觀測站</h1>
            縣市：<select id="selectRainfallLocation"></select>
            <br>
            觀測站：<select id="selectStation"></select>
            <div id="funtionShow"></div>`;
}