<?php
namespace QuoteCMS\PostBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use QuoteCMS\PostBundle\Entity\Post;


class RandomPostCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quotecms:post:random')
            ->setDescription('Put random data in bd')
        ;
    }

    private function randomString($length)
    {
        return substr(str_shuffle("                                                                                                                                                             0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ   0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ  0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ"), 0, $length);
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $em = $this->getContainer()->get('doctrine')->getManager();

        for ($i = 1; $i <= 50; $i++)
        {
            $firstGame = $em->getRepository("QuoteCMSGameBundle:Game")->findOneById(rand(1,6));
            $post = new Post();
            $post->setTitle($i . " " . time() . " " . $this->randomString(rand(10, 50)));
            $post->setStory($this->randomString(rand(255, 1000)));
            $post->setGame($firstGame);
            $post->setValidated(1);
            $post->setIp("127.0.0.1");
            $em->persist($post);
        }

        $em->flush();

    }
}