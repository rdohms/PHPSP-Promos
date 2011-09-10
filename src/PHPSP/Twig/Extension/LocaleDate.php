<?php

namespace PHPSP\Twig\Extension;

class LocaleDate extends \Twig_Extension
{
    public function getName()
    {
        return 'Locale Dates';
    }

    public function getFilters()
    {
        return array(
            'strftime' => new \Twig_Filter_Method($this, 'strftime'),
        );
    }


    public function strftime($value, $format)
    {
        $dateTime = new \DateTime($value);
        
        return strftime($format, $dateTime->format('U'));
    }
}