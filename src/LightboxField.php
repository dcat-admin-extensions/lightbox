<?php

namespace Abovesky\DcatAdmin\Lightbox;

use Dcat\Admin\Admin;
use Dcat\Admin\Show\AbstractField;
use Dcat\Admin\Support\Helper;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class LightboxField extends AbstractField
{
    private string $id;

    protected function script()
    {
        $this->id = 'viewer-' . Str::random(8);

        return <<<SCRIPT
new Viewer(document.getElementById('$this->id'));
SCRIPT;
    }

    public function render($server = '', $width = 200, $height = 200)
    {
        if (empty($this->value)) {
            return '';
        }

        $path = Helper::array($this->value);

        $html = collect($path)->transform(function ($path) use ($server, $width, $height) {
            if (url()->isValidUrl($path)) {
                $src = $path;
            } elseif ($server) {
                $src = rtrim($server, '/') . '/' . ltrim($path, '/');
            } else {
                $disk = config('admin.upload.disk');

                if (config("filesystems.disks.{$disk}")) {
                    $src = Storage::disk($disk)->url($path);
                } else {
                    return '';
                }
            }

            return "<img src='$src' style='max-width:{$width}px;max-height:{$height}px' class='img img-thumbnail' />";
        })->implode('&nbsp;');

        Admin::requireAssets('@abovesky.dcat-lightbox');
        Admin::script($this->script());

        return "<div id='$this->id'>$html</div>";
    }
}
