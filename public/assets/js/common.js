var YYUI = {},
    $body = null;
(function ($, YYUI) {
    "use strict";

    YYUI.common = (function () {
        function init() {
            $body = $("body");
        }

        return {
            init : init
        }
    })();

    /**
     * @TODO 数字格式化
     * @param s
     * @param n
     * @returns {string}
     */
    YYUI.numberFormat = function (s, n) {
        n = n > 0 && n <= 20 ? n : 2;
        s = parseFloat((s + "").replace(/[^\d\.-]/g, "")).toFixed(n) + "";
        var l = s.split(".")[0].split("").reverse(),
            r = s.split(".")[1];
        var t = "";
        for (var i = 0; i < l.length; i++)
        {
            t += l[i] + ((i + 1) % 3 === 0 && (i + 1) !== l.length ? "," : "");
        }
        return t.split("").reverse().join("") + "." + r;
    };

    /**
     * @TODO 检测手机号码格式是否正确
     * @param mobile
     * @returns {*|boolean}
     */
    YYUI.isMobile = function (mobile) {
        return /^(13[0-9]|14[0-9]|15[0-9]|18[0-9]|17[0-9])\d{8}$/.test(mobile);
    };

    /**
     * @TODO 验证邮箱格式是否正确
     * @param email
     * @returns {boolean}
     */
    YYUI.isEmail = function (email) {
        return /^(\w-*\.*)+@(\w-?)+(\.\w{2,})+$/.test(email);
    };

    /**
     * @TODO Cookie管理
     * @type {{set: set, get: get, del: del}}
     */
    YYUI.Cookie = {
        set : function (name, value) {
            var Days = 1000;
            var exp = new Date();
            exp.setTime(exp.getTime() + Days * 24 * 60 * 60 * 1000);
            document.cookie = name + "=" + escape(value) + ";expires=" + exp.toGMTString() + ";domain=" + document.domain + ";path=/";
        },

        get : function (name) {
            var arr = document.cookie.match(new RegExp("(^| )" + name + "=([^;]*)(;|$)"));
            if (arr !== null) {
                return unescape(arr[2]);
            }
            return null;
        },

        del : function (name) {
            var exp = new Date();
            exp.setTime(exp.getTime() - 1);
            var cval = this.getCookie(name);
            if (cval !== null) {
                document.cookie = name + "=" + cval + ";expires=" + exp.toGMTString() + ";domain=" + document.domain + ";path=/";
            }
        }
    };

    /**
     * @TODO get query string
     * @param name
     * @returns {any}
     */
    YYUI.getQueryString = function(name) {
        var url = window.location.search;
        var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
        var result = url.substr(1).match(reg);
        return result ? decodeURIComponent(result[2]) : null;
    };

    $(document).ready(function () {
        YYUI.common.init();
    });
}(jQuery, window.YYUI || {}));