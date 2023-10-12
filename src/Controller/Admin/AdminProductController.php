<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ProductType;
use App\Entity\Product;
use App\Entity\Image;
use App\Repository\CategoryRepository;
use App\Repository\ProductRepository;
use App\Services\ImageService;
use Doctrine\ORM\EntityManagerInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use Symfony\Component\String\Slugger\AsciiSlugger;
use Symfony\Component\HttpFoundation\Request;
use Knp\Component\Pager\PaginatorInterface;

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
    public function index(Request $request, PaginatorInterface $paginator, ProductRepository $productRepository): Response
    {
        $QueryProducts = $productRepository->findtheLatestProducts();
        $products = $paginator->paginate(
            $QueryProducts, /* query NOT result */
            $request->query->getInt("page", 1),
            10
        );
        return $this->render('admin_product/list.html.twig', [
            'products' => $products,
        ]);
    }

    /**
     * @Route("/admin/produit/createOrEdit/{id}", name="product_createOrEdit")
     */
    public function createOrEdit($id, Request $request, EntityManagerInterface $em, ImageService $imageService, ValidatorInterface $validator): Response
    {
        $images_path = [];
        if ($id == 0) {
            $product = new Product();
        } else {
            $product = $em->getRepository(Product::class)->find($id);
            $images = $em->getRepository(Image::class)->findBy(['product' => $product->getId()]);
            foreach ($images as $image) {
                array_push($images_path, $image->getPath());
            }
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

            $images = $form['images']->getData();
            if ($images) {
                foreach ($images as $img) {
                    $image = new Image();
                    $newFilename = $imageService->uploadImage($img);
                    $image->setPath('images/' . $newFilename);
                    $image->setProduct($product);
                    $em->persist($image);
                }
            }
            $slugger = new AsciiSlugger();
            $slug = $slugger->slug($form['title']->getData());
            $product->setSlug($slug);

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
            'images_path' => $images_path
        ]);
    }

    /**
     * @Route("/admin/produit/remove/{id}", name="product_remove")
     */
    public function remove(Product $product,  EntityManagerInterface $em)
    {
        // TODO
        $em->remove($product);
        $products_numbers = $product->getCategory()->getProductNumber();
        $product->getCategory()->setProductNumber($products_numbers - 1);
        $em->flush();
        return $this->redirectToRoute('admin_products');
    }
}
