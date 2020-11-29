<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\Form\Extension\Core\Type\IntegerType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Console;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param Request $request
     * @param KernelInterface $kernel
     * @param int $cases
     * @return Response
     * @throws Exception
     */
    public function index(Request $request,KernelInterface $kernel, $cases = 10)
    {

        $form = $this->createFormBuilder() //tworzenie formularza do wpisywania ilości przypadków do generowania
            ->add('ilosc', IntegerType::class, [
                'attr' => [
                    'class' => 'form-control',
                    'placeholder' => 'Ilość Przypadków'
                ],
                'label' => false
            ])
            ->add('send', SubmitType::class, [
                'attr' => [
                    'class' => 'btn btn-primary'
                ],
                'label' => 'Wyślij'
            ])
            ->getForm();

        $form->handleRequest($request);

        if($form->isSubmitted()){
            $cases = $form->getData()['ilosc']; //pobrani i przypisanie wartości
        }

        $application = new Console\Application($kernel); //wywołanie aplikacji konsolowej w celu wykorzystania jej do generacji przypadków

        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'user:list',
            'cases' => $cases,
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

//        return new Response($content);

        $tableData = json_decode($_GET['data']); //pobranie danych wygenerowanych z konsoli

        
        return $this->render('main/index.html.twig', [
            'tableData' => $tableData,
            'form' =>$form->createView()
        ]);
    }

}
