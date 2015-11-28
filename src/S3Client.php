<?php

namespace GbsLogistics\Emotes;


use Aws\Credentials\CredentialProvider;
use Aws\S3\S3Client as BaseClient;

class S3Client
{
    /** @var string */
    private $bucket;

    /** @var S3Client */
    private $client;

    function __construct($bucket, $profile = null, $region = 'us-east-1')
    {
        $this->bucket = $bucket;

        $parameters = [
            'version' => '2006-03-01',
            'region' => $region,
        ];

        if (null !== $profile) {
            $parameters['profile'] = $profile;
        }

        $this->client = new BaseClient($parameters);
    }

    /**
     * @return string
     */
    public function getBucket()
    {
        return $this->bucket;
    }

    /**
     * @param string $key
     * @param string $filename
     * @return \Aws\Result
     */
    public function putObject($key, $filename)
    {
        return $this->client->putObject([
            'Bucket' => $this->getBucket(),
            'Key' => $key,
            'SourceFile' => $filename,
            'ACL' => 'public-read'
        ]);
    }
}