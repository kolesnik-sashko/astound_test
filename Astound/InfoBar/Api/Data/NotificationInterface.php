<?php

namespace Astound\InfoBar\Api\Data;

interface NotificationInterface 
{
    const CACHE_TAG     = 'astound_infobar_notification';
    const REGISTRY_KEY  = 'astound_infobar_notification';

    public function getId();

    public function getTitle();

    public function setTitle($title);

    public function getContent();

    public function setContent($content);

    public function getStatus();

    public function setStatus($status);

    public function getBackgroundColor();

    public function setBackgroundColor($color);

    public function getOrder();

    public function setOrder($order);


}