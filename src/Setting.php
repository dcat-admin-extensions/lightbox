<?php

namespace Abovesky\DcatAdmin\Lightbox;

use Dcat\Admin\Extend\Setting as Form;

class Setting extends Form
{
    public function form()
    {
        $this->text('key1')->required();
        $this->text('key2')->required();
    }
}
