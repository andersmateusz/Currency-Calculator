<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ApiKeyType;
use App\Form\ConverterType;
use App\Form\CheckGrowthType;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request): Response
    {
        $apiForm=$this->createForm(ApiKeyType::class, null, [

        ]);
        //handleRequest only processes data when this is POST method
        $apiForm->handleRequest($request);
        
        if($apiForm->isSubmitted()){
            dump($apiForm->isValid());
            dump($apiForm->isSubmitted());
        };
        
      
        $converterForm=$this->createForm(ConverterType::class, null, [

        ]);
        $converterForm->handleRequest($request);
        if($converterForm->isSubmitted()){
            dump($converterForm->isValid());
            dump($converterForm->isSubmitted());
        };
        $checkGrowthType=$this->createForm(CheckGrowthType::class, null, [

        ]);


        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'title' => 'Currency Calculator',
            'ApiKeyType' => $apiForm->createView(),
            'ConverterType'=>$converterForm->createView(),
            'CheckGrowthType' => $checkGrowthType->createView(),
        ]);
    }

}
