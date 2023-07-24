<?php

namespace App\Twig\Components;

use App\Repository\EpisodeRepository;
use Symfony\UX\TwigComponent\Attribute\AsTwigComponent;

#[AsTwigComponent('last_episode')]
final class LastEpisodeComponent
{
    public function __construct(
        private EpisodeRepository $episodeRepository
    ) {   
    }

    public function getEpisodes(): array
    {
        return $this->episodeRepository->findBy([], ['id' => 'DESC'], 3);
    }
}
