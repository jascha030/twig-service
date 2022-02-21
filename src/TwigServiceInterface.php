<?php

declare(strict_types=1);

namespace Jascha030\Twig;

use Jascha030\Twig\Templater\TemplaterInterface;
use Twig\Environment;

/**
 * Extends TemplaterInterface, adds method to retrieve Twig Environment.
 *
 * @author Jascha030<contact@jasschavanaalst.nl>
 *
 * @since  1.0.0
 */
interface TwigServiceInterface extends TemplaterInterface
{
    /**
     * Retrieve the used Twig Environment.
     *
     * @see https://twig.symfony.com/doc/3.x/api.html#:~:text=Twig%20uses%20a%20central%20object,use%20that%20to%20load%20templates.
     */
    public function getEnvironment(): Environment;
}
