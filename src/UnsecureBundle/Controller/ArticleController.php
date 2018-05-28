<?php

namespace UnsecureBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class ArticleController extends Controller
{

    public function indexAction(Request $request)
    {
        $fileName = $request->get('fileName');
        $article = null;

        if ($fileName != null)
        {
            try
            {
                $handle = fopen('../src/UnsecureBundle/Resources/article/yesYouCan/' . $fileName, 'r');

                $article = stream_get_contents($handle);
                fclose($handle);
            }
            catch (\Exception $e)
            {
                $article = 'Open file fail';
            }
        }

        return $this->render('UnsecureBundle:Article:index.html.twig', array(
                    'article' => $article
        ));
    }

}
