var QUOTE_CALLBACK_REPLACE_STRING="_so_callback_quote",EQUAL_CALLBACK_REPLACE_STRING="_so_callback_equal",QUOTE_REPLACE_STRING="_so_quote",EQUAL_REPLACE_STRING="_so_equal",LIST_REPLACE_STRING="_so_list",QUOTE_LIST_REPLACE_STRING="_so_replace_quote_list",CF_EQUAL_REPLACE_STRING="_so_cf_equal",CF_QUOTE_REPLACE_STRING="_so_cf_quote",CF_LIST_REPLACE_STRING="_so_cf_list",CR_EQUAL_REPLACE_STRING="_so_cr_equal",CR_QUOTE_REPLACE_STRING="_so_cr_quote",CR_LIST_REPLACE_STRING="_so_cr_list",PLUS_MONTHLY_PLAN_AMOUNT=
"5",PLUS_YEARLY_PLAN_AMOUNT="50",PREMIUM_MONTHLY_PLAN_AMOUNT="9",PREMIUM_YEARLY_PLAN_AMOUNT="90",PROFESSIONAL_MONTHLY_PLAN_AMOUNT="19",PROFESSIONAL_YEARLY_PLAN_AMOUNT="190",WORKGROUP_MONTHLY_PLAN_AMOUNT="29",WORKGROUP_YEARLY_PLAN_AMOUNT="290",ENTERPRISE_MONTHLY_PLAN_AMOUNT="49",ENTERPRISE_YEARLY_PLAN_AMOUNT="490",MEETME_MONTHLY_AMOUNT="7",MEETME_YEARLY_AMOUNT="70",SPECIAL_STARTER="0",BASIC="1",TRIAL_PLUS="2",TRIAL_PREMIUM="3",TRIAL_PROFESSIONAL="26",TRIAL_WORKGROUP="27",TRIAL_ENTERPRISE="28",PLUS_Y=
"4",PREMIUM_Y="5",PROFESSIONAL_Y="6",WORKGROUP_Y="7",ENTERPRISE_Y="8",PLUS_M="14",PREMIUM_M="15",PROFESSIONAL_M="16",WORKGROUP_M="17",ENTERPRISE_M="18",MAX_MEETME_PAGES="10",MAX_BOOKNOW_PAGES="5",MAX_SERVICE_PAGES="50",scrollX=0,scrollY=0,elementToSetFocus=null,showCancelConnectionAttemptButton=!1,ie8Supported,isFirefox=document.getElementById&&!document.all,and="&",_gaq=_gaq||[];_gaq.push(["_setAccount","UA-3307458-1"]);var domain=window.location.hostname,pushToAnalytics=!1;
-1<domain.indexOf("scheduleonce")?(domain="scheduleonce.com",pushToAnalytics=!0):-1<domain.indexOf("meetme")?(domain="meetme.so",pushToAnalytics=!0):-1<domain.indexOf("booknow")&&(domain="booknow",pushToAnalytics=!0);_gaq.push(["_setDomainName",domain]);_gaq.push(["_setAllowLinker",!0]);/*function AnalyticsTracker(b){pushToAnalytics&&AnalyticsTrackerGo(b)}function AnalyticsTrackerGo(b){b=isQA?"/QA"+b:b;_gaq.push(["_trackPageview",b])}function CampaignTracker(b){}*/
/*function CampaignTrackerGo(b) {
    var c = readCookie("SO_src");
    c && (b = c + "/" + b, b = isQA ? "QA/" + b : b, _gaq.push(["t2._trackPageview", b]))
}*/

function disableSelection(b) {
    "undefined" != typeof b.onselectstart ? b.onselectstart = function() {
        return !1
    } : "undefined" != typeof b.style.MozUserSelect ? b.style.MozUserSelect = "none" : b.onmousedown = function() {
        return !1
    };
    b.style.cursor = "default"
}

function SelectAll(b) {
    b.focus();
    b.select()
}

function getElementHTML(b) {
    var c = document.createElement("div");
    c.appendChild(b);
    return c.innerHTML
}

function isFunction(b) {
    var c = !1;
    b && (c = typeof b == typeof Function);
    return c
}
var lastWinSize, ignoreSizeChangeOnce = !1;

function DetectSizeChange() {
    var b = GetWinSize();
    if (null == lastWinSize) lastWinSize = b;
    else if (lastWinSize[0] != b[0] || lastWinSize[1] != b[1])
        if (ignoreSizeChangeOnce) ignoreSizeChangeOnce = !1;
        else if (window.SizeChangedEvent) {
        window.SizeChangedEvent();
        var c = document.getElementById("RateThisPageOpaqueDiv");
        c || (c = document.getElementById("OpaqueDivConfirmDiv"));
        if (c && null != currentPopupId) {
            CenterDiv(currentPopupId, !0);
            var d = GetWinNetSize();
            c.style.width = d[0] + "px";
            c.style.height = d[1] - 2 + "px"
        }
    }
    lastWinSize = b;
    window.setTimeout(function() {
            DetectSizeChange()
        },
        200)
}

function GetWinSize() {
    var b = [0, 0];
    "number" == typeof window.innerWidth ? (b[0] = window.innerWidth, b[1] = window.innerHeight) : document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight) ? (b[0] = document.documentElement.clientWidth, b[1] = document.documentElement.clientHeight) : document.body && (document.body.clientWidth || document.body.clientHeight) && (b[0] = document.body.clientWidth, b[1] = document.body.clientHeight);
    return b
}

function getSize(b) {
    var c = curheight = 0,
        c = b.offsetWidth;
    curheight = b.offsetHeight;
    return [c, curheight]
}

function GetWinNetSize() {
    var b, c = [],
        d = navigator.userAgent;
    c[0] = 0;
    c[1] = 0;
    0 <= (b = d.indexOf("MSIE")) ? (c[0] = document.documentElement.offsetWidth - 1, c[1] = document.getElementsByTagName("body")[0].scrollHeight, b = parseFloat(d.substr(b + 4)), 7 < b && 10 > b && (c[0] -= 20), 10 <= b && (c[1] -= 4, c[0] = document.documentElement.scrollWidth - 4)) : 0 <= d.indexOf("Firefox") ? (c[0] = window.document.body.offsetWidth, c[1] = window.innerHeight + window.scrollMaxY) : (0 <= d.indexOf("Chrome") ? c[0] = document.body.clientWidth : 0 <= d.indexOf("Safari") ? c[0] =
        document.body.clientWidth : c[0] = window.document.body.offsetWidth, c[1] = document.documentElement.scrollHeight);
    return c
}

function getDocHeight() {
    var b = document;
    return Math.max(Math.max(b.body.scrollHeight, b.documentElement.scrollHeight), Math.max(b.body.offsetHeight, b.documentElement.offsetHeight), Math.max(b.body.clientHeight, b.documentElement.clientHeight))
}

function getDocWidth() {
    var b = document;
    return Math.max(Math.max(b.body.scrollWidth, b.documentElement.scrollWidth), Math.max(b.body.offsetWidth, b.documentElement.offsetWidth), Math.max(b.body.clientWidth, b.documentElement.clientWidth))
}

function CenterDiv(b, c, d, e) {
    b = document.getElementById(b);
    if (null != b) {
        c = getSize(b);
        GetWinNetSize();
        if (-1 != navigator.appVersion.indexOf("MSIE 7.") || -1 != navigator.appVersion.indexOf("MSIE 8.")) {
            e = document.documentElement.clientHeight;
            d = document.documentElement.clientWidth;
            var f = document.documentElement.scrollTop
        } else e = window.innerHeight, d = window.innerWidth, f = window.pageYOffset;
        e = (e - c[1]) / 2 + f;
        b.style.left = (d - c[0]) / 2 + "px";
        b.style.top = e + "px";
        browser.isIE && 10 < browser.version && (c = f_clientHeight() / 2, e > c &&
            (b.style.top = c + "px"))
    }
}

function f_clientWidth() {
    return f_filterResults(window.innerWidth ? window.innerWidth : 0, document.documentElement ? document.documentElement.clientWidth : 0, document.body ? document.body.clientWidth : 0)
}

function f_clientHeight() {
    return f_filterResults(window.innerHeight ? window.innerHeight : 0, document.documentElement ? document.documentElement.clientHeight : 0, document.body ? document.body.clientHeight : 0)
}

function f_scrollLeft() {
    return f_filterResults(window.pageXOffset ? window.pageXOffset : 0, document.documentElement ? document.documentElement.scrollLeft : 0, document.body ? document.body.scrollLeft : 0)
}

function f_scrollTop() {
    return f_filterResults(window.pageYOffset ? window.pageYOffset : 0, document.documentElement ? document.documentElement.scrollTop : 0, document.body ? document.body.scrollTop : 0)
}

function f_filterResults(b, c, d) {
    b = b ? b : 0;
    c && (!b || b > c) && (b = c);
    return d && (!b || b > d) ? d : b
}

function findPos(b) {
    var c = curtop = 0;
    if (b && b.offsetParent)
        for (c = b.offsetLeft, curtop = b.offsetTop; b = b.offsetParent;) c += b.offsetLeft, curtop += b.offsetTop;
    return [c, curtop]
}

function createCookie(b, c, d) {
    d || (d = 730);
    var e = new Date;
    e.setTime(e.getTime() + 864E5 * d);
    d = "; expires=" + e.toGMTString();
    document.cookie = b + "=" + c + d + "; path=/"
}

function readCookie(b) {
    b += "=";
    for (var c = document.cookie.split(";"), d = 0; d < c.length; d++) {
        for (var e = c[d];
            " " == e.charAt(0);) e = e.substring(1, e.length);
        if (0 == e.indexOf(b)) return e.substring(b.length, e.length)
    }
    return null
}

function eraseCookie(b) {
    createCookie(b, "", -1)
}

function HideDiv(b, c, d) {
    var e = window;
    isNotEmpty(d) && (e = d);
    d = e.document.getElementById(b);
    var f = null;
    try {
        f = e.parent.document
    } catch (g) {}!d && f && (d = f.getElementById(b));
    b = !0;
    null != c && (b = c);
    null != d && (d.style.visibility = "hidden", b && (d.style.display = "none"))
}

function HideDivElement(b, c) {
    var d = !0;
    null != c && (d = c);
    null != b && (b.style.visibility = "hidden", d && (b.style.display = "none"))
}

function ShowDiv(b, c, d, e) {
    var f = window;
    isNotEmpty(d) && (f = d);
    d = f.document.getElementById(b);
    !d && f.parent.document && (d = f.parent.document.getElementById(b));
    b = !0;
    null != c && (b = c);
    null != d && (d.style.visibility = "visible", d.style.display = b ? "block" : e ? "inline-block" : "")
}

function ShowDivElement(b, c) {
    var d = !0;
    null != c && (d = c);
    null != b && (b.style.visibility = "visible", b.style.display = d ? "block" : "")
}

function IsVisible(b, c) {
    var d = window;
    c && (d = c);
    d = d.document.getElementById(b);
    return null != d && "visible" == d.style.visibility ? !0 : !1
}

function ClearDiv(b) {
    b = document.getElementById(b);
    null != b && (b.innerHTML = "")
}

function Contains(b, c) {
    for (var d = b.length, e = 0; e < d; e++)
        if (b[e] == c) return !0;
    return !1
}

function IsValInArray(b, c) {
    for (var d = b.length, e = 0; e < d; e++)
        if (b[e] == c) return !0;
    return !1
}

function CleanList(b) {
    if (null != b.options)
        if (isFirefox) b.options.length = 0;
        else
            for (var c = b.options.length - 1; 0 <= c; c--) null != b.options[c] && b.removeChild(b.options[c])
}

function GetComboValue(b) {
    var c = null;
    b = document.getElementById(b);
    null != b && (c = b.options[b.selectedIndex].value);
    return c
}

function SetComboByValue(b, c, d) {
    var e = window;
    d && (e = d);
    b = e.document.getElementById(b);
    if (null != b)
        for (d = b.options.length, e = 0; e < d; e++)
            if (b.options[e].value == c) {
                isFirefox && (b.options[e].selected = !0);
                b.options[e].setAttribute("selected", "selected");
                b.selectedIndex = e;
                break
            }
}

function SetElementHTML(b, c) {
    var d = document.getElementById(b);
    null != d && (d.innerHTML = c)
}

function cloneArray(b) {
    for (var c = [], d = b.length, e = 0; e < d; e++) c[e] = b[e].constructor == Array ? cloneArray(b[e]) : b[e];
    return c
}

function Browser() {
    var b, c, d;
    this.isOpera = this.isChrome = this.isSafari = this.isFF = this.isNS = this.isIE = !1;
    this.version = null;
    this.isCSS3 = !1;
    b = navigator.userAgent;
    c = "MSIE";
    0 <= (d = b.indexOf(c)) ? (this.isIE = !0, this.version = parseFloat(b.substr(d + c.length)), "9" <= this.version && (this.isCSS3 = !0)) : (c = "rv:", 0 <= b.indexOf("Trident") && 0 <= (d = b.indexOf(c)) ? (this.isIE = !0, this.version = parseFloat(b.substr(d + c.length)), "9" <= this.version && (this.isCSS3 = !0)) : (c = "Firefox", 0 <= (d = b.indexOf(c)) ? (this.isFF = this.isNS = !0, this.version =
        parseFloat(b.substr(d + c.length + 1)), "3" <= this.version && (this.isCSS3 = !0)) : (c = "chrome", 0 <= (d = b.toLowerCase().indexOf(c)) ? (this.isChrome = !0, this.version = parseFloat(b.substr(d + c.length + 1)), "4" <= this.version && (this.isCSS3 = !0)) : 0 <= b.indexOf("Safari") ? (this.isSafari = !0, this.version = b, "5" <= this.version && (this.isCSS3 = !0)) : (c = "Netscape6/", 0 <= (d = b.indexOf(c)) ? (this.isNS = !0, this.version = parseFloat(b.substr(d + c.length))) : 0 <= b.indexOf("Gecko") ? this.isCSS3 = this.isNS = !0 : 0 <= b.indexOf("Opera") && (this.isOpera = !0, d = b.indexOf("Version"),
        this.version = parseFloat(b.substr(d + 7 + 1)), "10" <= this.version && (this.isCSS3 = !0))))))
}
var browser = new Browser,
    boolRefresh = !1;

function ShowMainData(b) {
    b ? isConnectionCalled || (boolRefresh = !1, HideDiv("LoadingDiv"), ShowDiv("MainDataDiv")) : (boolRefresh = !1, HideDiv("LoadingDiv"), ShowDiv("MainDataDiv"));
    showCancelConnectionAttemptButton = !1;
    HideDiv("CancelConnectionAttempt");
    (scrollX || scrollY) && window.scrollBy(scrollX, scrollY)
}

function StringBuilder(b) {
    this.strings = [""];
    this.append(b)
}
StringBuilder.prototype.append = function(b) {
    b && this.strings.push(b)
};
StringBuilder.prototype.clear = function() {
    this.strings.length = 1
};
StringBuilder.prototype.toString = function() {
    return this.strings.join("")
};
String.prototype.wordWrap = function(b, c, d) {
    var e, f, g, k = this.split("\n");
    if (0 < b)
        for (e in k) {
            g = k[e];
            for (k[e] = ""; g.length > b; f = d ? b : (f = g.substr(0, b).match(/\S*$/)).input.length - f[0].length || b, k[e] += g.substr(0, f) + ((g = g.substr(f)).length ? c : ""));
            k[e] += g
        }
    return k.join("\n")
};

function splitToRowsByChars(b, c, d) {
    for (var e = "", e = b.substr(0, c) + "<br />"; c < b.length;) e += b.substr(c, d) + "<br />", c += d;
    return e.substr(0, e.length - 6)
}

function SpliteToRows(b, c) {
    return b.wordWrap(c, "<br/>", !1)
}

function removeOpeningTag(b) {
    b && (b = b.replace(RegExp("<br>", "g"), "@@@br@@@").replace(RegExp("<br/>", "g"), "@@@br@@@").replace(RegExp("<br />", "g"), "@@@br@@@").replace(RegExp("<BR/>", "g"), "@@@br@@@").replace(RegExp("<BR />", "g"), "@@@br@@@"), b = b.replace(/</g, "&lt;"), b = b.replace(RegExp("@@@br@@@", "g"), "<br/>"));
    return b
}

