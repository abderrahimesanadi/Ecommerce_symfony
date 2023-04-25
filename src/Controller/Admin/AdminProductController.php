<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use App\Entity\Product;
use App\Repository\ProductRepository;
use App\Services\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */

class AdminProductController extends AbstractController
{
    /**
     * @Route("/admin/produits", name="admin_products")
     */
    public function index(ProductRepository $productRepository): Response
    {
        $products = $productRepository->findAll();
        return $this->render('admin_product/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/admin/produit/createOrEdit/{id}", name="product_createOrEdit")
     */
    public function createOrEdit($id, Request $request, EntityManagerInterface $em, ImageService $imageService, ValidatorInterface $validator): Response
    {
        if ($id == 0) {
            $product = new Product();
        } else {
            $product = $em->getRepository(Product::class)->find($id);
            if (!$product) {
                throw $this->createNotFoundException(
                    'produit introuvable '
                );
            }
        }

        $form = $this->createForm(ProductType::class, $product);
        $form->handleRequest($request);

        $errors = $validator->validate($product);
        if (count($errors) > 0) {
            $this->addFlash(
                'danger',
                (string) $errors
            );
            return new Response((string) $errors, 400);
        }
        if ($form->isSubmitted() && $form->isValid()) {

            $image = $form['image']->getData();
            if ($image) {
                $newFilename = $imageService->uploadImage($image);
                $product->setImage('images/' . $newFilename);
            }
            $msg = 'Produit crée avec succès!';
            if ($product->getId() != 0) {
                $msg = 'Produit modifié avec succès!';
            } else {
                $productNumber = (int)$product->getCategory()->getProductNumber();
                $product->getCategory()->setProductNumber($productNumber + 1);
                $em->persist($product);
            }

            $this->addFlash(
                'notice',
                $msg
            );
        }
        $em->flush();

        //return $this->redirectToRoute('product_index');

        return $this->render('admin_product/createOrEdit.html.twig', [
            'form' => $form->createView(),
            'product' => $product,
        ]);
    }

    /**
     * @Route("/admin/produit/remove/{id}", name="product_remove")
     */
    public function remove(Product $product,  EntityManagerInterface $em, Request $request)
    {
        // TODO
        $em->remove($product);
        $em->flush();
        return $this->redirectToRoute('admin_products');
    }
}
