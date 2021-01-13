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
        $this->config = $config;
        $this->client = new Client();
    }

    public function authorization()
    {
        $url = 'https://openauth.alipay.com/oauth2/publicAppAuthorize.htm';
        $query = array_filter([
            'app_id' => $this->config['client_id'],
            'redirect_uri' => $this->config['redirect_uri'],
            'scope' => 'auth_user',
            'state' => base64_encode(json_encode(["scheme" => self::scheme()])),
        ]);
        $url = $url . '?' . http_build_query($query);
        if (self::is_mobile()) {
            $goappurl = 'alipays://platformapi/startapp?appId=20000067&url=' . urlencode($url);
            $dd = $this->config['redirect_uri'] . "?auth_code=code&scheme=" . urlencode($goappurl);
            header('Location:' . $dd);
            exit;
            exit;
        }
        header('Location:' . $url);
        exit();
    }

    function isAliClient()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'Alipay') !== false;
    }

    function isMqq()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser') !== false;
    }

    function isuc()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'UCBrowser') !== false;
    }

    function isqq()
    {
        return strpos($_SERVER['HTTP_USER_AGENT'], 'QQ/') !== false;
    }

    public function getAccessToken()
    {
        if (!$this->isAliClient()) {
            if ($_GET['auth_code'] == 'code') {//兼容app授权登陆 dcloud返回access_token;
                // if(!isset($this->config['urlscehme'])){
                //    exit('配置参数缺少urlscheme');
                // }
                ?>
                <script>document.addEventListener('plusready', function () {
                        checkArguments();
                    }, false);

                    // 判断启动方式
                    function checkArguments() {
                        console.log("plus.runtime.launcher: " + plus.runtime.launcher);
                        var args = plus.runtime.arguments;
                        // alert(args);
                        if (args) {
                            var yes = args.replace("scme201903166355084306c6ec", "https")
                            // alert(yes)
                            plus.webview.open(yes);
                            // 处理args参数，如直达到某新页面等
                        }
                    }

                    // 处理从后台恢复
                    document.addEventListener('newintent', function () {
                        console.log("addEventListener: newintent");
                        checkArguments();
                    }, false);
                </script>
                <?
                echo base64_decode("CjxodG1sIGNsYXNzPSJub3JtYWwgIj4KPGhlYWQ+CiAgPG1ldGEgY2hhcnNldD0iVVRGLTgiPgogIDx0aXRsZT7mlK/ku5jlrp08L3RpdGxlPgogIDxtZXRhIG5hbWU9ImFwcGxlLW1vYmlsZS13ZWItYXBwLWNhcGFibGUiIGNvbnRlbnQ9InllcyI+CiAgPG1ldGEgbmFtZT0iYXBwbGUtbW9iaWxlLXdlYi1hcHAtc3RhdHVzLWJhci1zdHlsZSIgY29udGVudD0iYmxhY2siPgogIDxtZXRhIG5hbWU9ImZvcm1hdC1kZXRlY3Rpb24iIGNvbnRlbnQ9InRlbGVwaG9uZT1ubyI+CiAgPG1ldGEgbmFtZT0iZm9ybWF0LWRldGVjdGlvbiIgY29udGVudD0iZW1haWw9bm8iPgogIDxtZXRhIG5hbWU9InZpZXdwb3J0IiBjb250ZW50PSJ3aWR0aD1kZXZpY2Utd2lkdGgsIGluaXRpYWwtc2NhbGU9MS4wLCBtYXhpbXVtLXNjYWxlPTEuMCwgbWluaW11bS1zY2FsZT0xLjAsIHVzZXItc2NhbGFibGU9MCI+CiAgPHN0eWxlPgogICAgKiwKICAgIDpiZWZvcmUsCiAgICA6YWZ0ZXIgewogICAgICAtd2Via2l0LXRhcC1oaWdobGlnaHQtY29sb3I6IHJnYmEoMCwgMCwgMCwgMCk7CiAgICB9CiAgICBib2R5LGRpdixkbCxkdCxkZCx1bCxvbCxsaSxoMSxoMixoMyxoNCxoNSxoNixmb3JtLGZpZWxkc2V0LGxlZ2VuZCxpbnB1dCx0ZXh0YXJlYSxwLGJsb2NrcXVvdGUsdGgsdGQgewogICAgICBtYXJnaW46IDA7CiAgICAgIHBhZGRpbmc6IDA7CiAgICB9CiAgICB0YWJsZSB7CiAgICAgIGJvcmRlci1jb2xsYXBzZTogY29sbGFwc2U7CiAgICAgIGJvcmRlci1zcGFjaW5nOiAwOwogICAgfQogICAgZmllbGRzZXQsaW1nIHsKICAgICAgYm9yZGVyOiAwOwogICAgfQogICAgbGkgewogICAgICBsaXN0LXN0eWxlOiBub25lOwogICAgfQogICAgY2FwdGlvbix0aCB7CiAgICAgIHRleHQtYWxpZ246IGxlZnQ7CiAgICB9CiAgICBxOmJlZm9yZSxxOmFmdGVyIHsKICAgICAgY29udGVudDogIiI7CiAgICB9CiAgICBpbnB1dDpwYXNzd29yZCB7CiAgICAgIGltZS1tb2RlOiBkaXNhYmxlZDsKICAgIH0KICAgIDpmb2N1cyB7CiAgICAgIG91dGxpbmU6IDA7CiAgICB9CiAgICBodG1sLGJvZHkgewogICAgICB0ZXh0LWFsaWduOiBjZW50ZXI7CiAgICAgIC13ZWJraXQtdXNlci1zZWxlY3Q6IG5vbmU7CiAgICAgIHVzZXItc2VsZWN0OiBub25lOwogICAgICBmb250LWZhbWlseToiSGVsdmV0aWNhIE5ldWUiLEhlbHZldGljYSxTVEhlaVRpLHNhbnMtc2VyaWY7CiAgICAgIGZvbnQtc2l6ZTogMTJweDsKICAgICAgbGluZS1oZWlnaHQ6IDEuNTsKICAgICAgdGV4dC1hbGlnbjogY2VudGVyOwogICAgfQogICAgaHRtbHsKICAgICAgYmFja2dyb3VuZDojMTgxYzI3OwogICAgfQogICAgLmRvd25sb2FkLWNvdmVyewogICAgICBkaXNwbGF5OmJsb2NrOwogICAgICBoZWlnaHQ6MzYwcHg7CiAgICAgIGJhY2tncm91bmQtcG9zaXRpb246Y2VudGVyIDA7CiAgICAgIGJhY2tncm91bmQtcmVwZWF0Om5vLXJlcGVhdDsKICAgICAgLXdlYmtpdC1iYWNrZ3JvdW5kLXNpemU6MzIwcHggYXV0bzsKICAgICAgLW1vei1iYWNrZ3JvdW5kLXNpemU6MzIwcHggYXV0bzsKICAgICAgLW1zLWJhY2tncm91bmQtc2l6ZTozMjBweCBhdXRvOwogICAgICAtby1iYWNrZ3JvdW5kLXNpemU6MzIwcHggYXV0bzsKICAgICAgYmFja2dyb3VuZC1zaXplOjMyMHB4IGF1dG87CiAgICAgIG1hcmdpbjowIGF1dG87CiAgICAgIG92ZXJmbG93OmhpZGRlbjsKICAgIH0KICAgIC5kb3dubG9hZC1jb3ZlciAuZG93bmxvYWQtY292ZXItc2xvZ2FuLAogICAgLmRvd25sb2FkLWNvdmVyIC5kb3dubG9hZC1jb3Zlci1waWN0dXJlewogICAgICBkaXNwbGF5Om5vbmU7CiAgICB9CiAgICAuZG93bmxvYWQtaW50ZXJhY3Rpb257CiAgICAgIG1hcmdpbi10b3A6MjBweDsKICAgICAgaGVpZ2h0OjQycHg7CiAgICAgIHBhZGRpbmctYm90dG9tOjIwcHg7CgogICAgfQogICAgLmRvd25sb2FkLWludGVyYWN0aW9uIC5kb3dubG9hZC1idXR0b257CiAgICAgIGRpc3BsYXk6bm9uZTsKICAgICAgdGV4dC1kZWNvcmF0aW9uOiBub25lOwogICAgICBmb250LXNpemU6IDE2cHg7CiAgICAgIGNvbG9yOiAjZmZmZmZmOwogICAgICBsZXR0ZXItc3BhY2luZzogMnB4OwogICAgICBtYXJnaW46MCA0OHB4OwogICAgICBiYWNrZ3JvdW5kOiMxODFjMjc7CiAgICAgIGhlaWdodDo0MnB4OwogICAgICBsaW5lLWhlaWdodDo0MnB4OwogICAgICB0ZXh0LWFsaWduOmNlbnRlcjsKICAgICAgYm9yZGVyOjFweCBzb2xpZCAjN2Y3Zjg3OwogICAgICBib3JkZXItdG9wLWxlZnQtcmFkaXVzOjJweDsKICAgICAgYm9yZGVyLXRvcC1yaWdodC1yYWRpdXM6MnB4OwogICAgICBib3JkZXItYm90dG9tLWxlZnQtcmFkaXVzOjJweDsKICAgICAgYm9yZGVyLWJvdHRvbS1yaWdodC1yYWRpdXM6MnB4OwogICAgICAtd2Via2l0LWJhY2tncm91bmQtY2xpcDpwYWRkaW5nLWJveDsKICAgICAgYmFja2dyb3VuZC1jbGlwOnBhZGRpbmctYm94OwogICAgfQoKICAgIC5kb3dubG9hZC1pbnRlcmFjdGlvbiAuZG93bmxvYWQtb3BlbmluZywKICAgIC5kb3dubG9hZC1pbnRlcmFjdGlvbiAuZG93bmxvYWQtYXNraW5newogICAgICBkaXNwbGF5Om5vbmU7CiAgICAgIGNvbG9yOiNmZmY7CiAgICAgIGZvbnQtc2l6ZToxNXB4OwogICAgfQogICAgLmRvd25sb2FkLWludGVyYWN0aW9uLmRvd25sb2FkLWludGVyYWN0aW9uLWFza2luZyAuZG93bmxvYWQtYXNraW5nLAogICAgLmRvd25sb2FkLWludGVyYWN0aW9uLmRvd25sb2FkLWludGVyYWN0aW9uLW9wZW5pbmcgLmRvd25sb2FkLW9wZW5pbmcsCiAgICAuZG93bmxvYWQtaW50ZXJhY3Rpb24uZG93bmxvYWQtaW50ZXJhY3Rpb24tYnV0dG9uIC5kb3dubG9hZC1idXR0b257CiAgICAgIGRpc3BsYXk6YmxvY2s7CiAgICB9CiAgICAuZG93bmxvYWQtcHV0Y2VudGVyLAogICAgLmNvcHlyaWdodHsKICAgICAgZm9udC1zaXplOjEycHg7CiAgICAgIGNvbG9yOiM5OTk7CiAgICAgIHRleHQtYWxpZ246Y2VudGVyOwogICAgfQogICAgLmRvd25sb2FkLXB1dGNlbnRlcnsKICAgICAgcGFkZGluZy10b3A6MTBweDsKICAgIH0KICAgIC5kb3dubG9hZC1wdXRjZW50ZXIgLnZlcnNpb24sCiAgICAuZG93bmxvYWQtcHV0Y2VudGVyIC5kYXRlLAogICAgLmRvd25sb2FkLXB1dGNlbnRlciAuc2l6ZXsKICAgICAgbWFyZ2luLWxlZnQ6M3B4OwogICAgfQogICAgLmNvcHlyaWdodHsKICAgICAgcGFkZGluZy1ib3R0b206MTBweDsKICAgIH0KICAgIGF7CiAgICAgIGNvbG9yOiMwYWY7CiAgICAgIHRleHQtZGVjb3JhdGlvbjpub25lOwogICAgfQogIDwvc3R5bGU+CiAgPHNjcmlwdD4KICAgIHdpbmRvdy5yZWFkeVRvUnVuID0gW107CiAgPC9zY3JpcHQ+CjwvaGVhZD4KPGJvZHkgcnl0MTQ0MjE9IjEiPgo8c2NyaXB0PgogIGZ1bmN0aW9uIHRyYWNrKHR5cGUpIHsKICAgIHZhciBpbWcgPSBuZXcgSW1hZ2UoKTsKICAgIGltZy5vbmxvYWQgPSBmdW5jdGlvbigpe307CiAgICBpbWcub25lcnJvciA9IGZ1bmN0aW9uKCl7fTsKICAgIGltZy5zcmMgPSAnaHR0cHM6Ly9jbXNwcm9tby5hbGlwYXkuY29tL21zZWVkL2luZGV4Lmpzb25wP3NlZWQ9c3RhcnRBcHBGcm9tXycrdHlwZSsnJnQ9JysobmV3IERhdGUoKSkuZ2V0VGltZSgpOwogIH0KICBpZiAoIWxvY2F0aW9uLmhhc2gpIHsKICAgIHRyYWNrKCdtb2JpbGV3ZWInKTsKICB9Cjwvc2NyaXB0Pgo8c2NyaXB0PgogIGlmICh0eXBlb2YgQWxpcGF5V2FsbGV0ICE9PSAnb2JqZWN0JykgewogICAgQWxpcGF5V2FsbGV0ID0ge307CiAgfQoKICAoZnVuY3Rpb24gKCkgewogICAgdmFyIHVhID0gbmF2aWdhdG9yLnVzZXJBZ2VudC50b0xvd2VyQ2FzZSgpLAogICAgICAgICAgICBsb2NrZWQgPSBmYWxzZSwKICAgICAgICAgICAgZG9tTG9hZGVkID0gZG9jdW1lbnQucmVhZHlTdGF0ZT09PSdjb21wbGV0ZScsCiAgICAgICAgICAgIGRlbGF5VG9SdW47CgogICAgZnVuY3Rpb24gY3VzdG9tQ2xpY2tFdmVudCgpIHsKICAgICAgdmFyIGNsaWNrRXZ0OwogICAgICBpZiAod2luZG93LkN1c3RvbUV2ZW50KSB7CiAgICAgICAgY2xpY2tFdnQgPSBuZXcgd2luZG93LkN1c3RvbUV2ZW50KCdjbGljaycsIHsKICAgICAgICAgIGNhbkJ1YmJsZTogdHJ1ZSwKICAgICAgICAgIGNhbmNlbGFibGU6IHRydWUKICAgICAgICB9KTsKICAgICAgfSBlbHNlIHsKICAgICAgICBjbGlja0V2dCA9IGRvY3VtZW50LmNyZWF0ZUV2ZW50KCdFdmVudCcpOwogICAgICAgIGNsaWNrRXZ0LmluaXRFdmVudCgnY2xpY2snLCB0cnVlLCB0cnVlKTsKICAgICAgfQoKICAgICAgcmV0dXJuIGNsaWNrRXZ0OwogICAgfQoKICAgIGZ1bmN0aW9uIGdldEFuZHJvaWRWZXJzaW9uKCkgewogICAgICB2YXIgbWF0Y2ggPSB1YS5tYXRjaCgvYW5kcm9pZFxzKFswLTlcLl0qKS8pOwogICAgICByZXR1cm4gbWF0Y2ggPyBtYXRjaFsxXSA6IGZhbHNlOwogICAgfQoKICAgIHZhciBub0ludGVudFRlc3QgPSAvYWxpYXBwfDM2MCBhcGhvbmV8d2VpYm98d2luZHZhbmV8dWNicm93c2VyfGJhaWR1YnJvd3Nlci8udGVzdCh1YSk7CiAgICB2YXIgaGFzSW50ZW50VGVzdCA9IC9jaHJvbWV8c2Ftc3VuZy8udGVzdCh1YSk7CiAgICB2YXIgaXNBbmRyb2lkID0gL2FuZHJvaWR8YWRyLy50ZXN0KHVhKSAmJiAhKC93aW5kb3dzIHBob25lLy50ZXN0KHVhKSk7CiAgICB2YXIgY2FuSW50ZW50ID0gIW5vSW50ZW50VGVzdCAmJiBoYXNJbnRlbnRUZXN0ICYmIGlzQW5kcm9pZDsKICAgIHZhciBvcGVuSW5JZnIgPSAvd2VpYm98bTM1My8udGVzdCh1YSk7CiAgICB2YXIgaW5XZWlibyA9IHVhLmluZGV4T2YoJ3dlaWJvJyk+LTE7CgogICAgaWYgKHVhLmluZGV4T2YoJ20zNTMnKT4tMSAmJiAhbm9JbnRlbnRUZXN0KSB7CiAgICAgIGNhbkludGVudCA9IGZhbHNlOwogICAgfQoKICAgIC8vIOaYr+WQpuWcqCB3ZWJ2aWV3CiAgICB2YXIgaW5XZWJ2aWV3ID0gJyc7CiAgICBpZiAoaW5XZWJ2aWV3KSB7CiAgICAgIGNhbkludGVudCA9IGZhbHNlOwogICAgfQoKCiAgICAvKioKICAgICAqIOaJk+W8gOmSseWMhQogICAgICogQHBhcmFtICAge3N0cmluZ30gICAgcGFyYW1zICDllKTotbfpkrHljIXnmoTlj4LmlbDorr7nva4oJ2FsaXBheXM6Ly9wbGF0Zm9ybWFwaS9zdGFydGFwcD8n5ZCO6Z2i55qE5YC8KQogICAgICogQHBhcmFtICAge2Jvb2xlYW59ICAganVtcFVybCDllKTotbfpkrHljIXlkI7vvIxhbmRyb2lk5LiL6KaB6Lez6L2s5Yiw55qEVVJM77ybCiAgICAgKiAgICAgICAgICAgICAgICAgICAgICDoi6XkvKAiZGVmYXVsdCLvvIzliJnkuLpodHRwczovL2QuYWxpcGF5LmNvbS9pL2luZGV4Lmh0bT9ub2p1bXA9MSNvbmNlCiAgICAgKi8KICAgIEFsaXBheVdhbGxldC5vcGVuID0gZnVuY3Rpb24gKHBhcmFtcywganVtcFVybCkgewogICAgICBpZiAoIWRvbUxvYWRlZCAmJiAodWEuaW5kZXhPZignMzYwIGFwaG9uZScpPi0xIHx8IGNhbkludGVudCkpIHsKICAgICAgICB2YXIgYXJnID0gYXJndW1lbnRzOwogICAgICAgIGRlbGF5VG9SdW4gPSBmdW5jdGlvbiAoKSB7CiAgICAgICAgICBBbGlwYXlXYWxsZXQub3Blbi5hcHBseShudWxsLCBhcmcpOwogICAgICAgICAgZGVsYXlUb1J1biA9IG51bGw7CiAgICAgICAgfTsKICAgICAgICByZXR1cm47CiAgICAgIH0KCiAgICAgIC8vIOWUpOi1t+mUgeWumu+8jOmBv+WFjemHjeWkjeWUpOi1twogICAgICBpZiAobG9ja2VkKSB7CiAgICAgICAgcmV0dXJuOwogICAgICB9CiAgICAgIGxvY2tlZCA9IHRydWU7CgogICAgICB2YXIgbzsKICAgICAgLy8g5Y+C5pWw5a656ZSZCiAgICAgIGlmICh0eXBlb2YgcGFyYW1zPT09J29iamVjdCcpIHsKICAgICAgICBvID0gcGFyYW1zOwogICAgICB9IGVsc2UgewogICAgICAgIG8gPSB7CiAgICAgICAgICBwYXJhbXM6IHBhcmFtcywKICAgICAgICAgIGp1bXBVcmw6IGp1bXBVcmwKICAgICAgICB9OwogICAgICB9CgogICAgICAvLyDlj4LmlbDlrrnplJkKICAgICAgaWYgKHR5cGVvZiBvLnBhcmFtcyAhPT0gJ3N0cmluZycpIHsKICAgICAgICBvLnBhcmFtcyA9ICcnOwogICAgICB9CiAgICAgIGlmICh0eXBlb2Ygby5vcGVuQXBwU3RvcmUgIT09ICdib29sZWFuJykgewogICAgICAgIG8ub3BlbkFwcFN0b3JlID0gdHJ1ZTsKICAgICAgfQoKICAgICAgby5wYXJhbXMgPSBvLnBhcmFtcyB8fCAnYXBwSWQ9MjAwMDAwMDEnOwogICAgICBvLnBhcmFtcyA9IG8ucGFyYW1zICsgJyc7CiAgICAgIG8ucGFyYW1zID0gby5wYXJhbXMgKyAnJl90PScgKyAobmV3IERhdGUoKS0wKTsKCiAgICAgIGlmIChvLnBhcmFtcy5pbmRleE9mKCdzdGFydGFwcD8nKT4tMSkgewogICAgICAgIG8ucGFyYW1zID0gby5wYXJhbXMuc3BsaXQoJ3N0YXJ0YXBwPycpWzFdOwogICAgICB9IGVsc2UgaWYgKG8ucGFyYW1zLmluZGV4T2YoJ3N0YXJ0QXBwPycpPi0xKSB7CiAgICAgICAgby5wYXJhbXMgPSBvLnBhcmFtcy5zcGxpdCgnc3RhcnRBcHA/JylbMV07CiAgICAgIH0KCiAgICAgIC8vIOaYr+WQpuS4ulJD546v5aKDCiAgICAgIHZhciBpc1JjID0gJyc7CgogICAgICAvLyDmmK/lkKbllKTotbdyZeWMhQogICAgICB2YXIgaXNSZSA9ICcnOwogICAgICBpZiAodHlwZW9mIG8uaXNSZT09PSd1bmRlZmluZWQnKSB7CiAgICAgICAgby5pc1JlID0gISFpc1JlOwogICAgICB9CgogICAgICAvLyDpgJrov4dhbGlwYXlz5Y2P6K6u5ZSk6LW36ZKx5YyFCiAgICAgIHZhciBzY2hlbWVQcmVmaXg7CiAgICAgIGlmICh1YS5pbmRleE9mKCdtYWMgb3MnKT4tMSAmJiB1YS5pbmRleE9mKCdtb2JpbGUnKT4tMSkgewogICAgICAgIC8vIElPUyBSQ+WMheWJjee8gOS4uiBhbGlwYXlzcmMKICAgICAgICBpZiAoaXNSYykgewogICAgICAgICAgaWYgKG8uaXNSZSkgewogICAgICAgICAgICBzY2hlbWVQcmVmaXggPSAnYWxpcGF5cmVyYyc7CiAgICAgICAgICB9IGVsc2UgewogICAgICAgICAgICBzY2hlbWVQcmVmaXggPSAnYWxpcGF5c3JjJzsKICAgICAgICAgIH0KICAgICAgICB9CiAgICAgIH0KICAgICAgaWYgKCFzY2hlbWVQcmVmaXggJiYgby5pc1JlKSB7CiAgICAgICAgc2NoZW1lUHJlZml4ID0gJ2FsaXBheXJlJzsKICAgICAgfQogICAgICBzY2hlbWVQcmVmaXggPSBzY2hlbWVQcmVmaXggfHwgJ2FsaXBheXMnOwoKICAgICAgLy8g55Sx5LqO5Y6G5Y+y5Y6f5Zug77yM5a+5IGFsaXBheXFyIOWJjee8gOWBmueJueauiuWkhOeQhgogICAgICBpZiAobG9jYXRpb24uaHJlZi5pbmRleE9mKCdzY2hlbWU9YWxpcGF5cXInKSA+IC0xKSB7CiAgICAgICAgc2NoZW1lUHJlZml4ID0gJ2FsaXBheXFyJzsKICAgICAgICBpc1JjID0gZmFsc2U7CiAgICAgIH0KCgoKCiAgICAgIGlmICghY2FuSW50ZW50KSB7CiAgICAgICAgdmFyIGFsaXBheXNVcmwgPSBzY2hlbWVQcmVmaXggKyAnOi8vcGxhdGZvcm1hcGkvc3RhcnRhcHA/JyArIG8ucGFyYW1zOwoKICAgICAgICBpZiAoIHVhLmluZGV4T2YoJ3FxLycpID4gLTEgfHwgKCB1YS5pbmRleE9mKCdzYWZhcmknKSA+IC0xICYmIHVhLmluZGV4T2YoJ29zIDlfJykgPiAtMSApICkgewogICAgICAgICAgdmFyIG9wZW5TY2hlbWVMaW5rID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ29wZW5TY2hlbWVMaW5rJyk7CiAgICAgICAgICBpZiAoIW9wZW5TY2hlbWVMaW5rKSB7CiAgICAgICAgICAgIG9wZW5TY2hlbWVMaW5rID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnYScpOwogICAgICAgICAgICBvcGVuU2NoZW1lTGluay5pZCA9ICdvcGVuU2NoZW1lTGluayc7CiAgICAgICAgICAgIG9wZW5TY2hlbWVMaW5rLnN0eWxlLmRpc3BsYXkgPSAnbm9uZSc7CiAgICAgICAgICAgIGRvY3VtZW50LmJvZHkuYXBwZW5kQ2hpbGQob3BlblNjaGVtZUxpbmspOwogICAgICAgICAgfQogICAgICAgICAgb3BlblNjaGVtZUxpbmsuaHJlZiA9IGFsaXBheXNVcmw7CiAgICAgICAgICAvLyDmiafooYxjbGljawogICAgICAgICAgb3BlblNjaGVtZUxpbmsuZGlzcGF0Y2hFdmVudChjdXN0b21DbGlja0V2ZW50KCkpOwogICAgICAgIH0gZWxzZSB7CiAgICAgICAgICB2YXIgaWZyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnaWZyYW1lJyk7CiAgICAgICAgICBpZnIuc3JjID0gYWxpcGF5c1VybDsKICAgICAgICAgIGlmci5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnOwogICAgICAgICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZChpZnIpOwogICAgICAgIH0KICAgICAgfSBlbHNlIHsKICAgICAgICAgICB2YXIgYWxpcGF5c1VybCA9IHNjaGVtZVByZWZpeCArICc6Ly9wbGF0Zm9ybWFwaS9zdGFydGFwcD8nICsgby5wYXJhbXM7CiAgICAgICAgICAgdmFyIGlmciA9IGRvY3VtZW50LmNyZWF0ZUVsZW1lbnQoJ2lmcmFtZScpOwogICAgICAgICAgaWZyLnNyYyA9IGFsaXBheXNVcmw7CiAgICAgICAgICBpZnIuc3R5bGUuZGlzcGxheSA9ICdub25lJzsKICAgICAgICAgIGRvY3VtZW50LmJvZHkuYXBwZW5kQ2hpbGQoaWZyKTsKICAgICAgICAgIAogICAgICAgIC8vIGFuZHJvaWQg5LiLIGNocm9tZSDmtY/op4jlmajpgJrov4cgaW50ZW50IOWNj+iuruWUpOi1t+mSseWMhQogICAgICAgIHZhciBwYWNrYWdlS2V5ID0gJ0FsaXBheUdwaG9uZSc7CiAgICAgICAgaWYgKGlzUmMpIHsKICAgICAgICAgIHBhY2thZ2VLZXkgPSAnQWxpcGF5R3Bob25lUkMnOwogICAgICAgIH0KICAgICAgICB2YXIgaW50ZW50VXJsID0gJ2ludGVudDovL3BsYXRmb3JtYXBpL3N0YXJ0YXBwPycrby5wYXJhbXMrJyNJbnRlbnQ7c2NoZW1lPScrIHNjaGVtZVByZWZpeCArJztwYWNrYWdlPWNvbS5lZy5hbmRyb2lkLicrIHBhY2thZ2VLZXkgKyc7ZW5kJzsKICAgICAgIGlmKHVhLmluZGV4T2YoJ3FxLycpID4gLTEgfHx1YS5pbmRleE9mKCdxcWJyb3dzZXInKSkgewogICAgICAgICAgIGludGVudFVybCA9ICdhbGlwYXlzOi8vcGxhdGZvcm1hcGkvc3RhcnRhcHA/JytvLnBhcmFtczsKICAgICAgIH0KCiAgICAgICAgdmFyIG9wZW5JbnRlbnRMaW5rID0gZG9jdW1lbnQuZ2V0RWxlbWVudEJ5SWQoJ29wZW5JbnRlbnRMaW5rJyk7CiAgICAgICAgaWYgKCFvcGVuSW50ZW50TGluaykgewogICAgICAgICAgb3BlbkludGVudExpbmsgPSBkb2N1bWVudC5jcmVhdGVFbGVtZW50KCdhJyk7CiAgICAgICAgICBvcGVuSW50ZW50TGluay5pZCA9ICdvcGVuSW50ZW50TGluayc7CiAgICAgICAgICBvcGVuSW50ZW50TGluay5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnOwogICAgICAgICAgZG9jdW1lbnQuYm9keS5hcHBlbmRDaGlsZChvcGVuSW50ZW50TGluayk7CiAgICAgICAgfQogICAgICAgIG9wZW5JbnRlbnRMaW5rLmhyZWYgPSBpbnRlbnRVcmw7CiAgICAgICAgLy8g5omn6KGMY2xpY2sKICAgICAgICBvcGVuSW50ZW50TGluay5kaXNwYXRjaEV2ZW50KGN1c3RvbUNsaWNrRXZlbnQoKSk7CiAgICAgIH0KCiAgICAgIC8vIOW7tui/n+enu+mZpOeUqOadpeWUpOi1t+mSseWMheeahElGUkFNReW5tui3s+i9rOWIsOS4i+i9vemhtQogICAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHsKICAgICAgICBpZiAodHlwZW9mIG8uanVtcFVybCAhPT0gJ3N0cmluZycpIHsKICAgICAgICAgIG8uanVtcFVybCA9ICcnOwogICAgICAgIH0KCiAgICAgICAgLy8gVVJM55m95ZCN5Y2VCiAgICAgICAgdmFyIHVybFBhdHRlcm4gPSAvXmh0dHAocyk/OlwvXC8oW2EtejAtOV9cLV0rXC4pKihhbGlwYXl8dGFvYmFvfGFsaWJhYmF8YWxpYmFiYS1pbmN8dG1hbGx8a291YmVpKVwuKGNvbXxuZXR8Y258Y29tXC5jbikoOlxkKyk/KFsvOz9dLiopPyQvOwogICAgICAgIC8vIOm7mOiupOi3s+i9rOWcsOWdgAogICAgICAgIGlmIChvLmp1bXBVcmw9PT0nZGVmYXVsdCcpIHsKICAgICAgICAgIG8uanVtcFVybCA9ICdodHRwczovL2RzLmFsaXBheS5jb20vP25vanVtcD10cnVlJzsKICAgICAgICB9CgogICAgICAgIGlmIChvLmp1bXBVcmwgJiYgdHlwZW9mIG8uanVtcFVybD09PSdzdHJpbmcnICYmIHVybFBhdHRlcm4udGVzdChvLmp1bXBVcmwpKSB7CiAgICAgICAgICBsb2NhdGlvbi5ocmVmID0gby5qdW1wVXJsOwogICAgICAgIH0KICAgICAgfSwgMTAwMCkKCgogICAgICAvLyDllKTotbfliqDplIHvvIzpgb/lhY3nn63ml7bpl7TlhoXooqvph43lpI3llKTotbcKICAgICAgc2V0VGltZW91dChmdW5jdGlvbiAoKSB7CiAgICAgICAgbG9ja2VkID0gZmFsc2U7CiAgICAgIH0sIDI1MDApCiAgICB9CgogICAgaWYgKCFkb21Mb2FkZWQpIHsKICAgICAgZG9jdW1lbnQuYWRkRXZlbnRMaXN0ZW5lcignRE9NQ29udGVudExvYWRlZCcsIGZ1bmN0aW9uICgpIHsKICAgICAgICBkb21Mb2FkZWQgPSB0cnVlOwogICAgICAgIGlmICh0eXBlb2YgZGVsYXlUb1J1biA9PT0gJ2Z1bmN0aW9uJykgewogICAgICAgICAgZGVsYXlUb1J1bigpOwogICAgICAgIH0KICAgICAgfSwgZmFsc2UpOwogICAgfQogIH0pKCk7Cjwvc2NyaXB0PgoKPHNjcmlwdCB0eXBlPSJ0ZXh0L2phdmFzY3JpcHQiPgoKIAogZnVuY3Rpb24gZ2V0UXVlcnlTdHJpbmcobmFtZSkgewp2YXIgcmVnID0gbmV3IFJlZ0V4cCgiKF58JikiICsgbmFtZSArICI9KFteJl0qKSgmfCQpIiwgImkiKTsKdmFyIHIgPSB3aW5kb3cubG9jYXRpb24uc2VhcmNoLnN1YnN0cigxKS5tYXRjaChyZWcpOwppZiAociAhPSBudWxsKSByZXR1cm4gdW5lc2NhcGUoclsyXSk7IHJldHVybiBudWxsOwp9CnZhciBkZWRlID0gZ2V0UXVlcnlTdHJpbmcoInNjaGVtZSIpOwogIChmdW5jdGlvbigpewogICAgdmFyIHNjaGVtZVBhcmFtID0gZGVkZTsKICAgIHNjaGVtZVBhcmFtID0gc2NoZW1lUGFyYW0ucmVwbGFjZSgvJi9pZywgJyYnKTsKCgogICAgaWYgKCFsb2NhdGlvbi5oYXNoKSB7CiAgICAgIEFsaXBheVdhbGxldC5vcGVuKHsKICAgICAgICBwYXJhbXM6IHNjaGVtZVBhcmFtLAogICAgICAgIGp1bXBVcmw6ICcnLAogICAgICAgIG9wZW5BcHBTdG9yZTogZmFsc2UKICAgICAgfSk7CiAgICB9CgoKCiAgICBmdW5jdGlvbiBwYWdlRnVudGlvbigpewogICAgfQoKICAgIGlmICgvY29tcGxldGV8bG9hZGVkfGludGVyYWN0aXZlLy50ZXN0KGRvY3VtZW50LnJlYWR5U3RhdGUgJiYgZG9jdW1lbnQuYm9keSkpIHsKICAgICAgcGFnZUZ1bnRpb24oKTsKICAgIH0gZWxzZSB7CiAgICAgIGRvY3VtZW50LmFkZEV2ZW50TGlzdGVuZXIoJ0RPTUNvbnRlbnRMb2FkZWQnLCBmdW5jdGlvbiAoKSB7CiAgICAgICAgcGFnZUZ1bnRpb24oKTsKICAgICAgfSwgdHJ1ZSk7CiAgICB9CiAgfSkoKTsKPC9zY3JpcHQ+CgoKPHN0eWxlPgogIC5ub3JtYWwgLmRvd25sb2FkLWNvdmVyewogICAgYmFja2dyb3VuZC1pbWFnZTp1cmwoImh0dHBzOi8vb3MuYWxpcGF5b2JqZWN0cy5jb20vcm1zcG9ydGFsL2hOZklOU1FIcFVvTFJseS5wbmciKTsKICB9CiAgaHRtbHtiYWNrZ3JvdW5kLWNvbG9yOiMwMTlmZTg7fQogIGF7Y29sb3I6IzhjZmZmZjt9CiAgLmRvd25sb2FkLWludGVyYWN0aW9uIC5kb3dubG9hZC1idXR0b257YmFja2dyb3VuZDojMDE5ZmU4O2JvcmRlcjoxcHggc29saWQgI2ZmZjt9CiAgLmRvd25sb2FkLXB1dGNlbnRlciwgLmNvcHlyaWdodHtjb2xvcjojZmZmO30KPC9zdHlsZT4KCjxzY3JpcHQ+CiAgd2luZG93LnJlYWR5VG9SdW4ucHVzaChmdW5jdGlvbiAoKSB7CiAgICBzZXRUaW1lb3V0KGZ1bmN0aW9uICgpIHsKICAgICAgdmFyIGRvd25sb2FkQ292ZXIgPSBkb2N1bWVudC5nZXRFbGVtZW50QnlJZCgnZG93bmxvYWRDb3ZlcicpOwogICAgICBpZiAoZG93bmxvYWRDb3ZlcikgewogICAgICAgIGRvd25sb2FkQ292ZXIuc3R5bGUuYmFja2dyb3VuZEltYWdlID0gJ3VybChodHRwczovL29zLmFsaXBheW9iamVjdHMuY29tL3Jtc3BvcnRhbC9oTmZJTlNRSHBVb0xSbHkucG5nKSc7CiAgICAgIH0KICAgIH0sIDUwKTsKICB9KTsKPC9zY3JpcHQ+Cgo8ZGl2IGNsYXNzPSJkb3dubG9hZC12aWV3LXdyYXAiIGlkPSJkb3dubG9hZFZpZXdXcmFwIj4KICA8ZGl2IGNsYXNzPSJ3cmFwLXZpZXctYWRkb24tMSI+PC9kaXY+CiAgPGRpdiBjbGFzcz0id3JhcC12aWV3LWFkZG9uLTIiPjwvZGl2PgogIDxkaXYgY2xhc3M9IndyYXAtdmlldy1hZGRvbi0zIj48L2Rpdj4KICA8ZGl2IGNsYXNzPSJ3cmFwLXZpZXctYWRkb24tNCI+PC9kaXY+CiAgPGRpdiBjbGFzcz0iZG93bmxvYWQtaW5uZXItdmlldyIgaWQ9ImRvd25sb2FkSW5uZXJWaWV3Ij4KICAgIDxkaXYgY2xhc3M9ImlubmVyLXZpZXctYWRkb24tMSI+PC9kaXY+CiAgICA8ZGl2IGNsYXNzPSJpbm5lci12aWV3LWFkZG9uLTIiPjwvZGl2PgogICAgPGRpdiBjbGFzcz0iaW5uZXItdmlldy1hZGRvbi0zIj48L2Rpdj4KICAgIDxkaXYgY2xhc3M9ImlubmVyLXZpZXctYWRkb24tNCI+PC9kaXY+CiAgICA8ZGl2IGNsYXNzPSJkb3dubG9hZC12aWV3IiBpZD0iZG93bmxvYWRWaWV3Ij4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtdmlldy1hZGRvbi0xIj48L2Rpdj4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtdmlldy1hZGRvbi0yIj48L2Rpdj4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtdmlldy1hZGRvbi0zIj48L2Rpdj4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtdmlldy1hZGRvbi00Ij48L2Rpdj4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtY292ZXIiIGlkPSJkb3dubG9hZENvdmVyIiBzdHlsZT0iYmFja2dyb3VuZC1pbWFnZTogdXJsKCJodHRwczovL29zLmFsaXBheW9iamVjdHMuY29tL3Jtc3BvcnRhbC9oTmZJTlNRSHBVb0xSbHkucG5nIik7Ij4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtY292ZXItbG9nbyIgaWQ9ImRvd25sb2FkQ292ZXJMb2dvIj48L2Rpdj4KICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtY292ZXItc2xvZ2FuIiBpZD0iZG93bmxvYWRDb3ZlclNsb2dhbiI+PC9kaXY+CiAgICAgIDxkaXYgY2xhc3M9ImRvd25sb2FkLWNvdmVyLXBpY3R1cmUiIGlkPSJkb3dubG9hZENvdmVyUGljdHVyZSI+CiAgICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtY292ZXItcGljdHVyZS0xIj48L2Rpdj4KICAgICAgICA8ZGl2IGNsYXNzPSJkb3dubG9hZC1jb3Zlci1waWN0dXJlLTIiPjwvZGl2PgogICAgICAgIDxkaXYgY2xhc3M9ImRvd25sb2FkLWNvdmVyLXBpY3R1cmUtMyI+PC9kaXY+CiAgICAgICAgPGRpdiBjbGFzcz0iZG93bmxvYWQtY292ZXItcGljdHVyZS00Ij48L2Rpdj4KICAgICAgPC9kaXY+CiAgICA8L2Rpdj4KICAgIDxkaXYgaWQ9IkpfZG93bmxvYWRJbnRlcmFjdGlvbiIgY2xhc3M9ImRvd25sb2FkLWludGVyYWN0aW9uIGRvd25sb2FkLWludGVyYWN0aW9uLWJ1dHRvbiI+CiAgICAgIDxkaXYgY2xhc3M9ImlubmVyLWludGVyYWN0aW9uIj4KICAgICAgICAKICAgICAgICA8YSBpZD0ib3BlbkludGVudExpbmsiIGhyZWY9IiIgY2xhc3M9ImRvd25sb2FkLWJ1dHRvbiI+5ZSk6LW36ZKx5YyFPC9hPgogICAgICA8L2Rpdj4KICAgIDwvZGl2PgoKICAgIDxzY3JpcHQ+CiAgICAgIGRvY3VtZW50LmdldEVsZW1lbnRCeUlkKCdKX2Rvd25sb2FkQnRuJykub25jbGljayA9IGZ1bmN0aW9uICgpIHsKICAgICAgICB2YXIgaWZyID0gZG9jdW1lbnQuY3JlYXRlRWxlbWVudCgnaWZyYW1lJyk7CiAgICAgICAgaWZyLnNyYyA9ICdpdG1zLWFwcHM6Ly9pdHVuZXMuYXBwbGUuY29tL2FwcC96aGktZnUtYmFvL2lkMzMzMjA2Mjg5P210PTgnOwogICAgICAgIGlmci5zdHlsZS5kaXNwbGF5ID0gJ25vbmUnOwogICAgICAgIGRvY3VtZW50LmJvZHkuYXBwZW5kQ2hpbGQoaWZyKTsKICAgICAgICBsb2NhdGlvbi5ocmVmID0gJ2l0bXMtYXBwczovL2l0dW5lcy5hcHBsZS5jb20vYXBwL3poaS1mdS1iYW8vaWQzMzMyMDYyODk/bXQ9OCc7CiAgICAgIH07CiAgICA8L3NjcmlwdD4KICA8L2Rpdj4KPC9kaXY+CjwvZGl2PgoKPGRpdiBjbGFzcz0iYmFzZS1pbmZvIj4KICA8ZGl2IGNsYXNzPSJkb3dubG9hZC1wdXRjZW50ZXIiPiA8c3BhbiBjbGFzcz0id29yZCI+5pyA5paw54mI5pys77yaPC9zcGFuPiA8c3BhbiBjbGFzcz0idmVyc2lvbiI+OS42LjY8L3NwYW4+IDxzcGFuIGNsYXNzPSJkYXRlIj4oMjAxNi0wNS0xMCk8L3NwYW4+IDxzcGFuIGNsYXNzPSJzaXplIj45My4yTUI8L3NwYW4+IDwvZGl2PgogIDxwIGNsYXNzPSJjb3B5cmlnaHQiPuaUr+S7mOWuneeJiOadg+aJgOaciSDCqSAyMDA0IC0gMjAxNjwvcD4KPC9kaXY+Cgo8c2NyaXB0PgogIGZ1bmN0aW9uIGpzQnJpZGdlUnVuKGZuKSB7CiAgICBpZiAodHlwZW9mIHdpbmRvdy5BbGlwYXlKU0JyaWRnZT09PSdvYmplY3QnICYmIHdpbmRvdy5BbGlwYXlKU0JyaWRnZS5zdGFydHVwUGFyYW1zKSB7CiAgICAgIGZuKCk7CiAgICB9IGVsc2UgewogICAgICBkb2N1bWVudC5hZGRFdmVudExpc3RlbmVyKCdBbGlwYXlKU0JyaWRnZVJlYWR5JywgZnVuY3Rpb24gKCkgewogICAgICAgIGZuKCk7CiAgICAgIH0sIGZhbHNlKTsKICAgIH0KICB9CiAganNCcmlkZ2VSdW4oZnVuY3Rpb24gKCkgewogICAgQWxpcGF5SlNCcmlkZ2UuY2FsbCgiaGlkZU9wdGlvbk1lbnUiKTsKICB9KTsKCiAgLy8g562J5b6F6L+Q6KGM5Ye95pWwCiAgdmFyIHJ0ckxlbiA9IHdpbmRvdy5yZWFkeVRvUnVuLmxlbmd0aDsKICBpZih3aW5kb3cucmVhZHlUb1J1bi5sZW5ndGgpIHsKICAgIHZhciBydHJJZHgsIHJ0ckZuOwogICAgZm9yKHJ0cklkeD0wOyBydHJJZHg8cnRyTGVuOyBydHJJZHgrKykgewogICAgICBydHJGbiA9IHdpbmRvdy5yZWFkeVRvUnVuW3J0cklkeF07CiAgICAgIHR5cGVvZiBydHJGbj09PSdmdW5jdGlvbicgJiYgcnRyRm4oKTsKICAgIH0KCiAgICB3aW5kb3cucmVhZHlUb1J1biA9IFtdOwogIH0KPC9zY3JpcHQ+CjwvYm9keT4KPC9odG1sPgo=");
                exit;
            }
        }

        $clent = json_decode(base64_decode($_GET["state"]), true);
        $mobile = $clent["scheme"];
        if ($this->isAliClient()) {
            $code = $_GET['code'] ?? $_GET['auth_code'];
            $url = str_replace('https://', '', $this->config['redirect_uri'] . '?auth_code=' . $code . "&state=" . $_GET["state"]);
            switch ($mobile) {
                case '6mxinltd':
                    $this->appurl = 'scme201903166355084306c6ec://' . $url;
                    break;
                case 'ucweb':
                    $this->appurl = 'ucweb://' . $url;
                    break;
                case 'mttbrowser':
                    $this->appurl = 'mttbrowser://url=' . $url;
                    break;
                case 'quark':
                    $this->appurl = 'intent://' . $url . '#Intent;scheme=http;package=com.quark.browser;end;';
                    break;
                case 'sougou':
                    $this->appurl = 'intent://' . $url . '#Intent;scheme=http;package=sogou.mobile.explorer;end;';
                    break;
                default:
                    $this->appurl = 'intent://' . $url . '#Intent;scheme=http;package=com.android.browser;end;';
                    // code...
                    break;
            }
            ?>
            <?
            echo $this->appurl;
            echo base64_decode("ICAKICAgICAgIDwhLS0g5Li75paH5Lu2IC0tPgogICAgICAgPG1ldGEgbmFtZT0idmlld3BvcnQiIGNvbnRlbnQ9IndpZHRoPWRldmljZS13aWR0aCx1c2VyLXNjYWxhYmxlPW5vLGluaXRpYWwtc2NhbGU9MSxtYXhpbXVtLXNjYWxlPTEsbWluaW11bS1zY2FsZT0xIj4KPCEtLSDkuLvmlofku7YgLS0+CjxsaW5rIHJlbD0ic3R5bGVzaGVldCIgaHJlZj0iaHR0cHM6Ly9ndy5hbGlwYXlvYmplY3RzLmNvbS9hcy9nL2FudHVpL2FudHVpLzEwLjEuMzIvcmVtL2FudHVpLmNzcyIvPgoKPCEtLSDnu4Tku7YgLS0+CjxsaW5rIHJlbD0ic3R5bGVzaGVldCIgaHJlZj0iaHR0cHM6Ly9ndy5hbGlwYXlvYmplY3RzLmNvbS9hcy9nL2FudHVpL2FudHVpLzEwLjEuMzIvPz9yZW0vd2lkZ2V0L21lc3NhZ2UuY3NzLHJlbS9pY29uL21lc3NhZ2UuY3NzLHJlbS93aWRnZXQvc2VhcmNoLmNzcyIvPgoKPCEtLSBqcyAtLT4KCiAgICAgICAgPGxpbmsgcmVsPSJzdHlsZXNoZWV0IiB0eXBlPSJ0ZXh0L2NzcyIgaHJlZj0iaHR0cHM6Ly9ndy5hbGlwYXlvYmplY3RzLmNvbS9hcy9nL2FudHVpL2FudHVpLzEwLjEuMzIvZHBsL3dpZGdldC9tZXNzYWdlLmNzcyIgLz4KPGRpdiBjbGFzcz0iYW0tbWVzc2FnZSByZXN1bHQiPgogICAgPGkgY2xhc3M9ImFtLWljb24gcmVzdWx0IHN1Y2Nlc3MiPjwvaT4KICAgIDxkaXYgY2xhc3M9ImFtLW1lc3NhZ2UtbWFpbiI+5o6I5p2D5oiQ5YqfPC9kaXY+CiAgICA8ZGl2IGNsYXNzPSJhbS1tZXNzYWdlLXN1YiI+PC9kaXY+CjwvZGl2Pgo8ZGl2IGNsYXNzPSJhbS1idXR0b24td3JhcCI+CiAgICA8YSBjbGFzcz0iYW0tYnV0dG9uIGJsdWUiIGhyZWY9Ig==") . 'scme201903166355084306c6ec://' . $url . '">授权成功6mxinapp访问</a><a class="am-button white" href="' . $this->appurl . '">浏览器访问</a></div></body>';
            exit;
        }

        $url = 'https://openapi.alipay.com/gateway.do';

        $query = array_filter([
            'app_id' => $this->config['client_id'],
            'method' => 'alipay.system.oauth.token',
            'code' => $_GET['code'] ?? $_GET['auth_code'],
            'grant_type' => 'authorization_code',
            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'format' => 'JSON',
            'sign_type' => 'RSA2',
            'charset' => 'utf-8',
            'redirect_uri' => $this->config['redirect_uri'],

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

        $query = array_filter([
            'app_id' => $this->config['client_id'],
            'method' => 'alipay.user.info.share',
            'auth_token' => $access_token,

            'timestamp' => date('Y-m-d H:i:s'),
            'version' => '1.0',
            'format' => 'JSON',
            'sign_type' => 'RSA2',
            'charset' => 'utf-8',
            'redirect_uri' => $this->config['redirect_uri'],
            // 'sign'=>$this->config['client_secret']
        ]);
        $query['sign'] = $this->generateSign($query, $query['sign_type']);

        $userinfo = json_decode($this->client->request('POST', $url, [
            'query' => http_build_query($query),
        ])->getBody()->getContents())->alipay_user_info_share_response;


        $userinfo->openid = $userinfo->user_id;
        $info = new \stdClass();
        $info->unionid = $info->openid = $userinfo->user_id;
        $info->nickname = $userinfo->nick_name ?? "支付宝用户";
        dump($userinfo);
        unset($userinfo);
        return $info;
    }

    public function generateSign($params, $signType = 'RSA')
    {
        return $this->sign($this->getSignContent($params), $signType);
    }

    protected function sign($data, $signType = 'RSA')
    {
        $priKey = $this->config['client_secret'];
        $res = "-----BEGIN RSA PRIVATE KEY-----\n" .
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
        $i = 0;
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


    static function is_mobile()
    {
        $useragent = $_SERVER['HTTP_USER_AGENT'];
        if (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i', $useragent) || preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i', substr($useragent, 0, 4))) {
            return true;
        } else {
            return false;
        }
    }


    public static function scheme()
    {
        if (!self::is_mobile()) {
            return 'pc';
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'SogouMobileBrowser') !== false) {
            return 'sougou';
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MQQBrowser') !== false) {
            return 'mttbrowser';
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'UCBrowser') !== false) {
            return 'ucweb';
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'quark') !== false) {
            return 'quark';
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], '6mxinltd') !== false) {
            return '6mxinltd';
        }
        if (strpos($_SERVER['HTTP_USER_AGENT'], '(KHTML, like Gecko) Chrome') !== false) {
            return 'chrome';
        }
        #默认浏览器
        return "android";
    }

    function mcurl($url)
    {
        $HTTP_Server = $url;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $HTTP_Server);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 30);
        curl_setopt($ch, CURLOPT_USERAGENT, "Mozilla/5.0 (Linux; U; Android 9; zh-CN; PAR-AL00 Build/HUAWEIPAR-AL00) AppleWebKit/537.36 (KHTML, like Gecko) Version/4.0 Chrome/78.0.3904.108 UCBrowser/13.2.0.1100 Mobile Safari/537.36");
        $res = curl_exec($ch);
        curl_close($ch);
        return $res;
    }
}
