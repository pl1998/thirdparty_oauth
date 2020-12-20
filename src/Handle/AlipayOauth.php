<?php

/*
 * This file is part of the pl1998/thirdparty_oauth.
 *
 * (c) pl1998<pltruenine@163.com>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace Pl1998\ThirdpartyOauth\Handle;

use GuzzleHttp\Client;

class AlipayOauth implements Handle
{
    protected $client;
    protected $config;

    public function __construct($config)
    {
        $this->charset = 'utf-8';
        $this->config  = $config;
        $this->client  = new Client();
    }

    public function authorization()
    {
        $uuid = uniqid('', true);
        $url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';
        $query = array_filter([
            'app_id'       => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'scope'        => 'auth_user',
            'state'        => urlencode('https://6.mxin.ltd/login/alipay?uuid=' . $uuid),
        ]);


        $url = $url . '?' . http_build_query($query);

        if ($this->is_mobile()) {


            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->set($uuid, "0");

            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <meta charset="utf-8">
                <title>支付宝</title>
                <meta name="description" content="hello site">
                <meta name="keywords" content="site">
                <meta name="apple-mobile-web-app-capable" content="yes"/>
                <meta name="apple-mobile-web-app-status-bar-style" content="black"/>
                <meta name="format-detection" content="telephone=no"/>
                <meta name="format-detection" content="email=no"/>
                <meta name="data-aspm" content="a1179"/>
                <link rel="canonical" href="https://www.alipay.com/">
                <meta name="keywords" content="支付宝,电子支付/网上支付/安全支付/手机支付,安全购物/网络购物付款/付款/收款,水电煤缴费/信用卡还款/AA收款,支付宝网站">
                <meta name="description"
                      content="支付宝，全球领先的独立第三方支付平台，致力于为广大用户提供安全快速的电子支付/网上支付/安全支付/手机支付体验，及转账收款/水电煤缴费/信用卡还款/AA收款等生活服务应用。">
                <meta name="viewport"
                      content="width=device-width,initial-scale=0.5,maximum-scale=0.5,minimum-scale=0.5,user-scalable=no">
                <script>!function (e) {
                        function t(n) {
                            if (i[n]) return i[n].exports;
                            var r = i[n] = {exports: {}, id: n, loaded: !1};
                            return e[n].call(r.exports, r, r.exports, t), r.loaded = !0, r.exports
                        }

                        var i = {};
                        return t.m = e, t.c = i, t.p = "", t(0)
                    }([function (e, t) {
                        "use strict";
                        Object.defineProperty(t, "__esModule", {value: !0});
                        var i = window;
                        t["default"] = i.vl = function (e, t) {
                            var n = e || 100, r = t || 750, a = i.document, d = navigator.userAgent,
                                o = d.match(/Android[\S\s]+AppleWebkit\/(\d{3})/i), l = d.match(/U3\/((\d+|\.){5,})/i),
                                s = l && parseInt(l[1].split(".").join(""), 10) >= 80, u = a.documentElement, c = 1;
                            if (o && o[1] > 534 || s) {
                                u.style.fontSize = n + "px";
                                var p = a.createElement("div");
                                p.setAttribute("style", "width: 1rem;display:none"), u.appendChild(p);
                                var m = i.getComputedStyle(p).width;
                                if (u.removeChild(p), m !== u.style.fontSize) {
                                    var v = parseInt(m, 10);
                                    c = 100 / v
                                }
                            }
                            var f = a.querySelector('meta[name="viewport"]');
                            f || (f = a.createElement("meta"), f.setAttribute("name", "viewport"), a.head.appendChild(f)), f.setAttribute("content", "width=device-width,user-scalable=no,initial-scale=1,maximum-scale=1,minimum-scale=1");
                            var h = function () {
                                u.style.fontSize = n / r * u.clientWidth * c + "px"
                            };
                            h(), i.addEventListener("resize", h)
                        }, e.exports = t["default"]
                    }]);
                    vl(100, 750);</script>
                <script>
                    window._to = {autoStart: false};
                </script>
                <script src="--https://a.alipayobjects.com/g/animajs/mtracker/3.1.0/seed.js"></script>
                <script src="https://a.alipayobjects.com/amui/zepto/1.1.3/zepto.js"></script>
                <!-- spm埋点 @予凝 -->
                <script>!function (modules) {
                        function __webpack_require__(moduleId) {
                            if (installedModules[moduleId]) return installedModules[moduleId].exports;
                            var module = installedModules[moduleId] = {exports: {}, id: moduleId, loaded: !1};
                            return modules[moduleId].call(module.exports, module, module.exports, __webpack_require__), module.loaded = !0, module.exports
                        }

                        var installedModules = {};
                        return __webpack_require__.m = modules, __webpack_require__.c = installedModules, __webpack_require__.p = "", __webpack_require__(0)
                    }([function (module, exports) {
                        "use strict";
                        !function () {
                            if (!window.Tracert) {
                                for (var Tracert = {
                                    _isInit: !0, _readyToRun: [], _guid: function () {
                                        return "xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx".replace(/[xy]/g, function (c) {
                                            var r = 16 * Math.random() | 0, v = "x" === c ? r : 3 & r | 8;
                                            return v.toString(16)
                                        })
                                    }, get: function (key) {
                                        if ("pageId" === key) {
                                            if (window._tracert_loader_cfg = window._tracert_loader_cfg || {}, window._tracert_loader_cfg.pageId) return window._tracert_loader_cfg.pageId;
                                            var metaa = document.querySelectorAll("meta[name=data-aspm]"),
                                                spma = metaa && metaa[0].getAttribute("content"),
                                                spmb = document.body && document.body.getAttribute("data-aspm"),
                                                pageId = spma && spmb ? spma + "." + spmb + "_" + Tracert._guid() + "_" + Date.now() : "-_" + Tracert._guid() + "_" + Date.now();
                                            return window._tracert_loader_cfg.pageId = pageId, pageId
                                        }
                                        return this[key]
                                    }, call: function () {
                                        var argsList, args = arguments;
                                        try {
                                            argsList = [].slice.call(args, 0)
                                        } catch (ex) {
                                            var argsLen = args.length;
                                            argsList = [];
                                            for (var i = 0; i < argsLen; i++) argsList.push(args[i])
                                        }
                                        Tracert.addToRun(function () {
                                            Tracert.call.apply(Tracert, argsList)
                                        })
                                    }, addToRun: function (_fn) {
                                        var fn = _fn;
                                        "function" == typeof fn && (fn._logTimer = new Date - 0, Tracert._readyToRun.push(fn))
                                    }
                                }, fnlist = ["config", "logPv", "info", "err", "click", "expo", "pageName", "pageState", "time", "timeEnd", "parse", "checkExpo", "stringify", "report", "set", "before"], i = 0; i < fnlist.length; i++) {
                                    var fn = fnlist[i];
                                    !function (fn) {
                                        Tracert[fn] = function () {
                                            var argsList, args = arguments;
                                            try {
                                                argsList = [].slice.call(args, 0)
                                            } catch (ex) {
                                                var argsLen = args.length;
                                                argsList = [];
                                                for (var i = 0; i < argsLen; i++) argsList.push(args[i])
                                            }
                                            argsList.unshift(fn), Tracert.addToRun(function () {
                                                Tracert.call.apply(Tracert, argsList)
                                            })
                                        }
                                    }(fn)
                                }
                                window.Tracert = Tracert
                            }
                        }()
                    }]);</script>
                <script src="https://gw.alipayobjects.com/as/g/component/tracert/3.0.7/index.js"></script>
                <link rel="stylesheet" href="https://gw.alipayobjects.com/os/s/prod/i/index-815c8.css"/>
            </head>
            <body data-aspm="b10195">


            <div class="actions">
                <a class="downloads" style="display:block" href="alipays://platformapi/startapp?appId=20000067&url=<?php
                echo urlencode('https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=2019031363525423&scope=auth_user&state=' . urlencode(urlencode('https://6.mxin.ltd/login/alipay?uuid=' . $uuid)) . '&redirect_uri=https%3A%2F%2Fcoding.mxin.ltd%2F'); ?> ">打开支付宝</a>
                <a class="download">下载支付宝</a>
                <p class="tip">QQ浏览器不支持打开支付宝<br>请使用其他浏览器</p>
            </div>

            <div class="footer">
                <div class="links">
                    <a href="https://render.alipay.com/p/f/fd-iztoosq3/index.html">收费规则
                    </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="https://render.alipay.com/p/c/k2cx0tg8">隐私政策
                    </a>&nbsp;&nbsp;|&nbsp;&nbsp;<a
                            href="https://cshall.alipay.com/lab/help_detail.htm?help_id=201602386999">服务协议更新</a>
                </div>
                <p class="copyright">网站备案：沪ICP备15027489号</p>
            </div>

            <div class="wrap">
                <div class="load">
                    <img src="data:image/png;base64,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"
                         id="load_log" class="load_log">
                    <img src="data:image/png;base64,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"
                         class="load_circle">
                </div>
                <div class="text">加载中</div>
            </div>
            <!-- <div class="loading">
              <div class='c c1'></div>
              <div class='c c2'></div>
              <div class='c c3'></div>
              <div class='c c4'></div>
              <div class='c c5'></div>
              <div class='c c6'></div>
              <div class='c c7'></div>
              <div class='c c8'></div>
              <div class='c c9'></div>
              <div class='c c10'></div>
              <div class='c c11'></div>
              <div class='c c12'></div>
            </div> -->

            <input type="hidden" id="domainList"
                   value=".alipay.com|.alipay.cn|.alipay.net|.alipay.com.cn|.alipay.hk|.alipayplus.com|.alipay-eco.com|.alipay-cloud.com|.ant-financial.com|.ant-open.com|.ant-biz.com|.antfortune.com|.antgroup.com|.antfin.com|.ebuckler.com|.mayiyunbao.com|.fund123.com|.sinopayment.com.cn|.alipay-inc.com|.aliyun.com|.taobao.com|.taobao.cn|.taobao.net|.taobao.com.cn|.taobao.hk|.alibaba.com|.alibaba.cn|.alibaba.net|.alibaba.com.cn|.alibaba-inc.com|.alibaba-inc.cn|.alibaba-inc.net|.alibaba-inc.com.cn|.aliloan.com|.aliloan.cn|.aliloan.net|.aliloan.com.cn|.koubei.com|.koubei.cn|.koubei.net|.koubei.com.cn|.alimama.com|.alimama.cn|.alimama.com.cn|.1688.com|.1688.cn|.1688.com.cn|.alibado.com|.alibado.cn|.alibado.com.cn|.alisoft.com|.alisoft.cn|.alisoft.com.cn|.yahoo.cn|.yahoo.com.cn|.zhifubao.com|.zhifu.com|.aliexpress.com|.atpanel.com|.taobaocdn.com|.taojianghu.com|.taojapan.com|.hitao.com|.taohua.com|.tao123.com|.tmall.com|.tmall.net|.tmall.hk|.etao.com|.alitrip.com|.ban-ma.cn|.tmshare123.com|.tbshare123.com|.xiami.com|.dongting.com|.taobao.org|.koubei.org|.aliimg.com|.aliimg.net|.alibank.net|.mayibank.net|.mybank.cn|.alipaydev.com|.alipayobjects.com|.tbcdn.cn|.zhimaxy.net|.zmxy.com.cn|.zhimaxy.com.cn|.antsdaq.net|.antsdaq.com|.aliyuncs.com|.aliyun-inc.com|.alicdn.com|.aliyun.test|.uc.cn|.ucweb.com|.uodoo.com|.9gametest.local|.25pp.com|.pp.cn|.wandoujia.com|.9game.cn|.rantu.com|.rantutu.com|.aligames.com|.jiaoyimao.com|.sm.cn|.shuqiapi.com|.shuqireader.com|.shuqi.com|.ucweb.local|.tebon.com.cn|.dingtalk.com|.yunos.com|.alitrip.com|.taopiaopiao.com|.taopiaopiao.cn|.alibabaplanet.com|.fliggy.com|.feizhu.com|.feizhu.cn|.mei.com|.liangxinyao.com|.lazada.sg|.lazada.co.id|.lazada.com.my|.lazada.com.ph|.lazada.vn|.lazada.co.th|.amap.com|.youku.com|.cainiao.com|.qufenqi.cn|.zhongan.com.cn|.easyhin.com.cn|.easyhin.cn|.antfinancial-corp.com|.antfinancial-corp.cn|.alipay-corp.com|.anijue.com|.yupaopao.cn|.shixiseng.com|.blibao.com|.koubei.com|.guahao.com|.10661911.com|.jss.com.cn|.michaelkors.cn|.bangbangda.cn|.alipaydev.com|.samhotele.com|.ele.me|.51dh.com.cn|.yy365.cn|.yiyao365.cn|.romens.cn|.gl365.cn|.uniqlo.cn|.jujienet.com|.szyibei.com|.huaat.com|.91160.com|.yunfengdie.cn|.bangdao-tech.com|.play.hahaipi.com|.pay.hahaipi.com|.monstar-lab.com.cn|.alipayetc.trawe.cn|render.laifeng.com|jslife.com.cn|si.way51.com|ali-life-service.feiniu.com|ali-life-au-service.feiniu.com|www.e91job.com|s.taopiaopiao.cn|m.bysjy.com.cn|touch.10086.cn|appmail.mail.10086.cn|html5.mail.10086.cn|lqdj.smartfengze.com|ye921091578.oicp.net|wap.lotsmall.cn|kaola.com|consumer.sunny-mall.com:5443|qr.95516.com|ibsbjstar.ccb.com.cn|">

            <input type="hidden" id="urlList"
                   value="https://www.sobot.com/chat/h5/index.html?sysNum=95f145b6c90c48a19783af9d0f6a0f44|">

            <input type="hidden" id="greyProgress" value="100">

            <input type="hidden" id="flexibleSwich" value="">


            <!-- 来源 issues/36 -->
            <script src="--https://gw.alipayobjects.com/os/rmsportal/WpGrtMXlamAjMGBnDmvF.js"></script>
            <script src="--https://gw.alipayobjects.com/os/??s/prod/i/common-bf748.js,s/prod/i/index-3bb6a.js"></script>
            <script>!
                    function (e) {
                        function t(n) {
                            if (a[n]) return a[n].exports;
                            var r = a[n] = {
                                exports: {},
                                id: n,
                                loaded: !1
                            };
                            return e[n].call(r.exports, r, r.exports, t),
                                r.loaded = !0,
                                r.exports
                        }

                        var n = window.webpackJsonp;
                        window.webpackJsonp = function (c, o) {
                            for (var i, p, s = 0,
                                     f = []; s < c.length; s++) p = c[s],
                            r[p] && f.push.apply(f, r[p]),
                                r[p] = 0;
                            for (i in o) if (Object.prototype.hasOwnProperty.call(o, i)) {
                                var l = o[i];
                                switch (typeof l) {
                                    case "object":
                                        e[i] = function (t) {
                                            var n = t.slice(1),
                                                a = t[0];
                                            return function (t, r, c) {
                                                e[a].apply(this, [t, r, c].concat(n))
                                            }
                                        }(l);
                                        break;
                                    case "function":
                                        e[i] = l;
                                        break;
                                    default:
                                        e[i] = e[l]
                                }
                            }
                            for (n && n(c, o); f.length;) f.shift().call(null, t);
                            if (o[0]) return a[0] = 0,
                                t(0)
                        };
                        var a = {},
                            r = {
                                0: 0
                            };
                        t.e = function (e, n) {
                            if (0 === r[e]) return n.call(null, t);
                            if (void 0 !== r[e]) r[e].push(n);
                            else {
                                r[e] = [n];
                                var a = document.getElementsByTagName("head")[0],
                                    c = document.createElement("script");
                                c.type = "text/javascript",
                                    c.charset = "utf-8",
                                    c.async = !0,
                                    c.src = t.p + "" + ({
                                        1: "index"
                                    } [e] || e) + "-" + {
                                        1: "51afdbaf7de78a4752c6"
                                    } [e] + ".js",
                                    a.appendChild(c)
                            }
                        },
                            t.m = e,
                            t.c = a,
                            t.p = ""
                    }(function (e) {
                        for (var t in e) if (Object.prototype.hasOwnProperty.call(e, t)) switch (typeof e[t]) {
                            case "function":
                                break;
                            case "object":
                                e[t] = function (t) {
                                    var n = t.slice(1),
                                        a = e[t[0]];
                                    return function (e, t, r) {
                                        a.apply(this, [e, t, r].concat(n))
                                    }
                                }(e[t]);
                                break;
                            default:
                                e[t] = e[e[t]]
                        }
                        return e
                    }([]));
                webpackJsonp([1, 0], [function (e, t, o) {
                    "use strict";

                    function n(e) {
                        return e && e.__esModule ? e : {
                            default:
                            e
                        }
                    }

                    var a = Object.assign ||
                        function (e) {
                            for (var t = 1; t < arguments.length; t++) {
                                var o = arguments[t];
                                for (var n in o) Object.prototype.hasOwnProperty.call(o, n) && (e[n] = o[n])
                            }
                            return e
                        },
                        r = o(1),
                        i = n(r),
                        l = o(2),
                        u = n(l),
                        d = o(17),
                        s = n(d),
                        c = o(10),
                        f = n(c);
                    o(19);
                    var p = o(3),
                        g = window.Zepto,
                        h = !1,
                        m = null;
                    console.log(p);
                    var w = function () {
                            window.Tracker && (window.Tracker.mPageState = s.default.getHash("from")),
                            window.Tracker && window.Tracker.start(),
                                window.onerror = function (e) {
                                    u.default.log("jsError:JS\u9519\u8bef", {
                                        msg: JSON.stringify(e)
                                    }),
                                        console.log("ERROR :", JSON.stringify(e), e && e.originalEvent && e.originalEvent.error)
                                }
                        },
                        v = function () {
                            if (h) return void i.default.log("alreadyOpen");
                            if (S) {
                                i.default.log("\u652f\u4ed8\u5b9d\u5185"),
                                    u.default.log("isInAlipay:\u652f\u4ed8\u5b9d\u5185", {
                                        url: location.href
                                    }),
                                    document.addEventListener("pageResume",
                                        function () {
                                            setTimeout(function () {
                                                    window.AlipayJSBridge && AlipayJSBridge.call("closeWebview")
                                                },
                                                1e3)
                                        },
                                        !1);
                                var e = s.default.getAllParams(O),
                                    t = (e.appId || e.saId || "").replace(/\s+/, "");
                                i.default.log("appId", t),
                                    i.default.log("\u53c2\u6570", e),
                                    t ? u.default.onJSBridgeReady(function () {
                                        if (u.default.log("jsapiReady"), i.default.log("jsapi ready"), s.default.canRunNewCode()) {
                                            u.default.log("canRunNewCode");
                                            var o = "20000067" === t ? {
                                                    appClearTop: !1,
                                                    startMultApp: "YES"
                                                } : {},
                                                n = s.default.getAllParams(O),
                                                r = AlipayJSBridge.startupParams || {},
                                                l = {
                                                    appId: t,
                                                    param: a({},
                                                        o, n, {
                                                            fromLanding: !0,
                                                            appStartUpType: r.app_startup_type,
                                                            refferId: r.ap_framework_sceneId || "landing"
                                                        })
                                                };
                                            s.default.getSceneStackInfo(function (o) {
                                                if (o && 0 === o.currentIndex) {
                                                    u.default.log("currentIndex0");
                                                    var n = !u.default.isNewVersion(null, "10.1.22") && "10000007" === t && !!e.qrcode && u.default.browser.ios;
                                                    n || (l.closeCurrentApp = !0)
                                                } else u.default.log("sceneStackCurrentIndexOther");
                                                i.default.log("final", l),
                                                    setTimeout(function () {
                                                            window.Tracert.click("c24334.d45356"),
                                                                AlipayJSBridge.call("startApp", l)
                                                        },
                                                        600)
                                            })
                                        } else u.default.log("schemeOld:\u7070\u5ea6\u524d"),
                                            i.default.log("scheme old", O),
                                            setTimeout(function () {
                                                    window.Tracert.click("c24334.d45356"),
                                                        p.gotoPage(O, k)
                                                },
                                                600)
                                    }) : (u.default.log("urlOpen:url\u65b9\u5f0f\u6253\u5f00"), i.default.log("url open", O), setTimeout(function () {
                                            window.Tracert.click("c24334.d45356"),
                                                location.replace(O)
                                        },
                                        600))
                            } else {
                                i.default.log("\u652f\u4ed8\u5b9d\u5916"),
                                    u.default.log("isOutAlipay:\u652f\u4ed8\u5b9d\u5916", {
                                        url: location.href
                                    });
                                var o = s.default.getAllParams(O),
                                    n = (o.appId || o.saId || "").replace(/\s+/, "");
                                i.default.log("appId", n),
                                    i.default.log("\u53c2\u6570", o),
                                    g(".open").on("click",
                                        function () {
                                            window.Tracert.click("c24334.d48852"),
                                                u.default.log("openButtonClick:\u6253\u5f00\u652f\u4ed8\u5b9d\u6309\u94ae\u70b9\u51fb"),
                                                p.gotoPage(O, k)
                                        }),
                                    window.Tracert.click("c24334.d45356"),
                                    p.gotoPage(O, k)
                            }
                            h = !0
                        },
                        b = function () {
                            var e = {
                                "^zh-(hk|tw)$": {
                                    open: "\u6253\u958b\u652f\u4ed8\u5bf6",
                                    download: "\u4e0b\u8f09\u652f\u4ed8\u5bf6",
                                    tip: "QQ\u700f\u89bd\u5668\u4e0d\u652f\u6301\u6253\u958b\u652f\u4ed8\u5bf6<br>\u8acb\u4f7f\u7528\u5176\u4ed6\u700f\u89bd\u5668"
                                },
                                "^en-": {
                                    open: "Open Alipay",
                                    download: "Download Alipay",
                                    tip: "QQ\u6d4f\u89c8\u5668\u4e0d\u652f\u6301\u6253\u5f00\u652f\u4ed8\u5b9d<br>\u8bf7\u4f7f\u7528\u5176\u4ed6\u6d4f\u89c8\u5668"
                                }
                            };
                            i.default.log("navigator.language", navigator.language);
                            var t = urlParams.language || "zh-CN";
                            i.default.log("langParam", t);
                            for (var o = 0; o < Object.keys(e).length; o++) {
                                var n = new RegExp(Object.keys(e)[o], "i");
                                if (n.test(t) || n.test(navigator.language)) {
                                    var a = e[Object.keys(e)[o]];
                                    g(".open")[0].innerText = a.open,
                                        g(".download")[0].innerText = a.download,
                                        g(".tip")[0].innerHTML = a.tip;
                                    break
                                }
                            }
                            document.body.className = S ? "inside" : "outside",
                                "zh-CN" !== t || "zh-cn" !== navigator.language.toLowerCase() ? g(".footer").hide() : (g(".footer").show(), y(), window.addEventListener("orientationchange", y, !1))
                        },
                        y = function () {
                            null === m && (m = !0, setInterval(function () {
                                    try {
                                        var e = 0,
                                            t = 0,
                                            o = g(".actions").offset();
                                        o && (e = o.top + o.height);
                                        var n = g(".footer").offset();
                                        n && (t = n.top);
                                        var a = e > t || t - e > 200;
                                        a && (g(".footer").css({
                                            bottom: "initial"
                                        }), g(".footer").css({
                                            top: e + 10 + "px"
                                        }))
                                    } catch (e) {
                                    }
                                },
                                200))
                        },
                        x = function () {
                            return i.default.log("ua", _),
                                i.default.log("scheme", O),
                                b(),
                                (0, f.default)() ? void v() : void i.default.log("flow hang up")
                        },
                        _ = window.navigator.userAgent,
                        S = /AlipayClient/.test(_) && !/KoubeiClient/.test(_),
                        k = "com.eg.android.AlipayGphone",
                        P = s.default.getScheme(location.href),
                        O = P.scheme;
                    w(),
                        x()
                },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = n(a),
                            i = o(16);
                        n(i);
                        o(18);
                        var l = {},
                            u = (Zepto, "true" === r.default.getHash("alidebug"));
                        l.log = function () {
                            var e;
                            u && (e = console).log.apply(e, arguments)
                        },
                            window.debug = l,
                            t.default = l,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?
                            function (e) {
                                return typeof e
                            } : function (e) {
                                return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                            },
                            r = o(1),
                            i = n(r),
                            l = {};
                        l.getHash = function (e) {
                            var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)"),
                                o = window.location.search.substr(1).match(t);
                            return null !== o ? decodeURIComponent(o[2]) : null
                        },
                            l.dateFormat = function (e, t) {
                                e = e ? parseInt(e) : (new Date).getTime(),
                                    t = t || "yyyy-MM-dd hh:mm:ss";
                                var o = new Date(e),
                                    n = {
                                        "M+": o.getMonth() + 1,
                                        "d+": o.getDate(),
                                        "h+": o.getHours(),
                                        "m+": o.getMinutes(),
                                        "s+": o.getSeconds(),
                                        "q+": Math.floor((o.getMonth() + 3) / 3),
                                        S: o.getMilliseconds()
                                    };
                                /(y+)/.test(t) && (t = t.replace(RegExp.$1, (o.getFullYear() + "").substr(4 - RegExp.$1.length)));
                                for (var a in n) new RegExp("(" + a + ")").test(t) && (t = t.replace(RegExp.$1, 1 === RegExp.$1.length ? n[a] : ("00" + n[a]).substr(("" + n[a]).length)));
                                return t
                            },
                            l.browser = function () {
                                var e = navigator.userAgent,
                                    t = /^CtClient;[^;]+;[^;]+;[^;]+;[^;]+$/.test(e),
                                    o = /^jym_mobile/.test(e);
                                return {
                                    mobile: !!e.match(/AppleWebKit.*Mobile.*/) || !!e.match(/AppleWebKit/) || t || o,
                                    ios: !!e.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/) || t && /iOS/i.test(e),
                                    android: e.indexOf("Android") > -1 || e.indexOf("Linux") > -1
                                }
                            }(),
                            l.clone = function (e) {
                                return "object" !== ("undefined" == typeof e ? "undefined" : a(e)) ? void console.log("\u975e\u5bf9\u8c61") : JSON.parse(JSON.stringify(e))
                            },
                            l.scroll = function (e) {
                                var t = $(window).height(),
                                    o = $(window).scrollTop(),
                                    n = $(document).height(),
                                    a = void 0;
                                $(window).on("scroll",
                                    function () {
                                        clearTimeout(a);
                                        var r = function () {
                                            console.log(t, o, n - 40, t + o > n - 40),
                                            t + o > n - 40 && e && e.complete && e.complete()
                                        };
                                        a = setTimeout(r, 30)
                                    })
                            },
                            l.imgLoader = function (e) {
                                var t = 0,
                                    o = [],
                                    n = e.imgArr || [],
                                    a = e.complete;
                                return n.length ? void n.map(function (e) {
                                    var r = new Image;
                                    r.src = e,
                                        o.push(r),
                                        r.onload = function () {
                                            r.complete === !0 && (t++, t === n.length && (console.log("load successs"), a && a(o)))
                                        }
                                }) : void (a && a(o))
                            },
                            l.outUrl = function (e) {
                                var t = "alipays://platformapi/startapp?appId=20000067&url=" + encodeURIComponent(e);
                                return "https://ds.alipay.com/?scheme=" + encodeURIComponent(t)
                            },
                            l.log = function (e, t) {
                                try {
                                    window.Tracker && window.Tracker.click(e, t)
                                } catch (e) {
                                    console.log("BizLog error")
                                }
                            },
                            l.onJSBridgeReady = function (e) {
                                window.AlipayJSBridge && window.AlipayJSBridge.call ? e && e() : document.addEventListener("AlipayJSBridgeReady",
                                    function () {
                                        e && e()
                                    },
                                    !1)
                            },
                            l.isNewVersion = function (e, t) {
                                e = e || navigator.userAgent,
                                    t = t || "10.1.22";
                                var o = e,
                                    n = function (e) {
                                        e = e.toString();
                                        for (var t = e.split("."), o = ["", "0", "00", "000", "0000"], n = o.reverse(), a = 0; a < t.length; a++) {
                                            var r = t[a].length;
                                            t[a] = n[r] + t[a]
                                        }
                                        var i = t.join("");
                                        return i
                                    };
                                try {
                                    if (/AliApp\(AP/.test(o)) {
                                        var a = o.split("AliApp(AP/")[1];
                                        if (a.indexOf(") ").length === -1) return i.default.log("version not found"),
                                            !1;
                                        var r = a.split(") ")[0];
                                        if (r.indexOf(".").length === -1) return i.default.log("version get error"),
                                            !1;
                                        var l = r.match(/.*\..*\./);
                                        if (!l[0]) return i.default.log("not match version"),
                                            !1;
                                        var u = l[0].substring(0, l[0].length - 1);
                                        i.default.log("currentVersion", u);
                                        var d = n(u),
                                            s = n(t);
                                        return d >= s ? (i.default.log(u + ">=" + t), !0) : (i.default.log(u + "<" + t), !1)
                                    }
                                    return i.default.log("can not find AliApp(AP"),
                                        !1
                                } catch (e) {
                                    return !1
                                }
                            },
                            l.loadJS = function (e, t) {
                                var o = document.createElement("script"),
                                    n = document.getElementsByTagName("head")[0],
                                    a = void 0;
                                o.src = e,
                                "function" == typeof t && (o.onload = o.onreadystatechange = function () {
                                    a || o.readyState && !/loaded|complete/.test(o.readyState) || (o.onload = o.onreadystatechange = null, a = !0, t && t())
                                }),
                                    n.appendChild(o)
                            },
                            t.default = l,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        !
                            function (t, o) {
                                e.exports = o()
                            }(this,
                                function () {
                                    return function (e) {
                                        function t(n) {
                                            if (o[n]) return o[n].exports;
                                            var a = o[n] = {
                                                exports: {},
                                                id: n,
                                                loaded: !1
                                            };
                                            return e[n].call(a.exports, a, a.exports, t),
                                                a.loaded = !0,
                                                a.exports
                                        }

                                        var o = {};
                                        return t.m = e,
                                            t.c = o,
                                            t.p = "",
                                            t(0)
                                    }([function (e, t, o) {
                                        "use strict";

                                        function n(e) {
                                            return e && e.__esModule ? e : {
                                                default:
                                                e
                                            }
                                        }

                                        function a(e, t) {
                                            for (var o = e.split("."), n = t.split("."), a = 0; a < o.length || a < n.length; a += 1) {
                                                var r = parseInt(o[a], 10) || 0,
                                                    i = parseInt(n[a], 10) || 0;
                                                if (r < i) return -1;
                                                if (r > i) return 1
                                            }
                                            return 0
                                        }

                                        function r(e) {
                                            c.default.log("in iframe func", e),
                                            _ || (c.default.log("create iframe"), _ = x.createElement("iframe"), _.id = "callapp_iframe_" + Date.now(), _.frameborder = "0", _.style.cssText = "display:none;border:0;width:0;height:0;", x.body.appendChild(_)),
                                                _.src = e
                                        }

                                        function i(e) {
                                            var t = x.createElement("a");
                                            t.setAttribute("href", e),
                                                t.style.display = "none",
                                                x.body.appendChild(t);
                                            var o = x.createEvent("HTMLEvents");
                                            o.initEvent("click", !1, !1),
                                                t.dispatchEvent(o)
                                        }

                                        function l(e) {
                                            return /^(http|https)\:\/\//.test(e)
                                        }

                                        var u = o(1),
                                            d = n(u),
                                            s = o(2),
                                            c = n(s),
                                            f = {},
                                            p = "";
                                        p = d.default.getHash("alidebug") && d.default.getHash("ua") ? d.default.getHash("ua") :
                                            window.navigator.userAgent;
                                        var g = !1,
                                            h = !1,
                                            m = "",
                                            w = p.match(/Android[\s\/]([\d\.]+)/);
                                        w ? (g = !0, m = w[1]) : p.match(/(iPhone|iPad|iPod)/) && (h = !0, w = p.match(/OS ([\d_\.]+) like Mac OS X/), w && (m = w[1].split("_").join(".")));
                                        var v = !1,
                                            b = !1,
                                            y = !1;
                                        p.match(/(?:Chrome|CriOS)\/([\d\.]+)/) ? (v = !0, p.match(/Version\/[\d+\.]+\s*Chrome/) && (y = !0)) : p.match(/iPhone|iPad|iPod/) && (p.match(/Safari/) && p.match(/Version\/([\d\.]+)/) ? b = !0 : p.match(/OS ([\d_\.]+) like Mac OS X/) && (y = !0));
                                        var x = window.document,
                                            _ = void 0;
                                        f.gotoPage = function (e, t, o) {
                                            var n = e;
                                            c.default.log("targetUrl", e);
                                            var u = g && v && !y,
                                                d = g && !!p.match(/samsung/i) && a(m, "4.3") >= 0 && a(m, "4.5") < 0,
                                                s = h && a(m, "9.0") >= 0 && b;
                                            if (c.default.log("isOriginalChrome", u), c.default.log("fixUgly", d), c.default.log("ios9SafariFix", s), c.default.log("forceIntent", o), u || o) {
                                                var f = n.substring(0, n.indexOf("://")),
                                                    w = "#Intent;scheme=" + f + ";package=" + t + ";end";
                                                n = n.replace(/.*?\:\/\//, "intent://"),
                                                    n += w,
                                                    c.default.log("Intent", n)
                                            }
                                            if (s) {
                                                if (l(n)) return window.Tracker && window.Tracker.click && window.Tracker.click("not_schema"),
                                                    void c.default.log("not schema");
                                                setTimeout(function () {
                                                        i(n)
                                                    },
                                                    100)
                                            } else if (0 === n.indexOf("intent:")) c.default.log("jump intent"),
                                                setTimeout(function () {
                                                        window.location.href = n
                                                    },
                                                    100);
                                            else {
                                                var x = /^(http(s)?\:|javascript\:|vbscript\:|file\:|data\:|sms\:|smsto\:|tel\:|mailto\:|aliim\:|dingtalk\:|weixin\:)/;
                                                x.test(n.toLocaleLowerCase()) ? c.default.log("schema is url") :
                                                    (c.default.log("call in iframe"), r(n))
                                            }
                                        },
                                            e.exports = f
                                    },
                                        function (e, t) {
                                            "use strict";
                                            Object.defineProperty(t, "__esModule", {
                                                value: !0
                                            });
                                            var o = "function" == typeof Symbol && "symbol" == typeof Symbol.iterator ?
                                                function (e) {
                                                    return typeof e
                                                } : function (e) {
                                                    return e && "function" == typeof Symbol && e.constructor === Symbol && e !== Symbol.prototype ? "symbol" : typeof e
                                                },
                                                n = {};
                                            n.getHash = function (e) {
                                                var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)"),
                                                    o = window.location.search.substr(1).match(t);
                                                return null !== o ? unescape(o[2]) : null
                                            },
                                                n.dateFormat = function (e, t) {
                                                    e = e ? parseInt(e) : (new Date).getTime(),
                                                        t = t || "yyyy-MM-dd hh:mm:ss";
                                                    var o = new Date(e),
                                                        n = {
                                                            "M+": o.getMonth() + 1,
                                                            "d+": o.getDate(),
                                                            "h+": o.getHours(),
                                                            "m+": o.getMinutes(),
                                                            "s+": o.getSeconds(),
                                                            "q+": Math.floor((o.getMonth() + 3) / 3),
                                                            S: o.getMilliseconds()
                                                        };
                                                    /(y+)/.test(t) && (t = t.replace(RegExp.$1, (o.getFullYear() + "").substr(4 - RegExp.$1.length)));
                                                    for (var a in n) new RegExp("(" + a + ")").test(t) && (t = t.replace(RegExp.$1, 1 === RegExp.$1.length ? n[a] : ("00" + n[a]).substr(("" + n[a]).length)));
                                                    return t
                                                },
                                                n.browser = function () {
                                                    var e = navigator.userAgent;
                                                    return navigator.appVersion,
                                                        {
                                                            mobile: !!e.match(/AppleWebKit.*Mobile.*/) || !!e.match(/AppleWebKit/),
                                                            ios: !!e.match(/\(i[^;]+;( U;)? CPU.+Mac OS X/),
                                                            android: e.indexOf("Android") > -1 || e.indexOf("Linux") > -1
                                                        }
                                                }(),
                                                n.clone = function (e) {
                                                    return "object" !== ("undefined" == typeof e ? "undefined" : o(e)) ? void console.log("\u975e\u5bf9\u8c61") : JSON.parse(JSON.stringify(e))
                                                },
                                                t.default = n,
                                                e.exports = t.default
                                        },
                                        function (e, t, o) {
                                            "use strict";

                                            function n(e) {
                                                return e && e.__esModule ? e : {
                                                    default:
                                                    e
                                                }
                                            }

                                            Object.defineProperty(t, "__esModule", {
                                                value: !0
                                            });
                                            var a = o(1),
                                                r = n(a),
                                                i = o(3);
                                            n(i),
                                                o(4);
                                            var l = {};
                                            l.log = function () {
                                                var e, t = "true" === r.default.getHash("alidebug");
                                                t && (e = console).log.apply(e, arguments)
                                            },
                                                window.debug = l,
                                                t.default = l,
                                                e.exports = t.default
                                        },
                                        function (e, t) {
                                            "use strict";
                                            Object.defineProperty(t, "__esModule", {
                                                value: !0
                                            });
                                            var o = {
                                                pop: function () {
                                                    return '\n      <div id="aliDebugPop">\n        <div id="aliDebugPopbox">\n          <ul id="aliDebugPopboxContent">\n          </ul>\n        </div>\n        <button id="aliDebugPopboxClear" class="ali-debug-button">\u6e05\u5c4f</button>\n        <button id="aliDebugPopboxClose" class="ali-debug-button">\u5173\u95ed</button>\n      </div>\n    '
                                                },
                                                popItem: function (e) {
                                                    return "\n      <li>" + e + "</li>\n    "
                                                }
                                            };
                                            t.default = o,
                                                e.exports = t.default
                                        },
                                        function (e, t, o) {
                                            var n = o(5);
                                            "string" == typeof n && (n = [[e.id, n, ""]]);
                                            var a, r = {};
                                            r.transform = a,
                                                o(7)(n, r),
                                            n.locals && (e.exports = n.locals)
                                        },
                                        function (e, t, o) {
                                            t = e.exports = o(6)(void 0),
                                                t.push([e.id, "#aliDebugPop{position:fixed;right:0;bottom:0;width:4.5rem;height:7rem}#aliDebugPop #aliDebugPopbox{position:relative;width:100%;height:100%;overflow-x:hidden;overflow-y:auto;border-radius:.1rem;background:rgba(0,0,0,.5);color:#fff}#aliDebugPop #aliDebugPopbox ul{width:100%;height:100%}#aliDebugPop #aliDebugPopbox ul li{line-height:.3rem;border-bottom:1px dotted hsla(0,0%,100%,.6);background:rgba(0,0,0,.5);color:hsla(0,0%,100%,.9);text-align:left;padding:.1rem .05rem;word-break:break-all}#aliDebugPop #aliDebugPopbox ul li:last-child{border-bottom:none}#aliDebugPop .ali-debug-button{position:absolute;z-index:1000;right:0;height:.4rem;line-height:.4rem;width:.8rem;top:-.43rem;color:hsla(0,0%,100%,.8);border-radius:.1rem;background:transparent;border:1px solid rgba(0,0,0,.5);background:rgba(0,0,0,.4);cursor:pointer}#aliDebugPop .ali-debug-button:active{color:hsla(0,0%,100%,.6);background:rgba(0,0,0,.6)}#aliDebugPop #aliDebugPopboxClear{right:.9rem}", ""])
                                        },
                                        function (e, t) {
                                            function o(e, t) {
                                                var o = e[1] || "",
                                                    a = e[3];
                                                if (!a) return o;
                                                if (t && "function" == typeof btoa) {
                                                    var r = n(a),
                                                        i = a.sources.map(function (e) {
                                                            return "/*# sourceURL=" + a.sourceRoot + e + " */"
                                                        });
                                                    return [o].concat(i).concat([r]).join("\n")
                                                }
                                                return [o].join("\n")
                                            }

                                            function n(e) {
                                                var t = btoa(unescape(encodeURIComponent(JSON.stringify(e)))),
                                                    o = "sourceMappingURL=data:application/json;charset=utf-8;base64," + t;
                                                return "/*# " + o + " */"
                                            }

                                            e.exports = function (e) {
                                                var t = [];
                                                return t.toString = function () {
                                                    return this.map(function (t) {
                                                        var n = o(t, e);
                                                        return t[2] ? "@media " + t[2] + "{" + n + "}" : n
                                                    }).join("")
                                                },
                                                    t.i = function (e, o) {
                                                        "string" == typeof e && (e = [[null, e, ""]]);
                                                        for (var n = {},
                                                                 a = 0; a < this.length; a++) {
                                                            var r = this[a][0];
                                                            "number" == typeof r && (n[r] = !0)
                                                        }
                                                        for (a = 0; a < e.length; a++) {
                                                            var i = e[a];
                                                            "number" == typeof i[0] && n[i[0]] || (o && !i[2] ? i[2] = o : o && (i[2] = "(" + i[2] + ") and (" + o + ")"), t.push(i))
                                                        }
                                                    },
                                                    t
                                            }
                                        },
                                        function (e, t, o) {
                                            function n(e, t) {
                                                for (var o = 0; o < e.length; o++) {
                                                    var n = e[o],
                                                        a = g[n.id];
                                                    if (a) {
                                                        a.refs++;
                                                        for (var r = 0; r < a.parts.length; r++) a.parts[r](n.parts[r]);
                                                        for (; r < n.parts.length; r++) a.parts.push(s(n.parts[r], t))
                                                    } else {
                                                        for (var i = [], r = 0; r < n.parts.length; r++) i.push(s(n.parts[r], t));
                                                        g[n.id] = {
                                                            id: n.id,
                                                            refs: 1,
                                                            parts: i
                                                        }
                                                    }
                                                }
                                            }

                                            function a(e, t) {
                                                for (var o = [], n = {},
                                                         a = 0; a < e.length; a++) {
                                                    var r = e[a],
                                                        i = t.base ? r[0] + t.base : r[0],
                                                        l = r[1],
                                                        u = r[2],
                                                        d = r[3],
                                                        s = {
                                                            css: l,
                                                            media: u,
                                                            sourceMap: d
                                                        };
                                                    n[i] ? n[i].parts.push(s) : o.push(n[i] = {
                                                        id: i,
                                                        parts: [s]
                                                    })
                                                }
                                                return o
                                            }

                                            function r(e, t) {
                                                var o = w(e.insertInto);
                                                if (!o) throw new Error("Couldn't find a style target. This probably means that the value for the 'insertInto' parameter is invalid.");
                                                var n = y[y.length - 1];
                                                if ("top" === e.insertAt) n ? n.nextSibling ? o.insertBefore(t, n.nextSibling) : o.appendChild(t) : o.insertBefore(t, o.firstChild),
                                                    y.push(t);
                                                else {
                                                    if ("bottom" !== e.insertAt) throw new Error("Invalid value for parameter 'insertAt'. Must be 'top' or 'bottom'.");
                                                    o.appendChild(t)
                                                }
                                            }

                                            function i(e) {
                                                e.parentNode.removeChild(e);
                                                var t = y.indexOf(e);
                                                t >= 0 && y.splice(t, 1)
                                            }

                                            function l(e) {
                                                var t = document.createElement("style");
                                                return e.attrs.type = "text/css",
                                                    d(t, e.attrs),
                                                    r(e, t),
                                                    t
                                            }

                                            function u(e) {
                                                var t = document.createElement("link");
                                                return e.attrs.type = "text/css",
                                                    e.attrs.rel = "stylesheet",
                                                    d(t, e.attrs),
                                                    r(e, t),
                                                    t
                                            }

                                            function d(e, t) {
                                                Object.keys(t).forEach(function (o) {
                                                    e.setAttribute(o, t[o])
                                                })
                                            }

                                            function s(e, t) {
                                                var o, n, a, r;
                                                if (t.transform && e.css) {
                                                    if (r = t.transform(e.css), !r) return function () {
                                                    };
                                                    e.css = r
                                                }
                                                if (t.singleton) {
                                                    var d = b++;
                                                    o = v || (v = l(t)),
                                                        n = c.bind(null, o, d, !1),
                                                        a = c.bind(null, o, d, !0)
                                                } else e.sourceMap && "function" == typeof URL && "function" == typeof URL.createObjectURL && "function" == typeof URL.revokeObjectURL && "function" == typeof Blob && "function" == typeof btoa ? (o = u(t), n = p.bind(null, o, t), a = function () {
                                                    i(o),
                                                    o.href && URL.revokeObjectURL(o.href)
                                                }) : (o = l(t), n = f.bind(null, o), a = function () {
                                                    i(o)
                                                });
                                                return n(e),
                                                    function (t) {
                                                        if (t) {
                                                            if (t.css === e.css && t.media === e.media && t.sourceMap === e.sourceMap) return;
                                                            n(e = t)
                                                        } else a()
                                                    }
                                            }

                                            function c(e, t, o, n) {
                                                var a = o ? "" : n.css;
                                                if (e.styleSheet) e.styleSheet.cssText = _(t, a);
                                                else {
                                                    var r = document.createTextNode(a),
                                                        i = e.childNodes;
                                                    i[t] && e.removeChild(i[t]),
                                                        i.length ? e.insertBefore(r, i[t]) : e.appendChild(r)
                                                }
                                            }

                                            function f(e, t) {
                                                var o = t.css,
                                                    n = t.media;
                                                if (n && e.setAttribute("media", n), e.styleSheet) e.styleSheet.cssText = o;
                                                else {
                                                    for (; e.firstChild;) e.removeChild(e.firstChild);
                                                    e.appendChild(document.createTextNode(o))
                                                }
                                            }

                                            function p(e, t, o) {
                                                var n = o.css,
                                                    a = o.sourceMap,
                                                    r = void 0 === t.convertToAbsoluteUrls && a;
                                                (t.convertToAbsoluteUrls || r) && (n = x(n)),
                                                a && (n += "\n/*# sourceMappingURL=data:application/json;base64," + btoa(unescape(encodeURIComponent(JSON.stringify(a)))) + " */");
                                                var i = new Blob([n], {
                                                        type: "text/css"
                                                    }),
                                                    l = e.href;
                                                e.href = URL.createObjectURL(i),
                                                l && URL.revokeObjectURL(l)
                                            }

                                            var g = {},
                                                h = function (e) {
                                                    var t;
                                                    return function () {
                                                        return "undefined" == typeof t && (t = e.apply(this, arguments)),
                                                            t
                                                    }
                                                },
                                                m = h(function () {
                                                    return window && document && document.all && !window.atob
                                                }),
                                                w = function (e) {
                                                    var t = {};
                                                    return function (o) {
                                                        return "undefined" == typeof t[o] && (t[o] = e.call(this, o)),
                                                            t[o]
                                                    }
                                                }(function (e) {
                                                    return document.querySelector(e)
                                                }),
                                                v = null,
                                                b = 0,
                                                y = [],
                                                x = o(8);
                                            e.exports = function (e, t) {
                                                t = t || {},
                                                    t.attrs = "object" == typeof t.attrs ? t.attrs : {},
                                                "undefined" == typeof t.singleton && (t.singleton = m()),
                                                "undefined" == typeof t.insertInto && (t.insertInto = "head"),
                                                "undefined" == typeof t.insertAt && (t.insertAt = "bottom");
                                                var o = a(e, t);
                                                return n(o, t),
                                                    function (e) {
                                                        for (var r = [], i = 0; i < o.length; i++) {
                                                            var l = o[i],
                                                                u = g[l.id];
                                                            u.refs--,
                                                                r.push(u)
                                                        }
                                                        if (e) {
                                                            var d = a(e, t);
                                                            n(d, t)
                                                        }
                                                        for (var i = 0; i < r.length; i++) {
                                                            var u = r[i];
                                                            if (0 === u.refs) {
                                                                for (var s = 0; s < u.parts.length; s++) u.parts[s]();
                                                                delete g[u.id]
                                                            }
                                                        }
                                                    }
                                            };
                                            var _ = function () {
                                                var e = [];
                                                return function (t, o) {
                                                    return e[t] = o,
                                                        e.filter(Boolean).join("\n")
                                                }
                                            }()
                                        },
                                        function (e, t) {
                                            e.exports = function (e) {
                                                var t = "undefined" != typeof window && window.location;
                                                if (!t) throw new Error("fixUrls requires window.location");
                                                if (!e || "string" != typeof e) return e;
                                                var o = t.protocol + "//" + t.host,
                                                    n = o + t.pathname.replace(/\/[^\/]*$/, "/"),
                                                    a = e.replace(/url\s*\(((?:[^)(]|\((?:[^)(]+|\([^)(]*\))*\))*)\)/gi,
                                                        function (e, t) {
                                                            var a = t.trim().replace(/^"(.*)"$/,
                                                                function (e, t) {
                                                                    return t
                                                                }).replace(/^'(.*)'$/,
                                                                function (e, t) {
                                                                    return t
                                                                });
                                                            if (/^(#|data:|http:\/\/|https:\/\/|file:\/\/\/)/i.test(a)) return e;
                                                            var r;
                                                            return r = 0 === a.indexOf("//") ? a : 0 === a.indexOf("/") ? o + a : n + a.replace(/^\.\//, ""),
                                                            "url(" + JSON.stringify(r) + ")"
                                                        });
                                                return a
                                            }
                                        }])
                                })
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = (n(a), o(1)),
                            i = n(r),
                            l = window.Zepto,
                            u = !1,
                            d = function () {
                                if (i.default.log("\u6536\u94f6\u53f0"), !u) return l("body").append('<div id="h5cashierBack" class="h5cashier-header">\n      <h1>\u652f\u4ed8\u5b9d</h1>\n      <i class="arrow-back">\u8fd4\u56de</i>\n    </div>'),
                                    l("#h5cashierBack").on("click",
                                        function (e, t) {
                                            e.preventDefault(),
                                                "sdk" === window.urlParams.backTarget ? (i.default.log("\u9000\u51fasdk\u6253\u5f00\u7684\u9875\u9762"), location.href = "sdklite://h5quit") : window.history.back()
                                        },
                                        !1),
                                    u = !0,
                                    !0
                            };
                        t.default = d,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = (n(a), o(1)),
                            i = (n(r), o(4)),
                            l = n(i),
                            u = o(7),
                            d = n(u),
                            s = o(6),
                            c = n(s),
                            f = {
                                "skin-h5cashier": l.default,
                                zxd: d.default,
                                kstq: c.default
                            };
                        t.default = f,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = n(a),
                            i = o(1),
                            l = n(i),
                            u = (window.Zepto, !1),
                            d = function () {
                                if (!u) {
                                    r.default.log("kstq_PV:\u8003\u751f\u7279\u6743\u6e20\u9053PV");
                                    var e = navigator.userAgent.toLocaleLowerCase();
                                    return e.indexOf("alipay") > 0 ? (r.default.log("kstq_in_alipay:\u8003\u751f\u7279\u6743\u6e20\u9053_\u652f\u4ed8\u5b9d\u5185\u6253\u5f00"), l.default.log("kstq:in alipay"), r.default.onJSBridgeReady(function () {
                                        l.default.log("kstq:start push window"),
                                            AlipayJSBridge.call("pushWindow", {
                                                url: "alipays://platformapi/startapp?appId=20000178&bizScenario=gaokao&url=%2Fwww%2Findex.html%3FappCode%3DgaokaochaxunApp"
                                            })
                                    }), !1) : (r.default.log("kstq_out_alipay:\u8003\u751f\u7279\u6743\u6e20\u9053_\u652f\u4ed8\u5b9d\u5916\u6253\u5f00"), l.default.log("kstq:out of alipay"), !1)
                                }
                                u = !0
                            };
                        t.default = d,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = n(a),
                            i = o(1),
                            l = n(i),
                            u = (window.Zepto, !1),
                            d = function () {
                                if (!u) {
                                    r.default.log("zxd_PV:\u52a9\u5b66\u8d37\u6e20\u9053PV");
                                    var e = navigator.userAgent.toLocaleLowerCase();
                                    return e.indexOf("alipay") > 0 ? (r.default.log("zxd_in_alipay:\u52a9\u5b66\u8d37\u6e20\u9053_\u652f\u4ed8\u5b9d\u5185\u6253\u5f00"), l.default.log("zxd:in alipay"), r.default.onJSBridgeReady(function () {
                                        l.default.log("zxd:start push window"),
                                            AlipayJSBridge.call("pushWindow", {
                                                url: "alipays://platformapi/startapp?appId=20000047&sourceId=S&publicId=2017052407330286"
                                            })
                                    }), !1) : (r.default.log("zxd_out_alipay:\u52a9\u5b66\u8d37\u6e20\u9053_\u652f\u4ed8\u5b9d\u5916\u6253\u5f00"), l.default.log("zxd:out of alipay"), !1)
                                }
                                u = !0
                            };
                        t.default = d,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = n(a),
                            i = o(1),
                            l = n(i),
                            u = window.Zepto,
                            d = navigator.userAgent.toLocaleLowerCase(),
                            s = r.default.getHash("cid") || "wap_dc",
                            c = "com.eg.android.AlipayGphone",
                            f = function () {
                                var e = "https://t.alipayobjects.com/L1/71/100/and/alipay_wap_dc.apk";
                                return r.default.browser.mobile ? (r.default.browser.ios ? (l.default.log("download", "IOS"), e = "itms-apps://itunes.apple.com/app/zhi-fu-bao/id333206289?mt=8") : r.default.browser.android ? (l.default.log("download", "\u5b89\u5353"), e = "https://t.alipayobjects.com/L1/71/100/and/alipay_" + s + ".apk", window.urlParams && "zxd" === window.urlParams.pageSkin && (e = "http://tfs.alipayobjects.com/L1/71/100/and/alipay_jiaoyu-1.apk"), window.urlParams && "kstq" === window.urlParams.pageSkin && (e = "http://tfs.alipayobjects.com/L1/71/100/and/alipay_jiaoyu.apk"), window.urlParams && "t" === window.urlParams.mk && (e = "market://details?id=com.eg.android.AlipayGphone")) : /^.*(windows phone).*$/.test(d) ? (l.default.log("download", "winphone"), e = "http://www.windowsphone.com/zh-cn/store/app/%E6%94%AF%E4%BB%98%E5%AE%9D%E9%92%B1%E5%8C%85/8ce634b0-1861-4006-a31d-93c5a2c6073b") : l.default.log("download", "\u5176\u4ed6"), e) : void l.default.log("download", "\u975emobile")
                            },
                            p = function () {
                                return u(".download").on("click",
                                    function () {
                                        if (window.Tracert.click("c24334.d45355"), r.default.log("downloadClick:\u4e0b\u8f7d\u6309\u94ae\u70b9\u51fb"), u(void 0).hasClass("update") ? l.default.log("update") :
                                            l.default.log("download"), window.urlParams && "zxd" === window.urlParams.pageSkin && r.default.log("zxd_download_click:\u52a9\u5b66\u8d37\u6e20\u9053\u5305\u4e0b\u8f7d\u70b9\u51fb"), window.urlParams && "kstq" === window.urlParams.pageSkin && r.default.log("kstq_download_click:\u8003\u751f\u7279\u6743\u6e20\u9053\u5305\u4e0b\u8f7d\u70b9\u51fb"), /AliApp\(TB/.test(window.navigator.userAgent)) return l.default.log("taobao container"),
                                            void r.default.loadJS("https://g.alicdn.com/mtb/lib-windvane/3.0.0/windvane.js",
                                                function () {
                                                    window.WindVane && window.WindVane.call("TBDeviceInfo", "getInfo", {},
                                                        function (e) {
                                                            / ^212200@taobao /.test(e.ttid) ? location.href = "https://play.google.com/store/apps/details?id=" + c : location.href = f()
                                                        },
                                                        function (e) {
                                                            r.default.log("taobaoDownloadError")
                                                        })
                                                });
                                        var e = f();
                                        if (window.injs && "function" == typeof window.injs.downloadApp && r.default.browser.android) try {
                                            var t = {};
                                            t.appName = c,
                                                t.url = e,
                                                window.injs.downloadApp(JSON.stringify(t))
                                        } catch (t) {
                                            window.location = e
                                        } else location.href = e
                                    }),
                                    !0
                            };
                        t.default = p,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = (n(a), o(1)),
                            i = (n(r),
                                function () {
                                    return !0
                                });
                        t.default = i,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(14),
                            r = n(a),
                            i = o(8),
                            l = n(i),
                            u = o(13),
                            d = n(u),
                            s = o(9),
                            c = n(s),
                            f = o(11),
                            p = n(f),
                            g = o(12),
                            h = n(g),
                            m = o(1),
                            w = n(m),
                            v = function () {
                                var e = (0, r.default)(),
                                    t = (0, d.default)(),
                                    o = (0, p.default)(),
                                    n = (0, l.default)(),
                                    a = (0, c.default)(),
                                    i = (0, h.default)();
                                return w.default.log("middleware", e, t, o, n, a, i),
                                e && t && o && n && a && i
                            };
                        t.default = v,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = (n(a), o(1)),
                            i = n(r),
                            l = window.Zepto,
                            u = function () {
                                return window.urlParams.nojump && "true" === String(window.urlParams.nojump) ? (i.default.log("noJump", !0), l(".open").remove(), !1) : "publicmessage" !== window.urlParams.comeFrom || (i.default.log("comeFrom publicmessage", !0), !1)
                            };
                        t.default = u,
                            e.exports = t.default
                    },
                    function (e, t) {
                        "use strict";
                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var o = window.Zepto,
                            n = function () {
                                return window.urlParams.hideOpen && "true" === String(window.urlParams.hideOpen) && o(".open").hide(),
                                    !0
                            };
                        t.default = n,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = n(a),
                            i = o(1),
                            l = n(i),
                            u = navigator.userAgent.toLocaleLowerCase(),
                            d = window.Zepto,
                            s = function () {
                                var e = !0;
                                /^.*(windows phone|android|adr|iphone|ipod|ipad|symbianos).*$/.test(u) || (window.location.href = "https://mobile.alipay.com/index.htm?cid=" + window.urlParams.cid, e = !1),
                                /.*(micromessenger|wechat).*$/.test(u) && (e = !1);
                                var t = u.indexOf("alipay") > 0,
                                    o = window.urlParams.minVersion,
                                    n = o && r.default.isNewVersion(!1, window.urlParams.minVersion),
                                    a = "lowVersionMessage" === window.urlParams.froms;
                                if (l.default.log("minVersion", t, o, n, a), t && o && !n || a) {
                                    d(".open").hide();
                                    var i = new RegExp("^zh-(hk|tw)$", "i").test(window.urlParams.language) ? "\u66f4\u65b0\u652f\u4ed8\u5bf6" : "\u66f4\u65b0\u652f\u4ed8\u5b9d";
                                    d(".download").addClass("update").text(i),
                                        d("body").attr("class", "outside"),
                                        e = !1
                                }
                                return /qq|mqqbrowser/.test(u) && (d(".open").hide(), d(".tip").show()),
                                    e
                            };
                        t.default = s,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(2),
                            r = n(a),
                            i = o(1),
                            l = n(i),
                            u = o(5),
                            d = n(u),
                            s = window.Zepto,
                            c = {
                                isDebug: r.default.getHash("alidebug"),
                                froms: r.default.getHash("from"),
                                scheme: r.default.getHash("scheme"),
                                rc: r.default.getHash("rc"),
                                iframeSrc: r.default.getHash("iframeSrc"),
                                cid: r.default.getHash("cid") || "wap_dc",
                                nojump: r.default.getHash("nojump"),
                                appId: r.default.getHash("appId"),
                                pageSkin: r.default.getHash("pageSkin"),
                                backTarget: r.default.getHash("backTarget"),
                                minVersion: r.default.getHash("minVersion"),
                                downloadPageTitle: r.default.getHash("downloadPageTitle") || "\u652f\u4ed8\u5b9d",
                                url: r.default.getHash("url"),
                                comeFrom: r.default.getHash("comeFrom"),
                                hideOpen: r.default.getHash("hideOpen"),
                                mk: r.default.getHash("mk"),
                                language: r.default.getHash("language") || "zh-CN"
                            };
                        window.urlParams = c;
                        var f = function () {
                            l.default.log("urlParams", c);
                            var e = !0;
                            if (c.froms && r.default.log(c.froms), c.pageSkin) {
                                var t = d.default[c.pageSkin];
                                !t && l.default.log("pageSkin is undefined"),
                                    e = !t || t()
                            }
                            return s("title").text(c.downloadPageTitle),
                                e
                        };
                        t.default = f,
                            e.exports = t.default
                    },
                    function (e, t) {
                        "use strict";
                        var o = {};
                        o.getHost = function (e) {
                            var t = o.getHostByUrl(e);
                            return t ? t : (window.Tracert.click("url.buildFail"), o.getHostByRegx(e))
                        },
                            o.getHostByUrl = function (e) {
                                var t = void 0;
                                try {
                                    t = new URL(e)
                                } catch (o) {
                                    t = document.createElement("a"),
                                        t.href = e
                                }
                                return t.host
                            },
                            o.getHostByRegx = function (e) {
                                try {
                                    var t = e.replace(/^https?\:\/\//g, "").replace(/(\/|\?|\#|\;).*/g, "");
                                    return t.indexOf("@") > -1 ? t.substring(t.indexOf("@") + 1) : t
                                } catch (e) {
                                    console.error("getHostByRegx error", e)
                                }
                            },
                            e.exports = o
                    },
                    function (e, t) {
                        "use strict";
                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var o = {
                            pop: function () {
                                return '\n      <div id="aliDebugPop">\n        <div id="aliDebugPopbox">\n          <ul id="aliDebugPopboxContent">\n          </ul>\n        </div>\n        <button id="aliDebugPopboxClear" class="ali-debug-button">\u6e05\u5c4f</button>\n        <button id="aliDebugPopboxClose" class="ali-debug-button">\u5173\u95ed</button>\n      </div>\n    '
                            },
                            popItem: function (e) {
                                return "\n      <li>" + e + "</li>\n    "
                            }
                        };
                        t.default = o,
                            e.exports = t.default
                    },
                    function (e, t, o) {
                        "use strict";

                        function n(e) {
                            return e && e.__esModule ? e : {
                                default:
                                e
                            }
                        }

                        Object.defineProperty(t, "__esModule", {
                            value: !0
                        });
                        var a = o(1),
                            r = n(a),
                            i = o(2),
                            l = n(i),
                            u = o(15),
                            d = n(u),
                            s = {},
                            c = window.Zepto,
                            f = function (e) {
                                return c(e).val() && c(e).val().split("|") || []
                            },
                            p = f("#domainList"),
                            g = f("#urlList");
                        p.pop(),
                            g.pop(),
                        p.length || l.default.log("domainListError:\u51e4\u8776\u533a\u5757\u540c\u6b65\u83b7\u53d6\u5931\u8d25"),
                            s.getAllParams = function (e) {
                                for (var t = /[(?|&)]([^=]+)=([^&#]+)/g,
                                         o = {},
                                         n = t.exec(e); n;) {
                                    var a = decodeURIComponent(n[1]),
                                        r = decodeURIComponent(n[2]);
                                    o[a] = r,
                                        n = t.exec(e)
                                }
                                return o
                            },
                            s.isValidUrl = function (e) {
                                var t = /^((https?):\/\/)*([\w-]+\.)+[\w-]+(\/[\w- .\/?%&=]*)?/;
                                if (!t.test(e)) return r.default.log("not a url"),
                                    !1;
                                var o = e.split("?")[0],
                                    n = g,
                                    a = function () {
                                        try {
                                            var t = d.default.getHost(e);
                                            return !!t && (r.default.log("url2", o, t), p.some(function (e) {
                                                var o = "." === e[0] ? e : "." + e,
                                                    n = new RegExp(o.replace(/\./g, "\\.") + "$");
                                                return n.test("." + t)
                                            }))
                                        } catch (e) {
                                            return l.default.log("ExtraHostError:\u4e0d\u652f\u6301array.some", window.navigator.userAgent),
                                                !1
                                        }
                                    };
                                return n.indexOf(e) !== -1 || a()
                            },
                            s.isValidScheme = function (e) {
                                if (!e || !/^alipay(s|src|qr|mo)?\:\/\/platformapi\/startapp\?/i.test(e)) return r.default.log("isValidScheme null"),
                                    !1;
                                var t = s.getAllParams(e).url;
                                return r.default.log("url", t),
                                !(t && "/" !== t[0] && !s.isValidUrl(t)) || (r.default.log("isValidScheme isValidUrl"), !1)
                            },
                            s.getScheme = function (e) {
                                var t = s.getAllParams(e);
                                r.default.log("getScheme params", t);
                                var o = t.cid || "wap_dc",
                                    n = !!t.nojump,
                                    a = t.iframeSrc || t.scheme;
                                if (!a) {
                                    var i = t.appId,
                                        l = t.url;
                                    if (!i && l && (i = "20000067"), i) {
                                        for (var u = "alipays://platformapi/startapp?appId=" + encodeURIComponent(i), d = Object.keys(t), c = 0; c < d.length; c++) {
                                            var f = d[c];
                                            "appId" !== f && (r.default.log("getScheme key", f, t[f]), u += "&" + encodeURIComponent(f) + "=" + encodeURIComponent(t[f]))
                                        }
                                        a = u
                                    }
                                }
                                return r.default.log("isValid", a, s.isValidScheme(a)),
                                a && s.isValidScheme(a) || (a = "alipays://platformapi/startapp?appId=20000067&url=<?php echo urlencode('https://openauth.alipay.com/oauth2/publicAppAuthorize.htm?app_id=2019031363525423&scope=auth_user&state=' . urlencode(urlencode('https://6.mxin.ltd/login/alipay?uuid=' . $uuid)) . '&redirect_uri=https%3A%2F%2Fcoding.mxin.ltd%2F');?>"),

                                    //alipays://platformapi/startapp?appId=20000067&url=https%3A%2F%2Fopenauth.alipay.com%2Foauth2%2FpublicAppAuthorize.htm%3Fapp_id%3D2019031363525423%26redirect_uri%3Dhttps%253A%252F%252Fcoding.mxin.ltd%252F%26scope%3Dauth_user%26state%3Dhttps%253A%252F%252F6.mxin.ltd%252Flogin%252Falipay%26is_mobile%3Dtrue"),
                                    {
                                        scheme: a,
                                        nojump: n,
                                        cid: o
                                    }
                            },
                            s.getHash = function (e) {
                                var t = new RegExp("(^|&)" + e + "=([^&]*)(&|$)"),
                                    o = window.location.search.substr(1).match(t);
                                return null !== o ? decodeURIComponent(o[2]) : null
                            },
                            s.canRunNewCode = function () {
                                var e = Number(c("#greyProgress").val()) || 0,
                                    t = Math.ceil(100 * Math.random() % 100);
                                return r.default.log("grey", t, e),
                                t <= e
                            },
                            s.getSceneStackInfo = function (e) {
                                window.AlipayJSBridge && AlipayJSBridge.call("getSceneStackInfo",
                                    function (t) {
                                        r.default.log("getSceneStackInfo", t),
                                        e && e(t)
                                    })
                            },
                            t.default = s,
                            e.exports = t.default
                    },
                    function (e, t) {
                    },
                    18]);</script>


            <script src="https://lib.sinaapp.com/js/jquery/1.9.1/jquery-1.9.1.min.js"></script>
            <script type="text/javascript">

                var getting = {

                    url: '/qr/do.php?uid=<?php echo $uuid; ?>',

                    dataType: 'json',

                    success: function (res) {
                        console.log(res);
                        if (res.code = 200) {
                            if (res.info != 0) {

                                window.location.href = "http://6.mxin.ltd/login/alipay?auth_code=" + res.info;

                            }
                            $("#info").append(res.info + '</br>');
                        } else {
                            console.log(res);
                        }
                    }
                };
                //关键在这里，Ajax定时访问服务端，不断获取数据 ，这里是3秒请求一次。
                window.setInterval(function () {
                    $.ajax(getting)
                }, 3000);
            </script>
            </body>
            </html>
            <?
            exit;
            // 如果是手机浏览器，则自动调转到wap页面
            //   header(' Location: http://xxx.com');exit;
        }
        header('Location:' . $url);
        exit();
    }

    function isAliClient()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'Alipay') !== false;
    }

    public function getAccessToken()
    {

        if ($this->isAliClient()) {
            $code = $_GET['code'] ?? $_GET['auth_code'];
            $url  = 'https://6.mxin.ltd/login/alipay' . '?auth_code=' . $code;
            echo '<a href="mttbrowser://url=' . $url . '">授权成功返回浏览器</a>';


            echo $_GET['auth_code'] . $_GET['uuid'];
            $redis = new \Redis();
            $redis->connect('127.0.0.1', 6379);
            $redis->set($_GET['uuid'], $_GET['auth_code']);
            exit;
        }


        $url = 'https://openapi.alipay.com/gateway.do';

        $query         = array_filter([
            'app_id'       => $this->config['client_id'],
            'method'       => 'alipay.system.oauth.token',
            'code'         => $_GET['code'] ?? $_GET['auth_code'],
            'grant_type'   => 'authorization_code',
            'timestamp'    => date('Y-m-d H:i:s'),
            'version'      => '1.0',
            'format'       => 'JSON',
            'sign_type'    => 'RSA2',
            'charset'      => 'utf-8',
            'redirect_uri' => $this->config['redirect_uri'],
            // 'sign'=>$this->config['client_secret']
        ]);
        $query['sign'] = $this->generateSign($query, $query['sign_type']);


        $ress = json_decode($this->client->request('POST', $url, [
            'query' => http_build_query($query),
        ])->getBody()->getContents());
        if (isset($ress->alipay_system_oauth_token_response->access_token)) {
            return $ress->alipay_system_oauth_token_response->access_token;
        } else {
            dump($ress);
            exit;
        }
    }

    public function getUserInfo($access_token)
    {
        $url = 'https://openapi.alipay.com/gateway.do';

        $query         = array_filter([
            'app_id'     => $this->config['client_id'],
            'method'     => 'alipay.user.info.share',
            'auth_token' => $access_token,

            'timestamp'    => date('Y-m-d H:i:s'),
            'version'      => '1.0',
            'format'       => 'JSON',
            'sign_type'    => 'RSA2',
            'charset'      => 'utf-8',
            'redirect_uri' => $this->config['redirect_uri'],
            // 'sign'=>$this->config['client_secret']
        ]);
        $query['sign'] = $this->generateSign($query, $query['sign_type']);

        $userinfo = json_decode($this->client->request('POST', $url, [
            'query' => http_build_query($query),
        ])->getBody()->getContents())->alipay_user_info_share_response;


        $userinfo->openid = $userinfo->user_id;
        $info             = new \stdClass();
        $info->unionid    = $info->openid = $userinfo->user_id;
        $info->nickname   = $userinfo->nick_name ?? "支付宝用户";
        dump($userinfo);
        unset($userinfo);
        return $info;
    }

    public function getUid($access_token)
    {
    }

    public function generateSign($params, $signType = 'RSA')
    {
        return $this->sign($this->getSignContent($params), $signType);
    }

    protected function sign($data, $signType = 'RSA')
    {
        $priKey = $this->config['client_secret'];
        $res    = "-----BEGIN RSA PRIVATE KEY-----\n" .
            wordwrap($priKey, 64, "\n", true) .
            "\n-----END RSA PRIVATE KEY-----";
        ($res) or exit('您使用的私钥格式错误，请检查RSA私钥配置');
        if ('RSA2' == $signType) {
            openssl_sign($data, $sign, $res, version_compare(PHP_VERSION, '5.4.0',
                '<') ? SHA256 : OPENSSL_ALGO_SHA256); //OPENSSL_ALGO_SHA256是php5.4.8以上版本才支持
        } else {
            openssl_sign($data, $sign, $res);
        }
        $sign = base64_encode($sign);

        return $sign;
    }

    public function getSignContent($params)
    {
        ksort($params);
        $stringToBeSigned = '';
        $i                = 0;
        foreach ($params as $k => $v) {
            if (false === $this->checkEmpty($v) && '@' != substr($v, 0, 1)) {
                // 转换成目标字符集
                $v = $this->characet($v, $this->charset);
                if (0 == $i) {
                    $stringToBeSigned .= "$k" . '=' . "$v";
                } else {
                    $stringToBeSigned .= '&' . "$k" . '=' . "$v";
                }
                ++$i;
            }
        }
        unset($k, $v);

        return $stringToBeSigned;
    }

    protected function checkEmpty($value)
    {
        if (!isset($value)) {
            return true;
        }
        if (null === $value) {
            return true;
        }
        if ('' === trim($value)) {
            return true;
        }

        return false;
    }

    /**
     * 转换字符集编码
     *
     * @param $data
     * @param $targetCharset
     *
     * @return string
     */
    public function characet($data, $targetCharset)
    {
        if (!empty($data)) {
            $fileType = $this->charset;
            if (0 != strcasecmp($fileType, $targetCharset)) {
                $data = mb_convert_encoding($data, $targetCharset, $fileType);
                //$data = iconv($fileType, $targetCharset.'//IGNORE', $data);
            }
        }

        return $data;
    }


    function is_mobile()
    {


        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            return true;
        } else {
            return false;
        }


    }


}
