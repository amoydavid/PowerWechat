<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\MiniProgram\Message;

use PowerWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author liuwei <liuw@liuw.net>
 */
class Client extends BaseClient
{

    /**
     * 获得一个 ActivityId
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function createActivityId()
    {
        return $this->httpGet('cgi-bin/message/wxopen/activityid/create');
    }


    /**
     * 修改一个动态消息
     * @param string $activity_id
     * @param int $target_state
     * @param array $template_info
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function updatableMsg(string $activity_id, int $target_state, Array $template_info)
    {
        return $this->httpPost('cgi-bin/message/wxopen/updatablemsg/send', [
            'activity_id' => $activity_id,
            'target_state' =>$target_state,
            'template_info' => $template_info
        ]);
    }
}
