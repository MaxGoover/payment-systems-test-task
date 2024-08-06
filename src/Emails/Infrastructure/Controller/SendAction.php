<?php

namespace App\Emails\Infrastructure\Controller;

use App\Emails\Application\Command\CreateEmailDistribution\CreateEmailDistributionCommand;
use App\Shared\Application\Command\CommandBusInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Serializer\SerializerInterface;

class SendAction extends AbstractController
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private SerializerInterface $serializer,
    ) {
    }

    #[Route('/api/send', methods: ['POST'])]
    public function __invoke(Request $request): JsonResponse
    {
        $command = $this->serializer->deserialize($request->getContent(), CreateEmailDistributionCommand::class, 'json');
        $createdEmailIdsList = $this->commandBus->execute($command);

        return new JsonResponse([
            'createdEmailIdsList' => $createdEmailIdsList,
            'message'            => 'Emails created successfully',
        ]);
    }
}
