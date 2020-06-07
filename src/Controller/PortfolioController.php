<?php

namespace App\Controller;

use App\Services\PortfolioService;
use HttpException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class PortfolioController extends AbstractController
{
    private $portfolioService;


    public function __construct(PortfolioService $portfolioService)
    {
        $this->portfolioService = $portfolioService;
    }

    /**
     * Render an interface for Portfolio's data
     * @Route("/", name="index", methods={"GET"})
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index()
    {

        $portfolios = $this->portfolioService->getAllPortfolios();
        $buyOrders = $this->portfolioService->getOrders($this->portfolioService::ACTION_BUY);
        $sellOrders = $this->portfolioService->getOrders($this->portfolioService::ACTION_SELL);

        return $this->render('portfolio.html.twig', [
            'portfolios' => $portfolios,
            'buyOrders' => $buyOrders,
            'sellOrders' => $sellOrders,
        ]);
    }

    /**
     * @Route("/portfolio/{id}", name="get_portfolio", methods={"GET"})
     * @param int $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function getPortfolio( int $id )
    {
        $portfolio = $this->portfolioService->getPortfolio( $id );
        if(!$portfolio){
            return new JsonResponse([],404);
        }
        return new JsonResponse($portfolio,200);
    }

    /**
     * @Route("/portfolio", name="create_buyOrder", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createBuyOrder( Request $request )
    {
        $content = $request->getContent();
        if(empty($content)){
            return new JsonResponse( null,404 );
        }

        try {
            $response = $this->portfolioService->createOrder( $content,$this->portfolioService::ACTION_BUY );
        }catch(HttpException $e){
            return new JsonResponse( null,404 );
        }
        if( !$response ){
            return new JsonResponse( null,400 );
        }
        return new JsonResponse( null, 200 );
    }

    /**
     * @Route("/sell", name="create_sellOrder", methods={"PUT"})
     * @param Request $request
     * @return JsonResponse
     */
    public function createSellOrder( Request $request )
    {
        $content = $request->getContent();
        if(empty($content)){
            return new JsonResponse( null,404 );
        }

        try {
            $response = $this->portfolioService->createOrder( $content, $this->portfolioService::ACTION_SELL );
        }catch(HttpException $e){
            return new JsonResponse( null,404 );
        }
        if( !$response ){
            return new JsonResponse( null,400 );
        }
        return new JsonResponse( null, 200 );
    }

    /**
     * @Route("/complete/{orderId}", name="complete_Order", methods={"POST"})
     * @param int $orderId
     * @return JsonResponse
     */
    public function completeOrder(int $orderId)
    {
        $response = $this->portfolioService->completeOrder($orderId);

        if( !$response ){
            return new JsonResponse([],404);
        }
        return new JsonResponse( [],200 );
    }


}
