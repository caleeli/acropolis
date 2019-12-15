<?php

namespace App\Traits;

use Blade;

trait HasBladeCompile
{
    public function bladeCompile($value, array $args = [])
    {
        $generated = Blade::compileString($value);

        ob_start() and extract($args, EXTR_SKIP);

        try {
            eval('?>' . $generated);
        } catch (\Exception $e) {
            ob_get_clean();
            throw $e;
        }

        $content = ob_get_clean();

        return $content;
    }
}
