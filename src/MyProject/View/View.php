<?php

namespace MyProject\View;

class View
{
    private $templatePath;

    public function __construct(string $templatePath)
    {
        $this->templatePath = $templatePath;
    }

    public function renderHtml(string $templateName, array $vars = [])
    {
        // извлекает массив в переменные ['ключ' => 'значение']
        // делает $ключ = значение
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
}