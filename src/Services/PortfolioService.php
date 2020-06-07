<?php
/**
 * Created by PhpStorm.
 * User: chica
 * Date: 04/06/2020
 * Time: 16:51
 */

namespace App\Services;

use App\Entity\Allocation;
use App\Entity\Order;
use Doctrine\DBAL\Driver\PDOException;
use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Portfolio;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\Validator\Constraints\All;

/**
 * @property \Doctrine\Persistence\ObjectRepository buyOrderRepository
 */
class PortfolioService
{
    const ACTION_BUY = 'buy';
    const ACTION_SELL = 'sell';
    /**
     * @var EntityManagerInterface
     */
    private $em;

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $orderRepo;

    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $portFolioRepo;
    /**
     * @var \Doctrine\Persistence\ObjectRepository
     */
    private $allocationRepo;

    /**
     * @param EntityManagerInterface $entityManager
     */
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->em = $entityManager;
        $this->portFolioRepo = $this->em->getRepository(Portfolio::class);
        $this->orderRepo = $this->em->getRepository(Order::class);
        $this->allocationRepo = $this->em->getRepository(Allocation::class);
    }

    /**
     * @param int $id
     * @return null|object
     */
    public function getPortfolio(int $id)
    {

        return $this->portFolioRepo->find($id);
    }

    /**
     * @return object[]
     */
    public function getAllPortfolios()
    {
        return $this->portFolioRepo->findAll();
    }

    /**
     * @param $type
     * @param null $id
     * @return null|object
     */
    public function getOrders($type ,$id = null)
    {
        $params = [ 'type'=> $type ];
        if($id){
            $params['porfolio'] = $id;
        }
        return $this->orderRepo->findBy( $params );
    }

    /**
     * @param int $orderId
     * @return bool|PDOException|\Exception|null
     */
    public function completeOrder(int $orderId )
    {
        $order = $this->orderRepo->find($orderId);

        if ( !$order ) {
            return new HttpException(404,"The order doesn't exist.");
        }
        $portfolio = $this->getPortfolio( $order->getPortfolio() );

        if(!$portfolio){
            return null;
        }
        $allocation = $this->allocationRepo->find( $order->getAllocation() );

        if( !$allocation ){
            $allocation = new Allocation();
            $allocation->setId( $order->getAllocation() );
            $allocation->setPortfolio($portfolio);
        }

        switch ($order->getType())
        {
            case self::ACTION_BUY:
                $share = !$allocation ? $order->getShares() : $allocation->getShare() + $order->getShares();
                $allocation->setShare( $share );
                $this->em->persist($allocation);
                break;
            case self::ACTION_SELL:
                $share = !$allocation ? $order->getShares() : $allocation->getShare() - $order->getShares() ;
                if($share <= 0){
                    $this->em->remove( $allocation );
                    break;
                }
                $allocation->setShare( $share );

                break;

        }

        $this->em->remove( $order );

        try {
            $this->em->flush();
        }catch (PDOException $e){
            return $e;
        }
        return true;
    }

    /**
     * @param string $data
     * @param string $action
     * @return null
     */
    public function createOrder(string $data , string $action)
    {

        $data = json_decode($data,true);

        $portfolioID = $data['portfolio'];
        var_dump($portfolioID);
        if($this->getPortfolio( $portfolioID ) === null ){
            throw new HttpException(404,"The portfolio doesn't exist.");
        }
        $order = new Order();
        $order->setShares($data['shares']);
        $order->setPortfolio($portfolioID);
        $order->setAllocation($data['allocation']);
        $order->setType($action);
        $this->em->persist($order);
        try {
            $this->em->flush();
        }catch (PDOException $e){
            return $e;
        }
        return true;

    }


}