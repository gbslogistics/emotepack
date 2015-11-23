<?php

namespace GbsLogistics\Emotes\ImageBundle\Processor;


/**
 * Interface ProcessorInterface
 * @package GbsLogistics\Emotes\ImageBundle\Processor
 */
interface ProcessorInterface
{
    /**
     * Processes an image.
     *
     * @param \Imagick $inputImage
     * @return \Imagick The processed image.
     */
    public function processImage(\Imagick $inputImage);

}