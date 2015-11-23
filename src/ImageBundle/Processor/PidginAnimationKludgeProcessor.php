<?php

namespace GbsLogistics\Emotes\ImageBundle\Processor;

/**
 * Pidgin has a GTK bug where animated images only read the animation delay for
 * the first frame of an animated gif, and re-use it on all frames. This makes
 * animations look very strange. This processor works around this by re-timing
 * an animated gif to use the same animation delay throughout. It adds duplicate
 * frames to simulate variable animation delay.
 *
 * Class PidginAnimationKludgeProcessor
 * @package GbsLogistics\Emotes\ImageBundle\Processor
 */
class PidginAnimationKludgeProcessor implements ProcessorInterface
{
    /**
     * Processes an image.
     *
     * @param \Imagick $inputImage
     * @return \Imagick The processed image.
     */
    public function processImage(\Imagick $inputImage)
    {
        $totalFrames = 0;
        $uniqueFrameDelays = [];

        // If the image isn't animated, we don't have to do anything.
        if ($inputImage->getIteratorIndex() < 2) {
            return $inputImage;
        }

        $imageCopy = $inputImage->coalesceImages();

        // Count frames, and build a set of unique frame delay amounts.
        /** @var \Imagick $item */
        foreach ($imageCopy as $item) {
            $totalFrames++;
            $delay = $item->getImageDelay();

            if (!isset($uniqueFrameDelays[$delay])) {
                $uniqueFrameDelays[$delay] = 0;
            }

            $uniqueFrameDelays[$delay]++;
        }

        // If all the frames are the same length, we don't need to do anything.
        if (1 === count($uniqueFrameDelays)) {
            return $inputImage;
        }

        // To re-time the animation, we'll need to find the least common
        // multiple of all the frame delays.
        $frameDelays = array_keys($uniqueFrameDelays);
        $newDelay = max(min($frameDelays), gcf_array($frameDelays));

        $inputImage = $inputImage->coalesceImages();
        $outputImage = new \Imagick();

        var_dump(["Input delay", $inputImage->getImageDelay()]);
        /** @var \Imagick $frame */
        foreach ($inputImage as $frame) {
            $outputFrame = clone ($frame->getImage());
            $frameCount = floor($outputFrame->getImageDelay() / $newDelay);
            $outputFrame->setImageDelay($newDelay);

            for ($i = 0; $i < $frameCount; $i++) {
                $outputImage->addImage($outputFrame);
            }
        }

//        $outputImage = $outputImage->deconstructImages();
        $outputImage->setImageFormat('gif');

        foreach ($outputImage as $frame) {
            var_dump($frame->getImageDelay());
        }


        var_dump($inputImage->getImageLength());
        var_dump($outputImage->getImageLength());
        $outputImage->writeImages("output.gif", true);

        return $outputImage;
    }
}

/**
 * Calculates the Greatest Common Factor of two integers.
 *
 * @param int $a
 * @param int $b
 * @return int
 */
function gcf($a, $b)
{
    return ($b == 0) ? $a : gcf($b, $a % $b);
}

/**
 * Calculates the Least Common Multiple of an array of integers.
 *
 * @param array $array
 * @return integer
 */
function gcf_array($array)
{
    if (!is_array($array)) {
        throw new \InvalidArgumentException('lcm_array expects an array of integers.');
    }

    if (count($array) > 1) {
        $array[] = gcf(array_shift($array), array_shift($array));
        return gcf_array($array);
    }
    return $array[0];
}