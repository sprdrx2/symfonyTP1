<?php

namespace App\Controller;

use App\Entity\Rayon;
use App\Form\RayonType;
use App\Repository\RayonRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class RayonController extends AbstractController
{

    /**
     * @Route("/catalog", name="rayon_public_index_catalogue", methods = {"GET"})
     */
    public function rayonPublicIndexCatalogueAction(RayonRepository $rayonRepository): Response
    {
        return $this->render('rayon/catalogue.html.twig', [
            'rayons' => $rayonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/manager", name="rayon_manager_office", methods = {"GET"})
     */
    public function rayonManagerOfficeAction(RayonRepository $rayonRepository): Response {
	 return $this->render('rayon/managerOffice.html.twig', [
            'rayons' => $rayonRepository->findAll(),
        ]);
    }	    

    /**
     * @Route("/manager/rayon", name="rayon_index", methods={"GET"})
     */
    public function index(RayonRepository $rayonRepository): Response
    {
        return $this->render('rayon/index.html.twig', [
            'rayons' => $rayonRepository->findAll(),
        ]);
    }

    /**
     * @Route("/manager/rayon/new", name="rayon_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $rayon = new Rayon();
        $form = $this->createForm(RayonType::class, $rayon);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
	    
	     $imageFile = $form['imageFile']->getData();
	     if($imageFile) {
	   	$this->handleImageUpload($imageFile, $rayon); 
	     }	

	    $rayon->setDescription(htmlspecialchars($rayon->getDescription())); 
	    $entityManager->persist($rayon);
            $entityManager->flush();

            return $this->redirectToRoute('rayon_index');
        }

        return $this->render('rayon/new.html.twig', [
            'rayon' => $rayon,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/manager/rayon/{id}", name="rayon_show", methods={"GET"})
     */
    public function show(Rayon $rayon): Response
    {
        return $this->render('rayon/show.html.twig', [
            'rayon' => $rayon,
        ]);
    }

    /**
     * @Route("/manager/rayon/{id}/edit", name="rayon_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Rayon $rayon): Response
    {
        $form = $this->createForm(RayonType::class, $rayon);	
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

	     $imageFile = $form['imageFile']->getData();
	     if($imageFile) {
	   	$this->handleImageUpload($imageFile, $rayon); 
	     }	


	     $rayon->setDescription(htmlspecialchars($rayon->getDescription())); 
	     $this->getDoctrine()->getManager()->persist($rayon);
	     $this->getDoctrine()->getManager()->flush();
            return $this->redirectToRoute('rayon_index');
        }

        return $this->render('rayon/edit.html.twig', [
            'rayon' => $rayon,
            'form' => $form->createView(),
        ]);
    }

    private function handleImageUpload($imageFile, $rayon) {
	     	$originalFilename = pathinfo($imageFile->getClientOriginalName(), PATHINFO_FILENAME);
             	// this is needed to safely include the file name as part of the URL
             	//$safeFilename = transliterator_transliterate('Any-Latin; Latin-ASCII; [^A-Za-z0-9_] remove; Lower()', $originalFilename);
             	$newFilename = $originalFilename.'-'.uniqid().'.'.$imageFile->guessExtension();
	     	$imageFile->move('C:\Users\saami.perdrix\Downloads\IPI2\SYMFONY\epicerie\public', $newFilename);
	     	$rayon->setImageFile($newFilename);
     }     

    /**
     * @Route("/manager/rayon/{id}", name="rayon_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Rayon $rayon): Response
    {
        if ($this->isCsrfTokenValid('delete'.$rayon->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($rayon);
            $entityManager->flush();
        }

        return $this->redirectToRoute('rayon_index');
    }
}
