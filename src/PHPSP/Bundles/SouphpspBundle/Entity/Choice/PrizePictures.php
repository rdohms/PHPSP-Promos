<?php

namespace PHPSP\Bundles\SouphpspBundle\Entity\Choice;

use Symfony\Component\Form\Extension\Core\ChoiceList\ChoiceListInterface;

class PrizePictures implements ChoiceListInterface
{
    public function getChoices()
    {
        $files = array();
        
        foreach(new \DirectoryIterator(__DIR__ . '/../../Resources/public/images/prizes') as $file)
        {
            if ($file->isFile()) {
                $files['bundles/souphpsp/images/prizes/' . $file->getBasename()] = $file->getBasename();
            }
            
        }
        
        return $files;
    }
}