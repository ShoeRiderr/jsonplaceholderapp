<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{
    #[Route('/lista', name: 'app_post', methods: ['GET', 'HEAD'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(PostRepository $posts): Response
    {
        return $this->render('post/index.html.twig', [
            'controller_name' => 'PostController',
            'posts' => $posts->findAll(),
        ]);
    }

    #[Route('/post/{post}', name: 'app_post_delete', methods: ['GET', 'DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(PostRepository $posts, Post $post): Response
    {
        $posts->remove($post, true);

        $this->addFlash('success', 'Your post is deleted successfully.');

        return $this->redirectToRoute('app_post');
    }
}
