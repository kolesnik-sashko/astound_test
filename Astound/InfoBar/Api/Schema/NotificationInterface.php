<?php

namespace Astound\InfoBar\Api\Schema;

interface NotificationInterface
{
    const TABLE_NAME       = 'astound_info_bar';

    const ID_FIELD         = 'entity_id';
    const TITLE_FIELD      = 'title';
    const CONTENT_FIELD    = 'content';
    const STORE_VIEW_FIELD = 'store';
    const STATUS_FIELD     = 'status';

}