<?php

namespace App\Controller;

use App\Entity\Project;
use App\Form\ProjectType;
use App\Repository\ProjectRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class ProjectController extends AbstractController
{
    #[Route('/project', name: 'project')]
    public function index(Request $request, ProjectRepository $projectRepository): Response
    {
        $limit = $request->query->getInt('limit', 10);

        return $this->render('project/index.html.twig', [
            'projects' => $projectRepository->paginate(
                $request->query->getInt('page', 1),
                $limit,
            ),
        ]);
    }

    #[Route('/projects/create', name: 'project.create')]
    public function create(Request $request, EntityManagerInterface $em): Response
    {
        $project = new Project();

        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project');
        }

        return $this->render('project/create.html.twig', [
            'form' => $form,
        ]);
    }

    #[Route('/projects/{id}', name: 'project.update')]
    public function update(?Project $project, Request $request, EntityManagerInterface $em): Response
    {
        if (null === $project) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $form = $this->createForm(ProjectType::class, $project);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $em->persist($project);
            $em->flush();

            return $this->redirectToRoute('project');
        }

        return $this->render('project/create.html.twig', [
            'form' => $form,
            'id' => $project->getId(),
        ]);
    }

    #[Route('/projects/{id}/delete', name: 'project.delete',)]
    public function delete(?Project $project, EntityManagerInterface $em): RedirectResponse
    {
        if (null === $project) {
            return $this->redirectToRoute('error', ['code' => 404]);
        }
        $em->remove($project);
        $em->flush();
        return $this->redirectToRoute('project');
    }
}
