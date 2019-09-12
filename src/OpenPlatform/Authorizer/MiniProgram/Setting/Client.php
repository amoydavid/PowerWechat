<?php
/*
 * This file is part of the wyq09/powerwechat.
 *
 * (c) overtrue <i@overtrue.me>
 *
 * This source file is subject to the MIT license that is bundled
 * with this source code in the file LICENSE.
 */
namespace PowerWeChat\OpenPlatform\Authorizer\MiniProgram\Setting;
use PowerWeChat\Kernel\BaseClient;
/**
 * Class Client.
 *
 * @author ClouderSky <clouder.flow@gmail.com>
 */
class Client extends BaseClient
{
    /**
     * 获取账号可以设置的所有类目.
     */
    public function getAllCategories()
    {
        return $this->httpPostJson('cgi-bin/wxopen/getallcategories');
    }
    /**
     * 添加类目.
     *
     * @param array $categories 类目数组
     */
    public function addCategories(array $categories)
    {
        $params = ['categories' => $categories];
        return $this->httpPostJson('cgi-bin/wxopen/addcategory', $params);
    }
    /**
     * 删除类目.
     *
     * @param int $firstId  一级类目ID
     * @param int $secondId 二级类目ID
     */
    public function deleteCategories(int $firstId, int $secondId)
    {
        $params = ['first' => $firstId, 'second' => $secondId];
        return $this->httpPostJson('cgi-bin/wxopen/deletecategory', $params);
    }
    /**
     * 获取账号已经设置的所有类目.
     */
    public function getCategories()
    {
        return $this->httpPostJson('cgi-bin/wxopen/getcategory');
    }
    /**
     * 修改类目.
     *
     * @param array $category 单个类目
     */
    public function updateCategory(array $category)
    {
        return $this->httpPostJson('cgi-bin/wxopen/modifycategory', $category);
    }
    /**
     * 小程序名称设置及改名.
     *
     * @param string $nickname       昵称
     * @param string $idCardMediaId  身份证照片素材ID
     * @param string $licenseMediaId 组织机构代码证或营业执照素材ID
     * @param string $otherStuffs    其他证明材料素材ID
     */
    public function setNickname(
        string $nickname,
        string $idCardMediaId = '',
        string $licenseMediaId = '',
        array $otherStuffs = []
    ) {
        $params = [
            'nick_name' => $nickname,
            'id_card' => $idCardMediaId,
            'license' => $licenseMediaId,
        ];
        for ($i = \count($otherStuffs) - 1; $i >= 0; --$i) {
            $params['naming_other_stuff_'.($i + 1)] = $otherStuffs[$i];
        }
        return $this->httpPostJson('wxa/setnickname', $params);
    }
    /**
     * 小程序改名审核状态查询.
     *
     * @param int $auditId 审核单id
     */
    public function getNicknameAuditStatus($auditId)
    {
        $params = ['audit_id' => $auditId];
        return $this->httpPostJson('wxa/api_wxa_querynickname', $params);
    }
    /**
     * 微信认证名称检测.
     *
     * @param string $nickname 名称（昵称）
     */
    public function isAvailableNickname($nickname)
    {
        $params = ['nick_name' => $nickname];
        return $this->httpPostJson(
            'cgi-bin/wxverify/checkwxverifynickname', $params);
    }

    /**
     * 查询小程序是否可被搜索.
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getSearchStatus()
    {
        return $this->httpGet('wxa/getwxasearchstatus');

    }
    /**
     * 设置小程序可被搜素.
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function setSearchable()
    {
        return $this->httpPostJson('wxa/changewxasearchstatus', [
            'status' => 0,
        ]);
    }
    /**
     * 设置小程序不可被搜素.
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function setUnsearchable()
    {
        return $this->httpPostJson('wxa/changewxasearchstatus', [
            'status' => 1,
        ]);
    }

    /**
     * 获取展示的公众号信息.
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getDisplayedOfficialAccount()
    {
        return $this->httpGet('wxa/getshowwxaitem');
    }
    /**
     * 设置展示的公众号.
     *
     * @param string|bool $appid
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function setDisplayedOfficialAccount($appid)
    {
        return $this->httpPostJson('wxa/updateshowwxaitem', [
            'appid' => $appid ?: null,
            'wxa_subscribe_biz_flag' => $appid ? 1 : 0,
        ]);
    }
    /**
     * 获取可以用来设置的公众号列表.
     *
     * @param int $page
     * @param int $num
     *
     * @return array|\PowerWeChat\Kernel\Support\Collection|object|\Psr\Http\Message\ResponseInterface|string
     */
    public function getDisplayableOfficialAccounts(int $page, int $num)
    {
        return $this->httpGet('wxa/getwxamplinkforshow', [
            'page' => $page,
            'num' => $num,
        ]);
    }

    /**
     * 查询服务商的当月提审限额和加急次数（Quota）
     * 服务商可以调用该接口，查询当月平台分配的提审限额和剩余可提审次数，以及当月分配的审核加急次数和剩余加急次数。
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function queryQuota(){
        return $this->httpGet('wxa/queryquota');
    }

    /**
     * @param int $auditid
     * 加急审核申请
     * 有加急次数的第三方可以通过该接口，对已经提审的小程序进行加急操作，加急后的小程序预计2-12小时内审完。
     * @return array|object|\PowerWeChat\Kernel\Support\Collection|\Psr\Http\Message\ResponseInterface|string
     * @throws \PowerWeChat\Kernel\Exceptions\InvalidConfigException
     */
    public function speedUpAudit(int $auditid){
        return $this->httpPostJson('wxa/speedupaudit',[
            'auditid'=>$auditid
        ]);
    }
}