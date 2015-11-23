<?php
namespace GbsLogistics\Emotes\ImageBundle\Tests\Processor;

use GbsLogistics\Emotes\ImageBundle\Processor\PidginAnimationKludgeProcessor;
use GbsLogistics\Emotes\ImageBundle\Processor\ProcessorInterface;
use PHPUnit_Framework_TestCase;

class PidginAnimationKludgeProcessorTest extends PHPUnit_Framework_TestCase
{
    /** @var ProcessorInterface */
    private $processor;

    /** @var string */
    private static $fixturesDir;

    public static function setUpBeforeClass()
    {
        parent::setUpBeforeClass();
        self::$fixturesDir = __DIR__ . '/../fixtures';
    }

    public function setUp()
    {
        $this->processor = new PidginAnimationKludgeProcessor();
    }

    public function testCanDetectAnimatedImages()
    {
        /** @noinspection SpellCheckingInspection */
        $staticImagePath = self::$fixturesDir . '/emot-v.gif';
        /** @noinspection SpellCheckingInspection */
        $animatedImagePath = self::$fixturesDir . '/psythulu.gif';

        $this->assertTrue(file_exists($staticImagePath));
        $this->assertTrue(file_exists($animatedImagePath));

        $staticImage = new \Imagick($staticImagePath);
        $animatedImage = new \Imagick($animatedImagePath);

        $this->assertNotEquals(0, $staticImage->getImageSize(), 'Expected static image size to not be zero bytes.');
        $this->assertNotEquals(0, $animatedImage->getImageSize(), 'Expected animated image size to not be zero bytes.');

        $this->assertSame($staticImage, $this->processor->processImage($staticImage));
        $this->assertNotSame($animatedImage, $this->processor->processImage($animatedImage));
    }
}
