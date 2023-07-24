<?php

namespace App\Controller\UserControllers;

use App\Entity\Actor;
use App\Entity\Category;
use App\Entity\Episode;
use App\Entity\Program;
use App\Entity\Season;
use App\Form\ProgramType;
use App\Form\SearchProgramType;
use App\Repository\ActorRepository;
use App\Repository\CategoryRepository;
use App\Repository\EpisodeRepository;
use App\Repository\ProgramRepository;
use App\Repository\SeasonRepository;
use App\Repository\UserRepository;
use App\Service\ProgramDuration;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Entity;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\String\Slugger\SluggerInterface;

#[Route('/app/program')]

class UserProgramController extends AbstractController
{
    #[Route("/{id}/watchlist", name: "user_watchlist", methods: ['GET', 'POST'])]
    #[IsGranted('ROLE_CONTRIBUTOR')]
    public function addToWatchlist(Program $program, UserRepository $userRepository): Response
    {
        if (!$program) {
        throw $this->createNotFoundException(
            'No program with this id found in program\'s table.'
        );
    }

    /** @var \App\Entity\User */
    $user = $this->getUser();
    if ($user->isInWatchlist($program)) {
        $user->removeFromWatchlist($program);
    } else {
        $user->addToWatchlist($program);
    }

    $userRepository->save($user, true);

    return $this->json([
        'isInWatchlist' => $this->getUser()->isInWatchlist($program)
    ]);
    }
}