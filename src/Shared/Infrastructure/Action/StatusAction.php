<?php

namespace App\Shared\Infrastructure\Action;

use App\Emails\Application\Query\FindEmailById\FindEmailByIdQuery;
use App\Shared\Application\Query\QueryBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class StatusAction extends AbstractController
{
    public function __construct(
        private QueryBusInterface $queryBus,
        private SerializerInterface $serializer,
    ) {
    }

    #[Route('/api/status', methods: ['GET'])]
    public function __invoke(Request $request): JsonResponse
    {
        $query = new FindEmailByIdQuery($request->query->get('id'));
        $emailDTO = $this->queryBus->execute($query);

        if (is_null($emailDTO)) {
            return new JsonResponse(['message' => 'Email not found'], Response::HTTP_BAD_REQUEST);
        }

        return new JsonResponse([
            'message' => 'Email got successfully',
            'status'  => $emailDTO->getStatusCodename(),
        ]);
    }
}
