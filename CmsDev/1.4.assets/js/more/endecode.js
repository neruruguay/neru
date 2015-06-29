function utf8_decode(str_data) {
    var tmp_arr = [], i = 0, ac = 0, c1 = 0, c2 = 0, c3 = 0;
    str_data += "";
    while (i < str_data.length) {
        c1 = str_data.charCodeAt(i);
        if (c1 < 128) {
            tmp_arr[ac++] = String.fromCharCode(c1);
            i++
        } else {
            if (c1 > 191 && c1 < 224) {
                c2 = str_data.charCodeAt(i + 1);
                tmp_arr[ac++] = String.fromCharCode(((c1 & 31) << 6) | (c2 & 63));
                i += 2
            } else {
                c2 = str_data.charCodeAt(i + 1);
                c3 = str_data.charCodeAt(i + 2);
                tmp_arr[ac++] = String.fromCharCode(((c1 & 15) << 12) | ((c2 & 63) << 6) | (c3 & 63));
                i += 3
            }
        }
    }
    return tmp_arr.join("")
}
function utf8_encode(argString) {
    if (argString === null || typeof argString === "undefined") {
        return""
    }
    var string = (argString + "");
    var utftext = "", start, end, stringl = 0;
    start = end = 0;
    stringl = string.length;
    for (var n = 0; n < stringl; n++) {
        var c1 = string.charCodeAt(n);
        var enc = null;
        if (c1 < 128) {
            end++
        } else {
            if (c1 > 127 && c1 < 2048) {
                enc = String.fromCharCode((c1 >> 6) | 192, (c1 & 63) | 128)
            } else {
                enc = String.fromCharCode((c1 >> 12) | 224, ((c1 >> 6) & 63) | 128, (c1 & 63) | 128)
            }
        }
        if (enc !== null) {
            if (end > start) {
                utftext += string.slice(start, end)
            }
            utftext += enc;
            start = end = n + 1
        }
    }
    if (end > start) {
        utftext += string.slice(start, stringl)
    }
    return utftext
}
function base64_decode(data) {
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0, ac = 0, dec = "", tmp_arr = [];
    if (!data) {
        return data
    }
    data += "";
    do {
        h1 = b64.indexOf(data.charAt(i++));
        h2 = b64.indexOf(data.charAt(i++));
        h3 = b64.indexOf(data.charAt(i++));
        h4 = b64.indexOf(data.charAt(i++));
        bits = h1 << 18 | h2 << 12 | h3 << 6 | h4;
        o1 = bits >> 16 & 255;
        o2 = bits >> 8 & 255;
        o3 = bits & 255;
        if (h3 == 64) {
            tmp_arr[ac++] = String.fromCharCode(o1)
        } else {
            if (h4 == 64) {
                tmp_arr[ac++] = String.fromCharCode(o1, o2)
            } else {
                tmp_arr[ac++] = String.fromCharCode(o1, o2, o3)
            }
        }
    } while (i < data.length);
    dec = tmp_arr.join("");
    return dec
}
function base64_encode(data) {
    var b64 = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=";
    var o1, o2, o3, h1, h2, h3, h4, bits, i = 0, ac = 0, enc = "", tmp_arr = [];
    if (!data) {
        return data
    }
    do {
        o1 = data.charCodeAt(i++);
        o2 = data.charCodeAt(i++);
        o3 = data.charCodeAt(i++);
        bits = o1 << 16 | o2 << 8 | o3;
        h1 = bits >> 18 & 63;
        h2 = bits >> 12 & 63;
        h3 = bits >> 6 & 63;
        h4 = bits & 63;
        tmp_arr[ac++] = b64.charAt(h1) + b64.charAt(h2) + b64.charAt(h3) + b64.charAt(h4)
    } while (i < data.length);
    enc = tmp_arr.join("");
    var r = data.length % 3;
    return(r ? enc.slice(0, r - 3) : enc) + "===".slice(r || 3)
}
function urldecode(str) {
    return decodeURIComponent((str + "").replace(/\+/g, "%20"))
}
function urlencode(str) {
    str = (str + "").toString();
    return encodeURIComponent(str).replace(/!/g, "%21").replace(/'/g, "%27").replace(/\(/g, "%28").replace(/\)/g, "%29").replace(/\*/g, "%2A").replace(/%20/g, "+")
}
function admd($e) {
    return base64_decode(urldecode(utf8_decode($e))).replace(/''/g, "%3D");
}
function admd2($e) {
    return utf8_encode(urlencode(base64_encode($e)))
}
function SKTDecode($e) {
    return base64_decode(urldecode(utf8_decode($e))).replace(/''/g, "%3D");
}
function SKTEncode($e) {
    return utf8_encode(urlencode(base64_encode($e)))
}
function import_request_variables(types, prefix) {
    var i = 0, current = "", url = "", vars = "", arrayBracketPos = -1, arrName = "", win = this.window, requestObj = this.window, getObj = false, cookieObj = false;
    prefix = prefix || "";
    var that = this;
    var _ini_get = function(ini) {
        if (that.php_js && that.php_js.ini && that.php_js.ini[ini] && that.php_js.ini[ini].local_value) {
            return that.php_js.ini[ini].local_value
        }
        return false
    };
    requestObj = _ini_get("phpjs.requestVarsObj") || requestObj;
    if (/g/i.test(types)) {
        getObj = _ini_get("phpjs.getVarsObj") || getObj;
        for (i = 0, url = win.location.href, vars = url.substring(url.lastIndexOf("?") + 1, url.length).split("&"); i < vars.length; i++) {
            current = vars[i].split("=");
            current[1] = decodeURIComponent(current[1]);
            arrayBracketPos = current[0].indexOf("[");
            if (arrayBracketPos !== -1) {
                arrName = current[0].substring(0, arrayBracketPos);
                arrName = decodeURIComponent(arrName);
                if (!requestObj[prefix + arrName]) {
                    requestObj[prefix + arrName] = []
                }
                requestObj[prefix + arrName].push(current[1] || null);
                if (getObj) {
                    if (!getObj[prefix + arrName]) {
                        getObj[prefix + arrName] = []
                    }
                    getObj[prefix + arrName].push(current[1] || null)
                }
            } else {
                current[0] = decodeURIComponent(current[0]);
                requestObj[prefix + current[0]] = current[1] || null;
                if (getObj) {
                    getObj[prefix + current[0]] = current[1] || null
                }
            }
        }
    }
    if (/c/i.test(types)) {
        cookieObj = _ini_get("phpjs.cookieVarsObj") || cookieObj;
        for (i = 0, vars = win.document.cookie.split("&"); i < vars.length; i++) {
            current = vars[i].split("=");
            requestObj[prefix + current[0]] = current[1].split(";")[0] || null;
            if (cookieObj) {
                cookieObj[prefix + current[0]] = current[1].split(";")[0] || null
            }
        }
    }
}
;