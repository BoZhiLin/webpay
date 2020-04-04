<?php

namespace App\Packages;

class NewebpayPackage
{
    public static function mpg(array $data)
    {
        $tradeInfo = [
            'MerchantID' => env('MERCHANT_ID'),
            'RespondType' => 'JSON',
            'TimeStamp' => strtotime('now'),
            'Version' => '1.4',
            'MerchantOrderNo' => $data['id'],
            'Amt' => $data['price'],
            'ItemDesc' => $data['products']
        ];

        $tradeInfo = static::create_mpg_aes_encrypt($tradeInfo, env('HASH_KEY'), env('HASH_IV'));
        $tradeSHA = 'HashKey='.env('HASH_KEY').'&'.$tradeInfo.'&HashIV='.env('HASH_IV');
        $tradeSHA = strtoupper(hash('sha256', $tradeSHA));
        
        $rawData = [
            /** 商家代號 */
            'MerchantID' => env('MERCHANT_ID'),
            /** 交易資料 AES 加密 */
            'TradeInfo' => $tradeInfo,
            /** 交易資料 SHA256 加密 */
            'TradeSha' => $tradeSHA,
            /** 串接程式版本 */
            'Version' => '1.5',
            /** 回傳格式 */
            'RespondType' => 'JSON',
            /** 時間戳記 */
            'TimeStamp' => strtotime('now'),
            /** 商店訂單編號 */
            'MerchantOrderNo' => $data['id'],
            /** 訂單金額 */
            'Amt' => $data['price'],
            /** 商品資訊 */
            'ItemDesc' => $data['products'],
            /** 付款人電子信箱 */
            'Email' => $data['user']['id'],
            /** 藍新金流會員 */
            'LoginType' => '0',
        ];
        
        $formResult = "<form id='pay' method='post' action='".env('NEWEBPAY_API_URL')."'>";
        
        foreach ($rawData as $key => $value) {
            $formResult .= "<input type='hidden' name='".$key."' value='".$value."'><br>";
        }
        
        $formResult .= "</form>";
        $formResult .= "<script type='text/javascript'>";
        $formResult .= "document.getElementById('pay').submit();";
        $formResult .= "</script>";
        return $formResult;
    }

    /**
     * AES 加密
     */
    public static function create_mpg_aes_encrypt(array $tradeInfo, $hashKey, $hashIV)
    {
        $queryString = !empty($tradeInfo) ? http_build_query($tradeInfo) : '';
        return trim(bin2hex(openssl_encrypt(static::addpadding($queryString), 'aes-256-cbc', $hashKey, OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, $hashIV)));
    }

    /**
     * 協助 AES 加密
     */
    public static function addpadding($string, $blocksize = 32)
    {
        $len = strlen($string);
        $pad = $blocksize - ($len % $blocksize);
        $string .= str_repeat(chr($pad), $pad);
        return $string;
    }

    /**
     * AES 解密
     */
    public static function create_aes_decrypt($tradeInfo)
    {
        return static::strippadding(
            openssl_decrypt(hex2bin($tradeInfo), 'AES-256-CBC', env('HASH_KEY'), OPENSSL_RAW_DATA|OPENSSL_ZERO_PADDING, env('HASH_IV'))
        );
   }

    /**
     * 協助 AES 解密
     */
    public static function strippadding($string)
    {
        $slast = ord(substr($string, -1));
        $slastc = chr($slast);
        $pcheck = substr($string, -$slast);
        if (preg_match("/$slastc{" . $slast . "}/", $string)) {
            $string = substr($string, 0, strlen($string) - $slast);
            return $string;
        } else {
            return false;
        }
    }
}
