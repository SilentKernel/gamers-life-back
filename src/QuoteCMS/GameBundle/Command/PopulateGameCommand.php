<?php
namespace QuoteCMS\GameBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Input\InputOption;
use Symfony\Component\Console\Output\OutputInterface;

use QuoteCMS\GameBundle\Entity\Category;
use QuoteCMS\GameBundle\Entity\Game;


class PopulateGameCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quotecms:games:populate')
            ->setDescription('Populate database with games an category')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $em = $this->getContainer()->get('doctrine')->getManager();

        $mmorpg = new Category();
        $mmorpg->setName("MMORPG");
        $em->persist($mmorpg);

        $fps = new Category();
        $fps->setName("FPS");
        $em->persist($fps);

        // MMORPG
        $game = new Game();
        $game->setName("World of Warcraft");
        $game->setCategory($mmorpg);
        $em->persist($game);

        $game = new Game();
        $game->setName("Guild Wars");
        $game->setCategory($mmorpg);
        $em->persist($game);

        $game = new Game();
        $game->setName("The secret world");
        $game->setCategory($mmorpg);
        $em->persist($game);

        // FPS
        $game = new Game();
        $game->setName("Counter-Strike");
        $game->setCategory($fps);
        $em->persist($game);

        $game = new Game();
        $game->setName("Call of Duty");
        $game->setCategory($fps);
        $em->persist($game);

        $game = new Game();
        $game->setName("Battlefield");
        $game->setCategory($fps);
        $em->persist($game);

        // put all in database
        $em->flush();
    }
}