function htmlEncodeText(b, c) {
    b && (c && (b = b.replace(/\r/g, "").replace(/\n/g, "")), b = b.replace(/\\/g, "&#92;").replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&apos;").replace(/</g, "&lt;").replace(/>/g, "&gt;"));
    return b
}

function htmlDecodeTextWOlt(b) {
    b && (b = b.replace(/&amp;/g, "&").replace(/&quot;/g, '"').replace(/&apos;/g, "'").replace(/&gt;/g, ">").replace(/&#92;/g, "\\").replace(/&#92;/g, "\\"));
    return b
}

function encodeAposte(b) {
    b && (b = b.replace(/'/g, "&apos;"));
    return b
}

function deocdeForBackSlash(b) {
    b && (b = b.replace(/&amp;#92;/g, "&#92;"));
    return b
}

function htmlDecodeText(b, c) {
    b && (b = c ? b.replace(/&quot;/g, '"').replace(/&apos;/g, "'").replace(/&gt;/g, ">").replace(/&amp;/g, "&").replace(/&#92;/g, "\\") : b.replace(/&quot;/g, '"').replace(/&apos;/g, "'").replace(/&lt;/g, "<").replace(/&gt;/g, ">").replace(/&amp;/g, "&").replace(/&#92;/g, "\\"));
    return b
}

function cleanForHTML(b) {
    b && (b = b.replace(/&#92;/g, "\\").replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&apos;").replace(/</g, "&lt;").replace(/>/g, "&gt;"));
    return b
}

function cleanBackslash(b) {
    b && (b = b.replace(/&#92;/g, "\\").replace(/&amp;#92;/g, "\\"));
    return b
}
"function" !== typeof String.prototype.trim && (String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "")
});

function GetAttachmentName(b) {
    if (b)
        if (b = b.split("."), 2 == b.length) b = b[0].substring(0, b[0].indexOf("_CA")).replace(/___/g, " ") + "." + b[1];
        else {
            for (var c = "", d = b.length - 1, e = 0; e < d; e++) {
                var f = b[e].indexOf("_CA"),
                    c = 0 < f ? c + b[e].substring(0, f).replace(/___/g, " ") : c + b[e].replace(/___/g, " ");
                e < d - 1 && (c += ".")
            }
            b = c + "." + b[d]
        }
    return htmlDecodeText(b)
}

function CutStringToSize(b, c, d) {
    null == d && (d = !1);
    var e = b;
    b && 3 < c && (b.length > c ? (e = b.substring(0, c - 3).trim() + "...", e = e.replace(RegExp("br/", "g"), "<br/>"), e = removeOpeningTag(e), d && (b = CleanText(htmlDecodeText(b)).replace(RegExp("br/", "g"), "&#13;"), e = '<span title="' + b + '">' + e + "</span>")) : e = removeOpeningTag(e));
    return e
}

function GetAlertHieght(b, c) {
    null == c && (c = 240);
    b = b.replace(RegExp("<br />", "g"), "<br/>");
    var d = b.split("<br/>").length;
    return c + (1 < d ? 20 * d : 0)
}

function SplitStringToSize(b, c) {
    for (var d = "", e = b.length, f = 0; f < e; f += c) d += b.substring(f, f + c) + " ";
    return d
}

function CutStringAtChar(b, c) {
    var d = b.indexOf(c);
    return -1 == d ? b : b.substring(0, d)
}

function cleanExtraLineBreak(b) {
    if (b)
        for (;
            "line_break_placeHolder" == b.substring(b.length - 1, b.length);) b = b.substring(0, b.length - 1);
    return b
}

function fixeLineBreakFromPlaceHolder(b) {
    b && (b = b.replace(RegExp("<br/>", "g"), "line_break_placeHolder").replace(/\r/g, "line_break_placeHolder").replace(/\n/g, "line_break_placeHolder").replace(/\r\n/g, "line_break_placeHolder"));
    return b
}

function replaceLineBreakFromMessage(b) {
    b && (b = b.replace(/line_break_placeHolder/g, "<br/>"));
    return b
}

function replaceLineBreakToHTML(b) {
    b && (b = b.replace(/line_break_placeHolder/g, "<br/>"));
    return b
}

function replaceLineBreakToTextArea(b) {
    b && (b = b.replace(/line_break_placeHolder/g, "\n"));
    return b
}

function ShowLineBreakInHTML(b) {
    b && (b = b.replace(/\n/g, "<br/>"));
    return b
}

function ShowLineBreakInTextArea(b) {
    b && (b = b.replace(/<br\/>/g, "\n"));
    return b
}

function CleanForEmail(b) {
    b && (b = CleanText(b).replace(":", "").replace("*", "").replace("%", "").replace("+", "").replace("$", "").replace("&", "").replace("#", "").replace("?", "").replace(",", "").replace("!", "").replace("(", "").replace(")", "").replace("[", "").replace("]", "").replace("@", "").replace(";", ""));
    return b
}

function CleanText(b) {
    b && (b = b.replace(/&#92;/g, "").replace(/&/g, "").replace(/"/g, "").replace(/'/g, "").replace(/</g, "").replace(/>/g, "").replace(/\\/g, "").replace("`", "").replace("\ufffd", ""));
    return b
}

function CleanForLabel(b) {
    b && (b = b.replace(/</g, "").replace(/>/g, ""));
    return b
}

function CleanTextMessage(b) {
    b = b.replace(/"/g, "&quot;");
    return b = b.replace(/&apos;/g, "\\'")
}

function CleanTextMessageInp(b) {
    return b.replace(/&apos;/g, "'")
}

function GetHTMLValue(b) {
    var c = b;
    return c = browser.isIE && "8" == browser.version ? replaceLineBreakToHTML(htmlDecodeText(b)) : replaceLineBreakToHTML(cleanForHTML(htmlDecodeText(b)))
}

function InsertText(b, c, d, e) {
    var f = window;
    d && (f = d);
    if ((b = f.document.getElementById(b)) && c)
        for (b.innerHTML = "", c = -1 < c.indexOf("<br/>") ? c.split("<br/>") : c.split("\n"), d = c.length, f = 0; f < d; f++) {
            if (e)
                for (var g = c[f].split(" "), k = g.length, l = 0; l < k; l++)
                    if (-1 < g[l].indexOf("http://")) {
                        var n = document.createElement("a");
                        n.href = g[l];
                        n.target = "_blank";
                        var p = document.createTextNode(g[l].slice(7));
                        n.appendChild(p);
                        b.appendChild(n);
                        b.appendChild(document.createTextNode(" "))
                    } else -1 < g[l].indexOf("https://") ? (n = document.createElement("a"),
                        n.target = "_blank", n.href = g[l], p = document.createTextNode(g[l].slice(8)), n.appendChild(p), b.appendChild(n), b.appendChild(document.createTextNode(" "))) : -1 < g[l].indexOf("www.") && -1 < g[l].indexOf(".com") ? (n = document.createElement("a"), n.target = "_blank", n.href = "http://" + g[l], p = document.createTextNode(g[l]), n.appendChild(p), b.appendChild(n), b.appendChild(document.createTextNode(" "))) : (n = document.createTextNode(g[l] + " "), b.appendChild(n));
            else n = document.createTextNode(c[f]), b.appendChild(n);
            1 < d && (g = document.createElement("br"),
                b.appendChild(g))
        }
}

function InsertHTML(b, c) {
    var d = document.getElementById(b);
    d && (d.innerHTML = c ? c : "")
}

function removeExtraSpaces(b) {
    b && (b = b.trim(), b = b.replace(/\s+/g, " "));
    return b
}

function CloseAlertDiv(b) {
    var c = document.getElementById("AlertDiv" + b);
    c.parentNode.removeChild(c);
    AlertClosedByUser(b)
}

function ShowAlertDiv(b, c, d) {
    if (null == document.getElementById("AlertDiv" + d)) {
        var e = new StringBuilder('<div id="AlertDiv' + d + '" style="margin-bottom:10px;"><div style="font-size:1px;line-height:2px;height:10px"></div> <div class="Alert" >\r\n');
        e.append('<br/> <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">\r\n');
        e.append("   <tr>\r\n");
        e.append('       <td style="width: 2%"> &nbsp;</td>\r\n');
        e.append('       <td style="font-size: 14px;">\r\n');
        e.append('           <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">\r\n');
        e.append("               <tr>\r\n");
        e.append('                   <td style="height: 10px;" id="AlertHeader">\r\n');
        e.append("                       <b>" + b + "</b>\r\n");
        e.append("                   </td>\r\n");
        e.append('                   <td style="width:1%;height: 5px;text-allign:right;position:relative;left:6px;top:2px" align="right">\r\n');
        e.append('                       <span onclick="javascript:CloseAlertDiv(' + d + ')" style="cursor:pointer;">X</span>\r\n');
        e.append("                   </td>\r\n");
        e.append("               </tr>\r\n");
        e.append('               <tr><td style="height: 10px;"></td></tr>\r\n');
        e.append("               <tr>\r\n");
        e.append('                   <td style="height: 15px;" id="AlertFooter">' + c + "</td>\r\n");
        e.append("               </tr>\r\n");
        e.append("               <tr>\r\n");
        e.append('                   <td colspan="100" align="right"><a class="operation" href="javascript:CloseAlertDiv(' + d + ')">Dismiss this message</a></td>\r\n');
        e.append("               </tr>\r\n");
        e.append("           </table>\r\n");
        e.append("       </td>\r\n");
        e.append('       <td style="width: 2%">&nbsp;</td>\r\n');
        e.append("   </tr>\r\n");
        e.append("</table>\r\n");
        e.append("<br/> </div></div>\r\n");
        b = document.getElementById("alertTD");
        c = b.innerHTML;
        b.innerHTML = "";
        b.innerHTML = c + e.toString()
    }
}

function GetTimeStringByPrefrecesByDate(b, c, d) {
    return b.formatDate("h:mma")
}

function GetTimeStringByPrefrecesByHourMinute(b, c, d, e) {
    null == e && (e = !1);
    var f = "",
        f = 30,
        f = null != d ? d.userTimeFormat : userTimeFormat;
    30 != f || e ? f = b + ":" + (10 > c ? "0" : "") + c : (d = "am", 12 <= b && (d = "pm", b -= 12), 0 == b && (b = 12), f = b + ":" + (10 > c ? "0" : "") + c + " " + d);
    return f
}

function loadJS(b) {
    window.setTimeout(function() {
        loadJSGo(b)
    }, 0)
}

function loadJSGo(b) {
    var c = document.getElementsByTagName("head").item(0),
        d = document.createElement("script");
    d.setAttribute("type", "text/javascript");
    d.setAttribute("src", b);
    d.setAttribute("defer", "true");
    d.async = !0;
    c.appendChild(d)
}

function CreateNewDateFromMiliInUTC(b) {
    return new Date(b)
}
var currentPopupId = null;

function OpenPopup(b, c, d, e, f) {
    currentPopupId = b;
    var g;
    g = document.getElementById("tzConfirmCloseB");
    "undefined" != typeof textColor && (g.style.color = "#" + textColor);
    "undefined" != typeof buttonColor && (g.style.background = "#" + buttonColor);
    f && null != f && (g.value = f);
    if (isFirefox) opDiv = document.createElement("div"), c || getDocWidth(), g = getDocHeight(), opDiv.style.cssText = "background-color:black;position:fixed;left:0px;top:0px;bottom:0px;right:0px;z-index:29990;";
    else {
        var k = GetWinNetSize();
        opDiv = document.createElement("iframe");
        f = c ? c + 96 : k[0];
        g = d ? d + 4 : k[1];
        browser.isIE && 8 == browser.version && (f = c ? c + 100 : k[0], g = d ? d - 28 : k[1] + 10);
        opDiv.style.cssText = "background-color:black;position:absolute;left:0px;top:0px;z-index:29990;width:" + f + "px;height:" + g + "px;"
    }
    opDiv.id = "RateThisPageOpaqueDiv";
    opDiv.className = "opaque";
    document.getElementById("PopUpDivContainer").appendChild(opDiv);
    isFirefox || opDiv.contentWindow.document.writeln('<body style="background-color:Black;"></body>');
    d || e ? browser.isIE ? CenterDiv(b, !0, g, e) : CenterDiv(b, !0, null, e) : CenterDiv(b, !0);
    ShowDiv(b)
}

function HideLoading() {
    showCancelConnectionAttemptButton = !1;
    HideDiv("LoadingDiv");
    HideDiv("CancelConnectionAttempt");
    ShowDiv("MainDataDiv")
}

function days_between(b, c) {
    b.setHours(0, 0, 0, 0);
    c.setHours(0, 0, 0, 0);
    var d = b.getTime(),
        e = c.getTime(),
        d = Math.abs(d - e);
    return Math.round(d / 864E5)
}

function days_between1(b, c) {
    b.setHours(0, 0, 0, 0);
    c.setHours(0, 0, 0, 0);
    var d = b.getTime(),
        e = c.getTime();
    return Math.round((d - e) / 864E5)
}

function days_Diff(b, c) {
    var d = b.split("-"),
        e = c.split("-"),
        e = new Date(e[2], e[1] - 1, e[0]),
        d = (new Date(d[2], d[1] - 1, d[0])).getTime(),
        e = e.getTime(),
        d = Math.abs(d - e);
    return Math.round(d / 864E5)
}

function hideText(b, c) {
    b.value == c && (b.value = "");
    b.style.color = ""
}

function showText(b, c) {
    "" == b.value && (b.value = c);
    b.value == c && (b.style.color = "#bbb")
}

function showValue(b, c) {
    c && (document.getElementById(b).value = htmlDecodeText(c.toString()))
}

function showLink(b, c) {
    if (c) {
        var d = document.getElementById(b);
        d.style.display = "inline";
        d.href = c
    }
}

function minuteConvert(b) {
    return 60 > b ? b.toString() + " min" : 60 <= b && 1440 >= b ? (b / 60).toString() + " hr" + (60 == b ? "" : "s") : 2880 == b ? "2 days" : 4320 == b ? "3 days" : 5760 == b ? "4 days" : 7200 == b ? "5 days" : 10080 == b ? "7 days" : "10 min"
}

function normalizeText(b) {
    b = htmlDecodeText(b);
    if ("undefined" != typeof b) {
        var c = b.split("\n"),
            d = b.split("line_break_placeHolder");
        1 < c.length ? b = c[0] + "..." : 1 < d.length && (b = d[0] + "...");
        b = CutStringToSize(b, 70, !1)
    }
    return b
}
var IsError = !1;

function IsGoogleConnectionDisconnect(b) {
    IsError = b;
    "True" == b && SoAlert("Could not connect to Google Calendar, please try again later.", "Unable to connect")
}

function createIframe(b, c, d) {
    var e = document.createElement("iframe");
    e.src = b;
    e.frameborder = "0";
    e.height = c;
    e.width = "100%";
    e.id = "myFrame";
    e.name = "myFrame";
    e.scrolling = "no";
    e.setAttribute("frameborder", "0");
    e.setAttribute("hspace", "0");
    e.setAttribute("marginheight", "0");
    e.setAttribute("marginwidth", "0");
    e.setAttribute("style", "overflow: hidden; width: 100%;" + d);
    e.setAttribute("vspace", "0");
    document.getElementById("iFrameDiv").appendChild(e)
}

function LoadFrame(b, c, d) {
    window.addEventListener ? window.addEventListener("load", function() {
        createIframe(b, c, d)
    }, !1) : window.attachEvent ? window.attachEvent("onload", function() {
        createIframe(b, c, d)
    }) : window.onload = function() {
        createIframe(b, c, d)
    }
}

function MeetDuration(b, c) {
    var d = " min";
    c && (d = " minutes");
    return 180 <= b ? 60 == b ? b / 60 + " hour" : 0 == b % 60 ? b / 60 + " hours" : Math.floor(b / 60) + " hr, " + b % 60 + d : b + d
}

function MinutesToDuration(b) {
    var c;
    1440 <= b ? (c = Math.floor(b / 1440), c = c + " day" + (1 < c ? "s" : "")) : 60 > b ? c = b + " minutes" : (c = b % 60, b = Math.floor(b / 60), c = 0 < b ? 0 == c ? b + " hour" + (1 < b ? "s" : "") : b + " hr " + c + " min" : c + " minutes");
    return c
}

function DaysToDuration(b) {
    var c = b;
    60 <= b ? (b = Math.floor(b / 30), c = b + " month" + (1 < b ? "s" : "")) : 14 <= b && 60 > b ? (b = Math.floor(b / 7), c = b + " week" + (1 < b ? "s" : "")) : c = b + (1 == b ? " day" : " days");
    return c
}

function isNotEmpty(b) {
    var c = !1;
    b && "undefined" != b && "" != b && (c = !0);
    return c
}

function rgbConvert(b) {
    browser.isIE && "9" > browser.version || (b = b.replace(/rgb\(|\)/g, "").split(","), b[0] = parseInt(b[0], 10).toString(16).toLowerCase(), b[1] = parseInt(b[1], 10).toString(16).toLowerCase(), b[2] = parseInt(b[2], 10).toString(16).toLowerCase(), b[0] = 1 == b[0].length ? "0" + b[0] : b[0], b[1] = 1 == b[1].length ? "0" + b[1] : b[1], b[2] = 1 == b[2].length ? "0" + b[2] : b[2], b = "#" + b.join(""));
    return b
}

function IsChecked(b) {
    var c = !1;
    b = document.getElementById(b);
    null != b && (c = !0 == b.checked || "checked" == b.checked);
    return c
}

function CheckUncheck(b) {
    b = document.getElementById(b);
    null != b && (b.checked = !b.checked)
}

function Uncheck(b) {
    b = document.getElementById(b);
    null != b && (b.checked = !1)
}

function Check(b) {
    b = document.getElementById(b);
    null != b && (b.checked = !0)
}

function ShowLoading(b) {
    scrollX = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    scrollY = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    window.scrollTo(0, 0);
    var c = document.getElementById("ScheudleTimeSelector");
    c && (c.style.display = "none");
    boolRefresh = !0;
    "" != b && (c = document.getElementById("LoadingTitleDiv"), !c && window.parent && (c = window.parent.document.getElementById("LoadingTitleDiv")), c && (c.innerHTML = b));
    ShowDiv("LoadingDiv");
    showCancelConnectionAttemptButton &&
        ShowDiv("CancelConnectionAttempt");
    HideDiv("MainDataDiv");
    setTimeout("refreshPage()", 12E4)
}

function refreshPage() {
    boolRefresh && window.location.reload(!0)
}

function include(b, c) {
    if (Array.prototype.indexOf) return -1 != b.indexOf(c);
    for (var d = b.length, e = 0; e < d; e++)
        if (b[e] === c) return !0;
    return !1
}

function getInnerText(b, c) {
    var d = null;
    if (d = c ? b : document.getElementById(b)) return "undefined" != typeof d.innerText ? d.innerText : "undefined" != typeof d.textContent ? d.textContent : d.data
}

function setInnerText(b, c) {
    if (obj = document.getElementById(b)) "undefined" != typeof obj.innerText ? obj.innerText = c : "undefined" != typeof obj.textContent ? obj.textContent = c : obj.data = c
}

function isNumberKey(b) {
    return b && (b = b.which ? b.which : event.keyCode, 48 <= b && 57 >= b || 8 == b) ? !0 : !1
}

function ShowError(b, c) {
    var d = document.getElementById(b);
    d && (d.innerHTML = c, d.style.visibility = "visible")
}

function isCharKey(b) {
    return b && (b = b.which ? b.which : event.keyCode, 31 < b && (65 <= b && 90 >= b || 97 <= b && 122 >= b) || 8 == b || 32 == b) ? !0 : !1
}

function isZipKey(b) {
    return b && (b = b.which ? b.which : event.keyCode, 48 <= b && 57 >= b || 65 <= b && 90 >= b || 97 <= b && 122 >= b || 32 == b || 45 == b || 8 == b) ? !0 : !1
}

function isValidAddressKey(b) {
    return b ? (b = b.which ? b.which : event.keyCode, 60 == b || 62 == b ? !1 : !0) : !1
}

function validateTheLinkNameAsAlphaNumericOnly(b) {
    return b && (b = b.which ? b.which : event.keyCode, 48 <= b && 57 >= b || 65 <= b && 90 >= b || 97 <= b && 122 >= b || 45 == b || 95 == b || 8 == b) ? !0 : !1
}

function contactSO(b) {
    null != b && ClosePopup(b);
    window.open("http://www.scheduleonce.com/contactus", "_blank").focus()
}

function onFocus_CheckText(b) {
    "0" == b.value && (b.value = "")
}

function formatDate(b) {
    if (void 0 != b) {
        var c = b.getMonth(),
            d = b.getDate();
        return "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ")[c] + " " + d + ", " + b.getFullYear()
    }
    return ""
}

function GetReturnQuery(b) {
    return b.indexOf("?") ? "?" + b.toString().split("?")[1] : ""
}

function DownloadLink(b) {
    window.location.href = b
}

function OnCheck() {
    return !0 == flagPlan || !0 == flagUsers || !0 == flagBokings || !0 == flagWebEx || !0 == flagSF || !0 == flagInfusion || !0 == flagG2M ? !0 : !1
}

function DisableElement(b, c) {
    var d = document.getElementById(b);
    d && (d.disabled = c ? !0 : !1)
}

function setFocusOnElementByID() {
    elementToSetFocus.focus()
}

function getThemeNameByID(b) {
    switch (b) {
        case "0":
            return "blue";
        case "1":
            return "gray";
        case "2":
            return "darkgray";
        case "3":
            return "white";
        case "4":
            return "green";
        default:
            return "blue"
    }
}

function alterBrandlessEmbedSize(b) {
    var c = document.getElementById("EmbedDesktopPreview");
    "mobileView" == b.id ? (c.childNodes[0].style.width = "320px", c.childNodes[0].style.border = "1px solid rgb(210, 210, 210)", c.childNodes[0].style.overflow = "auto") : (c.childNodes[0].style.width = "100%", c.childNodes[0].style.overflow = "none", c.childNodes[0].style.maxHeight = "none", c.childNodes[0].style.border = "none")
}

function setCustomButtons(b, c, d, e) {
    e = null != e ? e : document;
    for (var f = b.length, g = 0; g < f; g++) {
        var k = e.getElementById(b[g]);
        k && (k.style.color = "#" + c, k.style.background = "#" + d)
    }
}

function getQueryStringParameter(b, c) {
    for (var d = b.split("&"), e = 0; e < d.length; e++) {
        var f = d[e].split("=");
        if (f[0] == c) return f[1]
    }
}

function updateQueryStringParameter(b, c, d) {
    var e = RegExp("([?&])" + c + "=.*?(&|$)", "i"),
        f = -1 !== b.indexOf("?") ? "&" : "?";
    return b.match(e) ? b.replace(e, "$1" + c + "=" + d + "$2") : b + f + c + "=" + d
}

function MobileShowHideBackButton() {
    m && isEmbed && (1 == navIdx && null != document.getElementById("NavBack") ? document.getElementById("NavBack").style.display = "none" : document.getElementById("NavBack").style.display = "block")
}

function resetButtonColorCode(b, c, d) {
    var e = document.getElementById(b);
    e.value = "FE9E0C";
    e.style.background = "#FE9E0C";
    e.style.color = "#000000";
    setResetButton(b, c);
    d && ("SOBookingButton" == d ? setBookingCode() : "SOEmailButton" == d ? setEmailCode() : "WebButton" == d && setButtonCode())
}

function setResetButton(b, c) {
    var d = document.getElementById(c),
        e = document.getElementById(b);
    d.style.color = d && e && "FE9E0C" == e.value ? "#777777" : "#0066cc"
};
var soTipX = 30,
    soTipY = -50;
tooltip = {
    name: "soTip",
    offsetX: soTipX,
    offsetY: soTipY,
    tip: null,
    preinit: function() {
        if (!b) var b = "soTip";
        var c = document.getElementById(b);
        !c && (c = document.createElementNS ? document.createElementNS("http://www.w3.org/1999/xhtml", "div") : document.createElement("div"), c.id = b, c.className = "tooltipDivStandard", document.getElementsByTagName("body").item(0).appendChild(c), document.getElementById && (this.tip = document.getElementById(this.name))) && (document.onmousemove = function(b) {
            tooltip.move(b)
        })
    },
    init: function(b,
        c) {
        if (!d) var d = "soTip";
        var e = document.getElementById(d);
        e || (e = document.createElementNS ? document.createElementNS("http://www.w3.org/1999/xhtml", "div") : document.createElement("div"), e.id = d, e.className = c, document.getElementsByTagName("body").item(0).appendChild(e));
        if (!b.getAttribute("tiptitle") && document.getElementById) {
            if (this.tip = document.getElementById(this.name)) document.onmousemove = function(b) {
                tooltip.move(b)
            };
            b && (a = b, sTitle = a.getAttribute("title")) && (a.setAttribute("tiptitle", sTitle), a.removeAttribute("title"),
                a.removeAttribute("alt"), a.attachEvent ? (a.attachEvent("onmouseover", function(b) {
                    srcElement = b.srcElement ? b.srcElement : b.target;
                    srcElement.getAttribute("tiptitle") ? tooltip.show(srcElement.getAttribute("tiptitle"), srcElement) : (b = tooltip.gettooltipparent(srcElement), tooltip.show(b.getAttribute("tiptitle"), b))
                }), a.attachEvent("onmouseout", function() {
                    tooltip.hide()
                })) : (a.addEventListener("mouseover", function(b) {
                        srcElement = b.currentTarget;
                        tooltip.show(srcElement.getAttribute("tiptitle"), srcElement)
                    }, !1),
                    a.addEventListener("mouseout", function() {
                        tooltip.hide()
                    }, !1)))
        }
    },
    gettooltipparent: function(b) {
        for (b = b.parentNode;
            "" == b.getAttribute("tiptitle") || null == b.getAttribute("tiptitle");) b = b.parentNode;
        return b
    },
    move: function(b) {
        var c = 0,
            d = 0;
        document.all ? (c = document.documentElement && document.documentElement.scrollLeft ? document.documentElement.scrollLeft : document.body.scrollLeft, d = document.documentElement && document.documentElement.scrollTop ? document.documentElement.scrollTop : document.body.scrollTop, c += window.event.clientX,
            d += window.event.clientY) : (c = b.pageX, d = b.pageY);
        b = GetWinSize();
        var e = c + this.offsetX;
        if (this.tip) {
            var f = getSize(this.tip);
            c + this.offsetX + f[0] + 30 > b[0] && (e = c - this.offsetX - f[0]);
            this.tip.style.left = e + "px";
            this.tip.style.top = d + this.offsetY + "px"
        }
    },
    gettipHTML: function(b) {
        var c = b.getAttribute("tipHeaderClass"),
            d = b.getAttribute("tipHeader"),
            e = b.getAttribute("tipContentClass"),
            f = b.getAttribute("tiptitle");
        this.tip.className = b.getAttribute("tipContainerClass");
        return c && d && e ? '<div class="' + c + '">' + d + '</div><div class="' +
            e + '">' + f + "</div>" : f
    },
    setTipProperties: function(b, c, d, e, f) {
        b.setAttribute("tipHeaderClass", d);
        b.setAttribute("tipHeader", c);
        b.setAttribute("tipContentClass", e);
        b.setAttribute("tipContainerClass", f)
    },
    show: function(b, c) {
        this.tip && (this.tip.innerHTML = tooltip.gettipHTML(c), this.tip.style.visibility = "visible")
    },
    hide: function() {
        this.tip && (this.tip.innerHTML = "", this.tip.style.visibility = "hidden")
    }
};
tooltip.preinit();

function hideP() {
    if (userProfileObj.HasProductivityPremission())
        for (var b = browser.isIE && 8 >= browser.version ? document.querySelectorAll(".PremiumFeature") : document.getElementsByClassName("PremiumFeature"), c = 0; c < b.length; c++) b[c].style.display = "none"
};

function DayLightSavingObj(b, c, d) {
    this.offset = b;
    this.startTimeMili = c;
    this.endTimeMili = d
}
DayLightSavingObj.prototype.copy = function(b) {
    b.offset = this.offset;
    b.startTimeMili = this.startTimeMili;
    b.endTimeMili = this.endTimeMili
};

function TimeZoneObj(b, c, d, e, f, g, k, l) {
    this.id = b;
    this.shortName = c;
    this.country = d;
    this.region = e;
    this.cityList = f;
    this.timeZone = g;
    this.hasDayLightSavings = k;
    this.dayLightSavings = null;
    this.CountryCallingCode = l
}
TimeZoneObj.prototype.copy = function(b) {
    b.id = this.id;
    b.shortName = this.shortName;
    b.country = this.country;
    b.region = this.region;
    b.cityList = this.cityList;
    b.timeZone = this.timeZone;
    b.hasDayLightSavings = this.hasDayLightSavings;
    if (null != this.dayLightSavings) {
        var c = this.dayLightSavings.length;
        b.dayLightSavings = [];
        for (var d = 0; d < c; d++) b.dayLightSavings[d] = new DayLightSavingObj(-1, -1, -1), this.dayLightSavings[d].copy(b.dayLightSavings[d])
    }
};
TimeZoneObj.prototype.AddDayLightSavings = function(b) {
    this.hasDayLightSavings = !0;
    null == this.dayLightSavings && (this.dayLightSavings = []);
    this.dayLightSavings[this.dayLightSavings.length] = b
};
TimeZoneObj.prototype.toFullNameString = function(b, c) {
    null == c && (c = !1);
    null == b && (b = 30);
    var d = "",
        e = this.country + "; ",
        e = e + this.region;
    "" != e && (e += "");
    e += this.cityList;
    e;
    var f = "";
    c || (f += '<span title="' + e + '">');
    f += CutStringToSize(e, b);
    c || (f += "</span>");
    d += " (GMT";
    0 < this.timeZone ? d += "+" : 0 == this.timeZone && (d += "&nbsp;");
    d += this.timeZone + ") ";
    return f + d
};
TimeZoneObj.prototype.toFullNameStringWithtrueOffset = function(b, c, d) {
    null == c && (c = !1);
    null == b && (b = 30);
    var e = "",
        f = this.country + "; ",
        f = f + this.region;
    "" != f && (f += "");
    f += this.cityList;
    f;
    var g = "";
    c || (g += '<span title="' + f + '">');
    g += CutStringToSize(f, b);
    c || (g += "</span>");
    e += " (GMT";
    d.IsInDLS() ? (0 < Getoffsetoutoftimezone(d) ? e += "+" : 0 == Getoffsetoutoftimezone(d) && (e += "&nbsp;"), e += Getoffsetoutoftimezone(d) + ") ") : (0 < this.timeZone && (e += "+"), e += this.timeZone + ") ");
    return g + e
};
TimeZoneObj.prototype.toFullNameStringGmtLastWithtrueOffset = function(b, c, d) {
    null == c && (c = !1);
    null == b && (b = 30);
    if (-1 == this.id) return "<span>Time zone region not selected</span>";
    var e = "&nbsp;(GMT";
    d.IsInDLS() ? (0 < Getoffsetoutoftimezone(d) ? e += "+" : 0 == Getoffsetoutoftimezone(d) && (e += "&nbsp;"), e += Getoffsetoutoftimezone(d) + ")") : (0 < this.timeZone ? e += "+" : 0 == this.timeZone && (e += "&nbsp;"), e += this.timeZone + ")");
    d = this.country + "; ";
    d += this.region;
    "" != d && (d += "");
    d += this.cityList;
    var f = "";
    c || (f += '<span class="locationCountryreason" title="' +
        d + '">');
    f += CutStringToSize(d, b) + e;
    c || (f += "</span>");
    return f
};
TimeZoneObj.prototype.toFullNameStringGmtLast = function(b, c) {
    null == c && (c = !1);
    null == b && (b = 30);
    if (-1 == this.id) return "<span>Time zone region not selected</span>";
    var d = "&nbsp;(GMT";
    0 < this.timeZone ? d += "+" : 0 == this.timeZone && (d += "&nbsp;");
    var d = d + (this.timeZone + ") "),
        e = this.country + "; ",
        e = e + this.region;
    "" != e && (e += "");
    var e = e + this.cityList,
        f = "";
    c || (f += '<span title="' + e + '">');
    f += CutStringToSize(e, b) + d;
    c || (f += "</span>");
    return f
};
TimeZoneObj.prototype.toFullNameStringGmtLastDstIcon = function(b, c) {
    null == c && (c = !1);
    null == b && (b = 30);
    if (-1 == this.id) return "<span>Time zone region not selected</span>";
    var d = "&nbsp;(GMT";
    GetNowDateTime(this).IsInDLS() ? (0 < Getoffsetoutoftimezone(GetNowDateTime(this)) ? d += "+" : 0 == Getoffsetoutoftimezone(GetNowDateTime(this)) && (d += "&nbsp;"), d += Getoffsetoutoftimezone(GetNowDateTime(this)) + ") ") : (0 < this.timeZone ? d += "+" : 0 == this.timeZone && (d += "&nbsp;"), d += this.timeZone + ") ");
    var e = this.country + "; ",
        f, e = e + this.region;
    "" != e && (e += "");
    f = "" + (e += this.cityList);
    e += d;
    GetNowDateTime(this).IsInDLS() && (e += " [DST]");
    var g = "";
    c || (g += '<span title="' + e + '">');
    g = GetNowDateTime(this).IsInDLS() ? g + (CutStringToSize(f, b) + d + " [DST]") : g + (CutStringToSize(f, b) + d);
    c || (g += "</span>");
    return g
};
TimeZoneObj.prototype.toString = function() {
    return this.toFullNameString(1E4)
};
TimeZoneObj.prototype.toFullNameWithoutCountryString = function() {
    var b;
    b = this.region;
    "" == b && (b = this.country);
    b = "" + b + " (GMT";
    GetNowDateTime(this).IsInDLS() ? (0 < Getoffsetoutoftimezone(GetNowDateTime(this)) ? b += "+" : 0 == Getoffsetoutoftimezone(GetNowDateTime(this)) && (b += " "), b += Getoffsetoutoftimezone(GetNowDateTime(this)) + ") ") : (0 < this.timeZone ? b += "+" : 0 == this.timeZone && (b += " "), b += this.timeZone + ") ");
    GetNowDateTime(this).IsInDLS() && (b += " [DST]");
    return b
};

function sortByGMT(b, c) {
    var d = b.timeZone,
        e = c.timeZone;
    return d < e ? -1 : d > e ? 1 : 0
}
TimeZoneObj.prototype.GetDlsChangeTime = function(b, c) {
    var d = null;
    if (this.hasDayLightSavings && null != this.dayLightSavings)
        for (var e = this.dayLightSavings.length, f = 0; f < e; f++) {
            var g = this.dayLightSavings[f];
            if (g.startTimeMili > b.innerMiliSecs && g.startTimeMili < c.innerMiliSecs) {
                d = CreateNewDateFromMili(g.startTimeMili, this);
                break
            }
            if (g.endTimeMili > b.innerMiliSecs && g.endTimeMili < c.innerMiliSecs) {
                d = CreateNewDateFromMili(g.endTimeMili, this);
                break
            }
        }
    return d
};

function DateTimeObj(b, c, d, e, f, g, k, l) {
    this.m_fullYearForShow = this.m_monthForShow = this.m_dayForShow = this.m_dateForShow = this.m_yearForShow = -1;
    null == l && (l = !1);
    this.innerMiliSecs = Date.UTC(b, c, d, e, f, g);
    this.timeZoneObj = null != k ? k : new TimeZoneObj(1, "UTC", "(UTC/GMT)", "", "", 0, !1);
    l && null != k && (b = this.GetTimeZoneOffset(), this.innerMiliSecs -= b * HOUR_IN_MILISECONDS, c = this.GetTimeZoneOffset(), c != b && (this.innerMiliSecs -= (c - b) * HOUR_IN_MILISECONDS))
}
DateTimeObj.prototype.fixForTimeZoneChange = function(b) {
    var c = this.timeZoneObj.timeZone - b.timeZone;
    b = CreateNewDateFromMili(this.innerMiliSecs, b);
    b = this.GetDLSOffset() - b.GetDLSOffset();
    this.innerMiliSecs = this.AddHours(c + b).innerMiliSecs
};
DateTimeObj.prototype.copy = function(b, c) {
    b.innerMiliSecs = this.innerMiliSecs;
    null == c ? this.timeZoneObj.copy(b.timeZoneObj) : b.SetTimeZoneObj(c)
};
DateTimeObj.prototype.clone = function(b) {
    var c = new DateTimeObj;
    this.copy(c, b);
    return c
};
var MINUTE_IN_MILISECONDS = 6E4,
    HOUR_IN_MILISECONDS = 60 * MINUTE_IN_MILISECONDS,
    DAY_IN_MILISECONDS = 24 * HOUR_IN_MILISECONDS;

function CreateNewDateFromMili(b, c) {
    var d = new DateTimeObj(1970, 1, 1, 0, 0, 0, c, !1);
    d.innerMiliSecs = b;
    return d
}

function GetNowDateTime(b) {
    dt = new Date;
    var c = CreateNewDateFromMili(dt.getTime(), b);
    try {
        null != win.earliestDate ? c = CreateNewDateFromMili(win.earliestDate, b) : null != win.curentmilisec && -1 != parseInt(win.curentmilisec) ? c = CreateNewDateFromMili(parseInt(win.curentmilisec), b) : null != curentmilisec && -1 != parseInt(curentmilisec) && (c = CreateNewDateFromMili(parseInt(curentmilisec), b))
    } catch (d) {}
    return c
}
DateTimeObj.prototype.SetTimeZoneObj = function(b) {
    this.timeZoneObj = b
};
DateTimeObj.prototype.GetDateOnlyDateTime = function(b) {
    null == b && (b = !1);
    var c = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj),
        d = c.GetDateForShow(),
        e = c.GetHoursForShow(),
        f = c.GetMinutesForShow(),
        g = c.GetSecondsForShow(),
        c = c.AddHours(-1 * e),
        c = c.AddMinutes(-1 * f),
        c = c.AddSeconds(-1 * g),
        e = this.CompareDateForShowTo(c);
    0 != e && (c = c.AddHours(e));
    if (b && 0 != c.GetHoursForShow())
        for (b = -1, c.GetDate() > d && (b = 1); 0 != c.GetHoursForShow();) c = c.AddHours(b);
    return c
};
DateTimeObj.prototype.GetDateOnlyDateTimeAbsolute = function() {
    var b = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj),
        b = b.AddHours(-1 * b.GetHours()),
        b = b.AddMinutes(-1 * b.GetMinutes());
    return b = b.AddSeconds(-1 * b.GetSeconds())
};
DateTimeObj.prototype.GetDateOnlyDateTimeUTC = function() {
    var b = this.GetDateOnlyDateTimeAbsolute();
    if (0 <= this.timeZoneObj.timeZone) {
        var c = b.GetInnerMiliseconds();
        this.GetDateOnlyDateTime().GetInnerMiliseconds() > c && (b = b.AddDay(1))
    }
    return b
};
DateTimeObj.prototype.GetDateOnlyDateTimeTZ = function() {
    var b = this.GetDateOnlyDateTime(!0);
    if (0 > this.timeZoneObj.timeZone) {
        var c = b.GetInnerMiliseconds(),
            d = this.GetDateOnlyDateTimeAbsolute().GetInnerMiliseconds();
        c < d && (b = b.AddDay(1))
    }
    return b
};
DateTimeObj.prototype.GenerateCreationString = function() {
    return "CreateNewDateFromMili(" + this.innerMiliSecs + ")"
};
DateTimeObj.prototype.AddSeconds = function(b) {
    return CreateNewDateFromMili(this.innerMiliSecs + 1E3 * b, this.timeZoneObj)
};
DateTimeObj.prototype.AddMinutes = function(b) {
    return CreateNewDateFromMili(this.innerMiliSecs + b * MINUTE_IN_MILISECONDS, this.timeZoneObj)
};
DateTimeObj.prototype.AddHours = function(b) {
    return CreateNewDateFromMili(this.innerMiliSecs + b * HOUR_IN_MILISECONDS, this.timeZoneObj)
};
DateTimeObj.prototype.AddMinutesForRecurringAvail = function(b) {
    var c = this.GetHoursForShow(),
        d = this.GetMinutesForShow();
    b = CreateNewDateFromMili(this.innerMiliSecs - c * HOUR_IN_MILISECONDS - d * MINUTE_IN_MILISECONDS + b * MINUTE_IN_MILISECONDS, this.timeZoneObj);
    c = this.GetDLSOffset() - b.GetDLSOffset();
    return b = b.AddHours(c)
};
DateTimeObj.prototype.AddDay = function(b) {
    var c = this.GetTimeZoneOffset();
    b = this.AddDays(b);
    var d = b.GetTimeZoneOffset();
    d != c && (b = b.AddHours(-1 * (d - c)));
    return b
};
DateTimeObj.prototype.AddDays = function(b) {
    return CreateNewDateFromMili(this.innerMiliSecs + b * DAY_IN_MILISECONDS, this.timeZoneObj)
};
DateTimeObj.prototype.GetSeconds = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCSeconds()
};
DateTimeObj.prototype.GetMinutes = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCMinutes()
};
DateTimeObj.prototype.GetHours = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCHours()
};
DateTimeObj.prototype.GetDate = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCDate()
};
DateTimeObj.prototype.GetDay = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCDay()
};
DateTimeObj.prototype.GetMonth = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCMonth()
};
DateTimeObj.prototype.GetFullYear = function() {
    var b = new Date;
    b.setTime(this.innerMiliSecs);
    return b.getUTCFullYear()
};
DateTimeObj.prototype.IsInDLS = function() {
    return 0 != this.GetDLSOffset()
};
DateTimeObj.prototype.GetDLSIcon = function(b) {
    var c = "";
    null == b && (b = 2);
    this.timeZoneObj.hasDayLightSavings && (c = "", this.IsInDLS() && (c += '<img alt="DST" style="width:14px;height:14px;position:relative;top:' + b + 'px" border="0" src="Images/sun_on.png" title="Daylight Saving Time is in effect" ></img>'));
    return c
};
DateTimeObj.prototype.GetDLSOffset = function() {
    var b = 0;
    if (this.timeZoneObj.hasDayLightSavings && null != this.timeZoneObj.dayLightSavings)
        for (var c = this.timeZoneObj.dayLightSavings.length, d = 0; d < c; d++) {
            var e = this.timeZoneObj.dayLightSavings[d];
            this.innerMiliSecs >= e.startTimeMili && this.innerMiliSecs < e.endTimeMili && (b = e.offset - this.timeZoneObj.timeZone)
        }
    return b
};
DateTimeObj.prototype.GetTimeZoneOffset = function() {
    return this.timeZoneObj.timeZone + this.GetDLSOffset()
};
DateTimeObj.prototype.IsPastDue = function() {
    var b = !1;
    1 == GetNowDateTime(this.timeZoneObj).CompareTo(this) && (b = !0);
    return b
};
DateTimeObj.prototype.GetInnerMilisecondsForShow = function() {
    if (null == this.timeZoneObj.timeZone) throw Error("kakai");
    return this.innerMiliSecs + (this.timeZoneObj.timeZone + this.GetDLSOffset()) * HOUR_IN_MILISECONDS
};
DateTimeObj.prototype.GetInnerMiliseconds = function() {
    if (null == this.timeZoneObj.timeZone) throw Error("kakai");
    return this.innerMiliSecs
};
DateTimeObj.prototype.GetSecondsForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return b.getUTCSeconds()
};
DateTimeObj.prototype.GetMinutesForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return b.getUTCMinutes()
};
DateTimeObj.prototype.GetHoursForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return b.getUTCHours()
};
DateTimeObj.prototype.GetYearForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return this.m_yearForShow = b.getUTCFullYear()
};
DateTimeObj.prototype.GetDateForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return this.m_dateForShow = b.getUTCDate()
};
DateTimeObj.prototype.GetDayForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return b.getUTCDay()
};
DateTimeObj.prototype.GetMonthForShow = function() {
    var b = new Date;
    b.setTime(this.GetInnerMilisecondsForShow());
    return this.m_monthForShow = b.getUTCMonth()
};
DateTimeObj.prototype.GetFullYearForShow = function() {
    if (-1 == this.m_fullYearForShow) {
        var b = new Date;
        b.setTime(this.GetInnerMilisecondsForShow());
        this.m_fullYearForShow = b.getUTCFullYear()
    }
    return this.m_fullYearForShow
};
DateTimeObj.prototype.GetMonthName = function() {
    return this.MONTH_NAMES[this.GetMonthForShow() + 12]
};
DateTimeObj.prototype.GetDayName = function() {
    return this.DAY_NAMES[this.GetDayForShow() + 7]
};
DateTimeObj.prototype.GetClosestSundayDate = function() {
    ret = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj);
    ret.innerMiliSecs -= DAY_IN_MILISECONDS * ret.GetDayForShow();
    return ret
};
DateTimeObj.prototype.GetClosestDayDate = function(b) {
    ret = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj);
    ret.innerMiliSecs -= DAY_IN_MILISECONDS * ret.GetDayForShow();
    ret = ret.AddDays(b);
    1 == ret.CompareTo(this) && (ret = ret.AddDays(-7));
    return ret
};
DateTimeObj.prototype.GetNextDay = function() {
    for (var b = this.GetDateForShow(), c = this.GetDateOnlyDateTime(!0), d = !1; c.GetDateForShow() == b;) c = c.AddHours(1), d = !0;
    d && 1 < c.GetHoursForShow() && (c = c.AddHours(-1));
    return c
};
DateTimeObj.prototype.GetDateTimeIndicator = function() {
    return this.GetFullYearForShow().toString() + "" + this.GetMonthForShow().toString() + "" + this.GetDateForShow().toString()
};
DateTimeObj.prototype.CompareTo = function(b) {
    b = this.innerMiliSecs - b.innerMiliSecs;
    return 0 < b ? 1 : 0 > b ? -1 : 0
};
DateTimeObj.prototype.CompareDateForShowTo = function(b) {
    var c = Date.UTC(this.GetFullYearForShow(), this.GetMonthForShow(), this.GetDateForShow(), 0, 0, 0);
    b = Date.UTC(b.GetFullYearForShow(), b.GetMonthForShow(), b.GetDateForShow(), 0, 0, 0);
    return c > b ? 1 : c < b ? -1 : 0
};
DateTimeObj.prototype.IsEqualToJSDate = function(b) {
    return this.GetFullYearForShow() == b.getFullYear() && this.GetMonthForShow() == b.getMonth() && this.GetDateForShow() == b.getDate() ? !0 : !1
};
DateTimeObj.prototype.IsEqualToJSUTCDate = function(b) {
    return this.GetFullYearForShow() == b.getUTCFullYear() && this.GetMonthForShow() == b.getUTCMonth() && this.GetDateForShow() == b.getUTCDate() ? !0 : !1
};
DateTimeObj.prototype.IsEqualToDate = function(b) {
    return this.GetFullYearForShow() == b.GetFullYearForShow() && this.GetMonthForShow() == b.GetMonthForShow() && this.GetDateForShow() == b.GetDateForShow() ? !0 : !1
};
DateTimeObj.prototype.IsEqualToTime = function(b) {
    return this.GetFullYearForShow() == b.GetFullYearForShow() && this.GetMonthForShow() == b.GetMonthForShow() && this.GetDateForShow() == b.GetDateForShow() && this.GetHoursForShow() == b.GetHoursForShow() && this.GetMinutesForShow() == b.GetMinutesForShow() ? !0 : !1
};
DateTimeObj.prototype.LowerOrEqual = function(b) {
    b = this.CompareTo(b);
    var c = !1;
    if (0 == b || -1 == b) c = !0;
    return c
};
DateTimeObj.prototype.GreaterOrEqual = function(b) {
    b = this.CompareTo(b);
    var c = !1;
    if (0 == b || 1 == b) c = !0;
    return c
};
DateTimeObj.prototype.toString = function(b) {
    null == b && (b = !0);
    var c = FormatDateWithDayMonthYearByUser(this) + " " + FormatTimeByUser(this);
    b && (c += "(" + this.timeZoneObj + ")");
    return c
};
DateTimeObj.prototype.toStringAbsolute = function() {
    return this.formatDateAbsolute("EE, MMM dd, yyyy") + " " + GetTimeStringByPrefrecesByDate(this, currUserData)
};
DateTimeObj.prototype.MONTH_NAMES = "January February March April May June July August September October November December Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ");
DateTimeObj.prototype.DAY_NAMES = "Sunday Monday Tuesday Wednesday Thursday Friday Saturday Sun Mon Tue Wed Thu Fri Sat".split(" ");
DateTimeObj.prototype.LZ = function(b) {
    return (0 > b || 9 < b ? "" : "0") + b
};
DateTimeObj.prototype.formatDate = function(b) {
    b += "";
    var c = "",
        d = 0,
        e = "",
        f = "",
        e = this.GetFullYearForShow() + "",
        f = this.GetMonthForShow() + 1,
        g = this.GetDateForShow(),
        k = this.GetDayForShow(),
        l = this.GetHoursForShow(),
        n = this.GetMinutesForShow(),
        p = this.GetSecondsForShow(),
        h = {};
    4 > e.length && (e = "" + (e - 0 + 1900));
    h.y = "" + e;
    h.yyyy = e;
    h.yy = e.substring(2, 4);
    h.M = f;
    h.MM = this.LZ(f);
    h.MMM = this.MONTH_NAMES[f - 1];
    h.NNN = this.MONTH_NAMES[f + 11];
    h.d = g;
    h.dd = this.LZ(g);
    h.E = this.DAY_NAMES[k + 7];
    h.EE = this.DAY_NAMES[k];
    h.H = l;
    h.HH = this.LZ(l);
    h.h = 0 == l ? 12 : 12 < l ? l - 12 : l;
    h.hh = this.LZ(h.h);
    h.K = 11 < l ? l - 12 : l;
    h.k = l + 1;
    h.KK = this.LZ(h.K);
    h.kk = this.LZ(h.k);
    h.a = 11 < l ? "pm" : "am";
    h.A = 11 < l ? "PM" : "AM";
    h.m = n;
    h.mm = this.LZ(n);
    h.s = p;
    for (h.ss = this.LZ(p); d < b.length;) {
        e = b.charAt(d);
        for (f = ""; b.charAt(d) == e && d < b.length;) f += b.charAt(d++);
        c = null != h[f] ? c + h[f] : c + f
    }
    return c
};
DateTimeObj.prototype.formatDateAbsolute = function(b) {
    b += "";
    var c = "",
        d = 0,
        e = "",
        f = "",
        e = this.GetFullYear() + "",
        f = this.GetMonth() + 1,
        g = this.GetDate(),
        k = this.GetDay(),
        l = this.GetHours(),
        n = this.GetMinutes(),
        p = this.GetSeconds(),
        h = {};
    4 > e.length && (e = "" + (e - 0 + 1900));
    h.y = "" + e;
    h.yyyy = e;
    h.yy = e.substring(2, 4);
    h.M = f;
    h.MM = this.LZ(f);
    h.MMM = this.MONTH_NAMES[f - 1];
    h.NNN = this.MONTH_NAMES[f + 11];
    h.d = g;
    h.dd = this.LZ(g);
    h.E = this.DAY_NAMES[k + 7];
    h.EE = this.DAY_NAMES[k];
    h.H = l;
    h.HH = this.LZ(l);
    h.h = 0 == l ? 12 : 12 < l ? l - 12 : l;
    h.hh = this.LZ(h.h);
    h.K = 11 < l ? l - 12 : l;
    h.k = l + 1;
    h.KK = this.LZ(h.K);
    h.kk = this.LZ(h.k);
    h.a = 11 < l ? "pm" : "am";
    h.m = n;
    h.mm = this.LZ(n);
    h.s = p;
    for (h.ss = this.LZ(p); d < b.length;) {
        e = b.charAt(d);
        for (f = ""; b.charAt(d) == e && d < b.length;) f += b.charAt(d++);
        c = null != h[f] ? c + h[f] : c + f
    }
    return c
};
DateTimeObj.prototype.GetWeekNum = function(b) {
    this.GetDayForShow();
    b = (7 - b + this.GetDayForShow()) % 7;
    var c = new Date(this.GetYearForShow(), this.GetMonthForShow(), this.GetDateForShow()),
        c = new Date(this.GetYearForShow(), this.GetMonthForShow(), this.GetDateForShow()),
        c = c.setDate(c.getDate() - b);
    b = new Date(this.GetFullYear(), 0, 1);
    b = Math.ceil(((c - b) / 864E5 + b.getDay()) / 7);
    53 == b && (b = 1);
    return b
};

