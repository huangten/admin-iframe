<?php

namespace App\Http\Controllers\Api;

use App\Http\Resources\WechatUserResource;
use App\Services\AliyunOss;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class WechatUserController extends Controller
{
    public function info(Request $request)
    {
        $wechat_user = auth('wechat')->user();

        if ($request->input('upload_avatar_oss')) {
            if (!$wechat_user->avatar_oss || $request->input('update_avatar_oss')) {
                $wechat_user->avatar_oss = AliyunOss::init()->uploadUrl($wechat_user->headimgurl, uniqid().'.jpg', 'avatar');
                $wechat_user->save();
            }
        }

        return WechatUserResource::make($wechat_user);
    }
    public function update(Request $request)
    {
        $user = auth('wechat')->user();

        // 解密
        if ($request->has('data')) {
            $session = $user->session_key;
            $iv = $request->input('iv');
            $app = $this->getApp($user->wechat);
            try {
                $decryptedData = $app->encryptor->decryptData($session, $iv, $request->input('data'));
                if (isset($decryptedData['nickName']) && $decryptedData['nickName']) {
                    $user->nickname = $decryptedData['nickName'];
                }
                if (isset($decryptedData['gender']) && $decryptedData['gender']) {
                    $user->sex = $decryptedData['gender'];
                }
                if (isset($decryptedData['avatarUrl']) && $decryptedData['avatarUrl']) {
                    $user->headimgurl = $decryptedData['avatarUrl'];
                }
                if (isset($decryptedData['province']) && $decryptedData['province']) {
                    $user->province = $decryptedData['province'];
                }
                if (isset($decryptedData['city']) && $decryptedData['city']) {
                    $user->city = $decryptedData['city'];
                }
                $user->save();
            } catch (\EasyWeChat\Kernel\Exceptions\DecryptException $e) {
                return $this->error('解析失败, '.$e->getMessage());
            }
        }
        return $this->json(WechatUserResource::make($user));
    }

    public function decrypt(Request $request)
    {
        $user = auth('wechat')->user();

        $validator = Validator::make($request->all(), [
            'data' => 'required',
            'iv' => 'required'
        ]);
        if ($validator->fails()) {
            return $this->error($validator->errors()->first());
        }

        // 解密
        $session = $user->session_key;
        $iv = $request->input('iv');
        $app = $this->getApp($user->wechat);
        try {
            $decryptedData = $app->encryptor->decryptData($session, $iv, $request->input('data'));
            return $this->json($decryptedData);
        } catch (\EasyWeChat\Kernel\Exceptions\DecryptException $e) {
            return $this->error('解析失败, '.$e->getMessage());
        }
    }
}