<?php

namespace Astound\InfoBar\Api\Data;

interface NotificationInterface 
{
    const CACHE_TAG     = 'astound_infobar_notification';
    const REGISTRY_KEY  = 'astound_infobar_notification';

    /**
     * @return mixed
     */
    public function getId();

    /**
     * @return string
     */
    public function getTitle();

    /**
     * @param $title string
     * @return NotificationInterface
     */
    public function setTitle($title);

    /**
     * @return string
     */
    public function getContent();

    /**
     * @param $content string
     * @return NotificationInterface
     */
    public function setContent($content);

    /**
     * @return integer
     */
    public function getStatus();

    /**
     * @param $status integer
     * @return NotificationInterface
     */
    public function setStatus($status);

    /**
     * @return string
     */
    public function getBackgroundColor();

    /**
     * @param $color string
     * @return NotificationInterface
     */
    public function setBackgroundColor($color);

    /**
     * @return integer
     */
    public function getSortOrder();

    /**
     * @param $order integer
     * @return NotificationInterface
     */
    public function setSortOrder($order);


}