function _isInteger(b) {
    for (var c = 0; c < b.length; c++)
        if (-1 == "1234567890".indexOf(b.charAt(c))) return !1;
    return !0
}

function _getInt(b, c, d, e) {
    for (; e >= d; e--) {
        var f = b.substring(c, c + e);
        if (f.length < d) break;
        if (_isInteger(f)) return f
    }
    return null
}

function getDateFromFormat(b, c) {
    b += "";
    c += "";
    for (var d = 0, e = 0, f = "", g = "", k, l, n = new Date, p = n.getFullYear(), h = n.getMonth() + 1, r = 1, q = n.getHours(), s = n.getMinutes(), n = n.getSeconds(), t = ""; e < c.length;) {
        f = c.charAt(e);
        for (g = ""; c.charAt(e) == f && e < c.length;) g += c.charAt(e++);
        if ("yyyy" == g || "yy" == g || "y" == g) {
            "yyyy" == g && (l = k = 4);
            "yy" == g && (l = k = 2);
            "y" == g && (k = 2, l = 4);
            p = _getInt(b, d, k, l);
            if (null == p) return 0;
            d += p.length;
            2 == p.length && (p = 70 < p ? 1900 + (p - 0) : 2E3 + (p - 0))
        } else if ("MMM" == g || "NNN" == g) {
            for (f = h = 0; f < DateTimeObj.prototype.MONTH_NAMES.length; f++) {
                var u =
                    DateTimeObj.prototype.MONTH_NAMES[f];
                if (b.substring(d, d + u.length).toLowerCase() == u.toLowerCase() && ("MMM" == g || "NNN" == g && 11 < f)) {
                    h = f + 1;
                    12 < h && (h -= 12);
                    d += u.length;
                    break
                }
            }
            if (1 > h || 12 < h) return 0
        } else if ("EE" == g || "E" == g)
            for (f = 0; f < DAY_NAMES.length; f++) {
                if (g = DAY_NAMES[f], b.substring(d, d + g.length).toLowerCase() == g.toLowerCase()) {
                    d += g.length;
                    break
                }
            } else if ("MM" == g || "M" == g) {
                h = _getInt(b, d, g.length, 2);
                if (null == h || 1 > h || 12 < h) return 0;
                d += h.length
            } else if ("dd" == g || "d" == g) {
            r = _getInt(b, d, g.length, 2);
            if (null == r || 1 > r || 31 <
                r) return 0;
            d += r.length
        } else if ("hh" == g || "h" == g) {
            q = _getInt(b, d, g.length, 2);
            if (null == q || 1 > q || 12 < q) return 0;
            d += q.length
        } else if ("HH" == g || "H" == g) {
            q = _getInt(b, d, g.length, 2);
            if (null == q || 0 > q || 23 < q) return 0;
            d += q.length
        } else if ("KK" == g || "K" == g) {
            q = _getInt(b, d, g.length, 2);
            if (null == q || 0 > q || 11 < q) return 0;
            d += q.length
        } else if ("kk" == g || "k" == g) {
            q = _getInt(b, d, g.length, 2);
            if (null == q || 1 > q || 24 < q) return 0;
            d += q.length;
            q--
        } else if ("mm" == g || "m" == g) {
            s = _getInt(b, d, g.length, 2);
            if (null == s || 0 > s || 59 < s) return 0;
            d += s.length
        } else if ("ss" ==
            g || "s" == g) {
            n = _getInt(b, d, g.length, 2);
            if (null == n || 0 > n || 59 < n) return 0;
            d += n.length
        } else if ("a" == g) {
            if ("am" == b.substring(d, d + 2).toLowerCase()) t = "am";
            else if ("pm" == b.substring(d, d + 2).toLowerCase()) t = "pm";
            else return 0;
            d += 2
        } else {
            if (b.substring(d, d + g.length) != g) return 0;
            d += g.length
        }
    }
    if (d != b.length) return 0;
    if (2 == h)
        if (0 == p % 4 && 0 != p % 100 || 0 == p % 400) {
            if (29 < r) return 0
        } else if (28 < r) return 0;
    if ((4 == h || 6 == h || 9 == h || 11 == h) && 30 < r) return 0;
    12 > q && "pm" == t ? q = q - 0 + 12 : 11 < q && "am" == t && (q -= 12);
    return (new Date(p, h - 1, r, q, s, n)).getTime()
}

