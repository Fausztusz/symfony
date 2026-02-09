<?php

namespace App\Controller;

use App\Entity\Team;
use App\Form\TeamType;
use App\Repository\ProjectRepository;
use App\Repository\TeamRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class TeamController extends AbstractController
{

    #[Route('/teams', name: 'team')]
    public function index(Request $request, TeamRepository $teamRepository): Response
    {
        $limit = $request->query->getInt('limit', 10);

        return $this->render('team/index.html.twig', [
            'teams' => $teamRepository->paginate(
                $request->query->getInt('page', 1),
                $limit,
            ),
        ]);
    }

    #[Route('/team/create', name: 'team.create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $team = new Team();

        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team');
        }

        return $this->render('team/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/team/{id}', name: 'team.update')]
    public function update(?Team $team, Request $request, EntityManagerInterface $em): Response
    {
        if (null === $team) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $form = $this->createForm(TeamType::class, $team);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($team);
            $em->flush();

            return $this->redirectToRoute('team');
        }

        return $this->render('team/create.html.twig', [
            'form' => $form,
            'id' => $team->getId(),
        ]);
    }

    #[Route('/team/{id}/stat', name: 'team.stat')]
    public function stat(?Team $team, TeamRepository $teamRepository, ProjectRepository $projectRepository): Response
    {
        if (null === $team) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }

        return $this->render('team/stat.html.twig', [
            'teamStatistics' =>  $teamRepository->getTeamStatistics($team->getId()),
            'projectStatistics' =>  $projectRepository->getProjectStatistics($team->getId()),
        ]);
    }

    #[Route('/team/{id}/delete', name: 'team.delete',)]
    public function delete(?Team $team, EntityManagerInterface $em): RedirectResponse
    {
        if (null === $team) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $em->remove($team);
        $em->flush();
        return $this->redirectToRoute('team');
    }
}
