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
use App\Repository\UserRepository;

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
        $themes = [
            "cerulean" => "themes/cerulean.jpg", "cosmo" => "themes/cosmo.jpg",
            "cyborg" => "themes/cyborg.jpg", "darkly" => "themes/darkly.jpg",
            "flaty" => "themes/flaty.jpg", "journal" => "themes/journal.jpg", "literia" => "themes/literia.jpg",
            "lumen" => "themes/lumen.jpg", "lux" => "themes/lux.jpg",
            "materia" => "themes/materia.jpg", "minty" => "themes/minty.jpg",
            "murph" => "themes/murph.jpg", "pulse" => "themes/pulse.jpg",
            "quartz" => "themes/quartz.jpg", "sandstone" => "themes/sandstone.jpg"


        ];
        return $this->render('admin_theme/list.html.twig', [
            "themes" => $themes
        ]);
    }

    /**
     * @Route("/admin/theme/update/{theme}", name="update_theme")
     */
    public function updateTheme($theme): Response
    {
        $user = $this->getUser();
        $user->setTheme($theme);
        $this->em->persist($user);
        $this->em->flush();
        $this->addFlash("success", "modification enregistré");
        return new JsonResponse("modification enregistré");
    }
}