function CalcWeekFromDate(b, c) {
    return c.GetWeekNum(currUserData.userStartWeekDay)
}

function LastDayOfMonth(b, c) {
    return (new Date(new Date(b, c + 1, 1) - 1)).getDate()
}

function sortByMiliSec(b, c) {
    var d = b.innerMiliSecs,
        e = c.innerMiliSecs;
    return d < e ? -1 : d > e ? 1 : 0
}

function IsTimeliesinDst(b) {
    var c = b.innerMiliSecs;
    if (null != b.timeZoneObj.dayLightSavings)
        for (var d = b.timeZoneObj.dayLightSavings.length, e = 0; e < d; e++)
            if (b.timeZoneObj.dayLightSavings[e].startTimeMili <= c && b.timeZoneObj.dayLightSavings[e].endTimeMili >= c) return "&nbsp;[DST]";
    return "&nbsp;"
}

function Getoffsetoutoftimezone(b) {
    var c = b.innerMiliSecs;
    if (null != b.timeZoneObj.dayLightSavings)
        for (var d = b.timeZoneObj.dayLightSavings.length, e = 0; e < d; e++)
            if (b.timeZoneObj.dayLightSavings[e].startTimeMili <= c && b.timeZoneObj.dayLightSavings[e].endTimeMili >= c) return b.timeZoneObj.dayLightSavings[e].offset
}

function GetGmtPlusDst(b) {
    var c = b.innerMiliSecs;
    if (null != b.timeZoneObj.dayLightSavings)
        for (var d = b.timeZoneObj.dayLightSavings.length, e = 0; e < d; e++)
            if (b.timeZoneObj.dayLightSavings[e].startTimeMili <= c && b.timeZoneObj.dayLightSavings[e].endTimeMili >= c) return "&nbsp;(GMT" + (0 == b.timeZoneObj.dayLightSavings[e].offset ? "&nbsp" + b.timeZoneObj.dayLightSavings[e].offset : 0 < b.timeZoneObj.dayLightSavings[e].offset ? "+" + b.timeZoneObj.dayLightSavings[e].offset : b.timeZoneObj.dayLightSavings[e].offset) + ")&nbsp;[DST]";
    return "&nbsp;(GMT" + (0 == b.timeZoneObj.timeZone ? "&nbsp" + b.timeZoneObj.timeZone : 0 < b.timeZoneObj.timeZone ? "+" + b.timeZoneObj.timeZone : b.timeZoneObj.timeZone) + ")"
}

function IsDst(b) {
    var c = b.innerMiliSecs;
    if (null != b.timeZoneObj.dayLightSavings)
        for (var d = b.timeZoneObj.dayLightSavings.length, e = 0; e < d; e++)
            if (b.timeZoneObj.dayLightSavings[e].startTimeMili <= c && b.timeZoneObj.dayLightSavings[e].endTimeMili >= c) return !0;
    return !1
};

function meetingTimeObj(b, c, d, e) {
    this.id = b;
    this.startTime = c;
    this.duration = d;
    this.locationId = e;
    this.isOrganizerMeetingTime = !0;
    this.inviteeMeetingTimeType = 39;
    this.lenPos = this.startPos = this.dayIdx = this.totalTouchingMeetings = this.gridLocIdx = this.userID = -1;
    this.isJumpDay = !1;
    this.durationOffSet = 0;
    this.mmIndexArr = []
}

function meetingTimeObj(b, c, d, e, f) {
    this.id = b;
    this.startTime = c;
    this.duration = d;
    this.locationId = e;
    this.isOrganizerMeetingTime = !0;
    this.inviteeMeetingTimeType = 39;
    this.lenPos = this.startPos = this.dayIdx = this.totalTouchingMeetings = this.gridLocIdx = this.userID = -1;
    this.isJumpDay = !1;
    this.inviteesCount = f;
    this.mmIndexArr = []
}
meetingTimeObj.prototype.addMMIndex = function(b) {
    this.mmIndexArr[this.mmIndexArr.length] = b
};
meetingTimeObj.prototype.getMMIndexArr = function() {
    return this.mmIndexArr
};
meetingTimeObj.prototype.hasMMIndex = function(b) {
    for (var c = this.mmIndexArr.length, d = !1, e = 0; e < c; e++)
        if (this.mmIndexArr[e] == b) {
            d = !0;
            break
        }
    return d
};
meetingTimeObj.prototype.getRealDuration = function() {
    var b = this.duration;
    this.isJumpDay && (b -= 60);
    return b
};
meetingTimeObj.prototype.copy = function(b) {
    b.id = this.id;
    b.startTime = this.startTime;
    b.duration = this.duration;
    b.locationId = this.locationId;
    b.isOrganizerMeetingTime = this.isOrganizerMeetingTime;
    b.inviteeMeetingTimeType = this.inviteeMeetingTimeType;
    b.userID = this.userID;
    b.gridLocIdx = this.gridLocIdx;
    b.dayIdx = this.dayIdx;
    b.startPos = this.startPos;
    b.lenPos = this.lenPos
};
meetingTimeObj.prototype.toServerString = function() {
    var b = "";
    15 <= this.duration && (b += this.id, this.isOrganizerMeetingTime || -2 == this.locationId ? (b += QUOTE_REPLACE_STRING + this.startTime, b += QUOTE_REPLACE_STRING + this.duration, b += QUOTE_REPLACE_STRING + this.locationId) : b += QUOTE_REPLACE_STRING + this.inviteeMeetingTimeType);
    return b
};
meetingTimeObj.prototype.toInviteeServerString = function() {
    var b = "";
    15 <= this.duration && (b += this.id, this.isOrganizerMeetingTime ? b += QUOTE_REPLACE_STRING + this.inviteeMeetingTimeType : (b += QUOTE_REPLACE_STRING + this.startTime, b += QUOTE_REPLACE_STRING + this.duration, b += QUOTE_REPLACE_STRING + this.locationId));
    return b
};
meetingTimeObj.prototype.GetMeetingStartTime = function(b) {
    return CreateNewDateFromMili(this.startTime, b)
};
meetingTimeObj.prototype.GetMeetingEndTime = function(b) {
    return this.GetMeetingStartTime(b).AddMinutes(this.duration)
};
meetingTimeObj.prototype.toHoursString = function(b, c) {
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration);
    return meetingStr = FormatTimeByUser(d) + c + "to" + c + FormatTimeByUser(e)
};
meetingTimeObj.prototype.toStringWithDate = function(b, c) {
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration);
    return meetingStr = d.formatDate("EE, NNN dd, yyyy") + "&nbsp;&nbsp;&nbsp;" + FormatTimeByUser(d) + c + FormatTimeByUser(e)
};
meetingTimeObj.prototype.toStringWithDateFullMonth = function(b, c) {
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration);
    return meetingStr = d.formatDate("EE, MMM dd, yyyy") + "&nbsp;&nbsp;&nbsp;" + FormatTimeByUser(d) + c + FormatTimeByUser(e)
};
meetingTimeObj.prototype.toStartString = function(b, c) {
    null == c && (c = !0);
    var d = this.GetMeetingStartTime(b);
    d.AddMinutes(this.duration);
    var e = FormatDateWithDayMonthByUser(d) + ", " + FormatTimeByUser(d);
    if (c) var f = FindLocationIdxById(this.locationId),
        e = -1 < f ? e + (", Location: " + CutStringToSize(locations[f].name, 30, !1)) : e + "";
    d.IsPastDue() && (e += " (past due)");
    return e
};
meetingTimeObj.prototype.toMonthDateString = function(b, c) {
    var d = this.GetMeetingStartTime(b);
    d.AddMinutes(this.duration);
    return d.formatDate("E NNN d")
};
meetingTimeObj.prototype.toTimeString = function(b, c) {
    var d = this.GetMeetingStartTime(b);
    d.AddMinutes(this.duration);
    return FormatTimeByUser(d)
};
meetingTimeObj.prototype.toTimeStringSTET = function(b, c) {
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration);
    return meetingStr = FormatTimeByUser(d) + "-" + FormatTimeByUser(e)
};
meetingTimeObj.prototype.toTooltipString = function(b, c) {
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration),
        f = "<span  class=tooltipDay>" + d.formatDate("E NNN d") + "</span><br/>";
    return f += FormatTimeByUser(d) + "-" + FormatTimeByUser(e)
};
meetingTimeObj.prototype.toMeetingString = function(b, c) {
    null == c && (c = !0);
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration),
        e = FormatDateWithDayMonthByUser(d) + ", " + FormatTimeByUser(d) + "-" + FormatTimeByUser(e);
    if (c) var f = FindLocationIdxById(this.locationId),
        e = -1 < f ? e + (", Location: " + CutStringToSize(locations[f].name, 30, !1)) : e + "";
    d.IsPastDue() && (e += " (past due)");
    return e
};
meetingTimeObj.prototype.toString = function(b, c) {
    null == c && (c = !1);
    var d = this.GetMeetingStartTime(b),
        e = d.AddMinutes(this.duration),
        f = FormatDateByUser(d),
        f = f + (", " + FormatDay(d) + " from " + FormatTimeByUser(d) + "-" + FormatTimeByUser(e));
    c && (e = FindLocationIdxById(this.locationId), f = -1 < e ? f + (", Location: " + CutStringToSize(locations[e].name, 30, !1)) : f + "");
    d.IsPastDue() && (f += "(past due)");
    return f
};
meetingTimeObj.prototype.GetDLSChange = function(b) {
    var c = 0;
    b = CreateNewDateFromMili(this.startTime, b);
    return c = b.AddMinutes(this.duration).GetDLSOffset() - b.GetDLSOffset()
};
meetingTimeObj.prototype.CreateHoursArray = function(b, c) {
    ret = [];
    0 == c && 0 < b && (c = 24);
    for (var d = b; d <= c;) ret[ret.length] = d, d++;
    return ret
};
meetingTimeObj.prototype.GetHoursIdxInArray = function(b, c) {
    for (var d = b.length, e = 0; e < d; e++)
        if (b[e] == c) return e;
    return -1
};
meetingTimeObj.prototype.IsInBoundaries = function(b, c, d, e, f) {
    f = CreateNewDateFromMili(this.startTime, f);
    var g = f.AddMinutes(this.duration),
        k = f.GetHoursForShow(),
        l = g.GetHoursForShow();
    0 == l && 0 < k && (l = 24);
    b = b.GetDateOnlyDateTime().AddHours(d);
    if (d != e && (d = this.CreateHoursArray(d, e), k = this.GetHoursIdxInArray(d, k), l = this.GetHoursIdxInArray(d, l), -1 == k || -1 == l || k > l || l == d.length - 1 && 0 < g.GetMinutesForShow())) return !1;
    c = c.AddDays(1).AddHours(e);
    return -1 == f.CompareTo(b) || -1 == g.CompareTo(b) || 1 == f.CompareTo(c) || 1 == g.CompareTo(c) ?
        !1 : !0
};
meetingTimeObj.prototype.IsPastDue = function(b) {
    var c = !1;
    return c = CreateNewDateFromMili(this.startTime, b).IsPastDue()
};

function GetOrganizerMeetings() {
    for (var b = [], c = meetingTimes.length, d = 0; d < c; d++) {
        var e = meetingTimes[d];
        e.isOrganizerMeetingTime && (b[b.length] = e)
    }
    return b
}

function GetMeetingStartsAt(b, c) {
    for (var d = null, e = c.length, f = 0; f < e; f++) b.innerMiliSecs == c[f].startTime && (d = c[f]);
    return d
}

function IsHasMeetingsIn(b, c, d) {
    for (var e = !1, f = d.length, g = 0; g < f; g++) {
        var k = d[g].startTime + d[g].duration * MINUTE_IN_MILISECONDS;
        b.innerMiliSecs >= d[g].startTime && c.innerMiliSecs <= k && (e = !0)
    }
    return e
}

function CountTotalSuggestionsReplied() {
    for (var b = meetingTimes.length, c = 0, d = 0, e = 0, f = 0; f < b; f++) {
        var g = meetingTimes[f]; - 2 != g.locationId ? (c++, g.isOrganizerMeetingTime || g.inviteeMeetingTimeType != InviteeMeetingTypeEnum_Not_Selectd_Yet && d++) : e++
    }
    b = [];
    b[0] = c;
    b[1] = d;
    b[2] = e;
    return b
}

function CountFreeBusyMeetingSuggestions() {
    for (var b = meetingTimes.length, c = 0, d = 0; d < b; d++) - 2 == meetingTimes[d].locationId && c++;
    return c
}

function sortByStartTime(b, c) {
    var d = b.startTime,
        e = c.startTime;
    return d < e ? -1 : d > e ? 1 : 0
}
var meetingTimes = [];

function FindMeetingTimeIdxById(b) {
    return FindMeetingTimeIdxByIdFromMeetsArr(meetingTimes, b)
}

function FindMeetingTimeIdxByIdFromMeetsArr(b, c) {
    if (null != b)
        for (var d = b.length, e = 0; e < d; e++)
            if (b[e].id == c) return e;
    return -1
}

function FindByMeetingTimeID(b) {
    for (var c = meetingTimes.length, d = 0; d < c; d++)
        if (meetingTimes[d].id == b) return meetingTimes[d];
    return null
}

function GetUserFreeBusyMeetingTimes(b, c) {
    null == c && (c = !1);
    window.status = "start " + b;
    for (var d = [], e = meetingTimes.length, f = 0; f < e; f++)
        if (meetingTimes[f].userID == b && -2 == meetingTimes[f].locationId) {
            var g = !0;
            c && meetingTimes[f].isOrganizerMeetingTime && (g = !1);
            g && (d[d.length] = meetingTimes[f])
        }
    window.status = "end " + b;
    d.sort(sortByStartTime);
    return d
}

function SortMeetingTimesArray(b) {
    b.sort(sortByStartTime);
    return b
}
var MINUTE_HEIGHT = 22 / 30,
    InviteeMeetingTypeEnum_Works_Best_For_Me = 11,
    InviteeMeetingTypeEnum_Can_Make_It = 12,
    InviteeMeetingTypeEnum_Cannot_Make_It = 13,
    InviteeMeetingTypeEnum_Not_Selectd_Yet = 39;

function UserDataObj() {
    this.id = -1;
    this.emailSignature = this.lastName = this.firstName = this.email = "";
    this.userType = -1;
    this.organizationName = "";
    this.userTimeFormat = 30;
    this.userStartWeekDay = 1;
    this.userEndWeekDay = 5;
    this.userDateFormatString = "MM/dd/yy";
    this.userTimeFormatString = "h:mma";
    this.TimeFormatEnum_Twelve_Hours = -1;
    this.userStartDayHour = 8;
    this.userEndDayHour = 17;
    this.userTimeZone = new TimeZoneObj(-1, "UTC", "(UTC/GMT)", "", "", 0, !1)
}
UserDataObj.prototype.GetFullName = function() {
    var b = this.firstName;
    return b += " " + this.lastName
};
UserDataObj.prototype.toString = function(b) {
    var c = "",
        c = "";
    "" != this.firstName && null != this.firstName && (c = this.firstName);
    "" != this.lastName && null != this.lastName && (c += " " + this.lastName);
    c = "" != c ? c + " (" + this.email + ")" : this.email;
    return c = '<a class="operation" style="' + b + '" href="mailto:' + this.email + '">' + c + "</a>"
};
var UserTypeEnum_New = 32,
    UserTypeEnum_Registered = 33,
    UserTypeEnum_Invitee = 34,
    UserTypeEnum_Frozen = 35,
    UserTypeEnum_Deleted = 36,
    UserTypeEnum_Admin = 37,
    UserTypeEnum_QuickMeeting = 38,
    currUserData = new UserDataObj;

function SyncUserDataWithParent() {
    var b = window.parent;
    window.GetParentObject && (b = GetParentObject());
    null != b && (currUserData = -1 != b.currUserData.id ? b.currUserData : this.top.currUserData)
}

function SaveUserDateTimeFormatCookie(b) {
    createCookie("userDateTimeFormat", b, 1E3)
}
var userDateTimeFormatCookieValue = -1;

function GetUserDateTimeFormatCookie() {
    if (0 <= userDateTimeFormatCookieValue) return userDateTimeFormatCookieValue;
    var b = readCookie("userDateTimeFormat");
    if (null == b || "" == b) b = "0", SaveUserDateTimeFormatCookie(b);
    return parseInt(b)
}

function FormatDateByUser(b) {
    switch (GetUserDateTimeFormatCookie()) {
        case 0:
        case 1:
            return b.formatDate("MM/dd/yyyy");
        case 2:
        case 3:
            return b.formatDate("dd/MM/yyyy")
    }
}

function FormatDateWithDayByUser(b) {
    switch (GetUserDateTimeFormatCookie()) {
        case 0:
        case 1:
            return b.formatDate("E MM/dd");
        case 2:
        case 3:
            return b.formatDate("E dd/MM")
    }
}

function FormatDateWithDayMonthByUser(b) {
    switch (GetUserDateTimeFormatCookie()) {
        case 0:
        case 1:
            return b.formatDate("E NNN d");
        case 2:
        case 3:
            return b.formatDate("E d NNN")
    }
}

function FormatDateWithDayMonthYearByUser(b, c) {
    var d = c ? "E" : "EE",
        e = c ? "NNN" : "MMM";
    switch (GetUserDateTimeFormatCookie()) {
        case 0:
        case 1:
            return b.formatDate(d + ", " + e + " dd, yyyy");
        case 2:
        case 3:
            return b.formatDate(d + ", dd " + e + " yyyy")
    }
}

function FormatTimeByUser(b, c) {
    null == c && (c = "");
    switch (GetUserDateTimeFormatCookie()) {
        case 0:
        case 2:
            return 0 < c.length ? b.formatDate("hh:mm" + c + " A") : b.formatDate("hh:mm A");
        case 1:
        case 3:
            return b.formatDate("HH:mm")
    }
}

function FormatTimeByUserNoCookie(b, c) {
    switch (c) {
        case 0:
        case 2:
            return b.formatDate("h:mm A");
        case 1:
        case 3:
            return b.formatDate("HH:mm");
        default:
            return b.formatDate("HH:mm")
    }
}

function FormatTimeByUserShort(b, c) {
    null == c && (c = "");
    switch (GetUserDateTimeFormatCookie()) {
        case 0:
        case 2:
            return 0 < c.length ? b.formatDate("h" + c + "a") : b.formatDate("ha");
        case 1:
        case 3:
            return "0" == b.formatDate("H") ? "00" : b.formatDate("H")
    }
}

function FormatDateTimeByUser(b) {
    return FormatDateByUser(b) + " " + FormatTimeByUser(b)
}

function FormatDay(b) {
    return b.formatDate("E")
};
var timezonesCount = 292;

