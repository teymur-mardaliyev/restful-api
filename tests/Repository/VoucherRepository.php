<?php
/**
 * Created by PhpStorm.
 * User: Tima
 * Date: 8/27/18
 * Time: 04:37
 */

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityRepository;

class VoucherRepositoryTest extends \PHPUnit\Framework\TestCase {

    public function Logger(){
        $logger = new \Monolog\Logger('slim-app');
        $logger->pushProcessor(new \Monolog\Processor\UidProcessor());
        $logger->pushHandler(new \Monolog\Handler\StreamHandler(isset($_ENV['docker']) ? 'php://stdout' : __DIR__ . '/../logs/app.log', \Monolog\Logger::DEBUG));
        return new \App\Service\LoggerService($logger);
    }

    public function testGetAllVouchers()
    {
        $voucherMock = $this->createMock(\App\Entity\VoucherCode::class);

        $expectedResult = [
            $voucherMock
        ];

        $entityRepositoryMock = $this->createMock(EntityRepository::class);
        $entityRepositoryMock->expects($this->once())
            ->method('findAll')
            ->willReturn($expectedResult);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(\App\Entity\VoucherCode::class)
            ->willReturn($entityRepositoryMock);

        $classUnderTest = new \App\Repository\VoucherRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->getAll();

        $this->assertEquals($expectedResult, $result);
    }

    public function testSaveVoucher()
    {
        $voucherMock = $this->createMock(\App\Entity\VoucherCode::class);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('persist')
            ->with($voucherMock);
        $entityManagerMock->expects($this->once())
            ->method('flush');

        $classUnderTest = new \App\Repository\VoucherRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->save($voucherMock);

        $this->assertTrue($result);
    }


    public function testGetVoucherByIdT()
    {
        $voucherMock = $this->createMock(\App\Entity\VoucherCode::class);

        $entityRepositoryMock = $this->createMock(EntityRepository::class);
        $entityRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['id' => 70])
            ->willReturn($voucherMock);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(\App\Entity\VoucherCode::class)
            ->willReturn($entityRepositoryMock);

        $classUnderTest = new \App\Repository\VoucherRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->get(['id' => 70]);

        $this->assertEquals($voucherMock, $result);
    }

    public function testGetVoucherByCodeAndRecipient()
    {
        $voucherMock = $this->createMock(\App\Entity\VoucherCode::class);

        $recipientMock = $this->createMock(\App\Entity\Recipient::class);

        $entityRepositoryMock = $this->createMock(EntityRepository::class);
        $entityRepositoryMock->expects($this->once())
            ->method('findOneBy')
            ->with(['code' => 'F589A88A','recipient' => $recipientMock])
            ->willReturn($voucherMock);

        $entityManagerMock = $this->createMock(EntityManager::class);
        $entityManagerMock->expects($this->once())
            ->method('getRepository')
            ->with(\App\Entity\VoucherCode::class)
            ->willReturn($entityRepositoryMock);

        $classUnderTest = new \App\Repository\VoucherRepository($entityManagerMock, $this->Logger());
        $result = $classUnderTest->getVoucherByCodeAndRecipient('F589A88A', $recipientMock);

        $this->assertEquals($voucherMock, $result);
    }

}