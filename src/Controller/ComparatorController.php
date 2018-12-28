<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ComparatorController extends AbstractController
{
    /**
     * @Route("/comparator", name="comparator")
     */
    public function index()
    {
        
        $feedIo = \FeedIo\Factory::create()->getFeedIo();
        
        $url = 'https://www.careserve.fr/leguide-2-s1-fr-EUR.xml';
        // read a feed
        $result = $feedIo->read($url);
        
        // or read a feed since a certain date
        //$result = $feedIo->readSince($url, new \DateTime('-7 days'));
        
        $items = array();
        // iterate through items
        foreach( $result->getFeed() as $item ) {
            array_push($items, $item);
        }
        
        // $itemsless est la liste des 10 premiers produits du flux
        $itemsless = array_slice($items,0,10);
        
        // $elements est la liste qui liste les 16 éléments de chaque produit
        $elements = array();
        for ($i = 0;$i<count($itemsless);$i++) {
            array_push($elements,$itemsless[$i]->getAllElements()->getArrayCopy());
        }
        
        
        
        return $this->render('comparator/index.html.twig', [
            'item'  => $itemsless[0],
            'elements' => $elements[0]
        ]);
        
        
        
    }
}
