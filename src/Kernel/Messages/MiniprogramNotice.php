<?php


namespace PowerWeChat\Kernel\Messages;


class MiniprogramNotice extends Message
{
    protected $type = 'miniprogram_notice';

    protected $properties = [
        'appid',
        'title',
    ];
}
