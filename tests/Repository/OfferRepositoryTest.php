<?php

use App\Entity\SpecialOffer;
use App\Repository\OfferRepository;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class OfferRepositoryTest extends \PHPUnit\Framework\TestCase {

    public function Logger(){
        $logger = new \Monolog\Logger('slim-app');
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log', \Monolog\Logger::DEBUG));
        return new \App\Service\LoggerService($logger);
    }

    public function testGetOfferById()
    {

        $offerMock = $this->createMock(SpecialOffer::class);

        $entityRepositoryMock = $this->createMock(EntityRepository::class);
        $entityRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 2])
            ->willReturn($offerMock);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(SpecialOffer::class)
            ->willReturn($entityRepositoryMock);

        $classUnderTest = new OfferRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->get(['id' => 2]);

        $this->assertEquals($offerMock, $result);
    }

    public function testGetAllSpecialOffers()
    {
        $offerMock = $this->createMock(SpecialOffer::class);

        $expectedResult = [
            $offerMock
        ];

        $entityRepositoryMock = $this->createMock(\Doctrine\ORM\EntityRepository::class);
        $entityRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedResult);

        $entityManagerMock = $this->createMock(\Doctrine\ORM\EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(SpecialOffer::class)
            ->willReturn($entityRepositoryMock);

        $classUnderTest = new OfferRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->getAll();

        $this->assertEquals($expectedResult, $result);
    }

    public function testSaveOffers()
    {
        $offerMock = $this->createMock(SpecialOffer::class);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($offerMock);
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $classUnderTest = new OfferRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->save($offerMock);

        $this->assertTrue($result);
    }

}