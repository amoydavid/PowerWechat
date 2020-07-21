<?php

/*
 * This file is part of the overtrue/wechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Work\Calendar;

use PowerWeChat\Kernel\BaseClient;

/**
 * Class Client.
 *
 * @author her-cat <i@her-cat.com>
 */
class Client extends BaseClient
{
    /**
     * Add a calendar.
     *
     * @param array $calendar
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function add(array $calendar)
    {
        return $this->httpPostJson('cgi-bin/oa/calendar/add', compact('calendar'));
    }

    /**
     * Update the calendar.
     *
     * @param string $id
     * @param array  $calendar
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function update(string $id, array $calendar)
    {
        $calendar += ['cal_id' => $id];

        return $this->httpPostJson('cgi-bin/oa/calendar/update', compact('calendar'));
    }

    /**
     * Get one or more calendars.
     *
     * @param string|array $ids
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($ids)
    {
        return $this->httpPostJson('cgi-bin/oa/calendar/get', ['cal_id_list' => (array) $ids]);
    }

    /**
     * Delete a calendar.
     *
     * @param string $id
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function delete(string $id)
    {
        return $this->httpPostJson('cgi-bin/oa/calendar/del', ['cal_id' => $id]);
    }
}
