<?php

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class RecipientRepositoryTest extends \PHPUnit\Framework\TestCase {

    public function Logger(){
        $logger = new \Monolog\Logger('slim-app');
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log', \Monolog\Logger::DEBUG));
        return new \App\Service\LoggerService($logger);
    }

    public function testSaveRecipient()
    {
        $recipientMock = $this->createMock(\App\Entity\Recipient::class);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($recipientMock);
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $classUnderTest = new \App\Repository\RecipientRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->save($recipientMock);

        $this->assertTrue($result);
    }

    public function testGetRecipientById()
    {
        $recipientMock = $this->createMock(\App\Entity\Recipient::class);

        $entityRepositoryMock = $this->createMock(EntityRepository::class);
        $entityRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 8])
            ->willReturn($recipientMock);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(\App\Entity\Recipient::class)
            ->willReturn($entityRepositoryMock);

        $classUnderTest = new \App\Repository\RecipientRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->get(['id' => 8]);

        $this->assertEquals($recipientMock, $result);
    }

}