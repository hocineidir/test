<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Merchant;
use FeedIo\Adapter\FileSystem\Response;
use App\Entity\Product;

class ComparatorController extends AbstractController
{
    /**
     * @Route("/comparator", name="comparator")
     */
    public function index()
    {
       
        $url = "https://www.careserve.fr/leguide-2-s1-fr-EUR.xml";
        $feed = simplexml_load_file($url);
        
        $title = array();
        foreach ($feed->channel->item as $products) {
            $title[] = $products->title;
        }
        
        $namespace = $feed->getNamespaces(true);
        $imageurl = $feed->channel->item[0]->children($namespace["g"]);
        $shipping = $imageurl->shipping->service;
        
        
        return $this->render('comparator/index.html.twig', [
            'feed' => $feed->channel->item->description,
            'title' => $feed->channel->item[0]->title,
            'shipping' => $shipping,
            'merchants' => $merchants 
        ]);   
    }
    
    /**
     * @Route("/show_products", name="show_products")
     */
    public function product_show() {
        
        $em = $this->getDoctrine()->getManager();
        $merchants = $em->getRepository(Merchant::class)->findAll();
        
        $feeds = array();
        foreach ( $merchants as $merchant) {
            $feeds[] = $merchant->getUrl();
        }
        
        
        
        return $this->render('comparator/show.html.twig', [
            'feeds' => $feeds
        ]);
    }
    
    
}



