<?php

declare(strict_types=1);

use Twig\Environment;

interface TwigTemplaterInterface extends TemplaterInterface
{
    public function getEnvironment(): Environment;
}