var QUOTE_CALLBACK_REPLACE_STRING = "_so_callback_quote",
    EQUAL_CALLBACK_REPLACE_STRING = "_so_callback_equal",
    QUOTE_REPLACE_STRING = "_so_quote",
    EQUAL_REPLACE_STRING = "_so_equal",
    LIST_REPLACE_STRING = "_so_list",
    QUOTE_LIST_REPLACE_STRING = "_so_replace_quote_list",
    CF_EQUAL_REPLACE_STRING = "_so_cf_equal",
    CF_QUOTE_REPLACE_STRING = "_so_cf_quote",
    CF_LIST_REPLACE_STRING = "_so_cf_list",
    CR_EQUAL_REPLACE_STRING = "_so_cr_equal",
    CR_QUOTE_REPLACE_STRING = "_so_cr_quote",
    CR_LIST_REPLACE_STRING = "_so_cr_list",
    PLUS_MONTHLY_PLAN_AMOUNT =
    "5",
    PLUS_YEARLY_PLAN_AMOUNT = "50",
    PREMIUM_MONTHLY_PLAN_AMOUNT = "9",
    PREMIUM_YEARLY_PLAN_AMOUNT = "90",
    PROFESSIONAL_MONTHLY_PLAN_AMOUNT = "19",
    PROFESSIONAL_YEARLY_PLAN_AMOUNT = "190",
    WORKGROUP_MONTHLY_PLAN_AMOUNT = "29",
    WORKGROUP_YEARLY_PLAN_AMOUNT = "290",
    ENTERPRISE_MONTHLY_PLAN_AMOUNT = "49",
    ENTERPRISE_YEARLY_PLAN_AMOUNT = "490",
    MEETME_MONTHLY_AMOUNT = "7",
    MEETME_YEARLY_AMOUNT = "70",
    SPECIAL_STARTER = "0",
    BASIC = "1",
    TRIAL_PLUS = "2",
    TRIAL_PREMIUM = "3",
    TRIAL_PROFESSIONAL = "26",
    TRIAL_WORKGROUP = "27",
    TRIAL_ENTERPRISE = "28",
    PLUS_Y =
    "4",
    PREMIUM_Y = "5",
    PROFESSIONAL_Y = "6",
    WORKGROUP_Y = "7",
    ENTERPRISE_Y = "8",
    PLUS_M = "14",
    PREMIUM_M = "15",
    PROFESSIONAL_M = "16",
    WORKGROUP_M = "17",
    ENTERPRISE_M = "18",
    MAX_MEETME_PAGES = "10",
    MAX_BOOKNOW_PAGES = "5",
    MAX_SERVICE_PAGES = "50",
    scrollX = 0,
    scrollY = 0,
    elementToSetFocus = null,
    showCancelConnectionAttemptButton = !1,
    ie8Supported, isFirefox = document.getElementById && !document.all,
    and = "&",
    _gaq = _gaq || [];
_gaq.push(["_setAccount", "UA-3307458-1"]);
var domain = window.location.hostname,
    pushToAnalytics = !1; - 1 < domain.indexOf("scheduleonce") ? (domain = "scheduleonce.com", pushToAnalytics = !0) : -1 < domain.indexOf("meetme") ? (domain = "meetme.so", pushToAnalytics = !0) : -1 < domain.indexOf("booknow") && (domain = "booknow", pushToAnalytics = !0);
_gaq.push(["_setDomainName", domain]);
_gaq.push(["_setAllowLinker", !0]);

function AnalyticsTracker(a) {
    pushToAnalytics && AnalyticsTrackerGo(a)
}

function AnalyticsTrackerGo(a) {
    a = isQA ? "/QA" + a : a;
    _gaq.push(["_trackPageview", a])
}

function CampaignTracker(a) {}

function CampaignTrackerGo(a) {
    var b = readCookie("SO_src");
    b && (a = b + "/" + a, a = isQA ? "QA/" + a : a, _gaq.push(["t2._trackPageview", a]))
}

function disableSelection(a) {
    "undefined" != typeof a.onselectstart ? a.onselectstart = function() {
        return !1
    } : "undefined" != typeof a.style.MozUserSelect ? a.style.MozUserSelect = "none" : a.onmousedown = function() {
        return !1
    };
    a.style.cursor = "default"
}

function SelectAll(a) {
    a.focus();
    a.select()
}

function getElementHTML(a) {
    var b = document.createElement("div");
    b.appendChild(a);
    return b.innerHTML
}

function isFunction(a) {
    var b = !1;
    a && (b = typeof a == typeof Function);
    return b
}
var lastWinSize, ignoreSizeChangeOnce = !1;

function DetectSizeChange() {
    var a = GetWinSize();
    if (null == lastWinSize) lastWinSize = a;
    else if (lastWinSize[0] != a[0] || lastWinSize[1] != a[1])
        if (ignoreSizeChangeOnce) ignoreSizeChangeOnce = !1;
        else if (window.SizeChangedEvent) {
        window.SizeChangedEvent();
        var b = document.getElementById("RateThisPageOpaqueDiv");
        b || (b = document.getElementById("OpaqueDivConfirmDiv"));
        if (b && null != currentPopupId) {
            CenterDiv(currentPopupId, !0);
            var c = GetWinNetSize();
            b.style.width = c[0] + "px";
            b.style.height = c[1] - 2 + "px"
        }
    }
    lastWinSize = a;
    window.setTimeout(function() {
            DetectSizeChange()
        },
        200)
}

function GetWinSize() {
    var a = [0, 0];
    "number" == typeof window.innerWidth ? (a[0] = window.innerWidth, a[1] = window.innerHeight) : document.documentElement && (document.documentElement.clientWidth || document.documentElement.clientHeight) ? (a[0] = document.documentElement.clientWidth, a[1] = document.documentElement.clientHeight) : document.body && (document.body.clientWidth || document.body.clientHeight) && (a[0] = document.body.clientWidth, a[1] = document.body.clientHeight);
    return a
}

function getSize(a) {
    var b = curheight = 0,
        b = a.offsetWidth;
    curheight = a.offsetHeight;
    return [b, curheight]
}

function GetWinNetSize() {
    var a, b = [],
        c = navigator.userAgent;
    b[0] = 0;
    b[1] = 0;
    0 <= (a = c.indexOf("MSIE")) ? (b[0] = document.documentElement.offsetWidth - 1, b[1] = document.getElementsByTagName("body")[0].scrollHeight, a = parseFloat(c.substr(a + 4)), 7 < a && 10 > a && (b[0] -= 20), 10 <= a && (b[1] -= 4, b[0] = document.documentElement.scrollWidth - 4)) : 0 <= c.indexOf("Firefox") ? (b[0] = window.document.body.offsetWidth, b[1] = window.innerHeight + window.scrollMaxY) : (0 <= c.indexOf("Chrome") ? b[0] = document.body.clientWidth : 0 <= c.indexOf("Safari") ? b[0] =
        document.body.clientWidth : b[0] = window.document.body.offsetWidth, b[1] = document.documentElement.scrollHeight);
    return b
}

function getDocHeight() {
    var a = document;
    return Math.max(Math.max(a.body.scrollHeight, a.documentElement.scrollHeight), Math.max(a.body.offsetHeight, a.documentElement.offsetHeight), Math.max(a.body.clientHeight, a.documentElement.clientHeight))
}

function getDocWidth() {
    var a = document;
    return Math.max(Math.max(a.body.scrollWidth, a.documentElement.scrollWidth), Math.max(a.body.offsetWidth, a.documentElement.offsetWidth), Math.max(a.body.clientWidth, a.documentElement.clientWidth))
}

