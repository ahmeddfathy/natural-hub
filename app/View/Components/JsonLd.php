<?php

namespace App\View\Components;

use Illuminate\Support\HtmlString;
use Illuminate\View\Component;

/**
 * Renders a <script type="application/ld+json"> block safely.
 *
 * Usage in Blade:
 *   <x-json-ld :data="$schemaArray" />
 *
 * This avoids the Blade @@ escaping issue entirely by using
 * json_encode() in PHP, guaranteeing "@context" is always correct.
 * Returns HtmlString so Blade does NOT try to compile the output
 * (which would break on @type, @id, etc.).
 */
class JsonLd extends Component
{
    public array $data;

    public function __construct(array $data)
    {
        $this->data = $data;
    }

    public function render()
    {
        $json = json_encode(
            $this->data,
            JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT
        );

        return new HtmlString("<script type=\"application/ld+json\">\n{$json}\n</script>");
    }
}
