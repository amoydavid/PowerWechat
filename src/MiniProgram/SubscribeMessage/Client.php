<?php

namespace PowerWeChat\MiniProgram\SubscribeMessage;

use InvalidArgumentException;
use PowerWeChat\OfficialAccount\TemplateMessage\Client as BaseClient;
use ReflectionClass;

/**
 * Class Client
 * @package PowerWeChat\MiniProgram\SubscribeMessage
 */
class Client extends BaseClient
{
    /**
     * {@inheritdoc}.
     */
    protected $message = [
        'touser' => '',
        'template_id' => '',
        'page' => '',
        'data' => [],
    ];

    /**
     * {@inheritdoc}.
     */
    protected $required = ['touser', 'template_id', 'data'];

    /**
     * 发送模板消息
     * @param $data
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function send($data = [])
    {
        $params = $this->formatMessage($data);
        $this->restoreMessage();
        return $this->httpPostJson('cgi-bin/message/subscribe/send', $params);
    }

    /**
     * @param array $data
     * @return array
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
        foreach ($params['data'] as $key => $value) {
            if (is_array($value)) {
                if (isset($value['value'])) {
                    $params['data'][$key] = ['value' => $value['value']];
                    continue;
                }
                if (count($value) >= 1) {
                    $value = [
                        'value' => $value[0],
//                        'color' => $value[1],// color unsupported
                    ];
                }
            } else {
                $value = [
                    'value' => strval($value),
                ];
            }
            $params['data'][$key] = $value;
        }
        return $params;
    }

    /**
     *
     */
    protected function restoreMessage()
    {
        $this->message = (new ReflectionClass(static::class))->getDefaultProperties()['message'];
    }

    /**
     * 组合模板并添加至帐号下的个人模板库
     * @param string $tid
     * @param $kidList
     * @param $sceneDesc
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function addNewTemplate($tid, $kidList, $sceneDesc)
    {
        return $this->httpPostJson('wxaapi/newtmpl/addtemplate', compact('tid', 'kidList', 'sceneDesc'));
    }

    /**
     * 删除帐号下的个人模板
     * @param $priTmplId
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function deleteTemplate($priTmplId)
    {
        return $this->httpPostJson('wxaapi/newtmpl/deltemplate', compact('priTmplId'));
    }

    /**
     * 获取小程序账号的类目
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getCategory()
    {
        return $this->httpGet('wxaapi/newtmpl/getcategory');
    }

    /**
     * 获取模板标题下的关键词列表
     * @param $tid
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getPubTemplateKeyWordsById($tid)
    {
        return $this->httpGet('wxaapi/newtmpl/getpubtemplatekeywords', compact('tid'));
    }

    /**
     * 获取帐号所属类目下的公共模板标题
     * @param $ids
     * @param $start
     * @param $limit
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getPubTemplateTitleList($ids, $start, $limit)
    {
        return $this->httpGet('wxaapi/newtmpl/getpubtemplatetitles', compact('ids', 'start', 'limit'));
    }

    /**
     * 获取当前帐号下的个人模板列表
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function getTemplateList()
    {
        return $this->httpGet('wxaapi/newtmpl/gettemplate');
    }
}
