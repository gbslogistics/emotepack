<?php

namespace GbsLogistics\Emotes\EmoteBundle\Distribution;


use GbsLogistics\Emotes\S3Client;

class S3Distribution extends AbstractDistribution
{
    /**
     * @var S3Client
     */
    private $client;

    function __construct(S3Client $client)
    {
        $this->client = $client;
    }

    /**
     * @param string $indexHTML
     * @return void
     */
    protected function distribute($indexHTML)
    {
        $tempFile = tempnam(sys_get_temp_dir(), 'gbslogistics_emotes_index_html');
        file_put_contents($tempFile, $indexHTML);

        $this->client->putObject('index.html', $tempFile);

        unlink($tempFile);
    }
}