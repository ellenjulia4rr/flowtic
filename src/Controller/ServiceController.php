<?php

namespace App\Controller;

use App\Filter\ServiceFilter;
use App\Form\Type\Filter\ServiceFilterType;
use App\Service\ServiceService;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/service', name: 'service_')]
class ServiceController extends AbstractCRUDController
{
    #[Route('/', name: 'index', methods: ['GET'])]
    public function index(Request $request, ServiceService $service, PaginatorInterface $paginator) : JsonResponse
    {
        $filter = new ServiceFilter();
        return parent::indexAction($request, $service, $paginator, $filter, ServiceFilterType::class );
    }
}