<?php
namespace App\Service;

use Firebase\JWT\JWT;

class Utility{
    public static function isSuccessResponse($response){
        if(!empty($response)){
            if(isset($response['status']) && $response['status'] == 'success'){
                return true;
            }
            elseif (isset($response['status']) && $response['status'] == 'error'){
                return false;
            }
        }
        return false;
    }
    public static function checkToken($token)
    {
        if (empty($token)){
            return static::responseFormat('error','Empty Token');
        }
        $token_data =static::decodeToken($token);
        if (!static::isSuccessResponse($token_data)){
            return static::responseFormat('error','Token response empty');
        }else{
            $token_data = json_decode(json_encode($token_data['data']),true);
        }
        if (empty($token_data['data'])){
            return static::responseFormat('error','Token data empty');
        }
        //expiry time check
        if (empty($token_data['exp']) || $token_data['exp'] < time()){
            return static::responseFormat('error','Token expire');
        }

        // issuer time check
        if (empty($token_data['nbf']) || $token_data['nbf'] > time()){
            return static::responseFormat('error','Token used before current time');
        }

        return static::responseFormat('success',$token_data['data']);
    }
    public static function responseFormat($status = 'error', $data = '',$options = []){
        $response = [''];
        if(!empty($status)){
            if($status == 'success'){
                $response = [
                    'status' => $status,
                    'data' => $data
                ];
            }
            elseif ($status == 'error'){
                $response = [
                    'status' => $status,
                    'message' => $data
                ];
                if(!empty($options) && !empty($options['details'])){
                    $response['details'] = $options['details'];
                }
                if(!empty($options) && !empty($options['reason'])){
                    $response['reason'] = $options['reason'];
                }
            }
            if(!empty($options) && !empty($options['code'])){
                $response['code'] = $options['code'];
            }
        }
        return $response;
    }
    public function decodeToken($token,$options = []){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.Error code:2.'
        ];
        try{
            if(empty($token)){
                $response['message'] = 'Required info not given.Code: 2';
                goto rtn;
            }
            $algorithm =empty($options['algorithm'])?JWT_ALGORITHM:$options['algorithm'];
            $secret_key =empty($options['secret_key'])?SECRET_KEY:$options['secret_key'];
            $decoded = JWT::decode($token, $secret_key, array($algorithm));
            if(!empty($decoded)){
                $response = [
                    'status' =>'success',
                    'data' => $decoded,
                ];
            }
        }catch(\Exception $ex){
            $response['message'] ="Could not verify api key " . $ex->getMessage();
        }
        rtn:
        return $response;
    }
    /*
    * JWT token generation
    *
    * @param array $data_to_encrypt which will be encrypted in token
    * @param string $algorithm which algorithm to encrypt data
    *
    * @return array contain status of operation and token if success
    */
    public static function generateToken($data_to_encrypt = [],$options = []){
        $response = [
            'status' =>'error',
            'message' => 'Something went wrong.Error code:5.'
        ];
        try{
            $time = time();
            $expire = $time + (empty($options['expire'])?(3600 * 24 * 1):$options['expire']);
            $algorithm =empty($options['algorithm'])?JWT_ALGORITHM:$options['algorithm'];
            $secret_key =empty($options['secret_key'])?SECRET_KEY:$options['secret_key'];

            $data = [
                'iat' => $time,
                'jti' => base64_encode(rand(1,1000).$time.rand(1,1000)),
                'iss' => $_SERVER['HTTP_HOST'],
                'nbf' => $time,
                'exp' => $expire ,
                'data' => $data_to_encrypt
            ];
            $token = JWT::encode(
                $data, //Data to be encoded in the JWT
                $secret_key, // The signing key
                $algorithm
            );

            if(!empty($token)){
                $response = [
                    'status' =>'success',
                    'token' => $token,
                    'expire' => $expire
                ];
            }
        }catch(\Exception $ex){
            $response['message'] ="Could not generate api key " . $ex->getMessage();
        }
        rtn:
        return $response;
    }
}
