<?php

namespace Azuos\Core;

class Core
{
    public function require(string $archive)
    {
        require_once dirname( dirname (__DIR__) ) . str_replace('\\', DIRECTORY_SEPARATOR, $archive);
    }

    public function requireHelpers()
    {
        $this->require('\src\Helper\functions.php');
        return $this;
    }

    public function requireRoutes()
    {
        $this->require('\routes.php');
        return $this;
    }
}