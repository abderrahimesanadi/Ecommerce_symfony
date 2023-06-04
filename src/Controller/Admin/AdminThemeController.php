<?php

namespace App\Controller\Admin;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use App\Repository\ProductRepository;
use Symfony\Component\HttpFoundation\Request;
use Doctrine\ORM\EntityManagerInterface;
use Knp\Component\Pager\PaginatorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;

use function PHPSTORM_META\map;

/**
 * Require ROLE_ADMIN for *every* controller method in this class.
 *
 * @IsGranted("ROLE_ADMIN")
 */
class AdminThemeController extends AbstractController
{

    private EntityManagerInterface $em;

    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }
    /**
     * @Route("/admin/themes", name="admin_themes")
     */
    public function index(Request $request, PaginatorInterface $paginator, ProductRepository $productRepository): Response
    {
        $themes = ["cerulean", "cosmo", "cyborg", "darkly", "flaty", "journal", "literia", "lumen", "lux"];
        $imgthemes = array_map(function ($t) {
            return "themes/" . $t . ".jpg";
        }, $themes);

        return $this->render('admin_theme/list.html.twig', ["themes" => $imgthemes]);
    }
}
