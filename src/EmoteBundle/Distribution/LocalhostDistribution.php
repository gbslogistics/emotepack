<?php

namespace GbsLogistics\Emotes\EmoteBundle\Distribution;


use GbsLogistics\Emotes\EmoteBundle\Model\PublishedRelease;

class LocalhostDistribution extends AbstractDistribution
{
    /** @var string */
    private $webRootPath;

    function __construct($webRootPath)
    {
        $this->webRootPath = $webRootPath;
    }

    /**
     * @param string $indexHTML
     * @return void
     */
    protected function distribute($indexHTML)
    {
        if (!is_dir($this->webRootPath) || !is_writable($this->webRootPath)) {
            throw new \RuntimeException('Could not write to web root.');
        }

        file_put_contents($this->webRootPath . DIRECTORY_SEPARATOR . 'index.html', $indexHTML);
    }
}