<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\MiniProgram\Business;

use PowerWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author wuyq <wuyq@haodianotng.cn>
 */
class Client extends BaseClient
{

    /**
     * 拉取直播房间列表api文档接口使用（只能在B端调用，每天调用限额500次）
     * @param int $start
     * @param int $limit
     * @param string $action "get_replay"获取回放
     * @param int $room_id 直播间id
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * // name 房间名
     * // roomid 房间id
     * // cover_img 封面图片url
     * // start_time 直播计划开始时间，列表按照 start_time 降序排列
     * // end_time 直播计划结束时间
     * // anchor_name 主播名
     * // anchor_img 主播头像
     * // goods 商品列表
     */
    public function getLiveInfo(int $start,int $limit,string $action="",int $room_id=0)
    {
        $data = [
            'start'=>$start,
            'limit'=>$limit
        ];
        if($action){
            $data['action'] = $action;
        }
        if($room_id){
            $data['room_id'] = $room_id;
        }
        return $this->httpPostJson('wxa/business/getliveinfo',$data);
    }

}
