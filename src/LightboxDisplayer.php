<?php

namespace Abovesky\DcatAdmin\Lightbox;

use Dcat\Admin\Admin;
use Dcat\Admin\Grid\Displayers\AbstractDisplayer;
use Dcat\Admin\Support\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LightboxDisplayer extends AbstractDisplayer
{
    private $id;

    protected function script()
    {
        $this->id = 'viewer-' . Str::random(8);

        return <<<SCRIPT
new Viewer(document.getElementById('$this->id'));
SCRIPT;
    }

    public function display($server = '', $width = 200, $height = 200)
    {
        if (empty($this->value)) {
            return '';
        }

        $path = Helper::array($this->value);

        $html = collect($path)->transform(function ($path) use ($server, $width, $height) {
            if (url()->isValidUrl($path) || mb_strpos($path, 'data:image') === 0) {
                $src = $path;
            } elseif ($server) {
                $src = rtrim($server, '/') . '/' . ltrim($path, '/');
            } else {
                $src = Storage::disk(config('admin.upload.disk'))->url($path);
            }

            return <<<HTML
<img src='$src' style='max-width:{$width}px;max-height:{$height}px;cursor:pointer' class='img img-thumbnail' />
HTML;
        })->implode('&nbsp;');

        Admin::requireAssets('@abovesky.dcat-lightbox');
        Admin::script($this->script());

        return "<div id='$this->id'>$html</div>";
    }
}
