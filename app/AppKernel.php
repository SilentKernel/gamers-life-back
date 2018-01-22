<?php

use Symfony\Component\HttpKernel\Kernel;
use Symfony\Component\Config\Loader\LoaderInterface;

class AppKernel extends Kernel
{
    public function registerBundles()
    {
        $bundles = array(
			// Symfony's base bundle
            new Symfony\Bundle\FrameworkBundle\FrameworkBundle(),
            new Symfony\Bundle\SecurityBundle\SecurityBundle(),
            new Symfony\Bundle\TwigBundle\TwigBundle(),
            new Symfony\Bundle\MonologBundle\MonologBundle(),
            new Symfony\Bundle\SwiftmailerBundle\SwiftmailerBundle(),
            new Symfony\Bundle\AsseticBundle\AsseticBundle(),
            new Doctrine\Bundle\DoctrineBundle\DoctrineBundle(),
            new Sensio\Bundle\FrameworkExtraBundle\SensioFrameworkExtraBundle(),
			
			// FoS User Bundle
			new FOS\UserBundle\FOSUserBundle(),
			// FoS Javascript routing
			new FOS\JsRoutingBundle\FOSJsRoutingBundle(),
			// OAuth
			new HWI\Bundle\OAuthBundle\HWIOAuthBundle(),
			// Doctrine extension
			new Stof\DoctrineExtensionsBundle\StofDoctrineExtensionsBundle(),
            // Pagination
            new Knp\Bundle\PaginatorBundle\KnpPaginatorBundle(),
            // Image resizer
            new Liip\ImagineBundle\LiipImagineBundle(),
            // Markdown
            new Knp\Bundle\MarkdownBundle\KnpMarkdownBundle(),

            // Sonata and hit dependancy
            new Sonata\CoreBundle\SonataCoreBundle(),
            new Sonata\BlockBundle\SonataBlockBundle(),
            new Knp\Bundle\MenuBundle\KnpMenuBundle(),
            new Sonata\DoctrineORMAdminBundle\SonataDoctrineORMAdminBundle(),
            // Then add SonataAdminBundle
            new Sonata\AdminBundle\SonataAdminBundle(),

            // Device detection
            new SunCat\MobileDetectBundle\MobileDetectBundle(),

            // Embeding video Bundle
            new Silentkernel\TwigEmbedBundle\SilentkernelTwigEmbedBundle(),
            // Social Media API
            new Silentkernel\SocialAPIBundle\SilentkernelSocialAPIBundle(),

            // QuoteCMS Core Bundle (general page ... etc)
            new QuoteCMS\CoreBundle\QuoteCMSCoreBundle(),		
			// Own User Bundle
            new QuoteCMS\UserBundle\QuoteCMSUserBundle(),
			// Games bundle (Cathegory, games)
			new QuoteCMS\GameBundle\QuoteCMSGameBundle(),
            // Faq Bundle
            new QuoteCMS\FaqBundle\QuoteCMSFaqBundle(),

            // Post Bundle (Entity, list ...)
            new QuoteCMS\PostBundle\QuoteCMSPostBundle(),
            new Silentkernel\SEAutoCompleteBundle\SilentkernelSEAutoCompleteBundle(),
            new QuoteCMS\DeviceAPIBundle\QuoteCMSDeviceAPIBundle(),
            new Silentkernel\CommentBundle\SilentkernelCommentBundle(),
            new Silentkernel\EmoticonBundle\SilentkernelEmoticonBundle(),
            new QuoteCMS\ModeratorBundle\QuoteCMSModeratorBundle(),
            new QuoteCMS\BlogBundle\QuoteCMSBlogBundle(),
            new QuoteCMS\JSBundle\QuoteCMSJSBundle(),
        );

        if (in_array($this->getEnvironment(), array('dev', 'test'))) {
            $bundles[] = new Symfony\Bundle\WebProfilerBundle\WebProfilerBundle();
            $bundles[] = new Sensio\Bundle\DistributionBundle\SensioDistributionBundle();
            $bundles[] = new Sensio\Bundle\GeneratorBundle\SensioGeneratorBundle();
        }

        return $bundles;
    }

    public function registerContainerConfiguration(LoaderInterface $loader)
    {
        $loader->load($this->getRootDir().'/config/config_'.$this->getEnvironment().'.yml');
    }
}
