<?php
namespace App\Controller;
use Symfony\Component\HttpFoundation\Response;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;


class DefaultController{
	 public function index()
    {
return new Response('OMG! My first page already! WOOO!');
    }

}