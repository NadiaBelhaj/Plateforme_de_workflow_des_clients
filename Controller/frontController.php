<?php


namespace App\Controller;

use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Entity\Contact;

use App\Form\ContactType;
class frontController  extends AbstractController{


	/**
**
 * @route ("espaceclient",name="espaceclient")
 */
	public function client()
{
    return $this->render('view/client.html.twig');
}

}