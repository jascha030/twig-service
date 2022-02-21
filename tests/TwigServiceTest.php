<?php
/** @noinspection PhpPropertyOnlyWrittenInspection */

declare(strict_types=1);

namespace Jascha030\Twig\Tests;

use Jascha030\Twig\TwigService;
use Jascha030\Twig\TwigServiceInterface;
use PHPUnit\Framework\TestCase;
use Twig\Environment;
use Twig\Loader\ArrayLoader;
use Twig\Loader\FilesystemLoader;

/**
 * @covers \Jascha030\Twig\TwigService
 *
 * @internal
 *
 * @since  1.0.0
 */
final class TwigServiceTest extends TestCase
{
    private const TEMPLATE_DIR = __DIR__ . '/Fixtures/templates';

    private const EXPECTED_RESULTS_DIR = __DIR__ . '/Fixtures/result';

    private static ?Environment $defaultEnvironment;

    private static array $templateData = [
        'template' => 'template.html.twig',
        'context'  => ['location' => 'World'],
    ];

    /**
     * Create Environment using FilesystemLoader for tests/Fixtures/templates.
     *
     * @see   Environment
     * @see   FilesystemLoader
     * @since 1.0.0
     */
    public static function setUpBeforeClass(): void
    {
        self::$defaultEnvironment = new Environment(new FilesystemLoader(self::TEMPLATE_DIR));
    }

    /**
     * {@inheritDoc}
     *
     * @since 1.0.0
     */
    public static function tearDownAfterClass(): void
    {
        self::$defaultEnvironment = null;
    }

    /**
     * @dataProvider environmentProvider
     *
     * @since        1.0.0
     */
    public function testConstructWithLoaders(Environment $environment): void
    {
        $this->assertInstanceOf(TwigServiceInterface::class, new TwigService($environment));
    }

    /**
     * @depends testConstructWithLoaders
     *
     * @since   1.0.0
     */
    public function testConstruct(): TwigServiceInterface
    {
        $service = new TwigService(self::$defaultEnvironment);

        $this->assertInstanceOf(TwigServiceInterface::class, $service);

        return $service;
    }

    /**
     * @depends testConstruct
     *
     * @since   1.0.0
     */
    public function testGetEnvironment(TwigServiceInterface $service): void
    {
        $this->assertInstanceOf(FilesystemLoader::class, $service->getEnvironment()->getLoader());
    }

    /**
     * @depends      testConstruct
     *
     * @since        1.0.0
     */
    public function testRenderString(TwigServiceInterface $service): string
    {
        $expected             = file_get_contents(self::EXPECTED_RESULTS_DIR . '/expected.html');
        [$template, $context] = $this->getTemplateData();

        $output = $service->renderString($template, $context);
        $this->assertEquals($expected, $output);

        return $output;
    }

    /**
     * @depends      testConstruct
     * @depends      testRenderString
     *
     * @since        1.0.0
     */
    public function testRender(TwigServiceInterface $service, string $expected): void
    {
        [$template, $context] = $this->getTemplateData();

        ob_start();
        $service->render($template, $context);

        $this->assertEquals($expected, ob_get_clean());
    }

    /**
     * Creates test Environments with identical templates, using FilesystemLoader and ArrayLoader.
     *
     * @see   FilesystemLoader
     * @see   ArrayLoader
     * @since 1.0.0
     */
    public function environmentProvider(): array
    {
        return [
            'Environment with FilesystemLoader' => [
                new Environment(new FilesystemLoader(self::TEMPLATE_DIR)),
            ],
            'Environment with ArrayLoader' => [
                new Environment(new ArrayLoader([
                    'template.html.twig' => '<p>Hello {{ location }}!</p>',
                ])),
            ],
        ];
    }

    /**
     * Provides template name, context array.
     *
     * @since 1.0.0
     */
    private function getTemplateData(): array
    {
        return array_values(self::$templateData);
    }
}
