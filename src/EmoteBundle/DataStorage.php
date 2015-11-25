<?php

namespace GbsLogistics\Emotes\EmoteBundle;


/**
 * Handles moving files around the data directory.
 *
 * Class DataStorage
 * @package GbsLogistics\Emotes
 */
class DataStorage
{
    const SOURCE_DIRECTORY = 'source';
    const DIST_DIRECTORY = 'dist';

    /** @var string */
    private $dataDirectory;

    function __construct($dataDirectory)
    {
        $this->dataDirectory = $dataDirectory;
        if (!$dataDirectory) {
            throw new \InvalidArgumentException('Argument to DataStorage::__construct cannot be empty.');
        }
    }

    public function copyImageToSource($imagePath)
    {
        return $this->copyImage($imagePath, self::SOURCE_DIRECTORY);
    }

    public function copyImageToDest($imagePath, $targetNamespace)
    {
        return $this->copyImage($imagePath, self::DIST_DIRECTORY . DIRECTORY_SEPARATOR . $targetNamespace);
    }

    public function getImageSourcePath($imageFilename)
    {
        return $this->getImagePath($imageFilename, self::SOURCE_DIRECTORY);
    }

    public function getSourceDirectory()
    {
        return $this->dataDirectory . DIRECTORY_SEPARATOR . self::SOURCE_DIRECTORY;
    }

    /**
     * @param string $namespace
     * @return string
     */
    public function getDistDirectory($namespace)
    {
        $distDirectory = $this->dataDirectory . DIRECTORY_SEPARATOR . self::DIST_DIRECTORY . DIRECTORY_SEPARATOR . $namespace;
        if (!is_dir($distDirectory)) {
            mkdir($distDirectory, 0755, true);
        }

        return $distDirectory;
    }


    /**
     * @param $imagePath string Path to the target image to copy.
     * @param $targetNamespace string The namespace for this image.
     * @return bool TRUE on success, FALSE on failure.
     * @throws \RuntimeException Thrown if the output directory is not writable or the image is not readable.
     *
     */
    private function copyImage($imagePath, $targetNamespace)
    {
        $destinationDirectory = $this->dataDirectory . DIRECTORY_SEPARATOR . $targetNamespace;

        if (!is_writable($this->dataDirectory)) {
            throw new \RuntimeException(sprintf('Could not write to directory %s.', $this->dataDirectory));
        }

        if (!is_writable($destinationDirectory)) {
            if (!mkdir($destinationDirectory, 0755, true)) {
                throw new \RuntimeException(sprintf('Could not create directory %s.', $destinationDirectory));
            }
        }

        if (!is_readable($imagePath)) {
            throw new \RuntimeException(sprintf('Could not read file %s.', realpath($imagePath)));
        }

        return copy($imagePath, $destinationDirectory . DIRECTORY_SEPARATOR . pathinfo($imagePath, PATHINFO_BASENAME));
    }

    /**
     * @param $imageFilename string
     * @param $targetNamespace string
     * @return null|string
     */
    private function getImagePath($imageFilename, $targetNamespace)
    {
        $filename = $this->dataDirectory . DIRECTORY_SEPARATOR . $targetNamespace . DIRECTORY_SEPARATOR . $imageFilename;
        if (file_exists($filename)) {
            return realpath($filename);
        }

        return null;
    }
}