function GenerateTimeZoneObjFromID(b) {
    var c = null;
    switch (b) {
        case 1:
            c = new TimeZoneObj(1, "", "(UTC/GMT)", "", "", 0, !1, "");
            break;
        case 2:
            c = new TimeZoneObj(2, "AF", "Afghanistan", "Kabul", "", 4.5, !1, 93);
            break;
        case 3:
            c = new TimeZoneObj(3, "AL", "Albania", "Tirane", "", 1, !0, 355);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 4:
            c = new TimeZoneObj(4, "DZ", "Algeria", "Algiers", "", 1, !1, 213);
            break;
        case 5:
            c = new TimeZoneObj(5, "AS", "American Samoa", "Pago Pago", "", -11, !1, 1684);
            break;
        case 6:
            c = new TimeZoneObj(6, "AD", "Andorra", "Andorra La Vella", "", 1, !0, 376);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b =
                new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 7:
            c = new TimeZoneObj(7, "AO", "Angola", "Luanda", "", 1, !1, 244);
            break;
        case 8:
            c = new TimeZoneObj(8, "AI", "Anguilla", "Crocus Hill", "", -4, !1,
                1264);
            break;
        case 9:
            c = new TimeZoneObj(9, "AG", "Antigua and Barbuda", "St. Johns", "", -4, !1, 1268);
            break;
        case 10:
            c = new TimeZoneObj(10, "AR", "Argentina", "East (Buenos Aires)", "", -3, !0, 54);
            b = new DayLightSavingObj(-2, 12243852E5, 12371688E5);
            c.AddDayLightSavings(b);
            break;
        case 11:
            c = new TimeZoneObj(11, "AM", "Armenia", "Yerevan", "", 4, !0, 374);
            b = new DayLightSavingObj(5, 12697272E5, 1288476E6);
            c.AddDayLightSavings(b);
            break;
        case 12:
            c = new TimeZoneObj(12, "AW", "Aruba", "Oranjestad", "", -4, !1, 297);
            break;
        case 13:
            c = new TimeZoneObj(13,
                "AU", "Australia", "Western Australia (Perth)", "", 8, !0, 61);
            b = new DayLightSavingObj(9, 12249576E5, 12383496E5);
            c.AddDayLightSavings(b);
            break;
        case 14:
            c = new TimeZoneObj(14, "AU", "Australia", "Northern Territory (Darwin)", "", 9.5, !1, 61);
            break;
        case 15:
            c = new TimeZoneObj(15, "AU", "Australia", "South Australia (Adelaide)", "", 9.5, !0, 61);
            b = new DayLightSavingObj(10.5, 14438898E5, 14596146E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(10.5, 1349541E6, 13652658E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(10.5,
                14753394E5, 14910642E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(10.5, 1506789E6, 15225138E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(10.5, 13809906E5, 13967154E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(10.5, 14124402E5, 1428165E6);
            c.AddDayLightSavings(b);
            break;
        case 16:
            c = new TimeZoneObj(16, "AU", "Australia", "New South Wales, Victoria, Tasmania (Sydney, Melbourne, Canberra, Hobart)", "", 10, !0, 61);
            b = new DayLightSavingObj(11, 1443888E6, 14596128E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(11,
                13495392E5, 1365264E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(11, 14124384E5, 14281632E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(11, 13809888E5, 13967136E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(11, 15067872E5, 1522512E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(11, 14753376E5, 14910624E5);
            c.AddDayLightSavings(b);
            break;
        case 17:
            c = new TimeZoneObj(17, "AU", "Australia", "Queensland (Brisbane)", "", 10, !1, 61);
            break;
        case 18:
            c = new TimeZoneObj(18, "AT", "Austria", "Vienna, Salzburg", "",
                1, !0, 43);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 19:
            c = new TimeZoneObj(19, "AZ", "Azerbaijan", "Baku",
                "", 4, !0, 994);
            b = new DayLightSavingObj(5, 1364688E6, 1382832E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(5, 13961376E5, 14142816E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(5, 13326336E5, 13513824E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(5, 14275872E5, 14457312E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(5, 14590368E5, 14777856E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(5, 14904864E5, 15092352E5);
            c.AddDayLightSavings(b);
            break;
        case 20:
            c = new TimeZoneObj(20, "", "Bahamas", "Nassau",
                "", -5, !0, 1242);
            b = new DayLightSavingObj(-4, 13314492E5, 13520088E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1425798E6, 14463576E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13628988E5, 13834584E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13943484E5, 1414908E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1489302E6, 15098616E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14578524E5, 1478412E6);
            c.AddDayLightSavings(b);
            break;
        case 21:
            c = new TimeZoneObj(21, "BH", "Bahrain",
                "Manama", "", 3, !1, 973);
            break;
        case 22:
            c = new TimeZoneObj(22, "BD", "Bangladesh", "Dhaka", "", 6, !0, 880);
            b = new DayLightSavingObj(7, 12454344E5, 1262286E6);
            c.AddDayLightSavings(b);
            break;
        case 23:
            c = new TimeZoneObj(23, "BB", "Barbados", "Bridgetown", "", -4, !1, 1246);
            break;
        case 24:
            c = new TimeZoneObj(24, "BY", "Belarus", "Minsk", "", 3, !0, 375);
            break;
        case 25:
            c = new TimeZoneObj(25, "BE", "Belgium", "Brussels", "", 1, !0, 32);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 26:
            c = new TimeZoneObj(26, "BZ", "Belize", "Belize City", "", -6, !1, 501);
            break;
        case 27:
            c = new TimeZoneObj(27, "BJ", "Benin", "Cotonou", "", 1, !1, 229);
            break;
        case 28:
            c = new TimeZoneObj(28, "BM",
                "Bermuda", "Hamilton", "", -4, !0, 1441);
            b = new DayLightSavingObj(-3, 13314456E5, 13520052E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14892984E5, 1509858E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14257944E5, 1446354E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14578488E5, 14784084E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13628952E5, 13834548E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13943448E5, 14149044E5);
            c.AddDayLightSavings(b);
            break;
        case 29:
            c = new TimeZoneObj(29,
                "BT", "Bhutan", "Thimphu", "", 6, !1, 975);
            break;
        case 30:
            c = new TimeZoneObj(30, "BO", "Bolivia", "La Paz", "", -4, !1, 591);
            break;
        case 31:
            c = new TimeZoneObj(31, "BA", "Bosnia and Herzegovina", "Sarajevo", "", 1, !0, 387);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 32:
            c = new TimeZoneObj(32, "BW", "Botswana", "Gaborone", "", 2, !1, 267);
            break;
        case 33:
            c = new TimeZoneObj(33, "BR", "Brazil", "Fernando de Noronha (Vila dos Remedios)", "", -2, !1, 55);
            break;
        case 34:
            c = new TimeZoneObj(34, "BR", "Brazil", "Eastern Brazil (Fortaleza , Recife, Salvador)", "", -3, !1, 55);
            break;
        case 35:
            c = new TimeZoneObj(35, "BR", "Brazil", "Central Brazil (Rio de Janeiro, Sao Paulo, Brasilia)",
                "", -3, !0, 55);
            b = new DayLightSavingObj(-2, 15080364E5, 15189192E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14451372E5, 145602E7);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 1318734E6, 13302216E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14136876E5, 14245704E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 13507884E5, 13610664E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 1382238E6, 1392516E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14765868E5, 14874696E5);
            c.AddDayLightSavings(b);
            break;
        case 36:
            c = new TimeZoneObj(36, "BR", "Brazil", "Northern Brazil (Santarem, Porto Velho, Boa Vista)", "", -4, !1, 55);
            break;
        case 37:
            c = new TimeZoneObj(37, "BR", "Brazil", "Mato Grosso, Mato Grosso do Sul (Cuiaba, Campo Grande)", "", -4, !0, 55);
            b = new DayLightSavingObj(-3, 13187376E5, 13302252E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14765904E5, 14874732E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 150804E7, 15189228E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3,
                14136912E5, 1424574E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 1350792E6, 136107E7);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13822416E5, 13925196E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14451408E5, 14560236E5);
            c.AddDayLightSavings(b);
            break;
        case 39:
            c = new TimeZoneObj(39, "", "Brunei Darussalam", "Bandar Seri Begawan", "", 8, !1, 673);
            break;
        case 40:
            c = new TimeZoneObj(40, "BG", "Bulgaria", "Sofia", "", 2, !0, 359);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            break;
        case 41:
            c = new TimeZoneObj(41, "BF", "Burkina Faso", "Ouagadougou", "", 0, !1, 226);
            break;
        case 42:
            c = new TimeZoneObj(42, "BI", "Burundi", "Bujumbura",
                "", 2, !1, 257);
            break;
        case 43:
            c = new TimeZoneObj(43, "KH", "Cambodia", "Phnom Penh", "", 7, !1, 855);
            break;
        case 44:
            c = new TimeZoneObj(44, "CM", "Cameroon", "Yaounde", "", 1, !1, 237);
            break;
        case 45:
            c = new TimeZoneObj(45, "CA", "Canada", "Labrador - exception (Port Hope Simpson)", "", -3.5, !0, 1);
            break;
        case 46:
            c = new TimeZoneObj(46, "CA", "Canada", "Newfoundland (St. Johns)", "", -3.5, !0, 1);
            b = new DayLightSavingObj(-2.5, 13314438E5, 13520034E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2.5, 1457847E6, 14784066E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2.5, 14892966E5, 15098562E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2.5, 1394343E6, 14149026E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2.5, 13628934E5, 1383453E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2.5, 14257926E5, 14463522E5);
            c.AddDayLightSavings(b);
            break;
        case 47:
            c = new TimeZoneObj(47, "CA", "Canada", "Labrador, Nova Scotia, Prince Edward Island", "", -4, !0, 1);
            b = new DayLightSavingObj(-3, 14257944E5, 1446354E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3,
                14578488E5, 14784084E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14892984E5, 1509858E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13628952E5, 13834548E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13943448E5, 14149044E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13314456E5, 13520052E5);
            c.AddDayLightSavings(b);
            break;
        case 48:
            c = new TimeZoneObj(48, "CA", "Canada", "New Brunswick (Fredericton)", "", -4, !0, 1);
            b = new DayLightSavingObj(-3, 13314456E5, 13520052E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14578488E5, 14784084E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13628952E5, 13834548E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13943448E5, 14149044E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14257944E5, 1446354E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14892984E5, 1509858E6);
            c.AddDayLightSavings(b);
            break;
        case 49:
            c = new TimeZoneObj(49, "CA", "Canada", "Quebec - far east (Blanc-Sablon)", "", -4, !1, 1);
            break;
        case 50:
            c = new TimeZoneObj(50, "CA",
                "Canada", "Ontario, Quebec, Nunavut (Eastern) (Toronto, Ottawa, Montreal)", "", -5, !0, 1);
            b = new DayLightSavingObj(-4, 13314492E5, 13520088E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1489302E6, 15098616E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1425798E6, 14463576E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13628988E5, 13834584E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13943484E5, 1414908E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14578524E5, 1478412E6);
            c.AddDayLightSavings(b);
            break;
        case 51:
            c = new TimeZoneObj(51, "CA", "Canada", "Saskatchewan-exceptions (east)", "", -6, !0, 1);
            b = new DayLightSavingObj(-5, 14893056E5, 15098688E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14258016E5, 14463648E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13314528E5, 13518396E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13629024E5, 1383462E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 1394352E6, 14149116E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5,
                1457856E6, 14784192E5);
            c.AddDayLightSavings(b);
            break;
        case 52:
            c = new TimeZoneObj(52, "CA", "Canada", "Nunavut - Southampton Island, Ontario (western)", "", -6, !0, 1);
            b = new DayLightSavingObj(-5, 12050496E5, 12256092E5);
            c.AddDayLightSavings(b);
            break;
        case 53:
            c = new TimeZoneObj(53, "CA", "Canada", "Saskatchewan (Regina, Saskatoon)", "", -6, !1, 1);
            break;
        case 54:
            c = new TimeZoneObj(54, "CA", "Canada", "Manitoba (Winnipeg)", "", -6, !0, 1);
            b = new DayLightSavingObj(-5, 14258016E5, 14463612E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5,
                1457856E6, 14784156E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14893056E5, 15098652E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13629024E5, 1383462E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13314528E5, 13520124E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 1394352E6, 14149116E5);
            c.AddDayLightSavings(b);
            break;
        case 55:
            c = new TimeZoneObj(55, "CA", "Canada", "Alberta, Northwest Territories, Nunavut (Central, mountain), Saskatchewan (exceptions - west)", "", -7, !0, 1);
            b = new DayLightSavingObj(-6,
                13314564E5, 1352016E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14258052E5, 14463648E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14893092E5, 15098688E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14578596E5, 14784192E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 13943556E5, 14149152E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 1362906E6, 13834656E5);
            c.AddDayLightSavings(b);
            break;
        case 56:
            c = new TimeZoneObj(56, "CA", "Canada", "British Columbia (Mountain time) (Does not observe DST)",
                "", -7, !1, 1);
            break;
        case 57:
            c = new TimeZoneObj(57, "CA", "Canada", "British Columbia (Pacific Time)", "", -8, !0, 1);
            b = new DayLightSavingObj(-7, 13629096E5, 13834692E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14893128E5, 15098724E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 133146E7, 13520196E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 13943592E5, 14149188E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14258088E5, 14463684E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7,
                14578632E5, 14784228E5);
            c.AddDayLightSavings(b);
            break;
        case 58:
            c = new TimeZoneObj(58, "CV", "Cape Verde", "Praia", "", -1, !1, 238);
            break;
        case 59:
            c = new TimeZoneObj(59, "KY", "Cayman Islands", "George Town", "", -5, !1, 1345);
            break;
        case 60:
            c = new TimeZoneObj(60, "CF", "Central African Republic", "Bangui", "", 1, !1, 236);
            break;
        case 61:
            c = new TimeZoneObj(61, "TD", "Chad", "NDjamena", "", 1, !1, 235);
            break;
        case 62:
            c = new TimeZoneObj(62, "CL", "Chile", "Santiago", "", -4, !0, 56);
            b = new DayLightSavingObj(-3, 13465584E5, 1367118E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13138992E5, 13356684E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 15044112E5, 15249708E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14100624E5, 14300172E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 1441512E6, 14620716E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14729616E5, 14935212E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13786128E5, 13985676E5);
            c.AddDayLightSavings(b);
            break;
        case 63:
            c = new TimeZoneObj(63, "", "Chile - Easter Island",
                "Easter Island", "", -6, !0, 56);
            b = new DayLightSavingObj(-5, 13465584E5, 1367118E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13786128E5, 13985676E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 1441512E6, 14620716E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14729616E5, 14935212E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 15044112E5, 15249708E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13138992E5, 13356684E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14100624E5,
                14300172E5);
            c.AddDayLightSavings(b);
            break;
        case 64:
            c = new TimeZoneObj(64, "", "China", "Beijing, Shanghai, Chengdu", "", 8, !1, 86);
            break;
        case 65:
            c = new TimeZoneObj(65, "CX", "Christmas Island", "The Settlement", "", 7, !1, 61);
            break;
        case 66:
            c = new TimeZoneObj(66, "CC", "Cocos (Keeling) Islands", "West Island", "", 6.5, !1, 61);
            break;
        case 67:
            c = new TimeZoneObj(67, "CO", "Colombia", "Bogota", "", -5, !1, 57);
            break;
        case 68:
            c = new TimeZoneObj(68, "KM", "Comoros", "Moroni", "", 3, !1, 269);
            break;
        case 69:
            c = new TimeZoneObj(69, "", "Congo", "Brazzaville",
                "", 1, !1, 243);
            break;
        case 70:
            c = new TimeZoneObj(70, "", "Congo, The Democratic Republic of the", "Eastern (Kananga, Kolwezi, Lubumbashi, Mbuji-Mayi)", "", 2, !1, 243);
            break;
        case 71:
            c = new TimeZoneObj(71, "", "Congo, The Democratic Republic of the", "Western (Kinshasa)", "", 1, !1, 243);
            break;
        case 72:
            c = new TimeZoneObj(72, "CK", "Cook Islands", "Rarotonga", "", -10, !1, 682);
            break;
        case 73:
            c = new TimeZoneObj(73, "CR", "Costa Rica", "San Jose", "", -6, !1, 506);
            break;
        case 74:
            c = new TimeZoneObj(74, "", "Cote DIvoire", "Abidjan", "", 0, !1, 225);
            break;
        case 75:
            c = new TimeZoneObj(75, "HR", "Croatia", "Zagreb", "", 1, !0, 385);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 76:
            c = new TimeZoneObj(76, "CU", "Cuba", "Havana", "", -5, !0, 53);
            b = new DayLightSavingObj(-4, 13628916E5, 13834548E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13943412E5, 14149044E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14578452E5, 14784084E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14892948E5, 1509858E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14257908E5, 1446354E6);
            c.AddDayLightSavings(b);
            break;
        case 77:
            c = new TimeZoneObj(77, "CY", "Cyprus", "Nicosia", "", 2, !0, 357);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 78:
            c = new TimeZoneObj(78, "CZ", "Czech Republic", "Prague",
                "", 1, !0, 420);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 79:
            c = new TimeZoneObj(79, "DK", "Denmark", "Copenhagen",
                "", 1, !0, 45);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 80:
            c = new TimeZoneObj(80, "DJ", "Djibouti", "Djibouti",
                "", 3, !1, 253);
            break;
        case 81:
            c = new TimeZoneObj(81, "DM", "Dominica", "Roseau", "", -4, !1, 1767);
            break;
        case 82:
            c = new TimeZoneObj(82, "DO", "Dominican Republic", "Santo Domingo", "", -4, !1, 1809);
            break;
        case 83:
            c = new TimeZoneObj(83, "EC", "Ecuador", "Quito", "", -5, !1, 593);
            break;
        case 84:
            c = new TimeZoneObj(84, "", "Ecuador - Galapagos Islands", "Galapagos Islands", "", -6, !1, 593);
            break;
        case 85:
            c = new TimeZoneObj(85, "EG", "Egypt", "Cairo", "", 2, !0, 20);
            break;
        case 86:
            c = new TimeZoneObj(86, "SV", "El Salvador", "San Salvador", "", -6, !1, 503);
            break;
        case 87:
            c = new TimeZoneObj(87, "GQ", "Equatorial Guinea", "Malabo", "", 1, !1, 240);
            break;
        case 88:
            c = new TimeZoneObj(88, "ER", "Eritrea", "Asmara", "", 3, !1, 291);
            break;
        case 89:
            c = new TimeZoneObj(89, "EE", "Estonia", "Tallinn", "", 2, !0, 372);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 90:
            c = new TimeZoneObj(90, "ET", "Ethiopia", "Addis Ababa", "", 3, !1, 251);
            break;
        case 91:
            c = new TimeZoneObj(91, "", "Falkland Islands (Malvinas)", "Port Stanley", "", -4, !0, 500);
            break;
        case 92:
            c = new TimeZoneObj(92, "FO", "Faroe Islands", "Torshaven", "", 0, !0, 298);
            b = new DayLightSavingObj(1, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1,
                14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 93:
            c = new TimeZoneObj(93, "FJ", "Fiji", "Suva", "", 12, !0, 679);
            b = new DayLightSavingObj(13, 1319292E6, 13271544E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13,
                13507416E5, 1358604E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 1382796E6, 13900536E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 14456952E5, 14535576E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 14771448E5, 14850072E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 14142456E5, 1422108E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 15085944E5, 15164568E5);
            c.AddDayLightSavings(b);
            break;
        case 94:
            c = new TimeZoneObj(94, "FI", "Finland", "Helsinki", "", 2, !0, 358);
            b = new DayLightSavingObj(3,
                14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 95:
            c = new TimeZoneObj(95, "FR", "France", "Paris", "", 1, !0, 33);
            b = new DayLightSavingObj(2,
                13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 96:
            c = new TimeZoneObj(96, "GF", "French Guiana", "Cayenne", "", -3, !1, 594);
            break;
        case 97:
            c =
                new TimeZoneObj(97, "PF", "French Polynesia", "Gambier Islands", "", -9, !1, 689);
            break;
        case 98:
            c = new TimeZoneObj(98, "PF", "French Polynesia", "Marquesas Islands", "", -9.5, !1, 689);
            break;
        case 99:
            c = new TimeZoneObj(99, "PF", "French Polynesia", "Society Archipelago (including Tahiti), Tuamotu Archipelago, Tubuai Islands", "", -10, !1, 689);
            break;
        case 100:
            c = new TimeZoneObj(100, "GA", "Gabon", "Libreville", "", 1, !1, 241);
            break;
        case 101:
            c = new TimeZoneObj(101, "", "Gambia", "Banjul", "", 0, !1, 220);
            break;
        case 102:
            c = new TimeZoneObj(102,
                "GE", "Georgia", "Tbilisi", "", 4, !1, 995);
            break;
        case 103:
            c = new TimeZoneObj(103, "DE", "Germany", "Berlin, Bonn, Frankfurt", "", 1, !0, 49);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 104:
            c = new TimeZoneObj(104, "GH", "Ghana", "Accra", "", 0, !1, 233);
            break;
        case 105:
            c = new TimeZoneObj(105, "GI", "Gibraltar", "Gibraltar", "", 1, !0, 350);
            b = new DayLightSavingObj(2, 13326372E5, 13513824E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457312E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 106:
            c = new TimeZoneObj(106, "GR", "Greece", "Athens", "", 2, !0, 30);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3,
                13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 107:
            c = new TimeZoneObj(107, "GL", "Greenland", "Ittoqqortoormiit, Nerlerit Inaat (Scoresbysund)", "", -1, !0, 299);
            b = new DayLightSavingObj(0, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            break;
        case 108:
            c = new TimeZoneObj(108, "GL", "Greenland", "Greenland (Nuuk)", "", -3, !0, 299);
            b = new DayLightSavingObj(-2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2,
                14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 109:
            c = new TimeZoneObj(109, "GL", "Greenland", "Pituffik (Thule)", "", -4, !0, 299);
            b = new DayLightSavingObj(-3, 13314456E5, 13520052E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14257944E5, 1446354E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14578488E5, 14784084E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13628952E5, 13834548E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14892984E5, 1509858E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 13943448E5, 14149044E5);
            c.AddDayLightSavings(b);
            break;
        case 110:
            c = new TimeZoneObj(110, "GD", "Grenada", "Saint Georges", "", -4, !1, 1473);
            break;
        case 111:
            c = new TimeZoneObj(111, "GP", "Guadeloupe", "Pointe-a-Pitre", "", -4, !1, 590);
            break;
        case 112:
            c = new TimeZoneObj(112, "GU", "Guam", "Hagatna", "", 10, !1, 1671);
            break;
        case 113:
            c = new TimeZoneObj(113,
                "GT", "Guatemala", "Guatemala City", "", -6, !0, 502);
            break;
        case 114:
            c = new TimeZoneObj(114, "GN", "Guinea", "Conakry", "", 0, !1, 224);
            break;
        case 115:
            c = new TimeZoneObj(115, "GW", "Guinea-Bissau", "Bissau", "", 0, !1, 245);
            break;
        case 116:
            c = new TimeZoneObj(116, "GY", "Guyana", "Georgetown", "", -4, !1, 592);
            break;
        case 117:
            c = new TimeZoneObj(117, "HT", "Haiti", "Port-au-Prince", "", -5, !0, 509);
            b = new DayLightSavingObj(-4, 13943484E5, 1414908E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1425798E6, 14463576E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14578524E5, 1478412E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13628988E5, 13834584E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1489302E6, 15098616E5);
            c.AddDayLightSavings(b);
            break;
        case 118:
            c = new TimeZoneObj(118, "HN", "Honduras", "Tegucigalpa", "", -6, !1, 504);
            break;
        case 119:
            c = new TimeZoneObj(119, "HK", "Hong Kong", "Hong Kong", "", 8, !1, 852);
            break;
        case 120:
            c = new TimeZoneObj(120, "HU", "Hungary", "Budapest", "", 1, !0, 36);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 121:
            c = new TimeZoneObj(121, "IS", "Iceland", "Reykjavik", "", 0, !1, 354);
            break;
        case 122:
            c = new TimeZoneObj(122, "IN",
                "India", "New Delhi, Bangalore, Kolkata, Chennai, Mumbai", "", 5.5, !1, 91);
            break;
        case 123:
            c = new TimeZoneObj(123, "ID", "Indonesia", "Central (Denpasar, Banjarmasin, Kupang, Makassar)", "", 8, !1, 62);
            break;
        case 124:
            c = new TimeZoneObj(124, "ID", "Indonesia", "Eastern (Ambon, Jayapura)", "", 9, !1, 62);
            break;
        case 125:
            c = new TimeZoneObj(125, "ID", "Indonesia", "Western (Jakarta, Medan, Surabaya)", "", 7, !1, 62);
            break;
        case 126:
            c = new TimeZoneObj(126, "", "Iran, Islamic Republic of", "Tehran", "", 3.5, !0, 98);
            b = new DayLightSavingObj(4.5,
                13322754E5, 13481694E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(4.5, 14901282E5, 15060222E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(4.5, 13638978E5, 13797918E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(4.5, 13954338E5, 14113278E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(4.5, 14585058E5, 14743998E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(4.5, 14269698E5, 14428638E5);
            c.AddDayLightSavings(b);
            break;
        case 127:
            c = new TimeZoneObj(127, "IQ", "Iraq", "Baghdad", "", 3, !0, 964);
            b = new DayLightSavingObj(4,
                11753856E5, 11911932E5);
            c.AddDayLightSavings(b);
            break;
        case 128:
            c = new TimeZoneObj(128, "IE", "Ireland", "Dublin, Belfast", "", 0, !0, 353);
            b = new DayLightSavingObj(1, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 129:
            c = new TimeZoneObj(129, "IL", "Israel", "Jerusalem, Tel Aviv", "", 2, !0, 972);
            b = new DayLightSavingObj(3, 13330656E5, 13483548E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14903136E5, 15092316E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14274144E5, 14457276E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13645152E5, 13828284E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 1458864E6, 1477782E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3,
                13959648E5, 1414278E6);
            c.AddDayLightSavings(b);
            break;
        case 130:
            c = new TimeZoneObj(130, "IT", "Italy", "Milan, Rome", "", 1, !0, 39);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 131:
            c = new TimeZoneObj(131, "JM", "Jamaica", "Kingston", "", -5, !1, 1876);
            break;
        case 132:
            c = new TimeZoneObj(132, "JP", "Japan", "Kyoto, Osaka, Tokyo, Yokohama", "", 9, !1, 81);
            break;
        case 133:
            c = new TimeZoneObj(133, "", "Johnston Atoll (U.S.)", "Johnston Atoll", "", -10, !1, 1);
            break;
        case 134:
            c = new TimeZoneObj(134, "JO", "Jordan", "Amman", "", 2, !0, 962);
            b = new DayLightSavingObj(3, 13330584E5, 13874904E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14274072E5, 1446156E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14594616E5, 14776056E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14909112E5, 15090552E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13959576E5, 14147064E5);
            c.AddDayLightSavings(b);
            break;
        case 135:
            c = new TimeZoneObj(135, "KZ", "Kazakhstan", "Eastern (Astana, Almaty, Qostanay, Qyzylorda)", "", 6, !1, 7);
            break;
        case 136:
            c = new TimeZoneObj(136, "KZ", "Kazakhstan", "Western (Aktobe, Aktau, Atyrau, Oral)", "", 5, !1, 7);
            break;
        case 137:
            c = new TimeZoneObj(137, "KE",
                "Kenya", "Nairobi", "", 3, !1, 254);
            break;
        case 138:
            c = new TimeZoneObj(138, "KI", "Kiribati", "Tarawa", "", 12, !1, 686);
            break;
        case 139:
            c = new TimeZoneObj(139, "", "Korea, Democratic Peoples Republic of", "Pyongyang", "", 9, !1, 850);
            break;
        case 140:
            c = new TimeZoneObj(140, "", "Korea, Republic of", "Seoul", "", 9, !1, 82);
            break;
        case 141:
            c = new TimeZoneObj(141, "KW", "Kuwait", "Kuwait City", "", 3, !1, 965);
            break;
        case 142:
            c = new TimeZoneObj(142, "KG", "Kyrgyzstan", "Bishkek", "", 6, !1, 996);
            break;
        case 143:
            c = new TimeZoneObj(143, "", "Lao Peoples Democratic Republic",
                "Vientiane", "", 7, !1, 856);
            break;
        case 144:
            c = new TimeZoneObj(144, "LV", "Latvia", "Riga", "", 2, !0, 371);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 145:
            c = new TimeZoneObj(145, "LB", "Lebanon", "Beirut", "", 2, !0, 961);
            b = new DayLightSavingObj(3, 14590296E5, 14777748E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14904792E5, 15092244E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326264E5, 13513716E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961304E5, 14142708E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646808E5, 13828212E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 142758E7, 14457204E5);
            c.AddDayLightSavings(b);
            break;
        case 146:
            c = new TimeZoneObj(146, "LS", "Lesotho", "Maseru", "", 2, !1, 266);
            break;
        case 147:
            c = new TimeZoneObj(147, "LR", "Liberia", "Monrovia", "", 0, !1, 231);
            break;
        case 148:
            c = new TimeZoneObj(148, "", "Libyan Arab Jamahiriya", "Tripoli", "", 2, !1, 218);
            break;
        case 149:
            c = new TimeZoneObj(149, "LI", "Liechtenstein", "Vaduz", "", 1, !0, 423);
            b = new DayLightSavingObj(2, 13326372E5, 13513824E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 150:
            c = new TimeZoneObj(150, "LT", "Lithuania", "Vilnius", "", 2, !0, 370);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3,
                14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 151:
            c = new TimeZoneObj(151, "LU", "Luxembourg", "Luxembourg", "", 1, !0, 352);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 152:
            c = new TimeZoneObj(152, "MO", "Macau", "Macao", "", 8, !1, 853);
            break;
        case 153:
            c = new TimeZoneObj(153, "", "Macedonia, The Former Yugoslav Republic Of", "Skopje", "", 1, !0, 389);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 154:
            c = new TimeZoneObj(154, "MG", "Madagascar", "Antananarivo", "", 3, !1, 261);
            break;
        case 155:
            c = new TimeZoneObj(155, "MW", "Malawi", "Lilongwe",
                "", 2, !1, 265);
            break;
        case 156:
            c = new TimeZoneObj(156, "MY", "Malaysia", "Kuala Lumpur", "", 8, !1, 60);
            break;
        case 157:
            c = new TimeZoneObj(157, "MV", "Maldives", "Male", "", 5, !1, 960);
            break;
        case 158:
            c = new TimeZoneObj(158, "ML", "Mali", "Bamako", "", 0, !1, 223);
            break;
        case 159:
            c = new TimeZoneObj(159, "MT", "Malta", "Valletta", "", 1, !0, 356);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 160:
            c = new TimeZoneObj(160, "MH", "Marshall Islands", "Majuro", "", 12, !1, 692);
            break;
        case 161:
            c = new TimeZoneObj(161, "MQ", "Martinique", "Maputo", "", -4, !1, 596);
            break;
        case 162:
            c = new TimeZoneObj(162, "MR", "Mauritania", "Nouakchott", "", 0, !1, 222);
            break;
        case 163:
            c =
                new TimeZoneObj(163, "MU", "Mauritius", "Port Louis", "", 4, !0, 230);
            b = new DayLightSavingObj(5, 12254904E5, 12384468E5);
            c.AddDayLightSavings(b);
            break;
        case 164:
            c = new TimeZoneObj(164, "YT", "Mayotte", "Mamoudzou", "", 3, !1, 262);
            break;
        case 165:
            c = new TimeZoneObj(165, "MX", "Mexico", "South, central and eastern (Mexico City, Guadalajara, Puebla)", "", -6, !0, 52);
            b = new DayLightSavingObj(-5, 14596704E5, 14778108E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 149112E7, 15092604E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5,
                13332672E5, 13514076E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13653216E5, 13828572E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13967712E5, 14143068E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14282208E5, 14457564E5);
            c.AddDayLightSavings(b);
            break;
        case 166:
            c = new TimeZoneObj(166, "MX", "Mexico", "Baja California Sur, Chihuahua, Nayarit, Sinaloa", "", -7, !0, 52);
            b = new DayLightSavingObj(-6, 13332708E5, 13514112E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14893092E5, 15098688E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 1362906E6, 13834656E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14258052E5, 14463648E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14578596E5, 14784192E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 13943556E5, 14149152E5);
            c.AddDayLightSavings(b);
            break;
        case 167:
            c = new TimeZoneObj(167, "MX", "Mexico", "Baja California Norte (Ensenada, Tijuana)", "", -8, !0, 52);
            b = new DayLightSavingObj(-7, 133146E7, 13520196E5);
            c.AddDayLightSavings(b);
            b =
                new DayLightSavingObj(-7, 13629096E5, 13834692E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 13943592E5, 14149188E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14258088E5, 14463684E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14578632E5, 14784228E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14893128E5, 15098724E5);
            c.AddDayLightSavings(b);
            break;
        case 168:
            c = new TimeZoneObj(168, "MX", "Mexico", "Sonora (Hermosillo)", "", -7, !1, 52);
            break;
        case 169:
            c = new TimeZoneObj(169, "", "Micronesia, Federated States Of",
                "Kosrae, Pohnpei (Palikir, Kolonia)", "", 11, !1, 691);
            break;
        case 170:
            c = new TimeZoneObj(170, "", "Micronesia, Federated States Of", "Yap, Chuuk", "", 10, !1, 691);
            break;
        case 171:
            c = new TimeZoneObj(171, "", "Midway Islands (U.S.)", "Midway Islands", "", -11, !1, 808);
            break;
        case 172:
            c = new TimeZoneObj(172, "", "Moldova, Republic of", "Chisinau", "", 2, !0, 373);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3,
                149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 173:
            c = new TimeZoneObj(173, "MC", "Monaco", "Monte Carlo", "", 1, !0, 377);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 174:
            c = new TimeZoneObj(174, "MN", "Mongolia", "Central and Eastern (Ulaanbaatar)", "", 8, !1, 976);
            break;
        case 175:
            c = new TimeZoneObj(175, "MN", "Mongolia", "Western (Olgiy, Hovd, Ulaangom)", "", 7, !1, 976);
            break;
        case 176:
            c = new TimeZoneObj(176,
                "ME", "Montenegro", "Podgorica", "", 1, !0, 382);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 177:
            c = new TimeZoneObj(177,
                "MS", "Montserrat", "Plymouth", "", -4, !1, 1664);
            break;
        case 178:
            c = new TimeZoneObj(178, "MA", "Morocco", "Rabat, Casablanca, Tangier", "", 0, !0, 212);
            b = new DayLightSavingObj(1, 13761E8, 138042E7);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13961448E5, 14040072E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14371848E5, 14457384E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 1459044E6, 14652648E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14678568E5, 14777928E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1,
                14275944E5, 14345928E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14984424E5, 15092424E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14065992E5, 14118696E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14904936E5, 14958504E5);
            c.AddDayLightSavings(b);
            break;
        case 179:
            c = new TimeZoneObj(179, "MZ", "Mozambique", "Maputo", "", 2, !1, 258);
            break;
        case 180:
            c = new TimeZoneObj(180, "", "Myanmar", "Rangoon", "", 6.5, !1, 95);
            break;
        case 181:
            c = new TimeZoneObj(181, "NA", "Namibia", "Windhoek", "", 1, !0, 264);
            b = new DayLightSavingObj(2,
                1315098E6, 13332384E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14100516E5, 1428192E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14729508E5, 14910912E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14415012E5, 14596416E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 15044004E5, 15225408E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13779972E5, 13967424E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13465476E5, 13652928E5);
            c.AddDayLightSavings(b);
            break;
        case 182:
            c = new TimeZoneObj(182,
                "NR", "Nauru", "Nauro", "", 12, !1, 674);
            break;
        case 183:
            c = new TimeZoneObj(183, "NL", "Netherlands", "Amsterdam, Hague", "", 1, !0, 31);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 184:
            c = new TimeZoneObj(184, "AN", "Netherlands Antilles", "Bonaire, Curacao, Saba, Sint Eustatius, Sint Maarten", "", -4, !1, 599);
            break;
        case 185:
            c = new TimeZoneObj(185, "NC", "New Caledonia", "Noumea", "", 11, !1, 687);
            break;
        case 186:
            c = new TimeZoneObj(186, "NZ", "New Zealand", "Auckland, Wellington", "", 12, !0, 64);
            b = new DayLightSavingObj(13, 13168728E5, 13332024E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 14118264E5, 1428156E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 1443276E6, 14596056E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 15061752E5, 15225048E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 13489272E5, 13652568E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 13803768E5, 13967064E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(13, 14747256E5, 14910552E5);
            c.AddDayLightSavings(b);
            break;
        case 187:
            c = new TimeZoneObj(187, "NI", "Nicaragua", "Managua", "", -6, !1, 505);
            break;
        case 188:
            c = new TimeZoneObj(188, "NE", "Niger", "Niamey",
                "", 1, !1, 227);
            break;
        case 189:
            c = new TimeZoneObj(189, "NG", "Nigeria", "Abuja, Kano", "", 1, !1, 234);
            break;
        case 190:
            c = new TimeZoneObj(190, "NU", "Niue", "Alofi", "", -11, !1, 683);
            break;
        case 191:
            c = new TimeZoneObj(191, "NF", "Norfolk Island", "Kingston", "", 11.5, !1, 672);
            break;
        case 192:
            c = new TimeZoneObj(192, "MP", "Northern Mariana Islands", "Saipan", "", 10, !1, 1670);
            break;
        case 193:
            c = new TimeZoneObj(193, "NO", "Norway", "Oslo", "", 1, !0, 47);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 194:
            c = new TimeZoneObj(194, "OM", "Oman", "Muscat", "", 4, !1, 968);
            break;
        case 195:
            c = new TimeZoneObj(195, "PK", "Pakistan", "Islamabad, Karachi", "", 5, !0, 92);
            b = new DayLightSavingObj(6,
                1212174E6, 12255624E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(6, 12397356E5, 1257012E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(6, 12712716E5, 1288548E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(6, 13028076E5, 1320084E6);
            c.AddDayLightSavings(b);
            break;
        case 196:
            c = new TimeZoneObj(196, "PW", "Palau", "Koror", "", 9, !1, 680);
            break;
        case 197:
            c = new TimeZoneObj(197, "", "Palestinian Territory, Occupied", "Gaza, Ramallah", "", 2, !0, 970);
            b = new DayLightSavingObj(3, 13330584E5, 13490496E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14274072E5, 14431284E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14594616E5, 1474578E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14909112E5, 15060276E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 1364508E6, 13802328E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13959576E5, 14116824E5);
            c.AddDayLightSavings(b);
            break;
        case 198:
            c = new TimeZoneObj(198, "PA", "Panama", "Panama City", "", -5, !1, 507);
            break;
        case 199:
            c = new TimeZoneObj(199, "PG", "Papua New Guinea",
                "Port Moresby", "", 10, !1, 675);
            break;
        case 200:
            c = new TimeZoneObj(200, "PY", "Paraguay", "Asuncion", "", -4, !0, 595);
            b = new DayLightSavingObj(-3, 1381032E6, 13955436E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14124816E5, 14269932E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14753808E5, 14904972E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 15068304E5, 15219468E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3, 14439312E5, 14590476E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-3,
                13495824E5, 1364094E6);
            c.AddDayLightSavings(b);
            break;
        case 201:
            c = new TimeZoneObj(201, "PE", "Peru", "Lima", "", -5, !1, 51);
            break;
        case 202:
            c = new TimeZoneObj(202, "PH", "Philippines", "Manila", "", 8, !1, 63);
            break;
        case 203:
            c = new TimeZoneObj(203, "", "Pitcairn", "Adamstown", "", -8, !1, 870);
            break;
        case 204:
            c = new TimeZoneObj(204, "PL", "Poland", "Warsaw, Krakow", "", 1, !0, 48);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            break;
        case 205:
            c = new TimeZoneObj(205, "PT", "Portugal", "Azores, Ponta Delgada", "", -1, !0, 351);
            b = new DayLightSavingObj(0, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b =
                new DayLightSavingObj(0, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(0, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 206:
            c = new TimeZoneObj(206, "PT", "Portugal", "Lisbon, Funchal", "", 0, !0, 351);
            b = new DayLightSavingObj(1, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 207:
            c = new TimeZoneObj(207, "PR", "Puerto Rico", "San Juan", "", -4, !1, 1);
            break;
        case 208:
            c = new TimeZoneObj(208, "QA", "Qatar", "Doha", "", 3, !1, 974);
            break;
        case 209:
            c = new TimeZoneObj(209, "RE", "Reunion", "Saint Denis",
                "", 4, !1, 262);
            break;
        case 210:
            c = new TimeZoneObj(210, "RO", "Romania", "Bucharest", "", 2, !0, 40);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 211:
            c = new TimeZoneObj(211, "", "Russian Federation", "Kaliningrad", "", 2, !0, 7);
            break;
        case 212:
            c = new TimeZoneObj(212, "", "Russian Federation", "Moscow, St. Petersburg", "", 3, !0, 7);
            break;
        case 213:
            c = new TimeZoneObj(213, "", "Russian Federation", "Samara, Sakhalin (Kuril Islands), Udmurtia", "", 4, !0, 7);
            break;
        case 214:
            c = new TimeZoneObj(214, "", "Russian Federation", "Yekaterinburg", "", 5, !0, 7);
            break;
        case 215:
            c = new TimeZoneObj(215, "", "Russian Federation", "Omsk, Novosibirsk, Tomsk, Altai Republic, Altaskiy Kray",
                "", 6, !0, 7);
            break;
        case 216:
            c = new TimeZoneObj(216, "", "Russian Federation", "Krasnoyarsk", "", 7, !0, 7);
            break;
        case 217:
            c = new TimeZoneObj(217, "", "Russian Federation", "Irkutsk", "", 8, !0, 7);
            break;
        case 218:
            c = new TimeZoneObj(218, "", "Russian Federation", "Yakutsk", "", 9, !0, 7);
            break;
        case 219:
            c = new TimeZoneObj(219, "", "Russian Federation", "Vladivistok", "", 10, !0, 7);
            break;
        case 220:
            c = new TimeZoneObj(220, "", "Russian Federation", "Magadan, Sakha (Eastern)", "", 10, !0, 7);
            break;
        case 221:
            c = new TimeZoneObj(221, "", "Russian Federation",
                "Chukot, Kamchatka, Koryak", "", 12, !0, 7);
            break;
        case 222:
            c = new TimeZoneObj(222, "RW", "Rwanda", "Kigali", "", 2, !1, 250);
            break;
        case 223:
            c = new TimeZoneObj(223, "GP", "Saint Barthelemy", "Gustavia", "", -4, !0, 590);
            b = new DayLightSavingObj(-3, 11743632E5, 11925972E5);
            c.AddDayLightSavings(b);
            break;
        case 224:
            c = new TimeZoneObj(224, "SH", "Saint Helena", "Jamestown", "", 0, !1, 290);
            break;
        case 225:
            c = new TimeZoneObj(225, "KN", "Saint Kitts and Nevis", "Basseterre", "", -4, !1, 1869);
            break;
        case 226:
            c = new TimeZoneObj(226, "LC", "Saint Lucia",
                "Castries", "", -4, !1, 1758);
            break;
        case 227:
            c = new TimeZoneObj(227, "PM", "Saint Pierre and Miquelon", "Saint Pierre", "", -3, !0, 508);
            b = new DayLightSavingObj(-2, 14578452E5, 14784048E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 13943412E5, 14149008E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 1331442E6, 13520016E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 13628916E5, 13834512E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14257908E5, 14463504E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2,
                14892948E5, 15098544E5);
            c.AddDayLightSavings(b);
            break;
        case 228:
            c = new TimeZoneObj(228, "VC", "Saint Vincent and The Grenadines", "Kingstown", "", -4, !1, 1784);
            break;
        case 229:
            c = new TimeZoneObj(229, "WS", "Samoa", "Apia", "", 13, !0, 685);
            b = new DayLightSavingObj(14, 14118264E5, 1428156E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(14, 1443276E6, 14596056E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(14, 13803768E5, 13967064E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(14, 15061752E5, 15225048E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(14, 14747256E5, 14910552E5);
            c.AddDayLightSavings(b);
            break;
        case 230:
            c = new TimeZoneObj(230, "SM", "San Marino", "San Marino", "", 1, !0, 378);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            break;
        case 231:
            c = new TimeZoneObj(231, "ST", "Sao Tome and Principe", "Sao Tome", "", 0, !1, 239);
            break;
        case 232:
            c = new TimeZoneObj(232, "SA", "Saudi Arabia", "Riyadh, Mecca", "", 3, !1, 966);
            break;
        case 233:
            c = new TimeZoneObj(233, "SN", "Senegal", "Dakar", "", 0, !1, 221);
            break;
        case 234:
            c = new TimeZoneObj(234, "RS", "Serbia", "Belgrade", "", 1, !0, 381);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5,
                13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 235:
            c = new TimeZoneObj(235, "SC", "Seychelles", "Victoria", "", 4, !1, 248);
            break;
        case 236:
            c = new TimeZoneObj(236, "SL", "Sierra Leone", "Freetown", "", 0, !1, 232);
            break;
        case 237:
            c =
                new TimeZoneObj(237, "SG", "Singapore", "Singapore City", "", 8, !1, 65);
            break;
        case 238:
            c = new TimeZoneObj(238, "SK", "Slovakia", "Bratislava", "", 1, !0, 421);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            break;
        case 239:
            c = new TimeZoneObj(239, "SI", "Slovenia", "Ljubljana", "", 1, !0, 386);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 240:
            c = new TimeZoneObj(240, "SB", "Solomon Islands", "Honiara", "", 11, !1, 677);
            break;
        case 241:
            c = new TimeZoneObj(241, "SO", "Somalia", "Mogadishu", "", 3, !1, 252);
            break;
        case 242:
            c = new TimeZoneObj(242, "ZA", "South Africa", "Cape Town, Johannesburg, Pretoria", "", 2, !1, 27);
            break;
        case 243:
            c = new TimeZoneObj(243, "ES", "Spain", "Canary Islands", "", 0, !0, 34);
            b = new DayLightSavingObj(1, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1,
                14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            break;
        case 244:
            c = new TimeZoneObj(244, "ES", "Spain", "Mainland  (Madrid, Barcelona), Baleares, Melilla, Ceuta", "", 1, !0, 34);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 245:
            c = new TimeZoneObj(245, "LK", "Sri Lanka", "Colombo", "", 5.5, !1, 94);
            break;
        case 246:
            c = new TimeZoneObj(246,
                "SD", "Sudan", "Khartoum", "", 3, !1, 249);
            break;
        case 247:
            c = new TimeZoneObj(247, "SR", "Suriname", "Paramaribo", "", -3, !1, 597);
            break;
        case 248:
            c = new TimeZoneObj(248, "", "Svalbard and Jan Mayen", "Longyearbyen", "", 1, !0, 47);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 249:
            c = new TimeZoneObj(249, "SZ", "Swaziland", "Mbabane", "", 2, !1, 268);
            break;
        case 250:
            c = new TimeZoneObj(250, "SE", "Sweden", "Stockholm", "", 1, !0, 46);
            b = new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2,
                149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 251:
            c = new TimeZoneObj(251, "CH", "Switzerland", "Zurich, Bern, Geneva", "", 1, !0, 41);
            b = new DayLightSavingObj(2, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b =
                new DayLightSavingObj(2, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(2, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            break;
        case 252:
            c = new TimeZoneObj(252, "", "Syrian Arab Republic", "Damascus", "", 2, !0, 963);
            b = new DayLightSavingObj(3, 14588568E5, 1477602E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14274072E5, 14461524E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13959576E5, 14147028E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 1364508E6, 13832532E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14909112E5, 15090516E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13330584E5, 13512024E5);
            c.AddDayLightSavings(b);
            break;
        case 253:
            c = new TimeZoneObj(253, "", "Taiwan", "Taipei", "", 8, !1, 886);
            break;
        case 254:
            c = new TimeZoneObj(254, "TJ", "Tajikistan", "Dushanbe", "", 5, !1, 992);
            break;
        case 255:
            c = new TimeZoneObj(255, "", "Tanzania, United Republic of", "Dar es Salaam", "", 3, !1, 255);
            break;
        case 256:
            c = new TimeZoneObj(256,
                "TH", "Thailand", "Bangkok", "", 7, !1, 66);
            break;
        case 257:
            c = new TimeZoneObj(257, "", "Timor-Leste", "Dili", "", 9, !1, 670);
            break;
        case 258:
            c = new TimeZoneObj(258, "TG", "Togo", "Lome", "", 0, !1, 228);
            break;
        case 259:
            c = new TimeZoneObj(259, "TK", "Tokelau", "Fakaofo", "", 14, !1, 690);
            break;
        case 260:
            c = new TimeZoneObj(260, "TT", "Trinidad and Tobago", "Port-of-Spain", "", -4, !1, 1868);
            break;
        case 261:
            c = new TimeZoneObj(261, "TN", "Tunisia", "Tunis", "", 1, !0, 216);
            break;
        case 262:
            c = new TimeZoneObj(262, "TR", "Turkey", "Istanbul, Ankara", "", 2, !0,
                90);
            b = new DayLightSavingObj(3, 13962276E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            break;
        case 263:
            c = new TimeZoneObj(263, "TM", "Turkmenistan", "Ashgabat",
                "", 5, !1, 993);
            break;
        case 264:
            c = new TimeZoneObj(264, "TC", "Turks and Caicos Islands", "Grand Turk", "", -5, !0, 1649);
            b = new DayLightSavingObj(-4, 13314492E5, 13520088E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1489302E6, 15098616E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1425798E6, 14463576E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14578524E5, 1478412E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13628988E5, 13834584E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4,
                13943484E5, 1414908E6);
            c.AddDayLightSavings(b);
            break;
        case 265:
            c = new TimeZoneObj(265, "TV", "Tuvalu", "Funafuti", "", 12, !1, 688);
            break;
        case 266:
            c = new TimeZoneObj(266, "UG", "Uganda", "Kampala", "", 3, !1, 256);
            break;
        case 267:
            c = new TimeZoneObj(267, "UA", "Ukraine", "Kiev", "", 2, !0, 380);
            b = new DayLightSavingObj(3, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3,
                13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 13961412E5, 14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(3, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            break;
        case 268:
            c = new TimeZoneObj(268, "AE", "United Arab Emirates", "Abu Dhabi, Dubai", "", 4, !1, 971);
            break;
        case 269:
            c = new TimeZoneObj(269, "GB", "United Kingdom", "London, Birmingham, Glasgow", "", 0, !0, 44);
            b = new DayLightSavingObj(1, 13646916E5, 13828356E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13961412E5,
                14142852E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 13326372E5, 1351386E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14590404E5, 14777892E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 149049E7, 15092388E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(1, 14275908E5, 14457348E5);
            c.AddDayLightSavings(b);
            break;
        case 270:
            c = new TimeZoneObj(270, "US", "United States", "Eastern time", "", -5, !0, 1);
            b = new DayLightSavingObj(-4, 13628988E5, 13834584E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4,
                1425798E6, 14463576E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13314492E5, 13520088E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 1489302E6, 15098616E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 13943484E5, 1414908E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-4, 14578524E5, 1478412E6);
            c.AddDayLightSavings(b);
            break;
        case 271:
            c = new TimeZoneObj(271, "US", "United States", "Central time", "", -6, !0, 1);
            b = new DayLightSavingObj(-5, 13629024E5, 1383462E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5,
                1457856E6, 14784156E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 1394352E6, 14149116E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 13314528E5, 13520124E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14893056E5, 15098652E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-5, 14258016E5, 14463612E5);
            c.AddDayLightSavings(b);
            break;
        case 272:
            c = new TimeZoneObj(272, "US", "United States", "Arizona", "", -7, !1, 1);
            break;
        case 273:
            c = new TimeZoneObj(273, "US", "United States", "Mountain time", "", -7, !0, 1);
            b = new DayLightSavingObj(-6, 14578596E5, 14784192E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 13314564E5, 1352016E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 1362906E6, 13834656E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 13943556E5, 14149152E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14258052E5, 14463648E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-6, 14893092E5, 15098688E5);
            c.AddDayLightSavings(b);
            break;
        case 274:
            c = new TimeZoneObj(274, "US", "United States",
                "Pacific time", "", -8, !0, 1);
            b = new DayLightSavingObj(-7, 13629096E5, 13834692E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14578632E5, 14784228E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 13943592E5, 14149188E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 133146E7, 13520196E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14258088E5, 14463684E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-7, 14893128E5, 15098724E5);
            c.AddDayLightSavings(b);
            break;
        case 275:
            c = new TimeZoneObj(275,
                "US", "United States", "Alaska", "", -9, !0, 1);
            b = new DayLightSavingObj(-8, 14258124E5, 1446372E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-8, 13629132E5, 13834728E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-8, 13943628E5, 14149224E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-8, 13314636E5, 13520232E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-8, 14578668E5, 14784264E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-8, 14893164E5, 1509876E6);
            c.AddDayLightSavings(b);
            break;
        case 276:
            c =
                new TimeZoneObj(276, "US", "United States", "Alaska (Aleutian Islands)", "", -10, !0, 1);
            b = new DayLightSavingObj(-9, 1425816E6, 14463756E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-9, 13943664E5, 1414926E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-9, 14578704E5, 147843E7);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-9, 148932E7, 15098796E5);
            c.AddDayLightSavings(b);
            break;
        case 277:
            c = new TimeZoneObj(277, "US", "United States", "Hawaii", "", -10, !1, 1);
            break;
        case 278:
            c = new TimeZoneObj(278, "UY", "Uruguay",
                "Montevideo", "", -3, !0, 598);
            b = new DayLightSavingObj(-2, 14124852E5, 14257872E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 1349586E6, 1362888E6);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 13810356E5, 13943376E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14753844E5, 14892912E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 14439348E5, 14578416E5);
            c.AddDayLightSavings(b);
            b = new DayLightSavingObj(-2, 1506834E6, 15207408E5);
            c.AddDayLightSavings(b);
            break;
        case 279:
            c = new TimeZoneObj(279,
                "UZ", "Uzbekistan", "Tashkent", "", 5, !1, 998);
            break;
        case 280:
            c = new TimeZoneObj(280, "VU", "Vanuatu", "Port-Vila", "", 11, !1, 678);
            break;
        case 281:
            c = new TimeZoneObj(281, "VE", "Venezuela", "Caracas", "", -4.5, !1, 58);
            break;
        case 282:
            c = new TimeZoneObj(282, "VN", "Vietnam", "Hanoi, Ho Chi Minh City", "", 7, !1, 84);
            break;
        case 283:
            c = new TimeZoneObj(283, "", "Virgin Islands, British", "Road Town", "", 7, !1, 1);
            break;
        case 284:
            c = new TimeZoneObj(284, "", "Virgin Islands, U.S.", "Charlotte Amamlie", "", -4, !1, 1);
            break;
        case 285:
            c = new TimeZoneObj(285,
                "", "Wake Island (U.S.)", "Wake Islands", "", 12, !1, 808);
            break;
        case 286:
            c = new TimeZoneObj(286, "WF", "Wallis and Futuna", "Mata-Utu", "", 12, !1, 681);
            break;
        case 287:
            c = new TimeZoneObj(287, "YE", "Yemen", "Sanaa", "", 3, !1, 967);
            break;
        case 288:
            c = new TimeZoneObj(288, "ZM", "Zambia", "Lusaka", "", 2, !1, 260);
            break;
        case 289:
            c = new TimeZoneObj(289, "ZW", "Zimbabwe", "Harare", "", 2, !1, 263);
            break;
        case 290:
            c = new TimeZoneObj(290, "AR", "Argentina", "San Luis", "", -4, !0, 54);
            b = new DayLightSavingObj(-3, 12709548E5, 13317804E5);
            c.AddDayLightSavings(b);
            break;
        case 291:
            c = new TimeZoneObj(291, "AR", "Argentina", "West, Jujuy", "", -3, !1, 54);
            break;
        case 292:
            c = new TimeZoneObj(292, "", "Kosovo", "Pristina", "", 1, !0, ""), b = new DayLightSavingObj(2, 14275908E5, 14457348E5), c.AddDayLightSavings(b), b = new DayLightSavingObj(2, 149049E7, 15092388E5), c.AddDayLightSavings(b), b = new DayLightSavingObj(2, 13331556E5, 1351386E6), c.AddDayLightSavings(b), b = new DayLightSavingObj(2, 13646916E5, 13828356E5), c.AddDayLightSavings(b), b = new DayLightSavingObj(2, 13961412E5, 14142852E5), c.AddDayLightSavings(b),
                b = new DayLightSavingObj(2, 14590404E5, 14777892E5), c.AddDayLightSavings(b)
    }
    return c
};
var isPopupTimeZoneEventFirePopup = !1,
    timeZonesPopup = [],
    countriesPopup = [],
    currPopupTimeZoneID = -2,
    mobileScrollAfterSelection;

function InitPopupTimeZoneData() {
    for (var b = 0, c = 0; c < timezonesCount; c++) {
        var d = GenerateTimeZoneObjFromID(c + 1);
        null != d && (timeZonesPopup[b] = d, Contains(countriesPopup, timeZonesPopup[b].country) || (countriesPopup[countriesPopup.length] = timeZonesPopup[b].country), b++)
    }
    var b = document.getElementById("sltCountryPopup"),
        d = countriesPopup.length,
        e = document.createElement("option");
    e.value = -1;
    var f = document.createTextNode("Please Select Country");
    e.appendChild(f);
    b.appendChild(e);
    for (var g = "Australia;Canada;China;France;Germany;Japan;United Kingdom;United States".split(";"),
            c = 0; c < g.length; c++) e = document.createElement("option"), e.value = g[c], f = document.createTextNode(g[c]), e.appendChild(f), b.appendChild(e);
    e = document.createElement("option");
    e.value = "-5";
    f = document.createTextNode("-------------------------------------");
    e.appendChild(f);
    e.disabled = "disabled";
    b.appendChild(e);
    for (c = 0; c < d; c++) e = document.createElement("option"), e.value = countriesPopup[c], f = document.createTextNode(countriesPopup[c]), e.appendChild(f), b.appendChild(e)
}

function TimeZonePopupChanged() {
    document.getElementById("RegionErrorDiv").style.visibility = "hidden";
    GetCurrentPopupTimeZoneID() != currPopupTimeZoneID && -1 != GetCurrentPopupTimeZoneID() && (currPopupTimeZoneID = GetCurrentPopupTimeZoneID(), isPopupTimeZoneEventFirePopup && PopupTimeZoneListChanged && isFunction(PopupTimeZoneListChanged) && PopupTimeZoneListChanged())
}

function SetPopupCountry(b) {
    if ("" != b)
        for (var c = document.getElementById("sltCountryPopup"), d = c.options.length, e = 0; e < d; e++)
            if (c.options[e].value.toLowerCase() == b.toLowerCase()) {
                browser.isIE || (c.options[e].selected = !0);
                c.options[e].setAttribute("selected", "selected");
                c.selectedIndex = e;
                break
            }
}

function GetPopupCountry() {
    var b = document.getElementById("sltCountryPopup");
    return b.options[b.selectedIndex].value
}

function GetPopupRegion() {
    var b = document.getElementById("sltTimeZonePopup");
    return b.options[b.selectedIndex].value
}

function SetPopupTimeZones(b) {
    document.getElementById("RegionErrorDiv").style.visibility = "hidden";
    var c = document.getElementById("sltCountryPopup"),
        d = document.getElementById("sltTimeZonePopup"),
        e = c.options[c.selectedIndex].value;
    if ("" == e || "-1" == e) SetPopupCountry(countryName), e = c.options[c.selectedIndex].value;
    c = timeZonesPopup.length;
    CleanList(document.getElementById("sltTimeZonePopup"));
    var f = [];
    if ("" != e) {
        for (var g = 0; g < c; g++) timeZonesPopup[g].country == e && (f[f.length] = timeZonesPopup[g]);
        var c = f.length,
            k;
        0 < c && (e = document.createElement("option"), e.value = -1, k = document.createTextNode("Select time zone region"), e.appendChild(k), d.appendChild(e));
        currTimeZoneID = -1;
        for (g = 0; g < c; g++) e = document.createElement("option"), e.value = f[g].id, k = document.createTextNode(f[g].toFullNameWithoutCountryString()), e.appendChild(k), d.appendChild(e);
        d = document.getElementById("sltTimeZonePopup");
        2 > c ? (1 == c && (SetComboByValue("sltTimeZonePopup", f[0].id), TimeZonePopupChanged(d)), d.disabled = !0) : d.disabled = !1
    }
    b && isFunction(mobileScrollAfterSelection) &&
        mobileScrollAfterSelection()
}

function SetCurrentPopupTimeZone(b) {
    for (var c = timeZonesPopup.length, d = 0; d < c; d++)
        if (timeZonesPopup[d].id == b) {
            currTimeZoneID = b;
            SetComboByValue("sltCountryPopup", timeZonesPopup[d].country);
            SetPopupTimeZones();
            SetComboByValue("sltTimeZonePopup", b);
            break
        }
}

function ClearCurrentPopupTimeZone() {
    currTimeZoneID = -1;
    SetComboByValue("sltCountryPopup", -1);
    SetPopupTimeZones()
}

function GetCurrentPopupTimeZoneID() {
    var b = document.getElementById("sltTimeZonePopup"),
        c = -999; - 1 != b.selectedIndex && (c = parseFloat(b.options[b.selectedIndex].value));
    return c
}

function GetCurrentPopupTimeZoneObj() {
    var b = new TimeZoneObj(-1, "", "", "", "", 0, !1),
        c = document.getElementById("sltTimeZonePopup"),
        b;
    if (-1 != c.selectedIndex)
        for (var c = parseFloat(c.options[c.selectedIndex].value), d = timeZonesPopup.length, e = 0; e < d; e++)
            if (timeZonesPopup[e].id == c) {
                b = timeZonesPopup[e];
                break
            }
    return b
}

function showTZConflictMessage(b, c, d) {
    document.getElementById(c).style.display = "block";
    c = timeZonesPopup.length;
    for (var e = 0; e < c; e++)
        if (timeZonesPopup[e].id == b) {
            document.getElementById(d).innerHTML = "The system has detected that you are in a different time zone. Do you want to change your time zone to " + timeZonesPopup[e].toFullNameStringGmtLast(30, !0) + "?";
            break
        }
}

function hideTZConflictMessage(b) {
    document.getElementById(b).style.display = "none"
};

function ScheduledSettingsObj(b, c, d, e, f, g, k, l, n, p, h, r, q, s, t, u, v, w, z, A, B, C, D, E, F, G, H, I, J, K, L, M, N, O, P, Q, R, S, T, U, V, W, X, Y, Z, $, aa, ba, ca, da, ea) {
    this.schedulingMode = b;
    this.maxMeetingDuration = c;
    this.isFixedDuration = d;
    this.maxSuggestionsADay = e;
    this.minimumOptionsCount = f;
    this.welcomeMessage = s;
    this.hasRecurringAvailbility = g;
    this.hasDateSpecificAvailiblity = k;
    this.meetingNoticePeriod = l;
    this.isShared = p;
    this.recurringAvailiblity = h;
    this.calendarList = r;
    this.weeklyAvailDayExceptionArray = q;
    this.welcomeMessage = s;
    this.oooMessage =
        t;
    this.minMeetingDuration = u;
    this.MaxHour = this.MinHour = -1;
    this.calendaroverride = !0;
    this.defaultCalendarId = "";
    this.tzSupport = !1;
    this.defaultDuration = v;
    this.requireCompany = this.requireLocation = this.requirePhoneNum = this.meetingStarts55 = this.meetingStarts50 = this.meetingStarts40 = this.meetingStarts35 = this.meetingStarts25 = this.meetingStarts20 = this.meetingStarts10 = this.meetingStarts05 = this.meetingStarts45 = this.meetingStarts30 = this.meetingStarts15 = this.meetingStarts00 = !1;
    this.isConnected = w;
    this.scheduleCalendarDataObj =
        z;
    this.defaultMeetingDetails = this.reqCustomInfo = this.defaultLocation = "";
    this.dayStartHour = 8;
    this.dayEndHour = 18;
    this.meetMeEmail = this.imageName = this.facebookProfile = this.linkedInProfile = this.twitterId = this.website = this.profileEmail = this.phone = this.company = this.title = this.profileName = "";
    this.status = 1;
    this.enableRedirectSettings = !1;
    this.redirectSeconds = E;
    this.redirectWebLink = F;
    this.ReminderObj = A;
    this.DoNotSendCalendarInvitation = !1;
    this.sendScheduleConfirmation = !0;
    this.availabilityFutureLimit = n;
    this.preBuffer =
        B;
    this.postBuffer = C;
    this.subject = D;
    this.settingsTimeZoneId = G;
    this.MeetMeLinkArr = H;
    this.MeetMeServiceLinkArr = I;
    this.BookNowLinkArr = J;
    this.noCancellationMsg = L;
    this.noCancellationTime = K;
    this.maxBookingsPerDay = M;
    this.PIN1 = N;
    this.PIN2 = O;
    this.multipleBookingPerSlot = P;
    this.locationType = Q;
    this.locationLabel = R;
    this.isProvidedByOwner = S;
    this.timeStepText = T;
    this.startHour = U;
    this.endHour = V;
    this.gap = W;
    this.defaultMeetingTitle = X;
    this.enablePhone = Y;
    this.enableNote = Z;
    this.requireNote = $;
    this.TagList = aa;
    this.PIN3 = ba;
    this.PIN4 = ca;
    this.mandatoryCompany = da;
    this.maxBookingsPerWeek = ea
}
ScheduledSettingsObj.prototype.IsExceptioDate = function(b) {
    var c = !1;
    if (this.hasDateSpecificAvailiblity)
        for (var d = this.weeklyAvailDayExceptionArray.length, e = 0; e < d; e++)
            if (b.IsEqualToJSUTCDate(this.weeklyAvailDayExceptionArray[e].date)) {
                c = !0;
                break
            }
    return c
};

function FormatDayTimeText(b, c) {
    var d = Math.floor(b / 60),
        e = b - 60 * d,
        f = "" + e;
    10 > e && (f = "0" + e);
    e = "";
    if (0 == c || 2 == c) {
        var g = !1;
        11 < d && 24 > d && (g = !0, d -= 12);
        e = "" + d;
        if (0 == d || 24 == d) e = "12";
        e = g ? e + ":" + f + "pm" : e + ":" + f + "am"
    } else e = d + ":" + f;
    return e
}
ScheduledSettingsObj.prototype.SetHourBoundaries = function(b) {
    this.MaxHour = this.MinHour = -1;
    if (this.hasRecurringAvailbility && this.recurringAvailiblity)
        for (var c = 0; 7 > c; c++)
            for (var d = this.recurringAvailiblity[c].length, e = 0; e < d; e++) {
                var f = Math.floor(this.recurringAvailiblity[c][e][0] / 4),
                    g = Math.ceil((this.recurringAvailiblity[c][e][0] + this.recurringAvailiblity[c][e][1] / 15) / 4);
                this.UpdateMinHour(f);
                this.UpdateMaxHour(g)
            }
    if (this.hasDateSpecificAvailiblity && this.weeklyAvailDayExceptionArray)
        for (d = this.weeklyAvailDayExceptionArray.length,
            c = 0; c < d; c++)
            if (!CreateNewDateFromMili(this.weeklyAvailDayExceptionArray[c].date.valueOf(), b).IsPastDue())
                for (var k = this.weeklyAvailDayExceptionArray[c].times, l = k.length, e = 0; e < l; e++) f = Math.floor(k[e][0] / 60), g = Math.ceil((k[e][0] + k[e][1]) / 60), this.UpdateMinHour(f), this.UpdateMaxHour(g)
};
ScheduledSettingsObj.prototype.UpdateMinHour = function(b) {
    if (-1 == this.MinHour || b < this.MinHour) this.MinHour = b
};
ScheduledSettingsObj.prototype.UpdateMaxHour = function(b) {
    if (-1 == this.MaxHour || b > this.MaxHour) this.MaxHour = b
};
var isInDrag = !1,
    startGridPos = null,
    endGridPos = null,
    cnt = [],
    MeetingColor = "#9CD629",
    BorderColorGrey15 = "#F3F3F3",
    BorderColorGrey30 = "#EBE7E7",
    BorderColorGrey60 = "#DDDDDD",
    BorderColorGreen15 = "#94ce24",
    BorderColorGreen30 = "#91ca23",
    BorderColorGreen60 = "#94cd26",
    settingsObj, userProfileObj, wizard, editReccur;
var jsonObj='{"userID": 240594,"timeZoneID": 122,"firstName": "MSP","lastName": "","email": "mspmakk@gmail.com","status": 1,"dateTimeFormat": 0,"weekStartDay": 1,"emailLabel": "","loginType": 4,"loginEmail": "mspmakk@gmail.com","AdminstrationName": "MSP","dayEndHour": 18,"dayStartHour": 8 }';
var settJsonObj='{"schedulingMode":1,"maxMeetingDuration":15,"isFixedDuration":false,"maxSuggestionsADay":96,"minimumOptionsCount":3,"welcomeMessage":"Please follow the instructions to schedule time with me - its fast and easy.  line_break_placeHolder                               line_break_placeHolderThanks,line_break_placeHolderMSPline_break_placeHolder                        ","hasRecurringAvailbility":true,"hasDateSpecificAvailiblity":false,"meetingNoticePeriod":240,"isShared":false,"recurringAvailiblity":[[],[[36,150],[57,165]],[[36,45],[47,90],[55,30],[60,120]],[[36,75],[44,360]],[[36,90],[43,375]],[[36,45],[42,45],[49,285]],[]],"oooMessage":"","minMeetingDuration":15,"MinHour":9,"MaxHour":17,"calendaroverride":false,"defaultCalendarId":"","tzSupport":true,"defaultDuration":15,"meetingStarts00":true,"meetingStarts15":true,"meetingStarts30":true,"meetingStarts45":true,"meetingStarts05":false,"meetingStarts10":false,"meetingStarts20":false,"meetingStarts25":false,"meetingStarts35":false,"meetingStarts40":false,"meetingStarts50":false,"meetingStarts55":false,"requirePhoneNum":false,"requireLocation":false,"requireCompany":false,"isConnected":false,"scheduleCalendarDataObj":{},"defaultLocation":"","reqCustomInfo":"","defaultMeetingDetails":"","dayStartHour":8,"dayEndHour":18,"profileName":"MSP ","title":"","company":"","phone":"","profileEmail":"","website":"","twitterId":"","linkedInProfile":"","facebookProfile":"","imageName":"","meetMeEmail":"","status":1,"enableRedirectSettings":false,"redirectSeconds":10,"redirectWebLink":"","DoNotSendCalendarInvitation":true,"sendScheduleConfirmation":"True","availabilityFutureLimit":540,"preBuffer":0,"postBuffer":0,"settingsTimeZoneId":122,"noCancellationTime":0,"maxBookingsPerDay":-1,"locationType":1,"locationLabel":"Location","isProvidedByOwner":true,"timeStepText":"","startHour":-1,"endHour":-1,"gap":15,"enablePhone":false,"enableNote":true,"requireNote":false,"TagList":"","maxBookingsPerWeek":-1,"serviceCode":2,"MultipleBookingPerSlot":"1","maxRecurringDuration":480,"maxDateDuration":0}';

/*var jsonObj='{"userID": 240594,"timeZoneID": 122,"firstName": "MSP","lastName": "","email": "mspmakk@gmail.com","status": 1,"dateTimeFormat": 0,"weekStartDay": 1,"subscribeNews": true,"planType": 26,"profileStatus": 1, "defaultMeetingDuration": 60,"obtzSupport": true,"profileCreateDate": "2015-02-17T00:58:44.613Z","MaxMeetMeLinkNum": 6,"MaxBookNowLinkNum": 0,"MaxServicePagesNum": 0,"MaxUsersNum": 3,"accountId": 230143,"accountCretedDate": "2015-02-17T00:58:35.777Z","availableLinkName": "","defaultCalendarId": "","emailLabel": "","loginType": 4,"loginEmail": "mspmakk@gmail.com","AccountRole": 1,"AdminstrationName": "MSP","CanCreateMeetMe": true,"selectServiceForNotification": true,"selectServiceForInformation": true,"filterOwner": true,"filterEditor": true,"filterViewer": true,"supportCode": "MjQwNTk0","isGoToConnected": false,"isWebExConnected": false,"trialLeftDays": 14,"isInfusionConnected": false,"CurrentDate": "2015-02-17T00:00:00.000Z","isAppsUser": false,"ThemeID": "0","ButtonColor": "FE9E0C","TextColor": "000000","encryptedUserID": "beSpB3XJB21Rz0AJTxGfvF7T3O2Gxec5Nv6bIe2ed8gTuqiCraMmxQqualqual","ConnectedCalendarAccount": "0","isConnected": false,"currencyCode": "USD","ReportHeaderImageName": "","TransactionLog": "No","dayEndHour": 18,"dayStartHour": 8 }';
var settJsonObj='{"schedulingMode":1,"maxMeetingDuration":15,"isFixedDuration":false,"maxSuggestionsADay":96,"minimumOptionsCount":3,"welcomeMessage":"Please follow the instructions to schedule time with me - its fast and easy.  line_break_placeHolder                               line_break_placeHolderThanks,line_break_placeHolderMSPline_break_placeHolder                        ","hasRecurringAvailbility":true,"hasDateSpecificAvailiblity":false,"meetingNoticePeriod":240,"isShared":false,"recurringAvailiblity":[[],[[36,150],[57,165]],[[36,45],[47,90],[55,30],[60,120]],[[36,75],[44,360]],[[36,90],[43,375]],[[36,45],[42,45],[49,285]],[]],"oooMessage":"","minMeetingDuration":15,"MinHour":9,"MaxHour":17,"calendaroverride":false,"defaultCalendarId":"","tzSupport":true,"defaultDuration":15,"meetingStarts00":true,"meetingStarts15":true,"meetingStarts30":true,"meetingStarts45":true,"meetingStarts05":false,"meetingStarts10":false,"meetingStarts20":false,"meetingStarts25":false,"meetingStarts35":false,"meetingStarts40":false,"meetingStarts50":false,"meetingStarts55":false,"requirePhoneNum":false,"requireLocation":false,"requireCompany":false,"isConnected":false,"scheduleCalendarDataObj":{},"defaultLocation":"","reqCustomInfo":"","defaultMeetingDetails":"","dayStartHour":8,"dayEndHour":18,"profileName":"MSP ","title":"","company":"","phone":"","profileEmail":"","website":"","twitterId":"","linkedInProfile":"","facebookProfile":"","imageName":"","meetMeEmail":"","status":1,"enableRedirectSettings":false,"redirectSeconds":10,"redirectWebLink":"","DoNotSendCalendarInvitation":true,"sendScheduleConfirmation":"True","availabilityFutureLimit":540,"preBuffer":0,"postBuffer":0,"settingsTimeZoneId":122,"noCancellationTime":0,"maxBookingsPerDay":-1,"locationType":1,"locationLabel":"Location","isProvidedByOwner":true,"timeStepText":"","startHour":-1,"endHour":-1,"gap":15,"enablePhone":false,"enableNote":true,"requireNote":false,"TagList":"","maxBookingsPerWeek":-1,"serviceCode":2,"MultipleBookingPerSlot":"1","maxRecurringDuration":480,"maxDateDuration":0}';*/

function SyncDataFromParent() {
    var b = window.parent;
    window.GetParentObject && (b = GetParentObject());
    null != b && b.settingsObj && (settingsObj = JSON.parse(settJsonObj), userProfileObj = JSON.parse(jsonObj), wizard = b.wizard, editReccur = b.editReccur)
    settingsObj=JSON.parse(settJsonObj);
    userProfileObj=JSON.parse(jsonObj);
   
}

function PopupTimeZoneListChanged() {}

function initIframe() {
    isTimeZoneEventFire = !0;
    SyncDataFromParent();
    isEdit || editReccur ? (userProfileObj.dayEndHour = settingsObj.dayEndHour, userProfileObj.dayStartHour = settingsObj.dayStartHour) : (userProfileObj.dayEndHour = 18, userProfileObj.dayStartHour = 8);
    userDateTimeFormatCookieValue = userProfileObj.dateTimeFormat;
    BuildGrid();
    isEdit || editReccur ? (ShowGrid(), DrawMeetings()) : (ShowText(), InitAvailability());
    RebuildStartEndTimeLists();
    SetStartTimeValue(userProfileObj.dayStartHour);
    SetEndTimeValue(userProfileObj.dayEndHour);
    UpdateStartEndTimeLists();
    InitPopupTimeZoneData();
    SetPopupTimeZones();
    isPopupTimeZoneEventFirePopup = !0;
    settingsObj.settingsTimeZoneId && 0 < settingsObj.settingsTimeZoneId ? SetCurrentPopupTimeZone(settingsObj.settingsTimeZoneId) : (SetPopupServerCountry(), 0 >= GetCurrentPopupTimeZoneID() && (0 < locationTimeZoneID ? SetCurrentPopupTimeZone(locationTimeZoneID) : window.parent.showTZPopup()));
    document.getElementById("TimeZoneDiv1") && TimeZoneListChangedYes();
   //isEdit ? (settingsObj.SetHourBoundaries(GetCurrentPopupTimeZoneObj()),HideLoading()) : window.parent.buttonOn("nextB");
    3 == window.parent.currentStep ? window.parent.ClickBack() : 1 == window.parent.currentStep && window.parent.ClickNext()
}

function ShowGrid() {
    DrawMeetings();
    HideDiv("TextBlock");
    ShowDiv("GridBlock");
    isEdit || (window.parent.editReccur = !0, window.parent.document.getElementById("WizardNavigation").style.display = "none", window.parent.document.getElementById("FrameDivWizard").style.paddingBottom = "0px");
    AdjustFrameSize()
}

function ShowText() {
    HideDiv("GridBlock");
    ShowDiv("TextBlock");
    AdjustFrameSize(280)
}

function AdjustFrameSize(b) {
   /* var c = parent.document.getElementById("myFrame");
    c.height.split("p");
    b || (b = 300 + 52 * (userProfileObj.dayEndHour - userProfileObj.dayStartHour));
    c.height = b + "px"*/
}

function ColorCell(b, c, d, e) {
    null == e && (e = GetCellObj(b, c));
    b = GetMarginObj(b, c);
    null != e && ("" != d ? (e.className = "NormalCell NMSelCell", e.style.cursor = "url(https://app.scheduleonce.com/Images/eraser.cur), default", b.style.cursor = "url(https://app.scheduleonce.com/Images/eraser.cur), default", c %= 4, 0 == c % 2 && (e.style.borderBottomColor = BorderColorGreen15), 1 == c && (e.style.borderBottomColor = BorderColorGreen30), 3 == c && (e.style.borderBottomColor = BorderColorGreen60)) : (e.className = "NormalCell", e.style.cursor = "", b.style.cursor = "", e.style.borderBottomColor =
        "", c %= 4, 0 == c % 2 && (e.style.borderBottomColor = BorderColorGrey15), 1 == c && (e.style.borderBottomColor = BorderColorGrey30)))
}

function DrawDragGrid(b, c, d) {
    b = GetCellObj(b[0], b[1]);
    var e = GetCellObj(c[0], c[1]),
        f;
    c = findPos(b);
    var g = findPos(e);
    c[0] > g[0] && (f = g[0], g[0] = c[0], c[0] = f);
    c[1] > g[1] && (f = g[1], g[1] = c[1], c[1] = f);
    e = getSize(e);
    f = document.getElementById("newMeetingCreateDiv");
    f.style.cursor = b.style.cursor;
    f.style.left = c[0] + "px";
    f.style.top = c[1] + "px";
    f.style.width = g[0] - c[0] + e[0] + "px";
    f.style.height = g[1] - c[1] + e[1] + "px";
    browser.isIE ? (stX = window.event.clientX, stY = window.event.clientY) : (stX = d.clientX, stY = d.clientY);
    cellSize = e
}
var stX, stY, cellSize;

function StartDragNewMeeting(b, c) {
    isEdit;
    isInDrag = !0;
    b.style.backgroundColor = null == currHighLightObjOldBG ? "" : currHighLightObjOldBG;
    endGridPos = startGridPos = GetTimeGridPos(b.id);
    document.getElementById("NewMeetingContainer").innerHTML = "";
    newMeetingCreateDiv = document.createElement("div");
    newMeetingCreateDiv.id = "newMeetingCreateDiv";
    newMeetingCreateDiv.className = isColoredCell(b) ? "DrawDragDivErase" : "DrawDragDiv";
    newMeetingCreateDiv.onmousemove = NewMeetingMouseMove;
    document.getElementById("NewMeetingContainer").appendChild(newMeetingCreateDiv);
    document.onmouseup = new Function("StopDragNewMeeting();");
    DrawDragGrid(startGridPos, endGridPos, c);
    //console.log(settingsObj.recurringAvailiblity);
    return !1
}

function NewMeetingMouseMove(b) {
    b || (b = window.event);
    var c = Math.abs(b.clientX - stX),
        d = Math.abs(b.clientY - stY),
        e = document.getElementById("newMeetingCreateDiv");
    if (c >= cellSize[0]) {
        var f = Math.abs(parseInt(e.style.width.replace("px", "")) - c);
        e.style.width = f + "px";
        b.clientX > stX && !Browser.isIE && (c = parseInt(e.style.left.replace("px", "")) + c, e.style.left = c + "px")
    }
    d >= cellSize[1] && (c = Math.abs(parseInt(e.style.height.replace("px", "")) - d), e.style.height = c + "px", b.clientY > stY && !Browser.isIE && (b = parseInt(e.style.top.replace("px",
        "")) + d, e.style.top = b + "px"))
}

function StopDragNewMeeting(b, c) {
    if (isInDrag) {
        isInDrag = !1;
        var d = document.getElementById("newMeetingCreateDiv");
        d.style.height = "0px";
        d.style.width = "0px";
        document.onmouseup = null;
        MergeMeetingsDrag(startGridPos, endGridPos);
        endGridPos = startGridPos = null
    }
}

function MergeMeetingsDrag(b, c) {
    ClearMeetingTimesTexts();
    var d = GenerateGridFromMeetings(),
        e = cloneArray(d),
        f = !d[b[0]][b[1]];
    if (b[0] > c[0]) {
        var g = c[0];
        c[0] = b[0];
        b[0] = g
    }
    b[1] > c[1] && (g = c[1], c[1] = b[1], b[1] = g);
    for (g = b[0]; g <= c[0]; g++)
        for (var k = b[1]; k <= c[1]; k++) d[g][k] = f;
    SetMeetingTimesFromDragGrid(d);
    DrawMeetings(e, d)
}

function SetMeetingTimesFromDragGrid(b) {
    RemoveMeetingsInGrid();
    settingsObj.recurringAvailiblity = Array(7);
    for (var c = 0; 7 > c; c++) settingsObj.recurringAvailiblity[c] = [];
    for (c = 0; 7 > c; c++)
        for (var d = -1, e = 0; 96 > e; e++)
            if (b[c][e]) {
                if (-1 == d && (d = e), 95 == e) {
                    var f = 15 * (e - d + 1),
                        g = ConvertGridDayToWeekDay(c, userProfileObj.weekStartDay),
                        k = settingsObj.recurringAvailiblity[g].length;
                    settingsObj.recurringAvailiblity[g][k] = [d, f];
                    d = -1
                }
            } else -1 != d && (f = 15 * (e - d), g = ConvertGridDayToWeekDay(c, userProfileObj.weekStartDay), k = settingsObj.recurringAvailiblity[g].length,
                settingsObj.recurringAvailiblity[g][k] = [d, f], d = -1);
    //isEdit && settingsObj.SetHourBoundaries(GetCurrentPopupTimeZoneObj())
}
var currHighLightObj = null,
    currHighLightObjOldBG = "";

function CellOver(b, c) {
    if (isInDrag) {
        var d = GetTimeGridPos(b.id);
        DrawDragGrid(startGridPos, d, c);
        endGridPos = d
    } else {
        currHighLightObjOldBG = b.style.backgroundColor;
        b.style.backgroundColor = "#e3f4c3";
        currHighLightObj = b;
        if (!isColoredCell(b)) {
            var e = b.id.split("_"),
                d = e[1],
                e = ConvertGridDayToWeekDay(eval(e[2]), userProfileObj.weekStartDay),
                f = Math.floor(d / 4),
                d = d % 4 * 15,
                d = GetWeekDayFromIndex(e) + ", " + FormatHourText(f, userProfileObj.dateTimeFormat, d);
            b.setAttribute("tiptitle", "Mark with green to add availability");
            tooltip.setTipProperties(b,
                d, "tooltipHeaderStandard", "tooltipContentStandard", "tooltipDivStandard")
        }
        tooltip.show(b.getAttribute("tiptitle"), b)
    }
}

function CellOut(b, c) {
    tooltip.hide();
    isInDrag || (b.style.backgroundColor = null == currHighLightObjOldBG ? "" : currHighLightObjOldBG)
}

function MarginCellOver(b, c) {
    if (!isInDrag) {
        var d = GetTimeGridPos(b.id),
            e = document.getElementById("Cell_" + d[1] + "_" + d[0]);
        if (e && !isColoredCell(e)) {
            var e = b.id.split("_"),
                f = e[1],
                e = ConvertGridDayToWeekDay(eval(e[2]), userProfileObj.weekStartDay),
                f = Math.floor(f / 4),
                d = 15 * d,
                d = GetWeekDayFromIndex(e) + ", " + FormatHourText(f, userProfileObj.dateTimeFormat, d);
            b.setAttribute("tiptitle", "Mark with green to add availability");
            tooltip.setTipProperties(b, d, "tooltipHeaderStandard", "tooltipContentStandard", "tooltipDivStandard")
        }
        tooltip.show(b.getAttribute("tiptitle"),
            b)
    }
}

function MarginCellOut(b, c) {
    tooltip.hide()
}

function GetTimeGridPos(b) {
    var c = [-1, -1];
    b = b.split("_");
    3 == b.length && (c[0] = parseInt(b[2]), c[1] = parseInt(b[1]));
    return c
}

function isColoredCell(b) {
    return 0 < b.className.indexOf("NMSelCell") || 0 < b.className.indexOf("PastDueCellTA")
}
var currDraggingDiv = "",
    currDraggivMeetingStartDuration, currDraggivMeetingDuration, isResizeDrag = !1,
    isMoveDrag = !1,
    x, y, tx, ty, newMeetingCreateDiv, newMeetingStartTime, newMeetingDurartion, tableCellCache = [];

function GetCellGrid(b) {
    b = GetTimeGridPos(b.id);
    return currTimeGridObj.grid[b[0]][b[1]]
}

function GetCellObj(b, c) {
    return document.getElementById("Cell_" + c + "_" + b)
}

function GetMarginObj(b, c) {
    return document.getElementById("MarginCell_" + c + "_" + b)
}

function GenerateGridFromMeetings() {
    for (var b = Array(7), c = 0; 7 > c; c++) {
        b[c] = Array(96);
        for (var d = 0; 96 > d; d++) b[c][d] = !1
    }
    if (settingsObj.recurringAvailiblity)
        for (var e = settingsObj.recurringAvailiblity.length, c = 0; c < e; c++)
            for (var f = ConvertWeekDayToGridDay(c, userProfileObj.weekStartDay), g = settingsObj.recurringAvailiblity[c].length, d = 0; d < g; d++)
                for (var k = settingsObj.recurringAvailiblity[c][d][0], l = k + settingsObj.recurringAvailiblity[c][d][1] / 15; k < l; k++) b[f][k] = !0;
    return b
}

function DrawMeetings(b, c) {
    for (var d = null, d = 1 < arguments.length ? c : GenerateGridFromMeetings(), e = 0; 7 > e; e++)
        for (var f = d[e].length, g = 0; g < f; g++) null != b ? d[e][g] != b[e][g] && ColorCell(e, g, d[e][g] ? MeetingColor : "", null) : d[e][g] && ColorCell(e, g, MeetingColor, null);
    DrawTextAndTooltipsOnMeetings()
}

function DrawTextAndTooltipsOnMeetings() {
    for (var b = settingsObj.recurringAvailiblity ? settingsObj.recurringAvailiblity.length : 0, c = 0; c < b; c++)
        for (var d = ConvertWeekDayToGridDay(c, userProfileObj.weekStartDay), e = settingsObj.recurringAvailiblity[c].length, f = 0; f < e; f++) {
            var g = [];
            g[0] = d;
            g[1] = settingsObj.recurringAvailiblity[c][f][0];
            var k = 15 * settingsObj.recurringAvailiblity[c][f][0],
                l = k + settingsObj.recurringAvailiblity[c][f][1],
                n = FormatDayTimeText(k, userProfileObj.dateTimeFormat),
                p = FormatDayTimeText(l, userProfileObj.dateTimeFormat),
                l = '<span class="tooltipDay">' + GetWeekDayFromIndex(ConvertGridDayToWeekDay(d, userProfileObj.weekStartDay)) + ", " + n + " - " + p + "</span>",
                h = GetCellObj(g[0], g[1]);
            h.setAttribute("tiptitle", "Click and drag to remove availability");
            tooltip.setTipProperties(h, l, "tooltipHeaderGreen", "tooltipContentStandard", "tooltipDivBig");
            if (k = document.getElementById("MarginCell_" + g[1] + "_" + g[0])) k.setAttribute("tiptitle", "Click and drag to remove availability"), tooltip.setTipProperties(k, l, "tooltipHeaderGreen", "tooltipContentStandard",
                "tooltipDivBig");
            h.innerHTML = "&nbsp;" + n + " - " + p;
            n = settingsObj.recurringAvailiblity[c][f][1] / 15;
            for (p = g[1] + 1; p < g[1] + n; p++)
                if (k = GetCellObj(g[0], p), k.setAttribute("tiptitle", "Click and drag to remove availability"), tooltip.setTipProperties(k, l, "tooltipHeaderGreen", "tooltipContentStandard", "tooltipDivBig"), k = document.getElementById("MarginCell_" + p + "_" + g[0])) k.setAttribute("tiptitle", "Click and drag to remove availability"), tooltip.setTipProperties(k, l, "tooltipHeaderGreen", "tooltipContentStandard", "tooltipDivBig")
        }
}

function ClearMeetingTimesTexts() {
    for (var b = settingsObj.recurringAvailiblity ? settingsObj.recurringAvailiblity.length : 0, c = 0; c < b; c++)
        for (var d = ConvertWeekDayToGridDay(c, userProfileObj.weekStartDay), e = settingsObj.recurringAvailiblity[c].length, f = 0; f < e; f++) {
            var g = [];
            g[0] = d;
            g[1] = settingsObj.recurringAvailiblity[c][f][0];
            if (g = GetCellObj(g[0], g[1])) g.innerHTML = ""
        }
}

function InitAvailability() {
    settingsObj.recurringAvailiblity = Array(7);
    for (var b = 0; 7 > b; b++) settingsObj.recurringAvailiblity[b] = [];
    for (b = 0; 5 > b; b++) {
        for (var c = 36; 68 > c; c++) ColorCell(b, c, MeetingColor, null);
        c = ConvertGridDayToWeekDay(b, userProfileObj.weekStartDay);
        settingsObj.recurringAvailiblity[c][settingsObj.recurringAvailiblity[c].length] = [36, 480]
    }
}

function RemoveMeetingsInGrid() {}

function TimeZoneListChangedYes() {
    var b = GetCurrentPopupTimeZoneObj();
    settingsObj.settingsTimeZoneId = b.id;
    document.getElementById("TimeZoneDiv1").innerHTML = b.toFullNameStringGmtLastDstIcon(40, !1);
    document.getElementById("TimeZoneDiv2").innerHTML = b.toFullNameStringGmtLastDstIcon(40, !1);
    document.getElementById("TimeZoneDivTextOnly").innerHTML = b.toFullNameStringGmtLast(40, !1)
}

function ApplyTimezonePicker() {
    var b = document.getElementById("RegionErrorDiv");
    "-1" == GetPopupCountry() ? (b.innerHTML = "Please select your time zone", ShowDiv("RegionErrorDiv", !1)) : 0 > GetCurrentPopupTimeZoneID() ? (b.innerHTML = "Please select your region", ShowDiv("RegionErrorDiv", !1)) : (CloseTimeZonePicker(), TimeZoneListChangedYes())
}

function CloseTimeZonePicker() {
    HideDiv("dvTimezonePicker")
}

function CancelTimeZonePicker() {
    HideDiv("dvTimezonePicker");
    SetCurrentPopupTimeZone(settingsObj.settingsTimeZoneId)
}

function OpenTimeZonePicker(b) {
    var c = document.getElementById("TimeZoneDiv" + b),
        d = document.getElementById("dvTimezonePicker"),
        e = findPos(c);
    getSize(c);
    getSize(d);
    c = e[0];
    e = e[1];
    d.style.position = "absolute";
    d.style.left = c + "px";
    d.style.top = e - ("2" == b ? 150 : 0) + "px";
    ShowDiv("dvTimezonePicker")
}

function SetStartTimeValue(b) {
    SetComboByValue("sltStartTimeListPopUp", b)
}

function SetEndTimeValue(b) {
    SetComboByValue("sltEndTimeListPopUp", b)
}

function UpdateStartEndTimeLists() {
    RebuildStartEndTimeLists(!0)
}

function RebuildStartEndTimeLists(b) {
    null == b && (b = !1);
    var c = document.getElementById("sltStartTimeListPopUp"),
        d = document.getElementById("sltEndTimeListPopUp"),
        e, f, g, k;
    b && (e = c.options[c.selectedIndex].innerHTML, f = d.options[d.selectedIndex].innerHTML, g = eval(c.value), k = eval(d.value));
    c.innerHTML = "";
    d.innerHTML = "";
    for (var l = new DateTimeObj(1996, 1, 1, 0, 0, 0, null), n = 0; 24 >= n; n++) {
        var p = FormatTimeByUser(l),
            h = document.createElement("option");
        h.value = n;
        var r = document.createTextNode(p);
        b && (n >= k && (h.disabled = !0),
            p == e && (isFirefox && (h.selected = !0), h.setAttribute("selected", "selected")));
        h.appendChild(r);
        24 != n && c.appendChild(h);
        h = document.createElement("option");
        h.value = n;
        r = document.createTextNode(p);
        b && (n <= g && (h.disabled = !0), p == f && (isFirefox && (h.selected = !0), h.setAttribute("selected", "selected")));
        h.appendChild(r);
        0 != n && d.appendChild(h);
        l = l.AddHours(1)
    }
}

function ClosePreferencesPopUp() {
    HideDiv("preferencesPopUp");
    SetStartTimeValue(userProfileObj.dayStartHour);
    SetEndTimeValue(userProfileObj.dayEndHour)
}

function CancelPreferencesPopUp() {
    HideDiv("preferencesPopUp")
}

function OpenPreferences(b) {
    var c = document.getElementById("preferencesPopUp"),
        d = findPos(b);
    b = d[0];
    d = d[1];
    c.style.position = "absolute";
    c.style.left = b + 50 + "px";
    c.style.top = d - 120 + "px";
    ShowDiv("preferencesPopUp")
}

function ApplyPreferences() {
    var b = document.getElementById("sltStartTimeListPopUp"),
        c = document.getElementById("sltEndTimeListPopUp");
    eval(c.value) < eval(b.value) ? alert("This is not a valid start time and end time to select") : eval(c.value) == eval(b.value) ? alert("Start time and end time can not be same. Please choose some other option.") : isEdit && (-1 < settingsObj.MinHour && settingsObj.MinHour < b.value || -1 < settingsObj.MaxHour && settingsObj.MaxHour > c.value) ? SoAlert("Display hours cannot be changed because you have marked recurring or date-specific availability during these times.<br/><br/>Please remove both recurring and date-specific availability first.",
        "Unable to change display hours") : (ClearAllMeetingsFromGrid(), userProfileObj.dayStartHour = b.value, userProfileObj.dayEndHour = c.value, settingsObj.dayStartHour = b.value, settingsObj.dayEndHour = c.value, NormalizeMeetingTimesOnChangingPrefs(b.value, c.value), CancelPreferencesPopUp(), BuildGrid(), AdjustFrameSize(), DrawMeetings())
}

function ClearAllMeetingsFromGrid() {
    for (var b = GenerateGridFromMeetings(), c = 0; 7 > c; c++)
        for (var d = b[c].length, e = 0; e < d; e++) {
            var f = GetCellObj(c, e);
            b[c][e] && isColoredCell(f) && (f.title = "", f.innerHTML = "", ColorCell(c, e, "", f))
        }
}

function NormalizeMeetingTimesOnChangingPrefs(b, c) {
    var d = 4 * b,
        e = 4 * c;
    if (settingsObj.recurringAvailiblity)
        for (var f = settingsObj.recurringAvailiblity.length, g = 0; g < f; g++)
            for (var k = 0; k < settingsObj.recurringAvailiblity[g].length;) {
                var l = settingsObj.recurringAvailiblity[g][k][0],
                    n = l + settingsObj.recurringAvailiblity[g][k][1] / 15;
                n <= d || l >= e ? settingsObj.recurringAvailiblity[g].splice(k, 1) : (l < d && (settingsObj.recurringAvailiblity[g][k][0] = d, settingsObj.recurringAvailiblity[g][k][1] = 15 * (n - d)), n > e && (settingsObj.recurringAvailiblity[g][k][1] =
                    15 * (e - settingsObj.recurringAvailiblity[g][k][0])), k++)
            }
}

function ClickedOutSidePopUp() {
    CloseAllPopUps()
}

function CloseAllPopUps() {
    CloseTimeZonePicker();
    ClosePreferencesPopUp()
}

function BuildGrid() {
    for (var b = 4 * userProfileObj.dayStartHour, c = 4 * userProfileObj.dayEndHour, d = 0; d < b; d++) HideDiv("HalfHoursRow_" + d);
    for (var e = userProfileObj.dayStartHour, d = b; d < c; d += 4) document.getElementById("TimeHeaders_" + d).innerHTML = FormatHourText(e, userProfileObj.dateTimeFormat), e++, ShowDiv("HalfHoursRow_" + d, !1), ShowDiv("HalfHoursRow_" + (d + 1), !1), ShowDiv("HalfHoursRow_" + (d + 2), !1), ShowDiv("HalfHoursRow_" + (d + 3), !1);
    for (d = c; 96 > d; d++) HideDiv("HalfHoursRow_" + d)
}

function FormatHourText(b, c, d) {
    d || (d = "00");
    var e = "";
    0 == c || 2 == c ? (c = !1, 11 < b && (c = !0, b -= 12), e = "" + b, 0 == b && (e = "12"), e = c ? e + ":" + d + "pm" : e + ":" + d + "am") : e = b + ":" + d;
    return e
}

function hasMarkedRecurAvail() {
    var b = !1;
    if (settingsObj.recurringAvailiblity)
        for (var c = settingsObj.recurringAvailiblity.length, d = 0; d < c; d++)
            if (0 < settingsObj.recurringAvailiblity[d].length) {
                b = !0;
                break
            }
    return b
}

function AllowWizardStepChange() {
    return -1 == GetCurrentPopupTimeZoneObj().id ? (alert("Please select your time zone"), !1) : hasMarkedRecurAvail() ? !0 : (alert("In this step you must mark some recurring availability.\n\nIf you want to use Date-specific availability only, complete the wizard and then make the changes in the Availability section."), !1)
}

function forceChangeStep() {
    window.parent.changeStep(3, !0)
}

function ConvertWeekDayToGridDay(b, c) {
    return (7 - c + b) % 7
}

function ConvertGridDayToWeekDay(b, c) {
    return (b + c) % 7
}

function GetWeekDayFromIndex(b) {
    switch (b) {
        case 0:
            return "Sunday";
        case 1:
            return "Monday";
        case 2:
            return "Tuesday";
        case 3:
            return "Wednesday";
        case 4:
            return "Thursday";
        case 5:
            return "Friday";
        case 6:
            return "Saturday"
    }
}

function ChangeTimeZoneFromPopup(b) {
    SetCurrentPopupTimeZone(b);
    TimeZoneListChangedYes()
};