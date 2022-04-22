<?php

namespace App\Controller;

use App\Entity\Checker;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use App\Form\ApiKeyType;
use App\Form\ConverterType;
use App\Form\CheckGrowthType;
use App\Entity\CurrencyManager;
use App\Entity\Converter;
use App\Entity\ApiKey;

use Symfony\Component\Form\Extension\Core\Type\MoneyType;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(Request $request):Response
    {
        $apiKey=new ApiKey();
        $apiKey->setApiKey(null);
        $apiForm=$this->createForm(ApiKeyType::class,$apiKey);
        $apiForm->handleRequest($request);
        if($apiForm->isSubmitted() && $apiForm->isValid())
        {
            $apiKey=$apiForm->getData();
            dump($apiKey);
            return $this->redirectToRoute('app_app',['apiKey'=>$apiKey->getApiKey()]);
           
        };
        return $this->renderForm('index/api.html.twig', [
            'apiForm'=>$apiForm,
        ]);
        
    }
    #[Route('/{apiKey}', name: 'app_app')]
    public function app(Request $request, $apiKey): Response
    {
        $manager=new CurrencyManager($apiKey);
        $_POST['symbols']=($manager->getSymbols())['symbols'];
        /////////////////////////////////////////////////////////////////////////////////////////
        //Converter Form
        $converter=new Converter();
        $converter->setFirstCurrency('EUR');
        $converter->setSecondCurrency('USD');
        $converter->setValue(1);
        $manager->UpdateLatest();
        $convertResult=$manager->Convert($converter->getValue(),$converter->getFirstCurrency(), $converter->getSecondCurrency());
        $converterForm=$this->createForm(ConverterType::class, $converter);
        $converterForm->handleRequest($request);
        if($converterForm->isSubmitted() && $converterForm->isValid()){
            $converterForm->getData();
            $convertResult=$manager->Convert($converter->getValue(),$converter->getFirstCurrency(), $converter->getSecondCurrency());
         };
        /////////////////////////////////////////////////////////////////////////////////////////
        /////////////////////////////////////////////////////////////////////////////////////////
        //Check Currency Rate Growth Form
        $checker=new Checker();
        $checker->setFirstCurrency('EUR');
        $checker->setSecondCurrency('USD');
        $checker->setStartDate('2020-01-10');
        $checker->setEndDate('2022-01-10');
        $checkerForm=$this->createForm(CheckGrowthType::class, $checker);
        $checkResult=$manager->CompareCurrency(
            $checker->getStartDate(), 
            $checker->getEndDate(),
            $checker->getFirstCurrency(),
            $checker->getSecondCurrency(), 
        );
        $checkerForm->handleRequest($request);
        if($checkerForm->isSubmitted() && $checkerForm->isValid()){
            $checkerForm->getData();
            $checkResult=$manager->CompareCurrency(
                $checker->getStartDate(), 
                $checker->getEndDate(),
                $checker->getFirstCurrency(),
                $checker->getSecondCurrency(), 
            );
         };
        /////////////////////////////////////////////////////////////////////////////////////////
        return $this->render('index/index.html.twig', [
            'controller_name' => 'IndexController',
            'title' => 'Currency Calculator',
            //'ApiKeyType' => $apiForm->createView(),
            'ConverterType'=>$converterForm->createView(),
            'CheckGrowthType' => $checkerForm->createView(),
            'latestCode1' =>  $convertResult['code1'],
            'latestCode2' => $convertResult['code2'],
            'latestDate' => $convertResult['date'],
            'latestResult'=>$convertResult['result'],
            'latestValue'=>$convertResult['value'],
             'pastDate1'=>$checkResult['date1'],
             'pastDate2'=>$checkResult['date2'],
             'pastCode1'=>$checkResult['code1'],
             'pastCode2'=>$checkResult['code2'],
             'pastResult1'=>$checkResult['result1'],
             'pastResult2'=>$checkResult['result2'],
             'percent'=>$checkResult['percent'],
             'isGrowing'=>$checkResult['isGrowing'],
        ]);
    }
    
}
