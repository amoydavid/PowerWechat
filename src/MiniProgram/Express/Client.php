<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\MiniProgram\Express;

use PowerWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author kehuanhuan <1152018701@qq.com>
 */
class Client extends BaseClient
{
    /**
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function listProviders()
    {
        return $this->httpGet('cgi-bin/express/business/delivery/getall');
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function createWaybill(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/order/add', $params);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function deleteWaybill(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/order/cancel', $params);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWaybill(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/order/get', $params);
    }

    /**
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getWaybillTrack(array $params = [])
    {
        return $this->httpPostJson('cgi-bin/express/business/path/get', $params);
    }

    /**
     * @param string $deliveryId
     * @param string $bizId
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getBalance(string $deliveryId, string $bizId)
    {
        return $this->httpPostJson('cgi-bin/express/business/quota/get', [
            'delivery_id' => $deliveryId,
            'biz_id' => $bizId,
        ]);
    }

    /**
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function getPrinter()
    {
        return $this->httpPostJson('cgi-bin/express/business/printer/getall');
    }

    /**
     * @param string $openid
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function bindPrinter(string $openid)
    {
        return $this->httpPostJson('cgi-bin/express/business/printer/update', [
            'update_type' => 'bind',
            'openid' => $openid,
        ]);
    }

    /**
     * @param string $openid
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function unbindPrinter(string $openid)
    {
        return $this->httpPostJson('cgi-bin/express/business/printer/update', [
            'update_type' => 'unbind',
            'openid' => $openid,
        ]);
    }

    /**
     * 第三方代商户发起开通即时配送权限
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function openDelivery(){
        return $this->httpPostJson('cgi-bin/express/local/business/open', [
        ]);
    }

    /**
     * 第三方代商户发起绑定配送公司帐号的请求
     * @param $delivery_id 配送公司ID
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function bindAccount($delivery_id){
        return $this->httpPostJson('cgi-bin/express/local/business/shop/add', [
            'delivery_id'=>$delivery_id
        ]);
    }

    /**
     * 拉取已绑定账号
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getBindAccount(){
        return $this->httpPostJson('cgi-bin/express/local/business/shop/get', [
        ]);
    }

    /**
     * 获取已支持的配送公司列表接口
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getAllImmeDelivery(){
        return $this->httpPostJson('cgi-bin/express/local/business/delivery/getall', [
        ]);
    }

    /**
     * 预下配送单接口
     * 参考文档 https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/immediate-delivery/by-business/immediateDelivery.preAddOrder.html
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $delivery_id
     * @param $openid
     * @param $sender
     * @param $receiver
     * @param $cargo
     * @param $order_info
     * @param $shop
     * @param $sub_biz_id
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function preAddOrder($shopid,$shop_order_id,$shop_no,$delivery_sign,$delivery_id,$openid,$sender,$receiver,$cargo,$order_info,$shop,$sub_biz_id=''){
        return $this->httpPostJson('cgi-bin/express/local/business/order/pre_add', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'delivery_id'=>$delivery_id,
            'openid'=>$openid,
            'sender'=>$sender,
            'receiver'=>$receiver,
            'cargo'=>$cargo,
            'order_info'=>$order_info,
            'shop'=>$shop,
            'sub_biz_id'=>$sub_biz_id
        ]);
    }

    /**
     * 下配送单接口
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $delivery_id
     * @param $openid
     * @param $sender
     * @param $receiver
     * @param $cargo
     * @param $order_info
     * @param $shop
     * @param string $sub_biz_id
     * @param string $delivery_token 预下单接口返回的参数，配送公司可保证在一段时间内运费不变
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function addOrder($shopid,$shop_order_id,$shop_no,$delivery_sign,$delivery_id,$openid,$sender,$receiver,$cargo,$order_info,$shop,$sub_biz_id='',$delivery_token=''){
        return $this->httpPostJson('cgi-bin/express/local/business/order/add', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'delivery_id'=>$delivery_id,
            'openid'=>$openid,
            'sender'=>$sender,
            'receiver'=>$receiver,
            'cargo'=>$cargo,
            'order_info'=>$order_info,
            'shop'=>$shop,
            'sub_biz_id'=>$sub_biz_id,
            'delivery_token'=>$delivery_token,
        ]);
    }

    /**
     * 重新下单
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $delivery_id
     * @param $openid
     * @param $sender
     * @param $receiver
     * @param $cargo
     * @param $order_info
     * @param $shop
     * @param string $sub_biz_id
     * @param string $delivery_token
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function reOrder($shopid,$shop_order_id,$shop_no,$delivery_sign,$delivery_id,$openid,$sender,$receiver,$cargo,$order_info,$shop,$sub_biz_id='',$delivery_token=''){
        return $this->httpPostJson('cgi-bin/express/local/business/order/readd', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'delivery_id'=>$delivery_id,
            'openid'=>$openid,
            'sender'=>$sender,
            'receiver'=>$receiver,
            'cargo'=>$cargo,
            'order_info'=>$order_info,
            'shop'=>$shop,
            'sub_biz_id'=>$sub_biz_id,
            'delivery_token'=>$delivery_token
        ]);

    }

    /**
     * 可以对待接单状态的订单增加小费。需要注意：订单的小费，以最新一次加小费动作的金额为准，故下一次增加小费额必须大于上一次小费额
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $waybill_id
     * @param $openid
     * @param $tips
     * @param $remark
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function addTip($shopid,$shop_order_id,$shop_no,$delivery_sign,$waybill_id,$openid,$tips,$remark){
        return $this->httpPostJson('cgi-bin/express/local/business/order/addtips', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'waybill_id'=>$waybill_id,
            'openid'=>$openid,
            'tips'=>$tips,
            'remark'=>$remark,
        ]);
    }

    /**
     * 预取消配送单接口
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $delivery_id
     * @param $waybill_id
     * @param string $cancel_reason_id
     * @param string $cancel_reason
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function preCancelOrder($shopid,$shop_order_id,$shop_no,$delivery_sign,$delivery_id,$waybill_id,$cancel_reason_id='',$cancel_reason=''){
        return $this->httpPostJson('cgi-bin/express/local/business/order/precancel', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'delivery_id'=>$delivery_id,
            'waybill_id'=>$waybill_id,
            'cancel_reason_id'=>$cancel_reason_id,
            'cancel_reason'=>$cancel_reason,
        ]);
    }

    /**
     * 取消配送单接口
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $delivery_id
     * @param $waybill_id
     * @param $cancel_reason_id 1 暂时不需要邮寄,2 价格不合适,3 订单信息有误，重新下单,4 骑手取货不及时,5 骑手配送不及时,6 其他原因(如果选择6，需要填写取消原因，否则不需要填写)
     * @param string $cancel_reason
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function cancelOrder($shopid,$shop_order_id,$shop_no,$delivery_sign,$delivery_id,$waybill_id,$cancel_reason_id,$cancel_reason=''){
        return $this->httpPostJson('cgi-bin/express/local/business/order/cancel', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'delivery_id'=>$delivery_id,
            'waybill_id'=>$waybill_id,
            'cancel_reason_id'=>$cancel_reason_id,
            'cancel_reason'=>$cancel_reason,
        ]);
    }

    /**
     * 异常件退回商家商家确认收货接口
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @param $waybill_id
     * @param string $remark
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function abnormalConfirm($shopid,$shop_order_id,$shop_no,$delivery_sign,$waybill_id,$remark=''){
        return $this->httpPostJson('cgi-bin/express/local/business/order/confirm_return', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
            'waybill_id'=>$waybill_id,
            'remark'=>$remark,
        ]);
    }

    /**
     * 拉取配送单信息
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $delivery_sign
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getOrder($shopid,$shop_order_id,$shop_no,$delivery_sign){
        return $this->httpPostJson('cgi-bin/express/local/business/order/get', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'delivery_sign'=>$delivery_sign,
        ]);
    }

    /**
     * 模拟配送公司更新配送单状态, 该接口只用于沙盒环境，即订单并没有真实流转到运力方
     * @param $shopid
     * @param $shop_order_id
     * @param $shop_no
     * @param $action_time 状态变更时间点，Unix秒级时间戳
     * @param $order_status
     * @param string $action_msg
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function mockUpdateOrder($shopid,$shop_order_id,$shop_no,$action_time,$order_status,$action_msg=''){
        return $this->httpPostJson('cgi-bin/express/local/business/test_update_order', [
            'shopid'=>$shopid,
            'shop_order_id'=>$shop_order_id,
            'shop_no'=>$shop_no,
            'action_time'=>$action_time,
            'order_status'=>$order_status,
            'action_msg'=>$action_msg,
        ]);
    }
}