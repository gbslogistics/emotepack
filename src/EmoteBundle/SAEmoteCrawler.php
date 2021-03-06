<?php

namespace GbsLogistics\Emotes\EmoteBundle;


use GbsLogistics\Emotes\EmoteBundle\Model\RemoteEmote;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;

class SAEmoteCrawler
{
    const /** @noinspection SpellCheckingInspection */
        EMOTES_URL = 'http://forums.somethingawful.com/misc.php?action=showsmilies';

    /** @var Client */
    private $client;

    /** @var array */
    private $blacklist;

    function __construct($blacklist = [])
    {
        $this->blacklist = $blacklist;
        $this->client = new Client();
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client)
    {
        $this->client = $client;
    }

    /**
     * Crawls the SA emote page, pulling all the emotes.
     *
     * @return RemoteEmote[]
     */
    public function crawl()
    {
        $crawler = $this->client->request('GET', self::EMOTES_URL);
        $remoteEmotes = array();

        /** @noinspection SpellCheckingInspection */
        $crawler->filter('.smilie')->each(function (Crawler $node, $i) use (&$remoteEmotes) {
            $emote = $node->filter('.text')->text();
            $imageUrl = $node->filter('img')->attr('src');

            if (in_array($emote, $this->blacklist)) {
                return;
            }

            if ($emote && $imageUrl) {
                $remoteEmotes[] = new RemoteEmote($emote, $imageUrl);
            }
        });

        return $remoteEmotes;
    }
}