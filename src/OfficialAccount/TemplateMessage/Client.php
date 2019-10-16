<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OfficialAccount\TemplateMessage;

use PowerWeChat\Kernel\BaseClient;
use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use ReflectionClass;

/**
 * Class Client.
 *
 * @author overtrue <i@overtrue.me>
 */
class Client extends BaseClient
{
    const API_SEND = 'cgi-bin/message/template/send';

    /**
     * Attributes.
     *
     * @var array
     */
    protected $message = [
        'touser' => '',
        'template_id' => '',
        'url' => '',
        'data' => [],
    ];

    /**
     * Required attributes.
     *
     * @var array
     */
    protected $required = ['touser', 'template_id'];

    /**
     * Set industry.
     *
     * @param int $industryOne
     * @param int $industryTwo
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     */
    public function setIndustry($industryOne, $industryTwo)
    {
        $params = [
            'industry_id1' => $industryOne,
            'industry_id2' => $industryTwo,
        ];

        return $this->httpPostJson('cgi-bin/template/api_set_industry', $params);
    }

    /**
     * Get industry.
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     */
    public function getIndustry()
    {
        return $this->httpPostJson('cgi-bin/template/get_industry');
    }

    /**
     * Add a template and get template ID.
     *
     * @param string $shortId
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     */
    public function addTemplate($shortId)
    {
        $params = ['template_id_short' => $shortId];

        return $this->httpPostJson('cgi-bin/template/api_add_template', $params);
    }

    /**
     * Get private templates.
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     */
    public function getPrivateTemplates()
    {
        return $this->httpPostJson('cgi-bin/template/get_all_private_template');
    }

    /**
     * Delete private template.
     *
     * @param string $templateId
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     */
    public function deletePrivateTemplate($templateId)
    {
        $params = ['template_id' => $templateId];

        return $this->httpPostJson('cgi-bin/template/del_private_template', $params);
    }

    /**
     * Send a template message.
     *
     * @param $data
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function send($data = [])
    {
        $params = $this->formatMessage($data);

        $this->restoreMessage();

        return $this->httpPostJson(static::API_SEND, $params);
    }

    /**
     * Send template-message for subscription.
     *
     * @param array $data
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function sendSubscription(array $data = [])
    {
        $params = $this->formatMessage($data);

        $this->restoreMessage();

        return $this->httpPostJson('cgi-bin/message/template/subscribe', $params);
    }

    /**
     * 发送订阅消息
     * @param array $data
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws InvalidArgumentException
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function sendSubscriptionTemplate(array $data = [])
    {
        $params = $this->formatMessage($data);
        $this->restoreMessage();
        return $this->httpPostJson('cgi-bin/message/subscribe/send', $params);
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    protected function formatMessage(array $data = [])
    {
        $params = array_merge($this->message, $data);

        foreach ($params as $key => $value) {
            if (in_array($key, $this->required, true) && empty($value) && empty($this->message[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $this->message[$key] : $value;
        }

        $params['data'] = $this->formatData($params['data'] ?? []);

        return $params;
    }

    /**
     * @param array $data
     *
     * @return array
     */
    protected function formatData(array $data)
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (isset($value['value'])) {
                    $formatted[$key] = $value;

                    continue;
                }

                if (count($value) >= 2) {
                    $value = [
                        'value' => $value[0],
                        'color' => $value[1],
                    ];
                }
            } else {
                $value = [
                    'value' => strval($value),
                ];
            }

            $formatted[$key] = $value;
        }

        return $formatted;
    }

    /**
     * Restore message.
     */
    protected function restoreMessage()
    {
        $this->message = (new ReflectionClass(__CLASS__))->getDefaultProperties()['message'];
    }
}
