<?php
namespace App\Admin;

use Sonata\AdminBundle\Admin\Admin as Base;

class Admin extends Base
{
    public function getExportFormats()
    {
        return array_merge(parent::getExportFormats(), ['pdf']);
    }
}
