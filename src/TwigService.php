<?php

declare(strict_types=1);

namespace Jascha030\Twig;

use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

/**
 * Basic implementation of TwigServiceInterface.
 *
 * @author Jascha030<contact@jaschavanaalst.nl>
 *
 * @since 1.0.0
 */
class TwigService implements TwigServiceInterface
{
    public function __construct(private Environment $environment)
    {
    }

    /**
     * {@inheritDoc}
     *
     * @since 1.0.0
     */
    public function getEnvironment(): Environment
    {
        return $this->environment;
    }

    /**
     * {@inheritDoc}
     *
     * @throws LoaderError|RuntimeError|SyntaxError
     *
     * @since 1.0.0
     */
    public function renderString(string $template, array $context = []): string
    {
        return $this->getEnvironment()->render($template, $context);
    }

    /**
     * {@inheritDoc}
     *
     * @throws LoaderError|RuntimeError|SyntaxError
     *
     * @since 1.0.0
     */
    public function render(string $template, array $context = []): void
    {
        echo $this->renderString($template, $context);
    }
}
