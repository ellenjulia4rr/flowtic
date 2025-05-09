<?php

namespace App\Controller;

use Doctrine\ORM\PersistentCollection;
use Knp\Bundle\PaginatorBundle\Pagination\SlidingPagination;
use Knp\Component\Pager\Pagination\PaginationInterface as Pagination;
use Knp\Component\Pager\PaginatorInterface;
use Symfony\Component\Form\FormError;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use \Symfony\Bundle\FrameworkBundle\Controller\AbstractController as SymfonyAbstractController;

class AbstractController extends SymfonyAbstractController
{
    private array $formatTextExceptions = array('email', 'uf', 'code', 'action');
    private function formatText(
        $value, string|null $key = null, bool|null $capitalize = null
    )
    {
        if(
            is_string($value) &&
            !in_array($key, $this->formatTextExceptions, true) &&
            $capitalize
        ) {
            $value = ucwords($value);
        }
        return $value;
    }

    private function formatData(
        array|null $data = null, bool|null $capitalize = null
    ): ?array
    {
        $capitalize ??= false;
        $data ??= [];

        if($data && $capitalize) {
            foreach ($data as $key => $value) {
                $data[$key] = (is_array($value)) ?
                    $this->formatData(
                        data: $value, capitalize: $capitalize
                    ) :
                    $this->formatText($value, $key)
                ;
            }
        }
        return $data;
    }

    public function itemsToArray(
        array|PersistentCollection $items,
        array|null                 $serializerGroups = null,
        bool                       $capitalize = false
    ): array {
        $data = [];
        foreach ($items as $item)
            $data[] = $item->toArray($serializerGroups);
        return $this->formatData($data, $capitalize);
    }

    public function jsonResponseByPaginator(
        SlidingPagination|PaginatorInterface|Pagination $pagination,
        int $statusCode = Response::HTTP_OK,
        array $serializerGroups = null,
        bool $capitalize = false
    ): JsonResponse
    {
        return $this->json(
            array(
                'success' => true,
                'data' => $this->itemsToArray((array)$pagination->getItems(), $serializerGroups, $capitalize),
                'page' => $pagination->getCurrentPageNumber(),
                'lastPage' => $pagination->getPageCount(),
                'nextPage' => $pagination->getCurrentPageNumber() < $pagination->getPageCount(),
                'previewsPage' => $pagination->getCurrentPageNumber() > 1,
                'perPage' => $pagination->getItemNumberPerPage(),
                'totalItems' => $pagination->getTotalItemCount(),
                'sort' => $pagination->getDirection()
            ),
            $statusCode
        );
    }

    public static function getFormErrorResponse(FormInterface $form): JsonResponse
    {
        $errors = [];
        /** @var FormError $error */
        foreach ($form->getErrors(true) as $error) {
            $errors[] = [
                "field" => $error->getOrigin()->getName(),
                "message" => $error->getMessage(),
            ];
        }

        return new JsonResponse(
            [
                'message' => $form->getErrors(true)[0]->getMessage(),
                'data' => $errors,
            ],
            status: Response::HTTP_BAD_REQUEST
        );
    }
}