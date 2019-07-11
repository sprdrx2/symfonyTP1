<?php

namespace App\Controller;

use App\Entity\Product;
use App\Form\ProductType;
use App\Entity\Comment;
use App\Form\CommentType;
use App\Entity\PopularVote;
use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    
    /**
     * @Route("/product/{slug}", name="product_show_public_slug", methods={"GET"}) 
     */
    public function showPublic(String $slug): Response
    {
	   $product = $this->getDoctrine()->getRepository(Product::class)->findOneByTitle(str_replace('-', ' ', $slug));
	   $comment = new Comment();
	   $comment->setProduct($product); 
	   $form = $this->createForm(CommentType::class, $comment); 
	   return $this->render('product/show.public.html.twig', [
		   'product' => $product,
		   'form'    => $form->createView(),
        ]);
    }

   /**	
    * @Route("/vote/{id}/{verdict}", name="product_vote", methods={"GET"}, requirements={ "verdict" = "OK|NOK" } )
    */
    public function productVoteAction(Product $product, String $verdict) {
	    $v = ($verdict === "OK") ? TRUE : FALSE;
	    $pV = new PopularVote();
	    $pV->setProduct($product);
	    $pV->setVerdict($v);
	    $this->getDoctrine()->getManager()->persist($pV);
	    $this->getDoctrine()->getManager()->flush();
	    //return $this->json(['popularVotesOK' => $product->getPopularVotesOK(), "popularVotesNOK" => $product->getPopularVotesNOK() ]); // pour AJAX après
    	    return $this->redirectToRoute('product_show_public_slug', ['slug' => $product->getSlug() ]);
    }

    /**
     * @Route("/manager/product", name="product_index", methods={"GET"})
     */
    public function index(ProductRepository $productRepository): Response
    {
        return $this->render('product/index.html.twig', [
            'products' => $productRepository->findAll(),
        ]);
    }

    /**
     * @Route("/manager/product/new", name="product_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $product = new Product();
        $form = $this->createForm(ProductType::class, $product);
	$form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($product);
            $entityManager->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/new.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/manager/product/{id}", name="product_show", methods={"GET"})
     */
    public function show(Product $product): Response
    {
        return $this->render('product/show.html.twig', [
            'product' => $product,
        ]);
    }

    /**
     * @Route("/manager/product/{id}/edit", name="product_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Product $product): Response
    {
        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('product_index');
        }

        return $this->render('product/edit.html.twig', [
            'product' => $product,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/manager/product/{id}", name="product_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Product $product): Response
    {
        if ($this->isCsrfTokenValid('delete'.$product->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($product);
            $entityManager->flush();
        }

        return $this->redirectToRoute('product_index');
    }
}
