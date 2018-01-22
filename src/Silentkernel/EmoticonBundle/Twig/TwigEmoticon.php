<?php
/**
 * Created by PhpStorm.
 * User: Silent
 * Date: 04/08/2015
 * Time: 01:25
 */

namespace Silentkernel\EmoticonBundle\Twig;


class TwigEmoticon extends \Twig_Extension
{
    private $parser;

    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('emoticons', array($this, 'emoticons'), array('is_safe' => array('html')) ),
        );
    }

    public function getName()
    {
        return 'silentkernel_twig_emoticons';
    }

    public function __construct($ParserService, $markdown)
    {
        $this->parser = $ParserService;
    }


    public function emoticons($data)
    {
        // Data must be cleared firstly !
        return $this->parser->parse($data);

    }
}