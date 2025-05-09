<?php

namespace App\Controller;

use App\Constants\SerializerGroups;
use App\Filter\AbstractFilter;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AbstractCRUDController extends AbstractController
{
    public function indexAction(
        Request $request, object $service, PaginatorInterface $paginator, AbstractFilter $filter, string $filterType,
    ): JsonResponse
    {
        $form = $this->createForm($filterType, $filter);
        $form->submit($request->query->all());

        try {
            if ($form->isValid()) {
                $pagination = $paginator->paginate(
                    $service->findByFilter($filter),
                    $request->query->get('page', $filter->getPage()?:1),
                    $request->query->get('per-page', $filter->getPerPage()?: 10)
                );
            } else {
                return self::getFormErrorResponse($form);
            }
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return $this->jsonResponseByPaginator($pagination);
    }

    public function createAction(
        Request $request, object $service, object $entity, string $type,
    ): JsonResponse
    {
        $form = $this->createForm($type, $entity);
        $form->submit(json_decode($request->getContent(), true));

        try {
            if ($form->isValid()) {
                $service->save($entity);
            } else {
                return self::getFormErrorResponse($form);
            }
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            data: $entity->toArray(),
            status: Response::HTTP_CREATED
        );
    }

    public function updateAction(
        Request $request, object $service, object $entity, string $type,
    ): JsonResponse
    {
        $form = $this->createForm($type, $entity, ['method' => 'PUT']);
        $form->submit([
            ...$entity->toArray([SerializerGroups::DEFAULT]),
            ...json_decode($request->getContent(), true)
        ]);

        try {
            if ($form->isValid()) {
                $service->save($entity);
            } else {
                return self::getFormErrorResponse($form);
            }
        } catch (\Exception $e) {
            return new JsonResponse(
                ['message' => $e->getMessage()],
                status: Response::HTTP_INTERNAL_SERVER_ERROR
            );
        }

        return new JsonResponse(
            data: $entity->toArray(),
            status: Response::HTTP_CREATED
        );
    }
}