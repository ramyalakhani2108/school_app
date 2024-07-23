<?php

declare(strict_types=1);

namespace Framework;

class TemplateEngine
{
    private array $global_template_data = [];
    public function __construct(private string $base_path)
    {
    }

    public function render(string $template, array $data = [])
    {
        extract($data, EXTR_SKIP);
        extract($this->global_template_data, EXTR_SKIP);

        ob_start();

        include $this->resolve($template);

        $output = ob_get_contents();

        ob_end_clean();

        return $output;
    }

    public function resolve(string $template)
    {
        return "{$this->base_path}/{$template}";
    }
    public function addGlobal(string $key, mixed $value)
    {
        $this->global_template_data[$key] = $value;
    }
}
