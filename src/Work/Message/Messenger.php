<?php

/*
 * This file is part of the amoydavid/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */

namespace PowerWeChat\Work\Message;

use PowerWeChat\Kernel\Exceptions\InvalidArgumentException;
use PowerWeChat\Kernel\Exceptions\RuntimeException;
use PowerWeChat\Kernel\Messages\Message;
use PowerWeChat\Kernel\Messages\Text;

/**
 * Class MessageBuilder.
 *
 * @author overtrue <i@overtrue.me>
 */
class Messenger
{
    /**
     * @var \PowerWeChat\Kernel\Messages\Message;
     */
    protected $message;

    /**
     * @var array
     */
    protected $to = ['touser' => '@all'];

    /**
     * @var int
     */
    protected $agentId;

    /**
     * @var bool
     */
    protected $secretive = false;

    /**
     * @var \PowerWeChat\Work\Message\Client
     */
    protected $client;

    /**
     * MessageBuilder constructor.
     *
     * @param \PowerWeChat\Work\Message\Client $client
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
     * @return \PowerWeChat\Work\Message\Messenger
     *
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function message($message)
    {
        if (is_string($message) || is_numeric($message)) {
            $message = new Text($message);
        }

        if (!($message instanceof Message)) {
            throw new InvalidArgumentException('Invalid message.');
        }

        $this->message = $message;

        return $this;
    }

    /**
     * @param int $agentId
     *
     * @return \PowerWeChat\Work\Message\Messenger
     */
    public function ofAgent(int $agentId)
    {
        $this->agentId = $agentId;

        return $this;
    }

    /**
     * @param array|string $userIds
     *
     * @return \PowerWeChat\Work\Message\Messenger
     */
    public function toUser($userIds)
    {
        return $this->setRecipients($userIds, 'touser');
    }

    /**
     * @param array|string $partyIds
     *
     * @return \PowerWeChat\Work\Message\Messenger
     */
    public function toParty($partyIds)
    {
        return $this->setRecipients($partyIds, 'toparty');
    }

    /**
     * @param array|string $tagIds
     *
     * @return \PowerWeChat\Work\Message\Messenger
     */
    public function toTag($tagIds)
    {
        return $this->setRecipients($tagIds, 'totag');
    }

    /**
     * Keep secret.
     *
     * @return \PowerWeChat\Work\Message\Messenger
     */
    public function secretive()
    {
        $this->secretive = true;

        return $this;
    }

    /**
     * @param array|string $ids
     * @param string       $key
     *
     * @return \PowerWeChat\Work\Message\Messenger
     */
    protected function setRecipients($ids, string $key): self
    {
        if (is_array($ids)) {
            $ids = implode('|', $ids);
        }

        $this->to = [$key => $ids];

        return $this;
    }

    /**
     * @param \PowerWeChat\Kernel\Messages\Message|string|null $message
     *
     * @return mixed
     *
     * @throws \PowerWeChat\Kernel\Exceptions\RuntimeException
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function send($message = null)
    {
        if ($message) {
            $this->message($message);
        }

        if (empty($this->message)) {
            throw new RuntimeException('No message to send.');
        }

        if (is_null($this->agentId)) {
            throw new RuntimeException('No agentid specified.');
        }

        $message = $this->message->transformForJsonRequest(array_merge([
            'agentid' => $this->agentId,
            'safe' => intval($this->secretive),
        ], $this->to));

        return $this->client->send($message);
    }

    /**
     * Return property.
     *
     * @param string $property
     *
     * @return mixed
     *
     * @throws InvalidArgumentException
     */
    public function __get($property)
    {
        if (property_exists($this, $property)) {
            return $this->$property;
        }

        throw new InvalidArgumentException(sprintf('No property named "%s"', $property));
    }
}
