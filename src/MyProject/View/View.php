<?php

namespace MyProject\View;

class View
{
    private $templatePath;

    private $extraVars = [];

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHtml(string $templateName, array $vars = [], $code = 200)
    {
        http_response_code($code);

        extract($this->extraVars);
        extract($vars);

        ob_start();
        include "$this->templatePath/$templateName";

        $buffer = ob_get_contents();
        ob_end_clean();

        echo $buffer;
    }

    public function displayJson($data, int $code = 200)
    {
        header('Content-type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
    }
}