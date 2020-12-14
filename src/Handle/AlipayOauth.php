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
            'state' => 'https://6.mxin.ltd/login/alipay',
        ]);

        $url = $url.'?'.http_build_query($query);

        header('Location:'.$url);
        exit();
    }

    public function getAccessToken()
    {
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
            // 'sign'=>$this->config['client_secret']
        ]);
        $query['sign'] = $this->generateSign($query, $query['sign_type']);

        //retur
        return $this->client->request('POST', $url, [
            'query' => http_build_query($query),
        ])->getBody()->getContents();
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

        $userinfo->unionid = $userinfo->user_id;
        $userinfo->openid = $userinfo->user_id;

        return $userinfo;
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
        $res = "-----BEGIN RSA PRIVATE KEY-----\n".
            wordwrap($priKey, 64, "\n", true).
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
                    $stringToBeSigned .= "$k".'='."$v";
                } else {
                    $stringToBeSigned .= '&'."$k".'='."$v";
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
}
