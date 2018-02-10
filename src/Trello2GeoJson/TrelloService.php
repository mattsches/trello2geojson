<?php

namespace Mattsches\Trello2GeoJson;

use Trello\Client;
use Trello\Exception\InvalidArgumentException;
use Trello\Manager;
use Trello\Model\CardInterface;

/**
 * Class TrelloService
 */
class TrelloService
{
    /**
     * @var Manager
     */
    private $manager;

    /**
     * TrelloService constructor.
     * @param string $apiKey
     * @param string $token
     * @throws InvalidArgumentException
     */
    public function __construct(string $apiKey, string $token)
    {
        $client = new Client();
        $client->authenticate($apiKey, $token, Client::AUTH_URL_CLIENT_ID);
        $this->manager = new Manager($client);
    }

    /**
     * @param $listId
     * @return array|CardInterface[]
     */
    public function getGeoCardsInList($listId): array
    {
        $cards = $this->manager->getList($listId)->getCards();
        $geoCards = array_filter(
            $cards,
            function (CardInterface $card) {
                preg_match('/geo:([0-9-.]+),([0-9-.]+)/', $card->getDescription(), $m);

                return \count($m) !== 0;
            }
        );

        return $geoCards;
    }
}
