<?php

namespace App\Controller;

use App\Entity\Post;
use App\Repository\PostRepository;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

class PostController extends AbstractController
{
    #[Route('/lista', name: 'app_post', methods: ['GET', 'HEAD'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function index(PostRepository $postRepository, Request $request, PaginatorInterface $paginator): Response
    {
        // Find all the data on the Appointments table, filter your query as you need
        $allPostsQuery = $postRepository->createQueryBuilder('p')
            ->getQuery();

        // Paginate the results of the query
        $posts = $paginator->paginate(
            // Doctrine Query, not results
            $allPostsQuery,
            // Define the page parameter
            $request->query->getInt('page', 1),
            // Items per page
            5
        );

        return $this->render('post/index.html.twig', [
            'posts' => $posts,
        ]);
    }

    #[Route('/post/{post}', name: 'app_post_delete', methods: ['GET', 'DELETE'])]
    #[IsGranted('IS_AUTHENTICATED_FULLY')]
    public function delete(PostRepository $postRepository, Post $post): Response
    {
        $postRepository->remove($post, true);

        $this->addFlash('success', 'Your post is deleted successfully.');

        return $this->redirectToRoute('app_post');
    }
}
