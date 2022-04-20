<?php

namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ApiKeyType;
use App\Form\ConverterType;
use App\Form\CheckGrowthType;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        $apiForm=$this->createForm(ApiKeyType::class, null, [

        ]);

        $converterForm=$this->createForm(ConverterType::class, null, [

        ]);

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
