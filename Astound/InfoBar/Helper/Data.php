<?php
/**
 * Created by PhpStorm.
 * User: kolesya
 * Date: 06.06.18
 * Time: 16:03
 */

namespace Astound\InfoBar\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

class Data extends AbstractHelper
{
    public function getTestContent($id)
    {
        return <<<CONTENT
     TEST NOTIFICATION #$id
Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard
dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen
book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially 
unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and
more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.
CONTENT;
    }
}