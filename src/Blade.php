<?php

declare(strict_types=1);

namespace Rawilk\Blade;

final class Blade
{
    public function javaScript(array $options = []): string
    {
        $html = config('app.debug') ? ['<!-- Blade Scripts -->'] : [];

        $html[] = $this->javaScriptAssets($options);

        return implode(PHP_EOL, $html);
    }

    private function javaScriptAssets(array $options = []): string
    {
        $assetsUrl = config('blade.asset_url') ?: rtrim($options['asset_url'] ?? '', '/');

        $manifest = json_decode(file_get_contents(__DIR__ . '/../dist/manifest.json'), true);
        $versionedFileName = $manifest['/blade.js'];

        $fullAssetPath = "{$assetsUrl}/blade{$versionedFileName}";

        return <<<HTML
        <script src="{$fullAssetPath}" data-turbo-eval="false" data-turbolinks-eval="false"></script>
        HTML;
    }
}