function CenterDiv(a, b, c, d) {
    a = document.getElementById(a);
    if (null != a) {
        b = getSize(a);
        GetWinNetSize();
        if (-1 != navigator.appVersion.indexOf("MSIE 7.") || -1 != navigator.appVersion.indexOf("MSIE 8.")) {
            d = document.documentElement.clientHeight;
            c = document.documentElement.clientWidth;
            var e = document.documentElement.scrollTop
        } else d = window.innerHeight, c = window.innerWidth, e = window.pageYOffset;
        d = (d - b[1]) / 2 + e;
        a.style.left = (c - b[0]) / 2 + "px";
        a.style.top = d + "px";
        browser.isIE && 10 < browser.version && (b = f_clientHeight() / 2, d > b &&
            (a.style.top = b + "px"))
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

function f_filterResults(a, b, c) {
    a = a ? a : 0;
    b && (!a || a > b) && (a = b);
    return c && (!a || a > c) ? c : a
}

function findPos(a) {
    var b = curtop = 0;
    if (a && a.offsetParent)
        for (b = a.offsetLeft, curtop = a.offsetTop; a = a.offsetParent;) b += a.offsetLeft, curtop += a.offsetTop;
    return [b, curtop]
}

function createCookie(a, b, c) {
    c || (c = 730);
    var d = new Date;
    d.setTime(d.getTime() + 864E5 * c);
    c = "; expires=" + d.toGMTString();
    document.cookie = a + "=" + b + c + "; path=/"
}

function readCookie(a) {
    a += "=";
    for (var b = document.cookie.split(";"), c = 0; c < b.length; c++) {
        for (var d = b[c];
            " " == d.charAt(0);) d = d.substring(1, d.length);
        if (0 == d.indexOf(a)) return d.substring(a.length, d.length)
    }
    return null
}

function eraseCookie(a) {
    createCookie(a, "", -1)
}

function HideDiv(a, b, c) {
    var d = window;
    isNotEmpty(c) && (d = c);
    c = d.document.getElementById(a);
    var e = null;
    try {
        e = d.parent.document
    } catch (f) {}!c && e && (c = e.getElementById(a));
    a = !0;
    null != b && (a = b);
    null != c && (c.style.visibility = "hidden", a && (c.style.display = "none"))
}

function HideDivElement(a, b) {
    var c = !0;
    null != b && (c = b);
    null != a && (a.style.visibility = "hidden", c && (a.style.display = "none"))
}

function ShowDiv(a, b, c, d) {
    var e = window;
    isNotEmpty(c) && (e = c);
    c = e.document.getElementById(a);
    !c && e.parent.document && (c = e.parent.document.getElementById(a));
    a = !0;
    null != b && (a = b);
    null != c && (c.style.visibility = "visible", c.style.display = a ? "block" : d ? "inline-block" : "")
}

function ShowDivElement(a, b) {
    var c = !0;
    null != b && (c = b);
    null != a && (a.style.visibility = "visible", a.style.display = c ? "block" : "")
}

function IsVisible(a, b) {
    var c = window;
    b && (c = b);
    c = c.document.getElementById(a);
    return null != c && "visible" == c.style.visibility ? !0 : !1
}

function ClearDiv(a) {
    a = document.getElementById(a);
    null != a && (a.innerHTML = "")
}

function Contains(a, b) {
    for (var c = a.length, d = 0; d < c; d++)
        if (a[d] == b) return !0;
    return !1
}

function IsValInArray(a, b) {
    for (var c = a.length, d = 0; d < c; d++)
        if (a[d] == b) return !0;
    return !1
}

function CleanList(a) {
    if (null != a.options)
        if (isFirefox) a.options.length = 0;
        else
            for (var b = a.options.length - 1; 0 <= b; b--) null != a.options[b] && a.removeChild(a.options[b])
}

function GetComboValue(a) {
    var b = null;
    a = document.getElementById(a);
    null != a && (b = a.options[a.selectedIndex].value);
    return b
}

function SetComboByValue(a, b, c) {
    var d = window;
    c && (d = c);
    a = d.document.getElementById(a);
    if (null != a && void 0 != a && null != a.options && void 0 != a.options)
        for (c = a.options.length, d = 0; d < c; d++)
            if (a.options[d].value == b) {
                isFirefox && (a.options[d].selected = !0);
                a.options[d].setAttribute("selected", "selected");
                a.selectedIndex = d;
                break
            }
}

function SetElementHTML(a, b) {
    var c = document.getElementById(a);
    null != c && void 0 != c && (c.innerHTML = b)
}

function cloneArray(a) {
    var b = [];
    if (null != a && void 0 != a)
        for (var c = a.length, d = 0; d < c; d++) null != a[d] && void 0 != a[d] && (b[d] = a[d].constructor == Array ? cloneArray(a[d]) : a[d]);
    return b
}

function Browser() {
    var a, b, c;
    this.isOpera = this.isChrome = this.isSafari = this.isFF = this.isNS = this.isIE = !1;
    this.version = null;
    this.isCSS3 = !1;
    a = navigator.userAgent;
    b = "MSIE";
    0 <= (c = a.indexOf(b)) ? (this.isIE = !0, this.version = parseFloat(a.substr(c + b.length)), "9" <= this.version && (this.isCSS3 = !0)) : (b = "rv:", 0 <= a.indexOf("Trident") && 0 <= (c = a.indexOf(b)) ? (this.isIE = !0, this.version = parseFloat(a.substr(c + b.length)), "9" <= this.version && (this.isCSS3 = !0)) : (b = "Firefox", 0 <= (c = a.indexOf(b)) ? (this.isFF = this.isNS = !0, this.version =
        parseFloat(a.substr(c + b.length + 1)), "3" <= this.version && (this.isCSS3 = !0)) : (b = "chrome", 0 <= (c = a.toLowerCase().indexOf(b)) ? (this.isChrome = !0, this.version = parseFloat(a.substr(c + b.length + 1)), "4" <= this.version && (this.isCSS3 = !0)) : 0 <= a.indexOf("Safari") ? (this.isSafari = !0, this.version = a, "5" <= this.version && (this.isCSS3 = !0)) : (b = "Netscape6/", 0 <= (c = a.indexOf(b)) ? (this.isNS = !0, this.version = parseFloat(a.substr(c + b.length))) : 0 <= a.indexOf("Gecko") ? this.isCSS3 = this.isNS = !0 : 0 <= a.indexOf("Opera") && (this.isOpera = !0, c = a.indexOf("Version"),
        this.version = parseFloat(a.substr(c + 7 + 1)), "10" <= this.version && (this.isCSS3 = !0))))))
}
var browser = new Browser,
    boolRefresh = !1;

function ShowMainData(a) {
    a ? isConnectionCalled || (boolRefresh = !1, HideDiv("LoadingDiv"), ShowDiv("MainDataDiv")) : (boolRefresh = !1, HideDiv("LoadingDiv"), ShowDiv("MainDataDiv"));
    showCancelConnectionAttemptButton = !1;
    HideDiv("CancelConnectionAttempt");
    (scrollX || scrollY) && window.scrollBy(scrollX, scrollY)
}

function StringBuilder(a) {
    this.strings = [""];
    this.append(a)
}
StringBuilder.prototype.append = function(a) {
    a && this.strings.push(a)
};
StringBuilder.prototype.clear = function() {
    this.strings.length = 1
};
StringBuilder.prototype.toString = function() {
    return this.strings.join("")
};
String.prototype.wordWrap = function(a, b, c) {
    var d, e, f, k = this.split("\n");
    if (0 < a)
        for (d in k) {
            f = k[d];
            for (k[d] = ""; f.length > a; e = c ? a : (e = f.substr(0, a).match(/\S*$/)).input.length - e[0].length || a, k[d] += f.substr(0, e) + ((f = f.substr(e)).length ? b : ""));
            k[d] += f
        }
    return k.join("\n")
};

function splitToRowsByChars(a, b, c) {
    for (var d = "", d = a.substr(0, b) + "<br />"; b < a.length;) d += a.substr(b, c) + "<br />", b += c;
    return d.substr(0, d.length - 6)
}

function SpliteToRows(a, b) {
    return a.wordWrap(b, "<br/>", !1)
}

function removeOpeningTag(a) {
    a && (a = a.replace(RegExp("<br>", "g"), "@@@br@@@").replace(RegExp("<br/>", "g"), "@@@br@@@").replace(RegExp("<br />", "g"), "@@@br@@@").replace(RegExp("<BR/>", "g"), "@@@br@@@").replace(RegExp("<BR />", "g"), "@@@br@@@"), a = a.replace(/</g, "&lt;"), a = a.replace(RegExp("@@@br@@@", "g"), "<br/>"));
    return a
}

function htmlEncodeText(a, b) {
    a && (b && (a = a.replace(/\r/g, "").replace(/\n/g, "")), a = a.replace(/\\/g, "&#92;").replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&apos;").replace(/</g, "&lt;").replace(/>/g, "&gt;"));
    return a
}

function htmlDecodeTextWOlt(a) {
    a && (a = a.replace(/&amp;/g, "&").replace(/&quot;/g, '"').replace(/&apos;/g, "'").replace(/&gt;/g, ">").replace(/&#92;/g, "\\").replace(/&#92;/g, "\\"));
    return a
}

function encodeAposte(a) {
    a && (a = a.replace(/'/g, "&apos;"));
    return a
}

function deocdeForBackSlash(a) {
    a && (a = a.replace(/&amp;#92;/g, "&#92;"));
    return a
}

function htmlDecodeText(a, b) {
    a && (a = b ? a.replace(/&quot;/g, '"').replace(/&apos;/g, "'").replace(/&gt;/g, ">").replace(/&amp;/g, "&").replace(/&#92;/g, "\\") : a.replace(/&quot;/g, '"').replace(/&apos;/g, "'").replace(/&lt;/g, "<").replace(/&gt;/g, ">").replace(/&amp;/g, "&").replace(/&#92;/g, "\\"));
    return a
}

function cleanForHTML(a) {
    a && (a = a.replace(/&#92;/g, "\\").replace(/&/g, "&amp;").replace(/"/g, "&quot;").replace(/'/g, "&apos;").replace(/</g, "&lt;").replace(/>/g, "&gt;"));
    return a
}

function cleanBackslash(a) {
    a && (a = a.replace(/&#92;/g, "\\").replace(/&amp;#92;/g, "\\"));
    return a
}
"function" !== typeof String.prototype.trim && (String.prototype.trim = function() {
    return this.replace(/^\s+|\s+$/g, "")
});

function GetAttachmentName(a) {
    if (a)
        if (a = a.split("."), 2 == a.length) a = a[0].substring(0, a[0].indexOf("_CA")).replace(/___/g, " ") + "." + a[1];
        else {
            for (var b = "", c = a.length - 1, d = 0; d < c; d++) {
                var e = a[d].indexOf("_CA"),
                    b = 0 < e ? b + a[d].substring(0, e).replace(/___/g, " ") : b + a[d].replace(/___/g, " ");
                d < c - 1 && (b += ".")
            }
            a = b + "." + a[c]
        }
    return htmlDecodeText(a)
}

function CutStringToSize(a, b, c) {
    null == c && (c = !1);
    var d = a;
    a && 3 < b && (a.length > b ? (d = a.substring(0, b - 3).trim() + "...", d = d.replace(RegExp("br/", "g"), "<br/>"), d = removeOpeningTag(d), c && (a = CleanText(htmlDecodeText(a)).replace(RegExp("br/", "g"), "&#13;"), d = '<span title="' + a + '">' + d + "</span>")) : d = removeOpeningTag(d));
    return d
}

function GetAlertHieght(a, b) {
    null == b && (b = 240);
    a = a.replace(RegExp("<br />", "g"), "<br/>");
    var c = a.split("<br/>").length;
    return b + (1 < c ? 20 * c : 0)
}

function SplitStringToSize(a, b) {
    for (var c = "", d = a.length, e = 0; e < d; e += b) c += a.substring(e, e + b) + " ";
    return c
}

function CutStringAtChar(a, b) {
    var c = a.indexOf(b);
    return -1 == c ? a : a.substring(0, c)
}

function cleanExtraLineBreak(a) {
    if (a)
        for (;
            "line_break_placeHolder" == a.substring(a.length - 1, a.length);) a = a.substring(0, a.length - 1);
    return a
}

function fixeLineBreakFromPlaceHolder(a) {
    a && (a = a.replace(RegExp("<br/>", "g"), "line_break_placeHolder").replace(/\r/g, "line_break_placeHolder").replace(/\n/g, "line_break_placeHolder").replace(/\r\n/g, "line_break_placeHolder"));
    return a
}

function replaceLineBreakFromMessage(a) {
    a && (a = a.replace(/line_break_placeHolder/g, "<br/>"));
    return a
}

function replaceLineBreakToHTML(a) {
    a && (a = a.replace(/line_break_placeHolder/g, "<br/>"));
    return a
}

function replaceLineBreakToTextArea(a) {
    a && (a = a.replace(/line_break_placeHolder/g, "\n"));
    return a
}

function ShowLineBreakInHTML(a) {
    a && (a = a.replace(/\n/g, "<br/>"));
    return a
}

function ShowLineBreakInTextArea(a) {
    a && (a = a.replace(/<br\/>/g, "\n"));
    return a
}

function CleanForEmail(a) {
    a && (a = CleanText(a).replace(":", "").replace("*", "").replace("%", "").replace("+", "").replace("$", "").replace("&", "").replace("#", "").replace("?", "").replace(",", "").replace("!", "").replace("(", "").replace(")", "").replace("[", "").replace("]", "").replace("@", "").replace(";", ""));
    return a
}

function CleanText(a) {
    a && (a = a.replace(/&#92;/g, "").replace(/&/g, "").replace(/"/g, "").replace(/'/g, "").replace(/</g, "").replace(/>/g, "").replace(/\\/g, "").replace("`", "").replace("\ufffd", ""));
    return a
}

function CleanForLabel(a) {
    a && (a = a.replace(/</g, "").replace(/>/g, ""));
    return a
}

function CleanTextMessage(a) {
    a = a.replace(/"/g, "&quot;");
    return a = a.replace(/&apos;/g, "\\'")
}

function CleanTextMessageInp(a) {
    return a.replace(/&apos;/g, "'")
}

function GetHTMLValue(a) {
    var b = a;
    return b = browser.isIE && "8" == browser.version ? replaceLineBreakToHTML(htmlDecodeText(a)) : replaceLineBreakToHTML(cleanForHTML(htmlDecodeText(a)))
}

function InsertText(a, b, c, d) {
    var e = window;
    c && (e = c);
    if ((a = e.document.getElementById(a)) && b)
        for (a.innerHTML = "", b = -1 < b.indexOf("<br/>") ? b.split("<br/>") : b.split("\n"), c = b.length, e = 0; e < c; e++) {
            if (d)
                for (var f = b[e].split(" "), k = f.length, h = 0; h < k; h++)
                    if (-1 < f[h].indexOf("http://")) {
                        var l = document.createElement("a");
                        l.href = f[h];
                        l.target = "_blank";
                        var p = document.createTextNode(f[h].slice(7));
                        l.appendChild(p);
                        a.appendChild(l);
                        a.appendChild(document.createTextNode(" "))
                    } else -1 < f[h].indexOf("https://") ? (l = document.createElement("a"),
                        l.target = "_blank", l.href = f[h], p = document.createTextNode(f[h].slice(8)), l.appendChild(p), a.appendChild(l), a.appendChild(document.createTextNode(" "))) : -1 < f[h].indexOf("www.") && -1 < f[h].indexOf(".com") ? (l = document.createElement("a"), l.target = "_blank", l.href = "http://" + f[h], p = document.createTextNode(f[h]), l.appendChild(p), a.appendChild(l), a.appendChild(document.createTextNode(" "))) : (l = document.createTextNode(f[h] + " "), a.appendChild(l));
            else l = document.createTextNode(b[e]), a.appendChild(l);
            1 < c && (f = document.createElement("br"),
                a.appendChild(f))
        }
}

function InsertHTML(a, b) {
    var c = document.getElementById(a);
    c && (c.innerHTML = b ? b : "")
}

function removeExtraSpaces(a) {
    a && (a = a.trim(), a = a.replace(/\s+/g, " "));
    return a
}

function CloseAlertDiv(a) {
    var b = document.getElementById("AlertDiv" + a);
    b.parentNode.removeChild(b);
    AlertClosedByUser(a)
}

function ShowAlertDiv(a, b, c) {
    if (null == document.getElementById("AlertDiv" + c)) {
        var d = new StringBuilder('<div id="AlertDiv' + c + '" style="margin-bottom:10px;"><div style="font-size:1px;line-height:2px;height:10px"></div> <div class="Alert" >\r\n');
        d.append('<br/> <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">\r\n');
        d.append("   <tr>\r\n");
        d.append('       <td style="width: 2%"> &nbsp;</td>\r\n');
        d.append('       <td style="font-size: 14px;">\r\n');
        d.append('           <table border="0" cellpadding="0" cellspacing="0" style="width: 100%;">\r\n');
        d.append("               <tr>\r\n");
        d.append('                   <td style="height: 10px;" id="AlertHeader">\r\n');
        d.append("                       <b>" + a + "</b>\r\n");
        d.append("                   </td>\r\n");
        d.append('                   <td style="width:1%;height: 5px;text-allign:right;position:relative;left:6px;top:2px" align="right">\r\n');
        d.append('                       <span onclick="javascript:CloseAlertDiv(' + c + ')" style="cursor:pointer;">X</span>\r\n');
        d.append("                   </td>\r\n");
        d.append("               </tr>\r\n");
        d.append('               <tr><td style="height: 10px;"></td></tr>\r\n');
        d.append("               <tr>\r\n");
        d.append('                   <td style="height: 15px;" id="AlertFooter">' + b + "</td>\r\n");
        d.append("               </tr>\r\n");
        d.append("               <tr>\r\n");
        d.append('                   <td colspan="100" align="right"><a class="operation" href="javascript:CloseAlertDiv(' + c + ')">Dismiss this message</a></td>\r\n');
        d.append("               </tr>\r\n");
        d.append("           </table>\r\n");
        d.append("       </td>\r\n");
        d.append('       <td style="width: 2%">&nbsp;</td>\r\n');
        d.append("   </tr>\r\n");
        d.append("</table>\r\n");
        d.append("<br/> </div></div>\r\n");
        a = document.getElementById("alertTD");
        b = a.innerHTML;
        a.innerHTML = "";
        a.innerHTML = b + d.toString()
    }
}

function GetTimeStringByPrefrecesByDate(a, b, c) {
    return a.formatDate("h:mma")
}

function GetTimeStringByPrefrecesByHourMinute(a, b, c, d) {
    null == d && (d = !1);
    var e = "",
        e = 30,
        e = null != c ? c.userTimeFormat : userTimeFormat;
    30 != e || d ? e = a + ":" + (10 > b ? "0" : "") + b : (c = "am", 12 <= a && (c = "pm", a -= 12), 0 == a && (a = 12), e = a + ":" + (10 > b ? "0" : "") + b + " " + c);
    return e
}

function loadJS(a) {
    window.setTimeout(function() {
        loadJSGo(a)
    }, 0)
}

function loadJSGo(a) {
    var b = document.getElementsByTagName("head").item(0),
        c = document.createElement("script");
    c.setAttribute("type", "text/javascript");
    c.setAttribute("src", a);
    c.setAttribute("defer", "true");
    c.async = !0;
    b.appendChild(c)
}

function CreateNewDateFromMiliInUTC(a) {
    return new Date(a)
}
var currentPopupId = null;

function OpenPopup(a, b, c, d, e) {
    currentPopupId = a;
    var f;
    f = document.getElementById("tzConfirmCloseB");
    "undefined" != typeof textColor && (f.style.color = "#" + textColor);
    "undefined" != typeof buttonColor && (f.style.background = "#" + buttonColor);
    e && null != e && (f.value = e);
    if (isFirefox) opDiv = document.createElement("div"), b || getDocWidth(), f = getDocHeight(), opDiv.style.cssText = "background-color:black;position:fixed;left:0px;top:0px;bottom:0px;right:0px;z-index:29990;";
    else {
        var k = GetWinNetSize();
        opDiv = document.createElement("iframe");
        e = b ? b + 96 : k[0];
        f = c ? c + 4 : k[1];
        browser.isIE && 8 == browser.version && (e = b ? b + 100 : k[0], f = c ? c - 28 : k[1] + 10);
        opDiv.style.cssText = "background-color:black;position:absolute;left:0px;top:0px;z-index:29990;width:" + e + "px;height:" + f + "px;"
    }
    opDiv.id = "RateThisPageOpaqueDiv";
    opDiv.className = "opaque";
    document.getElementById("PopUpDivContainer").appendChild(opDiv);
    isFirefox || opDiv.contentWindow.document.writeln('<body style="background-color:Black;"></body>');
    c || d ? browser.isIE ? CenterDiv(a, !0, f, d) : CenterDiv(a, !0, null, d) : CenterDiv(a, !0);
    ShowDiv(a)
}

function HideLoading() {
    showCancelConnectionAttemptButton = !1;
    HideDiv("LoadingDiv");
    HideDiv("CancelConnectionAttempt");
    ShowDiv("MainDataDiv")
}

function days_between(a, b) {
    a.setHours(0, 0, 0, 0);
    b.setHours(0, 0, 0, 0);
    var c = a.getTime(),
        d = b.getTime(),
        c = Math.abs(c - d);
    return Math.round(c / 864E5)
}

function days_between1(a, b) {
    a.setHours(0, 0, 0, 0);
    b.setHours(0, 0, 0, 0);
    var c = a.getTime(),
        d = b.getTime();
    return Math.round((c - d) / 864E5)
}

function days_Diff(a, b) {
    var c = a.split("-"),
        d = b.split("-"),
        d = new Date(d[2], d[1] - 1, d[0]),
        c = (new Date(c[2], c[1] - 1, c[0])).getTime(),
        d = d.getTime(),
        c = Math.abs(c - d);
    return Math.round(c / 864E5)
}

function hideText(a, b) {
    a.value == b && (a.value = "");
    a.style.color = ""
}

function showText(a, b) {
    "" == a.value && (a.value = b);
    a.value == b && (a.style.color = "#bbb")
}

function showValue(a, b) {
    b && (document.getElementById(a).value = htmlDecodeText(b.toString()))
}

function showLink(a, b) {
    if (b) {
        var c = document.getElementById(a);
        c.style.display = "inline";
        c.href = b
    }
}

function minuteConvert(a) {
    return 60 > a ? a.toString() + " min" : 60 <= a && 1440 >= a ? (a / 60).toString() + " hr" + (60 == a ? "" : "s") : 2880 == a ? "2 days" : 4320 == a ? "3 days" : 5760 == a ? "4 days" : 7200 == a ? "5 days" : 10080 == a ? "7 days" : "10 min"
}

function normalizeText(a) {
    a = htmlDecodeText(a);
    if ("undefined" != typeof a) {
        var b = a.split("\n"),
            c = a.split("line_break_placeHolder");
        1 < b.length ? a = b[0] + "..." : 1 < c.length && (a = c[0] + "...");
        a = CutStringToSize(a, 70, !1)
    }
    return a
}
var IsError = !1;

function IsGoogleConnectionDisconnect(a) {
    IsError = a;
    "True" == a && SoAlert("Could not connect to Google Calendar, please try again later.", "Unable to connect")
}

function createIframe(a, b, c) {
    var d = document.createElement("iframe");
    d.src = a;
    d.frameborder = "0";
    d.height = b;
    d.width = "100%";
    d.id = "myFrame";
    d.name = "myFrame";
    d.scrolling = "no";
    d.setAttribute("frameborder", "0");
    d.setAttribute("hspace", "0");
    d.setAttribute("marginheight", "0");
    d.setAttribute("marginwidth", "0");
    d.setAttribute("style", "overflow: hidden; width: 100%;" + c);
    d.setAttribute("vspace", "0");
    document.getElementById("iFrameDiv").appendChild(d)
}

function LoadFrame(a, b, c) {
    window.addEventListener ? window.addEventListener("load", function() {
        createIframe(a, b, c)
    }, !1) : window.attachEvent ? window.attachEvent("onload", function() {
        createIframe(a, b, c)
    }) : window.onload = function() {
        createIframe(a, b, c)
    }
}

function MeetDuration(a, b) {
    var c = " min";
    b && (c = " minutes");
    return 180 <= a ? 60 == a ? a / 60 + " hour" : 0 == a % 60 ? a / 60 + " hours" : Math.floor(a / 60) + " hr, " + a % 60 + c : a + c
}

function MinutesToDuration(a) {
    var b;
    1440 <= a ? (b = Math.floor(a / 1440), b = b + " day" + (1 < b ? "s" : "")) : 60 > a ? b = a + " minutes" : (b = a % 60, a = Math.floor(a / 60), b = 0 < a ? 0 == b ? a + " hour" + (1 < a ? "s" : "") : a + " hr " + b + " min" : b + " minutes");
    return b
}

function DaysToDuration(a) {
    var b = a;
    60 <= a ? (a = Math.floor(a / 30), b = a + " month" + (1 < a ? "s" : "")) : 14 <= a && 60 > a ? (a = Math.floor(a / 7), b = a + " week" + (1 < a ? "s" : "")) : b = a + (1 == a ? " day" : " days");
    return b
}

function isNotEmpty(a) {
    var b = !1;
    a && "undefined" != a && "" != a && (b = !0);
    return b
}

function rgbConvert(a) {
    browser.isIE && "9" > browser.version || (a = a.replace(/rgb\(|\)/g, "").split(","), a[0] = parseInt(a[0], 10).toString(16).toLowerCase(), a[1] = parseInt(a[1], 10).toString(16).toLowerCase(), a[2] = parseInt(a[2], 10).toString(16).toLowerCase(), a[0] = 1 == a[0].length ? "0" + a[0] : a[0], a[1] = 1 == a[1].length ? "0" + a[1] : a[1], a[2] = 1 == a[2].length ? "0" + a[2] : a[2], a = "#" + a.join(""));
    return a
}

function IsChecked(a) {
    var b = !1;
    a = document.getElementById(a);
    null != a && (b = !0 == a.checked || "checked" == a.checked);
    return b
}

function CheckUncheck(a) {
    a = document.getElementById(a);
    null != a && (a.checked = !a.checked)
}

function Uncheck(a) {
    a = document.getElementById(a);
    null != a && (a.checked = !1)
}

function Check(a) {
    a = document.getElementById(a);
    null != a && (a.checked = !0)
}

function ShowLoading(a) {
    scrollX = Math.max(document.documentElement.scrollLeft, document.body.scrollLeft);
    scrollY = Math.max(document.documentElement.scrollTop, document.body.scrollTop);
    window.scrollTo(0, 0);
    var b = document.getElementById("ScheudleTimeSelector");
    b && (b.style.display = "none");
    boolRefresh = !0;
    "" != a && (b = document.getElementById("LoadingTitleDiv"), !b && window.parent && (b = window.parent.document.getElementById("LoadingTitleDiv")), b && (b.innerHTML = a));
    ShowDiv("LoadingDiv");
    showCancelConnectionAttemptButton &&
        ShowDiv("CancelConnectionAttempt");
    HideDiv("MainDataDiv");
    setTimeout("refreshPage()", 12E4)
}

function refreshPage() {
    boolRefresh && window.location.reload(!0)
}

function include(a, b) {
    if (Array.prototype.indexOf) return -1 != a.indexOf(b);
    for (var c = a.length, d = 0; d < c; d++)
        if (a[d] === b) return !0;
    return !1
}

function getInnerText(a, b) {
    var c = null;
    if (c = b ? a : document.getElementById(a)) return "undefined" != typeof c.innerText ? c.innerText : "undefined" != typeof c.textContent ? c.textContent : c.data
}

function setInnerText(a, b) {
    if (obj = document.getElementById(a)) "undefined" != typeof obj.innerText ? obj.innerText = b : "undefined" != typeof obj.textContent ? obj.textContent = b : obj.data = b
}

function isNumberKey(a) {
    return a && (a = a.which ? a.which : event.keyCode, 48 <= a && 57 >= a || 8 == a) ? !0 : !1
}

function ShowError(a, b) {
    var c = document.getElementById(a);
    c && (c.innerHTML = b, c.style.visibility = "visible")
}

function isCharKey(a) {
    return a && (a = a.which ? a.which : event.keyCode, 31 < a && (65 <= a && 90 >= a || 97 <= a && 122 >= a) || 8 == a || 32 == a) ? !0 : !1
}

function isZipKey(a) {
    return a && (a = a.which ? a.which : event.keyCode, 48 <= a && 57 >= a || 65 <= a && 90 >= a || 97 <= a && 122 >= a || 32 == a || 45 == a || 8 == a) ? !0 : !1
}

function isValidAddressKey(a) {
    return a ? (a = a.which ? a.which : event.keyCode, 60 == a || 62 == a ? !1 : !0) : !1
}

function validateTheLinkNameAsAlphaNumericOnly(a) {
    return a && (a = a.which ? a.which : event.keyCode, 48 <= a && 57 >= a || 65 <= a && 90 >= a || 97 <= a && 122 >= a || 45 == a || 95 == a || 8 == a) ? !0 : !1
}

function contactSO(a) {
    null != a && ClosePopup(a);
    window.open("http://www.scheduleonce.com/contactus", "_blank").focus()
}

function onFocus_CheckText(a) {
    "0" == a.value && (a.value = "")
}

function formatDate(a) {
    if (void 0 != a) {
        var b = a.getMonth(),
            c = a.getDate();
        return "Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ")[b] + " " + c + ", " + a.getFullYear()
    }
    return ""
}

function GetReturnQuery(a) {
    return a.indexOf("?") ? "?" + a.toString().split("?")[1] : ""
}

function DownloadLink(a) {
    window.location.href = a
}

function OnCheck() {
    return !0 == flagPlan || !0 == flagUsers || !0 == flagBokings || !0 == flagWebEx || !0 == flagSF || !0 == flagInfusion || !0 == flagG2M ? !0 : !1
}

function DisableElement(a, b) {
    var c = document.getElementById(a);
    c && (c.disabled = b ? !0 : !1)
}

function setFocusOnElementByID() {
    elementToSetFocus.focus()
}

function getThemeNameByID(a) {
    switch (a) {
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

function alterBrandlessEmbedSize(a) {
    var b = document.getElementById("EmbedDesktopPreview");
    "mobileView" == a.id ? (b.childNodes[0].style.width = "320px", b.childNodes[0].style.border = "1px solid rgb(210, 210, 210)", b.childNodes[0].style.overflow = "auto") : (b.childNodes[0].style.width = "100%", b.childNodes[0].style.overflow = "none", b.childNodes[0].style.maxHeight = "none", b.childNodes[0].style.border = "none")
}

function setCustomButtons(a, b, c, d) {
    d = null != d ? d : document;
    for (var e = a.length, f = 0; f < e; f++) {
        var k = d.getElementById(a[f]);
        k && (k.style.color = "#" + b, k.style.background = "#" + c)
    }
}

function getQueryStringParameter(a, b) {
    for (var c = a.split("&"), d = 0; d < c.length; d++) {
        var e = c[d].split("=");
        if (e[0] == b) return e[1]
    }
}

function updateQueryStringParameter(a, b, c) {
    var d = RegExp("([?&])" + b + "=.*?(&|$)", "i"),
        e = -1 !== a.indexOf("?") ? "&" : "?";
    return a.match(d) ? a.replace(d, "$1" + b + "=" + c + "$2") : a + e + b + "=" + c
}

function MobileShowHideBackButton() {
    m && isEmbed && (1 == navIdx && null != document.getElementById("NavBack") && void 0 != document.getElementById("NavBack") ? document.getElementById("NavBack").style.display = "none" : null != document.getElementById("NavBack") && void 0 != document.getElementById("NavBack") && (document.getElementById("NavBack").style.display = "block"))
}

function resetButtonColorCode(a, b, c) {
    var d = document.getElementById(a);
    null != d && void 0 != d && (d.value = "FE9E0C", d.style.background = "#FE9E0C", d.style.color = "#000000", setResetButton(a, b), c && ("SOBookingButton" == c ? setBookingCode() : "SOEmailButton" == c ? setEmailCode() : "WebButton" == c && setButtonCode()))
}

function setResetButton(a, b) {
    var c = document.getElementById(b),
        d = document.getElementById(a);
    c.style.color = c && d && "FE9E0C" == d.value ? "#777777" : "#0066cc"
};

function ScheduledSettingsObj(a, b, c, d, e, f, k, h, l, p, g, q, n, r, s, t, Z, $, u, v, w, x, y, z, A, B, C, D, E, F, G, aa, H, I, J, K, L, ba, M, N, O, P, Q, R, S, T, U, V, W, X, Y) {
    this.schedulingMode = a;
    this.maxMeetingDuration = b;
    this.isFixedDuration = c;
    this.maxSuggestionsADay = d;
    this.minimumOptionsCount = e;
    this.welcomeMessage = r;
    this.hasRecurringAvailbility = f;
    this.hasDateSpecificAvailiblity = k;
    this.meetingNoticePeriod = h;
    this.isShared = p;
    this.recurringAvailiblity = g;
    this.calendarList = q;
    this.weeklyAvailDayExceptionArray = n;
    this.welcomeMessage = r;
    this.oooMessage =
        s;
    this.minMeetingDuration = t;
    this.MaxHour = this.MinHour = -1;
    this.calendaroverride = !0;
    this.defaultCalendarId = "";
    this.tzSupport = !1;
    this.defaultDuration = Z;
    this.requireCompany = this.requireLocation = this.requirePhoneNum = this.meetingStarts55 = this.meetingStarts50 = this.meetingStarts40 = this.meetingStarts35 = this.meetingStarts25 = this.meetingStarts20 = this.meetingStarts10 = this.meetingStarts05 = this.meetingStarts45 = this.meetingStarts30 = this.meetingStarts15 = this.meetingStarts00 = !1;
    this.isConnected = $;
    this.scheduleCalendarDataObj =
        u;
    this.defaultMeetingDetails = this.reqCustomInfo = this.defaultLocation = "";
    this.dayStartHour = 8;
    this.dayEndHour = 18;
    this.meetMeEmail = this.imageName = this.facebookProfile = this.linkedInProfile = this.twitterId = this.website = this.profileEmail = this.phone = this.company = this.title = this.profileName = "";
    this.status = 1;
    this.enableRedirectSettings = !1;
    this.redirectSeconds = z;
    this.redirectWebLink = A;
    this.ReminderObj = v;
    this.DoNotSendCalendarInvitation = !1;
    this.sendScheduleConfirmation = !0;
    this.availabilityFutureLimit = l;
    this.preBuffer =
        w;
    this.postBuffer = x;
    this.subject = y;
    this.settingsTimeZoneId = B;
    this.MeetMeLinkArr = C;
    this.MeetMeServiceLinkArr = D;
    this.BookNowLinkArr = E;
    this.noCancellationMsg = G;
    this.noCancellationTime = F;
    this.maxBookingsPerDay = aa;
    this.PIN1 = H;
    this.PIN2 = I;
    this.multipleBookingPerSlot = J;
    this.locationType = K;
    this.locationLabel = L;
    this.isProvidedByOwner = ba;
    this.timeStepText = M;
    this.startHour = N;
    this.endHour = O;
    this.gap = P;
    this.defaultMeetingTitle = Q;
    this.enablePhone = R;
    this.enableNote = S;
    this.requireNote = T;
    this.TagList = U;
    this.PIN3 =
        V;
    this.PIN4 = W;
    this.mandatoryCompany = X;
    this.maxBookingsPerWeek = Y
}
ScheduledSettingsObj.prototype.IsExceptioDate = function(a) {
    var b = !1;
    if (this.hasDateSpecificAvailiblity)
        for (var c = this.weeklyAvailDayExceptionArray.length, d = 0; d < c; d++)
            if (a.IsEqualToJSUTCDate(this.weeklyAvailDayExceptionArray[d].date)) {
                b = !0;
                break
            }
    return b
};

function FormatDayTimeText(a, b) {
    var c = Math.floor(a / 60),
        d = a - 60 * c,
        e = "" + d;
    10 > d && (e = "0" + d);
    d = "";
    if (0 == b || 2 == b) {
        var f = !1;
        11 < c && 24 > c && (f = !0, c -= 12);
        d = "" + c;
        if (0 == c || 24 == c) d = "12";
        d = f ? d + ":" + e + "pm" : d + ":" + e + "am"
    } else d = c + ":" + e;
    return d
}
ScheduledSettingsObj.prototype.SetHourBoundaries = function(a) {
    this.MaxHour = this.MinHour = -1;
    if (this.hasRecurringAvailbility && this.recurringAvailiblity)
        for (var b = 0; 7 > b; b++)
            for (var c = this.recurringAvailiblity[b].length, d = 0; d < c; d++) {
                var e = Math.floor(this.recurringAvailiblity[b][d][0] / 4),
                    f = Math.ceil((this.recurringAvailiblity[b][d][0] + this.recurringAvailiblity[b][d][1] / 15) / 4);
                this.UpdateMinHour(e);
                this.UpdateMaxHour(f)
            }
    if (this.hasDateSpecificAvailiblity && this.weeklyAvailDayExceptionArray)
        for (c = this.weeklyAvailDayExceptionArray.length,
            b = 0; b < c; b++)
            if (!CreateNewDateFromMili(this.weeklyAvailDayExceptionArray[b].date.valueOf(), a).IsPastDue())
                for (var k = this.weeklyAvailDayExceptionArray[b].times, h = k.length, d = 0; d < h; d++) e = Math.floor(k[d][0] / 60), f = Math.ceil((k[d][0] + k[d][1]) / 60), this.UpdateMinHour(e), this.UpdateMaxHour(f)
};
ScheduledSettingsObj.prototype.UpdateMinHour = function(a) {
    if (-1 == this.MinHour || a < this.MinHour) this.MinHour = a
};
ScheduledSettingsObj.prototype.UpdateMaxHour = function(a) {
    if (-1 == this.MaxHour || a > this.MaxHour) this.MaxHour = a
};

function SettingCalendarDataObj(a, b, c) {
    this.accountEmail = a;
    this.calendarID = b;
    this.calendarName = c
};

function UserProfileObj(a, b, c, d, e, f, k, h, l, p, g, q, n, r, s, t, Z, $, u, v, w, x, y, z, A, B, C, D, E, F, G, aa, H, I, J, K, L, ba, M, N, O, P, Q, R, S, T, U, V, W, X, Y) {
    this.userID = a;
    this.timeZoneID = c;
    this.firstName = d;
    this.lastName = e;
    this.email = f;
    this.status = k;
    this.dateTimeFormat = h;
    this.weekStartDay = l;
    this.subscribeNews = !1;
    this.planType = p;
    this.profileStatus = g;
    this.LogoImageName = q;
    this.BillingEndDate = n;
    this.defaultMeetingDuration = r;
    this.obtzSupport = !1;
    this.profileCreateDate = s;
    this.MaxUsersNum = this.MaxServicePagesNum = this.MaxBookNowLinkNum =
        this.MaxMeetMeLinkNum = 0;
    this.accountId = u;
    this.accountCretedDate = v;
    this.MeetMeLinksArr = w;
    this.BookNowLinksArr = x;
    this.ServiceLinksArr = y;
    this.CategoryLinksArr = z;
    this.defaultCalendarId = this.availableLinkName = "";
    this.ReminderObj = A;
    this.currecyCode = B;
    this.emailLabel = C;
    this.loginType = D;
    this.loginEmail = E;
    this.AccountRole = 1;
    this.AdminstrationName = F;
    this.CanCreateMeetMe = G;
    this.selectServiceForNotification = H;
    this.selectServiceForInformation = I;
    this.filterOwner = J;
    this.filterEditor = K;
    this.filterViewer = L;
    this.supportCode =
        M;
    this.isGoToConnected = N;
    this.isWebExConnected = O;
    this.billedManually = P;
    this.trialLeftDays = Q;
    this.isUSProfile = R;
    this.isInfusionConnected = S;
    this.CurrentDate = new Date((new Date).getUTCMilliseconds());
    this.isOldProfessional = T;
    this.isAppsUser = U;
    this.ThemeID = V;
    this.ButtonColor = W;
    this.TextColor = X;
    this.encryptedUserID = Y
}
UserProfileObj.prototype.onTrial = function() {
    var a = !1;
    if (20 < this.planType || 3 == this.planType || 2 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.notActive = function() {
    var a = !1;
    this.HasMultiUserPermission() || (a = 1 != this.status || 6 == this.profileStatus);
    return a
};
UserProfileObj.prototype.HasMultiCalendarPremission = function() {
    var a = !1;
    1 != this.planType && (a = !0);
    return a
};
UserProfileObj.prototype.HasAddCategoryPermission = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || 7 == this.planType || 17 == this.planType || 27 == this.planType || 8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasAdditionalCalendarPremission = function() {
    var a = !1;
    if (16 <= this.planType || 6 <= this.planType && 8 >= this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasAppointmentModePremission = function() {
    var a = !0;
    if (1 == this.planType || 2 == this.planType || 4 == this.planType || 14 == this.planType) a = !1;
    return a
};
UserProfileObj.prototype.HasProductivityPremission = function(a) {
    return a ? 0 == this.planType || 2 <= this.planType : 2 <= this.planType
};
UserProfileObj.prototype.HasAdditionalEmailPermission = function() {
    return this.isOldCreatedAccount(this.accountCretedDate) ? 2 <= this.planType : 8 == this.planType || 18 == this.planType || 28 == this.planType
};
UserProfileObj.prototype.isOldAccount = function(a) {
    return this.isOldProfessional
};
UserProfileObj.prototype.isOldCreatedAccount = function(a) {
    return a < new Date(2014, 4, 10)
};
UserProfileObj.prototype.HasRemoveAddPermission = function() {
    var a = !1;
    2 <= this.planType && (a = !0);
    return a
};
UserProfileObj.prototype.HasUploadLogoPermission = function() {
    var a = !1;
    2 <= this.planType && (a = !0);
    return a
};
UserProfileObj.prototype.HasUploadHeaderPermission = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || 7 == this.planType || 17 == this.planType || 27 == this.planType || 8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasServicesPermission = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || 7 == this.planType || 17 == this.planType || 27 == this.planType || 8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasEmbedPermission = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || 7 == this.planType || 17 == this.planType || 27 == this.planType || 8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasMeetMeUpgradePermission = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || this.HasMultiUserPermission()) a = !0;
    return a
};
UserProfileObj.prototype.HasMultiUserPermission = function() {
    var a = !1;
    1 != this.planType && (a = !0);
    return a
};
UserProfileObj.prototype.HasImagePermission = function() {
    var a = !0;
    if (1 == this.planType || 0 == this.planType) a = !1;
    return a
};
UserProfileObj.prototype.HasPooledAvail = function() {
    var a = !1;
    if (8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasMultipleBookingPerSlotPermission = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || 7 == this.planType || 17 == this.planType || 27 == this.planType || 8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.HasAdvanvedBooking = function() {
    var a = !1;
    if (6 == this.planType || 16 == this.planType || 26 == this.planType || 7 == this.planType || 17 == this.planType || 27 == this.planType || 8 == this.planType || 18 == this.planType || 28 == this.planType) a = !0;
    return a
};
UserProfileObj.prototype.GetTrialDays = function() {
    return this.trialLeftDays
};
UserProfileObj.prototype.GetBillingEndDays = function() {
    var a = 0;
    this.BillingEndDate && this.CurrentDate && (a = days_between1(this.BillingEndDate, this.CurrentDate));
    return a
};
UserProfileObj.prototype.CanBeUpgraded = function() {
    var a = !0;
    this.BillingEndDate && (a = days_between(this.BillingEndDate, this.CurrentDate), a = 3 < a || this.IsPaymentFailure() || 0 > a);
    return a
};
UserProfileObj.prototype.IsPaymentFailure = function() {
    return 3 == this.profileStatus || 4 == this.profileStatus || 5 == this.profileStatus && 0 > this.GetBillingEndDays()
};
UserProfileObj.prototype.GetPlanToUpgrade = function() {
    var a;
    switch (this.planType) {
        case 2:
            a = 4;
            break;
        case 3:
            a = 5;
            break;
        case 26:
            a = 6;
            break;
        case 27:
            a = 7;
            break;
        case 28:
            a = 8
    }
    return a
};
UserProfileObj.prototype.GetPlanShortString = function() {
    var a;
    switch (this.planType) {
        case 0:
            a = "Basic";
            break;
        case 1:
            a = "Basic";
            break;
        case 2:
            a = "Plus (Free trial)";
            break;
        case 3:
            a = "Premium (Free trial)";
            break;
        case 4:
            a = "Plus";
            break;
        case 5:
            a = "Premium";
            break;
        case 6:
            a = "Professional";
            break;
        case 7:
            a = "Workgroup";
            break;
        case 8:
            a = "Enterprise";
            break;
        case 14:
            a = "Plus";
            break;
        case 15:
            a = "Premium";
            break;
        case 16:
            a = "Professional";
            break;
        case 17:
            a = "Workgroup";
            break;
        case 18:
            a = "Enterprise";
            break;
        case 26:
            a = "Professional (Free trial)";
            break;
        case 27:
            a = "Workgroup (Free trial)";
            break;
        case 28:
            a = "Enterprise (Free trial)"
    }
    return a
};
UserProfileObj.prototype.GetPlanFullString = function() {
    var a = this.GetTrialDays(),
        b;
    switch (this.planType) {
        case 0:
            b = "Basic";
            break;
        case 1:
            b = "Basic";
            break;
        case 2:
            b = 'Plus (Free trial) <span class="textRed">Your free trial ends in ' + a + " days</span>";
            break;
        case 3:
            b = 'Premium (Free trial) <span class="textRed">Your free trial ends in ' + a + " days</span>";
            break;
        case 4:
            b = "Plus";
            break;
        case 5:
            b = "Premium";
            break;
        case 6:
            b = "Professional";
            break;
        case 7:
            b = "Workgroup";
            break;
        case 8:
            b = "Enterprise";
            break;
        case 14:
            b = "Plus";
            break;
        case 15:
            b = "Premium";
            break;
        case 16:
            b = "Professional";
            break;
        case 17:
            b = "Workgroup";
            break;
        case 18:
            b = "Enterprise";
            break;
        case 26:
            b = 'Professional (Free trial) <span class="textRed">Your free trial ends in ' + a + " days</span>";
            break;
        case 27:
            b = 'Workgroup (Free trial) <span class="textRed">Your free trial ends in ' + a + " days</span>";
            break;
        case 28:
            b = 'Enterprise (Free trial) <span class="textRed">Your free trial ends in ' + a + " days</span>"
    }
    return b
};
UserProfileObj.prototype.GetPlanString = function() {
    this.GetTrialDays();
    var a;
    switch (this.planType) {
        case 0:
            a = "<strong>Basic</strong>";
            break;
        case 1:
            a = "<strong>Basic</strong>";
            break;
        case 2:
            a = "<strong>Plus</strong>";
            break;
        case 3:
            a = "<strong>Premium</strong>";
            break;
        case 4:
            a = "<strong>Plus</strong>";
            break;
        case 5:
            a = "<strong>Premium</strong>";
            break;
        case 6:
            a = "<strong>Professional</strong>";
            break;
        case 7:
            a = "<strong>Workgroup</strong>";
            break;
        case 8:
            a = "<strong>Enterprise</strong>";
            break;
        case 14:
            a = "<strong>Plus</strong>";
            break;
        case 15:
            a = "<strong>Premium</strong>";
            break;
        case 16:
            a = "<strong>Professional</strong>";
            break;
        case 17:
            a = "<strong>Workgroup</strong>";
            break;
        case 18:
            a = "<strong>Enterprise</strong>";
            break;
        case 26:
            a = "<strong>Professional</strong>";
            break;
        case 27:
            a = "<strong>Workgroup</strong>";
            break;
        case 28:
            a = "<strong>Enterprise</strong>"
    }
    return a
};
UserProfileObj.prototype.GetUserLicensesString = function() {
    this.GetTrialDays();
    var a = "";
    return a = "<strong>" + this.MaxUsersNum + " User " + (1 < this.MaxUsersNum || 0 == this.MaxUsersNum ? "licenses" : "license") + "</strong>"
};
UserProfileObj.prototype.GetBookingLicensesString = function() {
    this.GetTrialDays();
    var a = "";
    return a = "<strong>" + this.MaxMeetMeLinkNum + " Booking page " + (1 < this.MaxMeetMeLinkNum || 0 == this.MaxMeetMeLinkNum ? "licenses" : "license") + "</strong>"
};
UserProfileObj.prototype.GetTrailString = function() {
    var a = this.GetTrialDays(),
        b = "";
    switch (this.planType) {
        case 2:
            b = ' Free trial <span class="textRed">(' + a + ")</span>";
            break;
        case 3:
            b = ' Free trial <span class="textRed">(' + a + ")</span>";
            break;
        case 26:
            b = ' Free trial <span class="textRed">(' + a + ")</span>";
            break;
        case 27:
            b = ' Free trial <span class="textRed">(' + a + ")</span>";
            break;
        case 28:
            b = ' Free trial <span class="textRed">(' + a + ")</span>"
    }
    return b
};
UserProfileObj.prototype.GetLoginStr = function() {
    var a;
    switch (this.loginType) {
        case 1:
            a = "Your Google ID (" + this.loginEmail + ")";
            break;
        case 2:
            a = "Your ScheduleOnce for Google Apps ID (" + this.loginEmail + ")";
            break;
        case 3:
            a = "Your Facebook ID (" + this.loginEmail + ")";
            break;
        case 4:
            a = "Your ScheduleOnce ID (" + this.loginEmail + ")"
    }
    return a
};
UserProfileObj.prototype.IsAdmin = function() {
    return 1 == userProfileObj.AccountRole
};
UserProfileObj.prototype.GetUsersInPlan = function() {
    var a = 1;
    switch (this.planType) {
        case 6:
        case 16:
            a = 1;
            break;
        case 7:
        case 17:
            a = 1;
            break;
        case 8:
        case 18:
            a = 1
    }
    return a
};
UserProfileObj.prototype.GetBookingPagesInPlan = function() {
    var a = 1;
    switch (this.planType) {
        case 1:
        case 2:
        case 4:
        case 14:
        case 3:
        case 5:
        case 15:
            a = 1;
            break;
        case 6:
        case 16:
            a = 2;
            this.isOldAccount(this.accountCretedDate) && (a += 1);
            break;
        case 7:
        case 17:
            a = 3;
            break;
        case 8:
        case 18:
            a = 3
    }
    return a
};

function enableProductivity(a, b, c) {
    if (userProfileObj.HasProductivityPremission()) {
        if (b = document.getElementById(b)) b.disabled = !a.checked
    } else {
        SoPromotion("Enable productivity features", '<p>Productivity features are available in all paid plans.</p><p>Access all productivity features for only $5 per month!</p><a href="http://help.scheduleonce.com/customer/portal/articles/247545-complete-list-of-productivity-features-?t=47564" target="blank_">See the complete list of productivity features</a>', 247);
        a.checked = !1;
        if (b = document.getElementById(b)) b.disabled = !0;
        c && a.blur()
    }
}

function enableAdditionalEmail(a, b, c) {
    if (userProfileObj.HasAdditionalEmailPermission()) {
        if (b = document.getElementById(b)) b.disabled = !a.checked
    } else {
        1 == userProfileObj.AccountRole ? SoPromotion("Notifications to a non-ScheduleOnce User", "Notifications to a non-ScheduleOnce User are only available in the Enterprise plan.", 199, null, function() {
            LoadPage("Account-Plan.aspx?e")
        }) : SoAlert("Notifications to a non-ScheduleOnce User are only available in the Enterprise plan.", "Notifications to a non-ScheduleOnce User",
            183);
        a.checked = !1;
        if (b = document.getElementById(b)) b.disabled = !0;
        c && a.blur()
    }
}

function days_between(a, b) {
    a.setHours(0, 0, 0, 0);
    b.setHours(0, 0, 0, 0);
    var c = a.getTime(),
        d = b.getTime(),
        c = Math.abs(c - d);
    return Math.round(c / 864E5)
}

function days_between1(a, b) {
    a.setHours(0, 0, 0, 0);
    b.setHours(0, 0, 0, 0);
    var c = a.getTime(),
        d = b.getTime();
    return Math.round((c - d) / 864E5)
}

function GetUserPlanStr(a) {
    var b;
    switch (a) {
        case 0:
            b = "Basic";
            break;
        case 1:
            b = "Basic";
            break;
        case 2:
            b = "Plus (Free trial)";
            break;
        case 3:
            b = "Premium (Free trial)";
            break;
        case 4:
            b = "Plus";
            break;
        case 5:
            b = "Premium";
            break;
        case 6:
            b = "Professional";
            break;
        case 7:
            b = "Workgroup";
            break;
        case 8:
            b = "Enterprise";
            break;
        case 14:
            b = "Plus";
            break;
        case 15:
            b = "Premium";
            break;
        case 16:
            b = "Professional";
            break;
        case 17:
            b = "Workgroup";
            break;
        case 18:
            b = "Enterprise";
            break;
        case 26:
            b = "Professional (Free trial)";
            break;
        case 27:
            b = "Workgroup (Free trial)";
            break;
        case 28:
            b = "Enterprise (Free trial)"
    }
    return b
}
UserProfileObj.prototype.LoadPaymentPage = function(a, b) {
    !0 == this.billedManually ? null != b ? OpenPopup(b) : OpenPopup("divBilledManually") : LoadPage(a)
};

function DayLightSavingObj(a, b, c) {
    this.offset = a;
    this.startTimeMili = b;
    this.endTimeMili = c
}
DayLightSavingObj.prototype.copy = function(a) {
    a.offset = this.offset;
    a.startTimeMili = this.startTimeMili;
    a.endTimeMili = this.endTimeMili
};

function TimeZoneObj(a, b, c, d, e, f, k, h) {
    this.id = a;
    this.shortName = b;
    this.country = c;
    this.region = d;
    this.cityList = e;
    this.timeZone = f;
    this.hasDayLightSavings = k;
    this.dayLightSavings = null;
    this.CountryCallingCode = h
}
TimeZoneObj.prototype.copy = function(a) {
    a.id = this.id;
    a.shortName = this.shortName;
    a.country = this.country;
    a.region = this.region;
    a.cityList = this.cityList;
    a.timeZone = this.timeZone;
    a.hasDayLightSavings = this.hasDayLightSavings;
    if (null != this.dayLightSavings) {
        var b = this.dayLightSavings.length;
        a.dayLightSavings = [];
        for (var c = 0; c < b; c++) a.dayLightSavings[c] = new DayLightSavingObj(-1, -1, -1), this.dayLightSavings[c].copy(a.dayLightSavings[c])
    }
};
TimeZoneObj.prototype.AddDayLightSavings = function(a) {
    this.hasDayLightSavings = !0;
    null == this.dayLightSavings && (this.dayLightSavings = []);
    this.dayLightSavings[this.dayLightSavings.length] = a
};
TimeZoneObj.prototype.toFullNameString = function(a, b) {
    null == b && (b = !1);
    null == a && (a = 30);
    var c = "",
        d = this.country + "; ",
        d = d + this.region;
    "" != d && (d += "");
    d += this.cityList;
    d;
    var e = "";
    b || (e += '<span title="' + d + '">');
    e += CutStringToSize(d, a);
    b || (e += "</span>");
    c += " (GMT";
    0 < this.timeZone ? c += "+" : 0 == this.timeZone && (c += "&nbsp;");
    c += this.timeZone + ") ";
    return e + c
};
TimeZoneObj.prototype.toFullNameStringWithtrueOffset = function(a, b, c) {
    null == b && (b = !1);
    null == a && (a = 30);
    var d = "",
        e = this.country + "; ",
        e = e + this.region;
    "" != e && (e += "");
    e += this.cityList;
    e;
    var f = "";
    b || (f += '<span title="' + e + '">');
    f += CutStringToSize(e, a);
    b || (f += "</span>");
    d += " (GMT";
    c.IsInDLS() ? (0 < Getoffsetoutoftimezone(c) ? d += "+" : 0 == Getoffsetoutoftimezone(c) && (d += "&nbsp;"), d += Getoffsetoutoftimezone(c) + ") ") : (0 < this.timeZone && (d += "+"), d += this.timeZone + ") ");
    return f + d
};
TimeZoneObj.prototype.toFullNameStringGmtLastWithtrueOffset = function(a, b, c) {
    null == b && (b = !1);
    null == a && (a = 30);
    if (-1 == this.id) return "<span>Time zone region not selected</span>";
    var d = "&nbsp;(GMT";
    c.IsInDLS() ? (0 < Getoffsetoutoftimezone(c) ? d += "+" : 0 == Getoffsetoutoftimezone(c) && (d += "&nbsp;"), d += Getoffsetoutoftimezone(c) + ")") : (0 < this.timeZone ? d += "+" : 0 == this.timeZone && (d += "&nbsp;"), d += this.timeZone + ")");
    c = this.country + "; ";
    c += this.region;
    "" != c && (c += "");
    c += this.cityList;
    var e = "";
    b || (e += '<span class="locationCountryreason" title="' +
        c + '">');
    e += CutStringToSize(c, a) + d;
    b || (e += "</span>");
    return e
};
TimeZoneObj.prototype.toFullNameStringGmtLast = function(a, b) {
    null == b && (b = !1);
    null == a && (a = 30);
    if (-1 == this.id) return "<span>Time zone region not selected</span>";
    var c = "&nbsp;(GMT";
    0 < this.timeZone ? c += "+" : 0 == this.timeZone && (c += "&nbsp;");
    var c = c + (this.timeZone + ") "),
        d = this.country + "; ",
        d = d + this.region;
    "" != d && (d += "");
    var d = d + this.cityList,
        e = "";
    b || (e += '<span title="' + d + '">');
    e += CutStringToSize(d, a) + c;
    b || (e += "</span>");
    return e
};
TimeZoneObj.prototype.toFullNameStringGmtLastDstIcon = function(a, b) {
    null == b && (b = !1);
    null == a && (a = 30);
    if (-1 == this.id) return "<span>Time zone region not selected</span>";
    var c = "&nbsp;(GMT";
    GetNowDateTime(this).IsInDLS() ? (0 < Getoffsetoutoftimezone(GetNowDateTime(this)) ? c += "+" : 0 == Getoffsetoutoftimezone(GetNowDateTime(this)) && (c += "&nbsp;"), c += Getoffsetoutoftimezone(GetNowDateTime(this)) + ") ") : (0 < this.timeZone ? c += "+" : 0 == this.timeZone && (c += "&nbsp;"), c += this.timeZone + ") ");
    var d = this.country + "; ",
        e, d = d + this.region;
    "" != d && (d += "");
    e = "" + (d += this.cityList);
    d += c;
    GetNowDateTime(this).IsInDLS() && (d += " [DST]");
    var f = "";
    b || (f += '<span title="' + d + '">');
    f = GetNowDateTime(this).IsInDLS() ? f + (CutStringToSize(e, a) + c + " [DST]") : f + (CutStringToSize(e, a) + c);
    b || (f += "</span>");
    return f
};
TimeZoneObj.prototype.toString = function() {
    return this.toFullNameString(1E4)
};
TimeZoneObj.prototype.toFullNameWithoutCountryString = function() {
    var a;
    a = this.region;
    "" == a && (a = this.country);
    a = "" + a + " (GMT";
    GetNowDateTime(this).IsInDLS() ? (0 < Getoffsetoutoftimezone(GetNowDateTime(this)) ? a += "+" : 0 == Getoffsetoutoftimezone(GetNowDateTime(this)) && (a += " "), a += Getoffsetoutoftimezone(GetNowDateTime(this)) + ") ") : (0 < this.timeZone ? a += "+" : 0 == this.timeZone && (a += " "), a += this.timeZone + ") ");
    GetNowDateTime(this).IsInDLS() && (a += " [DST]");
    return a
};

function sortByGMT(a, b) {
    var c = a.timeZone,
        d = b.timeZone;
    return c < d ? -1 : c > d ? 1 : 0
}
TimeZoneObj.prototype.GetDlsChangeTime = function(a, b) {
    var c = null;
    if (this.hasDayLightSavings && null != this.dayLightSavings)
        for (var d = this.dayLightSavings.length, e = 0; e < d; e++) {
            var f = this.dayLightSavings[e];
            if (f.startTimeMili > a.innerMiliSecs && f.startTimeMili < b.innerMiliSecs) {
                c = CreateNewDateFromMili(f.startTimeMili, this);
                break
            }
            if (f.endTimeMili > a.innerMiliSecs && f.endTimeMili < b.innerMiliSecs) {
                c = CreateNewDateFromMili(f.endTimeMili, this);
                break
            }
        }
    return c
};

function DateTimeObj(a, b, c, d, e, f, k, h) {
    this.m_fullYearForShow = this.m_monthForShow = this.m_dayForShow = this.m_dateForShow = this.m_yearForShow = -1;
    null == h && (h = !1);
    this.innerMiliSecs = Date.UTC(a, b, c, d, e, f);
    this.timeZoneObj = null != k ? k : new TimeZoneObj(1, "UTC", "(UTC/GMT)", "", "", 0, !1);
    h && null != k && (a = this.GetTimeZoneOffset(), this.innerMiliSecs -= a * HOUR_IN_MILISECONDS, b = this.GetTimeZoneOffset(), b != a && (this.innerMiliSecs -= (b - a) * HOUR_IN_MILISECONDS))
}
DateTimeObj.prototype.fixForTimeZoneChange = function(a) {
    var b = this.timeZoneObj.timeZone - a.timeZone;
    a = CreateNewDateFromMili(this.innerMiliSecs, a);
    a = this.GetDLSOffset() - a.GetDLSOffset();
    this.innerMiliSecs = this.AddHours(b + a).innerMiliSecs
};
DateTimeObj.prototype.copy = function(a, b) {
    a.innerMiliSecs = this.innerMiliSecs;
    null == b ? this.timeZoneObj.copy(a.timeZoneObj) : a.SetTimeZoneObj(b)
};
DateTimeObj.prototype.clone = function(a) {
    var b = new DateTimeObj;
    this.copy(b, a);
    return b
};
var MINUTE_IN_MILISECONDS = 6E4,
    HOUR_IN_MILISECONDS = 60 * MINUTE_IN_MILISECONDS,
    DAY_IN_MILISECONDS = 24 * HOUR_IN_MILISECONDS;

function CreateNewDateFromMili(a, b) {
    var c = new DateTimeObj(1970, 1, 1, 0, 0, 0, b, !1);
    c.innerMiliSecs = a;
    return c
}

function GetNowDateTime(a) {
    dt = new Date;
    var b = CreateNewDateFromMili(dt.getTime(), a);
    try {
        null != win.earliestDate ? b = CreateNewDateFromMili(win.earliestDate, a) : null != win.curentmilisec && -1 != parseInt(win.curentmilisec) ? b = CreateNewDateFromMili(parseInt(win.curentmilisec), a) : null != curentmilisec && -1 != parseInt(curentmilisec) && (b = CreateNewDateFromMili(parseInt(curentmilisec), a))
    } catch (c) {}
    return b
}
DateTimeObj.prototype.SetTimeZoneObj = function(a) {
    this.timeZoneObj = a
};
DateTimeObj.prototype.GetDateOnlyDateTime = function(a) {
    null == a && (a = !1);
    var b = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj),
        c = b.GetDateForShow(),
        d = b.GetHoursForShow(),
        e = b.GetMinutesForShow(),
        f = b.GetSecondsForShow(),
        b = b.AddHours(-1 * d),
        b = b.AddMinutes(-1 * e),
        b = b.AddSeconds(-1 * f),
        d = this.CompareDateForShowTo(b);
    0 != d && (b = b.AddHours(d));
    if (a && 0 != b.GetHoursForShow())
        for (a = -1, b.GetDate() > c && (a = 1); 0 != b.GetHoursForShow();) b = b.AddHours(a);
    return b
};
DateTimeObj.prototype.GetDateOnlyDateTimeAbsolute = function() {
    var a = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj),
        a = a.AddHours(-1 * a.GetHours()),
        a = a.AddMinutes(-1 * a.GetMinutes());
    return a = a.AddSeconds(-1 * a.GetSeconds())
};
DateTimeObj.prototype.GetDateOnlyDateTimeUTC = function() {
    var a = this.GetDateOnlyDateTimeAbsolute();
    if (0 <= this.timeZoneObj.timeZone) {
        var b = a.GetInnerMiliseconds();
        this.GetDateOnlyDateTime().GetInnerMiliseconds() > b && (a = a.AddDay(1))
    }
    return a
};
DateTimeObj.prototype.GetDateOnlyDateTimeTZ = function() {
    var a = this.GetDateOnlyDateTime(!0);
    if (0 > this.timeZoneObj.timeZone) {
        var b = a.GetInnerMiliseconds(),
            c = this.GetDateOnlyDateTimeAbsolute().GetInnerMiliseconds();
        b < c && (a = a.AddDay(1))
    }
    return a
};
DateTimeObj.prototype.GenerateCreationString = function() {
    return "CreateNewDateFromMili(" + this.innerMiliSecs + ")"
};
DateTimeObj.prototype.AddSeconds = function(a) {
    return CreateNewDateFromMili(this.innerMiliSecs + 1E3 * a, this.timeZoneObj)
};
DateTimeObj.prototype.AddMinutes = function(a) {
    return CreateNewDateFromMili(this.innerMiliSecs + a * MINUTE_IN_MILISECONDS, this.timeZoneObj)
};
DateTimeObj.prototype.AddHours = function(a) {
    return CreateNewDateFromMili(this.innerMiliSecs + a * HOUR_IN_MILISECONDS, this.timeZoneObj)
};
DateTimeObj.prototype.AddMinutesForRecurringAvail = function(a) {
    var b = this.GetHoursForShow(),
        c = this.GetMinutesForShow();
    a = CreateNewDateFromMili(this.innerMiliSecs - b * HOUR_IN_MILISECONDS - c * MINUTE_IN_MILISECONDS + a * MINUTE_IN_MILISECONDS, this.timeZoneObj);
    b = this.GetDLSOffset() - a.GetDLSOffset();
    return a = a.AddHours(b)
};
DateTimeObj.prototype.AddDay = function(a) {
    var b = this.GetTimeZoneOffset();
    a = this.AddDays(a);
    var c = a.GetTimeZoneOffset();
    c != b && (a = a.AddHours(-1 * (c - b)));
    return a
};
DateTimeObj.prototype.AddDays = function(a) {
    return CreateNewDateFromMili(this.innerMiliSecs + a * DAY_IN_MILISECONDS, this.timeZoneObj)
};
DateTimeObj.prototype.GetSeconds = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCSeconds()
};
DateTimeObj.prototype.GetMinutes = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCMinutes()
};
DateTimeObj.prototype.GetHours = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCHours()
};
DateTimeObj.prototype.GetDate = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCDate()
};
DateTimeObj.prototype.GetDay = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCDay()
};
DateTimeObj.prototype.GetMonth = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCMonth()
};
DateTimeObj.prototype.GetFullYear = function() {
    var a = new Date;
    a.setTime(this.innerMiliSecs);
    return a.getUTCFullYear()
};
DateTimeObj.prototype.IsInDLS = function() {
    return 0 != this.GetDLSOffset()
};
DateTimeObj.prototype.GetDLSIcon = function(a) {
    var b = "";
    null == a && (a = 2);
    this.timeZoneObj.hasDayLightSavings && (b = "", this.IsInDLS() && (b += '<img alt="DST" style="width:14px;height:14px;position:relative;top:' + a + 'px" border="0" src="Images/sun_on.png" title="Daylight Saving Time is in effect" ></img>'));
    return b
};
DateTimeObj.prototype.GetDLSOffset = function() {
    var a = 0;
    if (this.timeZoneObj.hasDayLightSavings && null != this.timeZoneObj.dayLightSavings)
        for (var b = this.timeZoneObj.dayLightSavings.length, c = 0; c < b; c++) {
            var d = this.timeZoneObj.dayLightSavings[c];
            this.innerMiliSecs >= d.startTimeMili && this.innerMiliSecs < d.endTimeMili && (a = d.offset - this.timeZoneObj.timeZone)
        }
    return a
};
DateTimeObj.prototype.GetTimeZoneOffset = function() {
    return this.timeZoneObj.timeZone + this.GetDLSOffset()
};
DateTimeObj.prototype.IsPastDue = function() {
    var a = !1;
    1 == GetNowDateTime(this.timeZoneObj).CompareTo(this) && (a = !0);
    return a
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
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return a.getUTCSeconds()
};
DateTimeObj.prototype.GetMinutesForShow = function() {
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return a.getUTCMinutes()
};
DateTimeObj.prototype.GetHoursForShow = function() {
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return a.getUTCHours()
};
DateTimeObj.prototype.GetYearForShow = function() {
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return this.m_yearForShow = a.getUTCFullYear()
};
DateTimeObj.prototype.GetDateForShow = function() {
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return this.m_dateForShow = a.getUTCDate()
};
DateTimeObj.prototype.GetDayForShow = function() {
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return a.getUTCDay()
};
DateTimeObj.prototype.GetMonthForShow = function() {
    var a = new Date;
    a.setTime(this.GetInnerMilisecondsForShow());
    return this.m_monthForShow = a.getUTCMonth()
};
DateTimeObj.prototype.GetFullYearForShow = function() {
    if (-1 == this.m_fullYearForShow) {
        var a = new Date;
        a.setTime(this.GetInnerMilisecondsForShow());
        this.m_fullYearForShow = a.getUTCFullYear()
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
DateTimeObj.prototype.GetClosestDayDate = function(a) {
    ret = CreateNewDateFromMili(this.innerMiliSecs, this.timeZoneObj);
    ret.innerMiliSecs -= DAY_IN_MILISECONDS * ret.GetDayForShow();
    ret = ret.AddDays(a);
    1 == ret.CompareTo(this) && (ret = ret.AddDays(-7));
    return ret
};
DateTimeObj.prototype.GetNextDay = function() {
    for (var a = this.GetDateForShow(), b = this.GetDateOnlyDateTime(!0), c = !1; b.GetDateForShow() == a;) b = b.AddHours(1), c = !0;
    c && 1 < b.GetHoursForShow() && (b = b.AddHours(-1));
    return b
};
DateTimeObj.prototype.GetDateTimeIndicator = function() {
    return this.GetFullYearForShow().toString() + "" + this.GetMonthForShow().toString() + "" + this.GetDateForShow().toString()
};
DateTimeObj.prototype.CompareTo = function(a) {
    a = this.innerMiliSecs - a.innerMiliSecs;
    return 0 < a ? 1 : 0 > a ? -1 : 0
};
DateTimeObj.prototype.CompareDateForShowTo = function(a) {
    var b = Date.UTC(this.GetFullYearForShow(), this.GetMonthForShow(), this.GetDateForShow(), 0, 0, 0);
    a = Date.UTC(a.GetFullYearForShow(), a.GetMonthForShow(), a.GetDateForShow(), 0, 0, 0);
    return b > a ? 1 : b < a ? -1 : 0
};
DateTimeObj.prototype.IsEqualToJSDate = function(a) {
    return this.GetFullYearForShow() == a.getFullYear() && this.GetMonthForShow() == a.getMonth() && this.GetDateForShow() == a.getDate() ? !0 : !1
};
DateTimeObj.prototype.IsEqualToJSUTCDate = function(a) {
    return this.GetFullYearForShow() == a.getUTCFullYear() && this.GetMonthForShow() == a.getUTCMonth() && this.GetDateForShow() == a.getUTCDate() ? !0 : !1
};
DateTimeObj.prototype.IsEqualToDate = function(a) {
    return this.GetFullYearForShow() == a.GetFullYearForShow() && this.GetMonthForShow() == a.GetMonthForShow() && this.GetDateForShow() == a.GetDateForShow() ? !0 : !1
};
DateTimeObj.prototype.IsEqualToTime = function(a) {
    return this.GetFullYearForShow() == a.GetFullYearForShow() && this.GetMonthForShow() == a.GetMonthForShow() && this.GetDateForShow() == a.GetDateForShow() && this.GetHoursForShow() == a.GetHoursForShow() && this.GetMinutesForShow() == a.GetMinutesForShow() ? !0 : !1
};
DateTimeObj.prototype.LowerOrEqual = function(a) {
    a = this.CompareTo(a);
    var b = !1;
    if (0 == a || -1 == a) b = !0;
    return b
};
DateTimeObj.prototype.GreaterOrEqual = function(a) {
    a = this.CompareTo(a);
    var b = !1;
    if (0 == a || 1 == a) b = !0;
    return b
};
DateTimeObj.prototype.toString = function(a) {
    null == a && (a = !0);
    var b = FormatDateWithDayMonthYearByUser(this) + " " + FormatTimeByUser(this);
    a && (b += "(" + this.timeZoneObj + ")");
    return b
};
DateTimeObj.prototype.toStringAbsolute = function() {
    return this.formatDateAbsolute("EE, MMM dd, yyyy") + " " + GetTimeStringByPrefrecesByDate(this, currUserData)
};
DateTimeObj.prototype.MONTH_NAMES = "January February March April May June July August September October November December Jan Feb Mar Apr May Jun Jul Aug Sep Oct Nov Dec".split(" ");
DateTimeObj.prototype.DAY_NAMES = "Sunday Monday Tuesday Wednesday Thursday Friday Saturday Sun Mon Tue Wed Thu Fri Sat".split(" ");
DateTimeObj.prototype.LZ = function(a) {
    return (0 > a || 9 < a ? "" : "0") + a
};
DateTimeObj.prototype.formatDate = function(a) {
    a += "";
    var b = "",
        c = 0,
        d = "",
        e = "",
        d = this.GetFullYearForShow() + "",
        e = this.GetMonthForShow() + 1,
        f = this.GetDateForShow(),
        k = this.GetDayForShow(),
        h = this.GetHoursForShow(),
        l = this.GetMinutesForShow(),
        p = this.GetSecondsForShow(),
        g = {};
    4 > d.length && (d = "" + (d - 0 + 1900));
    g.y = "" + d;
    g.yyyy = d;
    g.yy = d.substring(2, 4);
    g.M = e;
    g.MM = this.LZ(e);
    g.MMM = this.MONTH_NAMES[e - 1];
    g.NNN = this.MONTH_NAMES[e + 11];
    g.d = f;
    g.dd = this.LZ(f);
    g.E = this.DAY_NAMES[k + 7];
    g.EE = this.DAY_NAMES[k];
    g.H = h;
    g.HH = this.LZ(h);
    g.h = 0 == h ? 12 : 12 < h ? h - 12 : h;
    g.hh = this.LZ(g.h);
    g.K = 11 < h ? h - 12 : h;
    g.k = h + 1;
    g.KK = this.LZ(g.K);
    g.kk = this.LZ(g.k);
    g.a = 11 < h ? "pm" : "am";
    g.A = 11 < h ? "PM" : "AM";
    g.m = l;
    g.mm = this.LZ(l);
    g.s = p;
    for (g.ss = this.LZ(p); c < a.length;) {
        d = a.charAt(c);
        for (e = ""; a.charAt(c) == d && c < a.length;) e += a.charAt(c++);
        b = null != g[e] ? b + g[e] : b + e
    }
    return b
};
DateTimeObj.prototype.formatDateAbsolute = function(a) {
    a += "";
    var b = "",
        c = 0,
        d = "",
        e = "",
        d = this.GetFullYear() + "",
        e = this.GetMonth() + 1,
        f = this.GetDate(),
        k = this.GetDay(),
        h = this.GetHours(),
        l = this.GetMinutes(),
        p = this.GetSeconds(),
        g = {};
    4 > d.length && (d = "" + (d - 0 + 1900));
    g.y = "" + d;
    g.yyyy = d;
    g.yy = d.substring(2, 4);
    g.M = e;
    g.MM = this.LZ(e);
    g.MMM = this.MONTH_NAMES[e - 1];
    g.NNN = this.MONTH_NAMES[e + 11];
    g.d = f;
    g.dd = this.LZ(f);
    g.E = this.DAY_NAMES[k + 7];
    g.EE = this.DAY_NAMES[k];
    g.H = h;
    g.HH = this.LZ(h);
    g.h = 0 == h ? 12 : 12 < h ? h - 12 : h;
    g.hh = this.LZ(g.h);
    g.K = 11 < h ? h - 12 : h;
    g.k = h + 1;
    g.KK = this.LZ(g.K);
    g.kk = this.LZ(g.k);
    g.a = 11 < h ? "pm" : "am";
    g.m = l;
    g.mm = this.LZ(l);
    g.s = p;
    for (g.ss = this.LZ(p); c < a.length;) {
        d = a.charAt(c);
        for (e = ""; a.charAt(c) == d && c < a.length;) e += a.charAt(c++);
        b = null != g[e] ? b + g[e] : b + e
    }
    return b
};
DateTimeObj.prototype.GetWeekNum = function(a) {
    this.GetDayForShow();
    a = (7 - a + this.GetDayForShow()) % 7;
    var b = new Date(this.GetYearForShow(), this.GetMonthForShow(), this.GetDateForShow()),
        b = new Date(this.GetYearForShow(), this.GetMonthForShow(), this.GetDateForShow()),
        b = b.setDate(b.getDate() - a);
    a = new Date(this.GetFullYear(), 0, 1);
    a = Math.ceil(((b - a) / 864E5 + a.getDay()) / 7);
    53 == a && (a = 1);
    return a
};

function _isInteger(a) {
    for (var b = 0; b < a.length; b++)
        if (-1 == "1234567890".indexOf(a.charAt(b))) return !1;
    return !0
}

function _getInt(a, b, c, d) {
    for (; d >= c; d--) {
        var e = a.substring(b, b + d);
        if (e.length < c) break;
        if (_isInteger(e)) return e
    }
    return null
}

function getDateFromFormat(a, b) {
    a += "";
    b += "";
    for (var c = 0, d = 0, e = "", f = "", k, h, l = new Date, p = l.getFullYear(), g = l.getMonth() + 1, q = 1, n = l.getHours(), r = l.getMinutes(), l = l.getSeconds(), s = ""; d < b.length;) {
        e = b.charAt(d);
        for (f = ""; b.charAt(d) == e && d < b.length;) f += b.charAt(d++);
        if ("yyyy" == f || "yy" == f || "y" == f) {
            "yyyy" == f && (h = k = 4);
            "yy" == f && (h = k = 2);
            "y" == f && (k = 2, h = 4);
            p = _getInt(a, c, k, h);
            if (null == p) return 0;
            c += p.length;
            2 == p.length && (p = 70 < p ? 1900 + (p - 0) : 2E3 + (p - 0))
        } else if ("MMM" == f || "NNN" == f) {
            for (e = g = 0; e < DateTimeObj.prototype.MONTH_NAMES.length; e++) {
                var t =
                    DateTimeObj.prototype.MONTH_NAMES[e];
                if (a.substring(c, c + t.length).toLowerCase() == t.toLowerCase() && ("MMM" == f || "NNN" == f && 11 < e)) {
                    g = e + 1;
                    12 < g && (g -= 12);
                    c += t.length;
                    break
                }
            }
            if (1 > g || 12 < g) return 0
        } else if ("EE" == f || "E" == f)
            for (e = 0; e < DAY_NAMES.length; e++) {
                if (f = DAY_NAMES[e], a.substring(c, c + f.length).toLowerCase() == f.toLowerCase()) {
                    c += f.length;
                    break
                }
            } else if ("MM" == f || "M" == f) {
                g = _getInt(a, c, f.length, 2);
                if (null == g || 1 > g || 12 < g) return 0;
                c += g.length
            } else if ("dd" == f || "d" == f) {
            q = _getInt(a, c, f.length, 2);
            if (null == q || 1 > q || 31 <
                q) return 0;
            c += q.length
        } else if ("hh" == f || "h" == f) {
            n = _getInt(a, c, f.length, 2);
            if (null == n || 1 > n || 12 < n) return 0;
            c += n.length
        } else if ("HH" == f || "H" == f) {
            n = _getInt(a, c, f.length, 2);
            if (null == n || 0 > n || 23 < n) return 0;
            c += n.length
        } else if ("KK" == f || "K" == f) {
            n = _getInt(a, c, f.length, 2);
            if (null == n || 0 > n || 11 < n) return 0;
            c += n.length
        } else if ("kk" == f || "k" == f) {
            n = _getInt(a, c, f.length, 2);
            if (null == n || 1 > n || 24 < n) return 0;
            c += n.length;
            n--
        } else if ("mm" == f || "m" == f) {
            r = _getInt(a, c, f.length, 2);
            if (null == r || 0 > r || 59 < r) return 0;
            c += r.length
        } else if ("ss" ==
            f || "s" == f) {
            l = _getInt(a, c, f.length, 2);
            if (null == l || 0 > l || 59 < l) return 0;
            c += l.length
        } else if ("a" == f) {
            if ("am" == a.substring(c, c + 2).toLowerCase()) s = "am";
            else if ("pm" == a.substring(c, c + 2).toLowerCase()) s = "pm";
            else return 0;
            c += 2
        } else {
            if (a.substring(c, c + f.length) != f) return 0;
            c += f.length
        }
    }
    if (c != a.length) return 0;
    if (2 == g)
        if (0 == p % 4 && 0 != p % 100 || 0 == p % 400) {
            if (29 < q) return 0
        } else if (28 < q) return 0;
    if ((4 == g || 6 == g || 9 == g || 11 == g) && 30 < q) return 0;
    12 > n && "pm" == s ? n = n - 0 + 12 : 11 < n && "am" == s && (n -= 12);
    return (new Date(p, g - 1, q, n, r, l)).getTime()
}

function CalcWeekFromDate(a, b) {
    return b.GetWeekNum(currUserData.userStartWeekDay)
}

function LastDayOfMonth(a, b) {
    return (new Date(new Date(a, b + 1, 1) - 1)).getDate()
}

function sortByMiliSec(a, b) {
    var c = a.innerMiliSecs,
        d = b.innerMiliSecs;
    return c < d ? -1 : c > d ? 1 : 0
}

function IsTimeliesinDst(a) {
    var b = a.innerMiliSecs;
    if (null != a.timeZoneObj.dayLightSavings)
        for (var c = a.timeZoneObj.dayLightSavings.length, d = 0; d < c; d++)
            if (a.timeZoneObj.dayLightSavings[d].startTimeMili <= b && a.timeZoneObj.dayLightSavings[d].endTimeMili >= b) return "&nbsp;[DST]";
    return "&nbsp;"
}

function Getoffsetoutoftimezone(a) {
    var b = a.innerMiliSecs;
    if (null != a.timeZoneObj.dayLightSavings)
        for (var c = a.timeZoneObj.dayLightSavings.length, d = 0; d < c; d++)
            if (a.timeZoneObj.dayLightSavings[d].startTimeMili <= b && a.timeZoneObj.dayLightSavings[d].endTimeMili >= b) return a.timeZoneObj.dayLightSavings[d].offset
}

function GetGmtPlusDst(a) {
    var b = a.innerMiliSecs;
    if (null != a.timeZoneObj.dayLightSavings)
        for (var c = a.timeZoneObj.dayLightSavings.length, d = 0; d < c; d++)
            if (a.timeZoneObj.dayLightSavings[d].startTimeMili <= b && a.timeZoneObj.dayLightSavings[d].endTimeMili >= b) return "&nbsp;(GMT" + (0 == a.timeZoneObj.dayLightSavings[d].offset ? "&nbsp" + a.timeZoneObj.dayLightSavings[d].offset : 0 < a.timeZoneObj.dayLightSavings[d].offset ? "+" + a.timeZoneObj.dayLightSavings[d].offset : a.timeZoneObj.dayLightSavings[d].offset) + ")&nbsp;[DST]";
    return "&nbsp;(GMT" + (0 == a.timeZoneObj.timeZone ? "&nbsp" + a.timeZoneObj.timeZone : 0 < a.timeZoneObj.timeZone ? "+" + a.timeZoneObj.timeZone : a.timeZoneObj.timeZone) + ")"
}

function IsDst(a) {
    var b = a.innerMiliSecs;
    if (null != a.timeZoneObj.dayLightSavings)
        for (var c = a.timeZoneObj.dayLightSavings.length, d = 0; d < c; d++)
            if (a.timeZoneObj.dayLightSavings[d].startTimeMili <= b && a.timeZoneObj.dayLightSavings[d].endTimeMili >= b) return !0;
    return !1
};

function WeeklyAvailDayExceptionObj(a, b) {
    this.date = a;
    this.times = b;
    this.dateTimeObj = null
}

function sortByDateTime(a, b) {
    var c = a.date,
        d = b.date;
    return c < d ? -1 : c > d ? 1 : 0
}

function SortWeeklyAvailDayExceptionArray(a) {
    a.sort(sortByDateTime);
    return a
};

function Wizard() {
    this.needToConfirmExit = !1;
    window.onbeforeunload = confirmExit
}
Wizard.prototype.needToConfirm = function() {
    this.needToConfirmExit = !0
};
Wizard.prototype.dontNeedToConfirm = function() {
    this.needToConfirmExit = !1
};
Wizard.prototype.setInputConfirmation = function() {
    for (var a = document.getElementsByTagName("input"), b = 0; b < a.length; b++) "text" == a[b].type && null == a[b].onchange && a[b].setAttribute("onchange", "wizard.needToConfirm()"), "radio" == a[b].type && null == a[b].onclick && a[b].setAttribute("onclick", "wizard.needToConfirm()");
    a = document.getElementsByTagName("select");
    for (b = 0; b < a.length; b++) null == a[b].onclick ? a[b].setAttribute("onclick", "wizard.needToConfirm()") : null == a[b].onchange && a[b].setAttribute("onchange", "wizard.needToConfirm()");
    a = document.getElementsByTagName("textarea");
    for (b = 0; b < a.length; b++) null == a[b].onchange && a[b].setAttribute("onchange", "wizard.needToConfirm()");
    try {
        var c = document.getElementById("additionalUsers");
        null != userProfileObj && userProfileObj.onTrial() && null != c && wizard.needToConfirm()
    } catch (d) {}
};
Wizard.prototype.ShowAlert = function() {
    return this.needToConfirmExit
};
var wizard = new Wizard;

function confirmExit() {
    if (wizard.ShowAlert()) return HideLoading(), "function" == typeof SendSupportEmail && performDeletion(!0), "undefined" !== typeof InfusionPage ? "You have not completed the connector setup wizard.\n\nYour settings have not been saved." : "Your changes have not been saved."
};