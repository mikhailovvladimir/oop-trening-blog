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

    // помогает задавать переменные прямо в конструкторе до рендеринга шаблона
    public function setVar(string $name, $value): void
    {
        $this->extraVars[$name] = $value;
    }

    public function renderHtml(string $templateName, array $vars = [], $code = 200)
    {
        // задаем код ответа
        http_response_code($code);
        // извлекает массив в переменные ['ключ' => 'значение']
        // делает $ключ = значение
        extract($this->extraVars);
        extract($vars);

        // кладем вс в буфер вывода,
        // чтобы проверить на ошибки и только потом
        // выводить, а не отрисовывать неправильно переданный шаблон
        ob_start();
        include "$this->templatePath/$templateName";
        // все данные которые должны были передаться в поток
        // вывода теперь в переменной буфер
        $buffer = ob_get_contents();
        ob_end_clean();

        // передаем данные в потом вывода
        echo $buffer;
    }

    public function displayJson($data, int $code = 200)
    {
        header('Content-type: application/json; charset=utf-8');
        http_response_code($code);
        echo json_encode($data);
    }
}