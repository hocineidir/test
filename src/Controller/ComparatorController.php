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
        
        $itemsless = array_slice($items,0,10);
        //$elements = array();
        //foreach ( $itemsless as $item) {
            //array_push($elements, $item->getAllElements()->getArrayCopy());
        //}
        $elements = $itemsless[0]->getAllElements()->getArrayCopy();
        
        return $this->render('comparator/index.html.twig', [
            'items'  => $itemsless,
            'elements' => $elements
        ]);
        
        
        
    }
}
