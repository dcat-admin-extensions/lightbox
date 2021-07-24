<?php

namespace Abovesky\DcatAdmin\Lightbox;

use Dcat\Admin\Extend\ServiceProvider;
use Dcat\Admin\Grid\Column;
use Dcat\Admin\Show\Field;

class LightboxServiceProvider extends ServiceProvider
{
    protected $js = [
        'js/viewer.min.js',
    ];
    protected $css = [
        'css/viewer.min.css',
    ];

    public function register()
    {
        //
    }

    public function init()
    {
        parent::init();

        Field::extend('lightbox', LightboxField::class);
        Column::extend('lightbox', LightboxDisplayer::class);
    }

    public function settingForm()
    {
        return new Setting($this);
    }
}
