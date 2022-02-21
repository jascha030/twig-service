<?php

declare(strict_types=1);

namespace Jascha030\Twig\Templater;

/**
 * Templating methods, that are required for a templating service.
 * Twig functions are omitted to enable implementation with other templating libraries/methods.
 *
 * @author Jascha030<contact@jaschavanaalst.nl>
 *
 * @since  1.0.0
 */
interface TemplaterInterface
{
    /**
     * Render a template and return output as string.
     *
     * @since  1.0.0
     */
    public function renderString(string $template, array $context = []): string;

    /**
     * Render and output a template.
     *
     * @since 1.0.0
     */
    public function render(string $template, array $context = []): void;
}
