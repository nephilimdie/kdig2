<?php

namespace Kdig\TemplateBundle\Twig;

class DemoExtension extends \Twig_Extension
{
    const FULL_TEMPLATE = '::full-layout.html.twig';
    const PARTIAL_TEMPLATE = '::partial-layout.html.twig';
 
    public function getFunctions()
    {
        return array(
            'parent_template' => new \Twig_Function_Method($this, 'getParentTemplate'),
        );
    }
 
    public function getParentTemplate()
    {
        if ($this->useFullTemplate()) {
            return self::FULL_TEMPLATE;
        }
        return self::PARTIAL_TEMPLATE; 
    }
 
    public function useFullTemplate()
    {
         return true;
    }
}