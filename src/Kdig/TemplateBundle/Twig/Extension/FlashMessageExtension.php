<?php

namespace Kdig\TemplateBundle\Twig\Extension;

use Symfony\Component\HttpFoundation\Session as Session;

class FlashMessageExtension extends \Twig_Extension
{
    /**
     * @var Session
     */
    protected $session;
    
    /**
     * @param Session $session
     */
    public function __construct(Session $session)
    {
        $this->session = $session;
    }
    
    /**
     * {@inheritdoc}
     */
    public function getFunctions()
    {
        return array(
            'showFlashMessages' => new \Twig_Function_Method($this, 'showFlashMessages', array('is_safe' => array('html'))),
            'flash' => new \Twig_Function_Method($this, 'flash', array('is_safe' => array('html'))),
        );
    }

    public function showFlashMessages()
    {
        $return = '<div id="kdig_flash_message"></div>';
        $return .= $this->renderFlashJavascript($this->session->getFlashes());
        return $return;
    }
    
    public function flash($type, $message)
    {
        return $this->renderFlashJavascript(array($type => $message));
    }
    
    /**
     * Generates HTML for flash message call to the jQuery.flash(...) function.
     * This method returns the enclosing <script></script> tags as well.
     * 
     * @param array $messages
     */
    protected function renderFlashJavascript($messages) 
    {
        $return = "";
        if (count($messages) > 0) {
            $return .= '<script language="javascript">$(function () {';
            foreach ($messages as $type => $message) {
                $return .= '$.flash({ type: "' . addslashes($type) . '", message: "' . addslashes($message) . '" });';
            }
            $return .= '});</script>';
        }
        return $return;
    }

    /**
     * Returns the name of the extension.
     *
     * @return string The extension name
     */
    public function getName()
    {
        return 'flashmessage';
    }
}
