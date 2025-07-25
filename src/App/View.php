<?php

declare(strict_types=1);

namespace App;
use App\Exceptions;

class View
{
    protected string $viewPath = "";
    protected array $params;

    public function __construct(
        string $path,
        array $params = []
    ) {
        $this->viewPath = VIEW_PATH . $path . ".php";
        $this->params = $params;

        $this->params["CSS_PATH"] = CSS_PATH;
    }

    public function render(): string
    {

        if (!file_exists($this->viewPath)) {
            throw new Exceptions\RouteNotFoundException();
        }

        ob_start();
        include $this->viewPath;
        $content = ob_get_clean();

        ob_start();
        include __DIR__ . "/Layout/layout.php";
        return ob_get_clean();

    }
}