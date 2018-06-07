<?php

namespace Astound\InfoBar\Api\Schema;

interface NotificationInterface
{
    const TABLE_NAME                       = 'astound_notification';
    const ID_FIELD                         = 'entity_id';
    const TITLE_FIELD                      = 'title';
    const CONTENT_FIELD                    = 'content';
    const STATUS_FIELD                     = 'status';
    const SORT_ORDER_FIELD                 = 'sort_order';
    const BACKGROUND_COLOR_FIELD           = 'background_color';

    const NOTIFICATION_TO_STORE_TABLE_NAME = 'astound_notification_store';
    const NOTIFICATION_ID_FIELD            = 'notification_id';
    const STORE_VIEW_ID_FIELD              = 'store_id';
}