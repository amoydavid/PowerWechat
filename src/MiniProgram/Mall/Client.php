<?php
/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PowerWeChat\MiniProgram\Mall;
use PowerWeChat\Kernel\BaseClient;
/**
 * Class Client.
 *
 * @author mingyoung <mingyoungcheung@gmail.com>
 */
class Client extends BaseClient
{

    /**
     * @param $order_list 订单列表
     * @param int $is_history 是否为历史订单
     * @param int $is_test 是否为测试环境
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function addOrder($order_list,$is_history=0,$is_test=0)
    {
        if($is_test){
            $url = 'mall/importorder?action=add-order&is_test='.$is_test;
        }else{
            $url = 'mall/importorder?action=add-order&is_history='.$is_history;
        }
        return $this->httpPostJson($url, [
            'order_list' => $order_list,
        ]);
    }

    /**
     * @param $order_list
     * @param int $is_history
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function updateOrder($order_list,$is_history=0)
    {
        $url = 'mall/importorder?action=update-order&is_history='.$is_history;
        return $this->httpPostJson($url, [
            'order_list' => $order_list,
        ]);
    }

    /**
     * @param $user_open_id
     * @param $order_id
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteOrder($user_open_id,$order_id)
    {
        return $this->httpPostJson('mall/deleteorder', [
            'user_open_id' => $user_open_id,
            'order_id'=>$order_id,
        ]);
    }

    /**
     * @param $user_open_id
     * @param $sku_product_list
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function addShoppingList($user_open_id,$sku_product_list)
    {
        return $this->httpPostJson('mall/addshoppinglist', [
            'user_open_id' => $user_open_id,
            'sku_product_list'=>$sku_product_list,
        ]);
    }

    /**
     * @param $user_open_id
     * @param string $type
     * @param array $key_list 例如：key_list:[{"item_code":"00003563372839_0000xxxxxxxx"}]
     * @param int $offset
     * @param int $count
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryShoppingList($user_open_id,$type="batchquery",$key_list=[],$offset=0,$count=20)
    {
        if($type == "batchquery"){
            return $this->httpPostJson('mall/queryshoppinglist', [
                'user_open_id' => $user_open_id,
                'key_list'=>$key_list,
            ]);
        }else{
            return $this->httpPostJson('mall/queryshoppinglist', [
                'user_open_id' => $user_open_id,
                'offset'=>$offset,
                'count'=>$count,
            ]);
        }
    }

    /**
     * @param $user_open_id
     * @param $sku_product_list 例如：sku_product_list:[{"item_code": "here_is_spu_id","sku_id": "here_is_sku_id"}]
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteShoppingList($user_open_id,$sku_product_list)
    {
        return $this->httpPostJson('mall/deleteshoppinglist', [
            'user_open_id' => $user_open_id,
            'sku_product_list'=>$sku_product_list,
        ]);

    }

    /**
     * @param $user_open_id
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteBizAllShoppingList($user_open_id)
    {
        return $this->httpPostJson('mall/deletebizallshoppinglist', [
            'user_open_id' => $user_open_id,
        ]);
    }

    /**
     * 参考 https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/goods/update.part.html
     * @param $product_list
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function importProduct($product_list)
    {
        return $this->httpPostJson('mall/importproduct', [
            'product_list' => $product_list,
        ]);
    }

    /**
     * @param $key_list
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryProduct($key_list)
    {
        return $this->httpPostJson('mall/queryproduct?type=batchquery', [
            'key_list' => $key_list,
        ]);
    }

    /**
     * @param $can_be_search
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function setBizCanBeSearch($can_be_search)
    {
        return $this->httpPostJson('mall/brandmanage?action=set_biz_can_be_search', [
            'can_be_search' => $can_be_search,
        ]);
    }

}