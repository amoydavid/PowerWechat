<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\OfficialAccount\CustomerService;

use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use PowerWeChat\Kernel\Exceptions\RuntimeException;
use PowerWeChat\Kernel\Messages\Message;
use PowerWeChat\Kernel\Messages\Raw as RawMessage;
use PowerWeChat\Kernel\Messages\Text;

/**
 * Class MessageBuilder.
 *
 * @author overtrue <i@overtrue.me>
 */
class Messenger
{
    /**
     * Messages to send.
     *
     * @var \PowerWeChat\Kernel\Messages\Message;
     */
    protected $message;

    /**
     * Messages target user open id.
     *
     * @var string
     */
    protected $to;

    /**
     * Messages sender staff id.
     *
     * @var string
     */
    protected $account;

    /**
     * Customer service instance.
     *
     * @var \PowerWeChat\OfficialAccount\CustomerService\Client
     */
    protected $client;

    /**
     * MessageBuilder constructor.
     *
     * @param \PowerWeChat\OfficialAccount\CustomerService\Client $client
     */
    public function __construct(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Set message to send.
     *
     * @param string|Message $message
     *
     * @return Messenger
     *
     * @throws InvalidArgumentException
     */
    public function message($message)
    {
        if (is_string($message)) {
            $message = new Text($message);
        }

        $this->message = $message;

        return $this;
    }

    /**
     * Set staff account to send message.
     *
     * @param string $account
     *
     * @return Messenger
     */
    public function by(string $account)
    {
        $this->account = $account;

        return $this;
    }

    /**
     * @param string $account
     *
     * @return Messenger
     */
    public function from(string $account)
    {
        return $this->by($account);
    }

    /**
     * Set target user open id.
     *
     * @param string $openid
     *
     * @return Messenger
     */
    public function to($openid)
    {
        $this->to = $openid;

        return $this;
    }

    /**
     * Send the message.
     *
     * @return \Psr\Http\Message\ResponseInterface|\PowerWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws RuntimeException
     */
    public function send()
    {
        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        if ($this->message instanceof RawMessage) {
            $message = json_decode($this->message->get('content'), true);
        } else {
            $prepends = [
                'touser' => $this->to,
            ];
            if ($this->account) {
                $prepends['customservice'] = ['kf_account' => $this->account];
            }
            $message = $this->message->transformForJsonRequest($prepends);
        }

        return $this->client->send($message);
    }

    /**
     * Return property.
     *
     * @param $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        return null;
    }
}
