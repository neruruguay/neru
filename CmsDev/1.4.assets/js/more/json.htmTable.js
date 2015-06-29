function CreateTableView(objArray, theme, enableHeader) {
    if (theme === undefined) {
        theme = "mediumTable"
    }
    if (enableHeader === undefined) {
        enableHeader = true
    }
    var array = typeof objArray != "object" ? JSON.parse(objArray) : objArray;
    var str = '<table class="' + theme + '">';
    if (enableHeader) {
        str += "<thead><tr>";
        for (var index in array[0]) {
            str += '<th scope="col">' + index + "</th>"
        }
        str += "</tr></thead>"
    }
    str += "<tbody>";
    for (var i = 0; i < array.length; i++) {
        str += (i % 2 == 0) ? '<tr class="alt">' : "<tr>";
        for (var index in array[i]) {
            str += "<td>" + array[i][index] + "</td>"
        }
        str += "</tr>"
    }
    str += "</tbody>";
    str += "</table>";
    return str
}
function CreateDetailView(objArray, theme, enableHeader) {
    if (theme === undefined) {
        theme = "mediumTable"
    }
    if (enableHeader === undefined) {
        enableHeader = true
    }
    var array = typeof objArray != "object" ? JSON.parse(objArray) : objArray;
    var str = '<table class="' + theme + '">';
    str += "<tbody>";
    for (var i = 0; i < array.length; i++) {
        var row = 0;
        for (var index in array[i]) {
            str += (row % 2 == 0) ? '<tr class="alt">' : "<tr>";
            if (enableHeader) {
                str += '<th scope="row">' + index + "</th>"
            }
            str += "<td>" + array[i][index] + "</td>";
            str += "</tr>";
            row++
        }
    }
    str += "</tbody>";
    str += "</table>";
    return str
}
;