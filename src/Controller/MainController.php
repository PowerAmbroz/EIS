<?php

namespace App\Controller;

use Exception;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Input\ArrayInput;
use Symfony\Component\Console\Output\BufferedOutput;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Console;

class MainController extends AbstractController
{
    /**
     * @Route("/", name="main")
     * @param KernelInterface $kernel
     * @param int $cases
     * @return Response
     * @throws Exception
     */
    public function index(KernelInterface $kernel, $cases = 10)
    {

        $application = new Console\Application($kernel);

        $application->setAutoExit(false);

        $input = new ArrayInput([
            'command' => 'user:list',
            'cases' => $cases,
        ]);

        $output = new BufferedOutput();
        $application->run($input, $output);

        $content = $output->fetch();

//        return new Response($content);

        $tableData = json_decode($_GET['data']);

        
        return $this->render('main/index.html.twig', [
            'tableData' => $tableData
        ]);
    }

}
