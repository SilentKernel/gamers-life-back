<?php
namespace QuoteCMS\DeviceAPIBundle\Command;

use Symfony\Bundle\FrameworkBundle\Command\ContainerAwareCommand;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

use QuoteCMS\DeviceAPIBundle\Entity\DeviceType;


class PopulateDeviceTypeCommand extends ContainerAwareCommand
{
    protected function configure()
    {
        $this
            ->setName('quotecms:devicetype:populate')
            ->setDescription('Populate database with type of device')
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
       $em = $this->getContainer()->get('doctrine')->getManager();


        // Desktop
        $computer_web = new DeviceType();
        $computer_web->setName("Ordinateur Web");
        $computer_web->setIdentifier("computer_web");
        $computer_web->setIcon("fa fa-desktop");
        $em->persist($computer_web);

        $computer_app = new DeviceType();
        $computer_app->setName("Ordinateur App");
        $computer_app->setIdentifier("computer_app");
        $computer_app->setIcon("fa fa-desktop");
        $em->persist($computer_app);

        // Mobile
        $mobile_web = new DeviceType();
        $mobile_web->setName("Mobile Web");
        $mobile_web->setIdentifier("mobile_web");
        $mobile_web->setIcon("fa fa-mobile");
        $em->persist($mobile_web);

        $mobile_app = new DeviceType();
        $mobile_app->setName("Mobile App");
        $mobile_app->setIdentifier("mobile_app");
        $mobile_app->setIcon("fa fa-mobile");
        $em->persist($mobile_app);

        // Tablet
        $tablet_web = new DeviceType();
        $tablet_web->setName("Tablet Web");
        $tablet_web->setIdentifier("tablet_web");
        $tablet_web->setIcon("fa fa-tablet");
        $em->persist($tablet_web);

        $tablet_app = new DeviceType();
        $tablet_app->setName("Tablet App");
        $tablet_app->setIdentifier("tablet_app");
        $tablet_app->setIcon("fa fa-tablet");
        $em->persist($tablet_app);

        // Console
        $console_web = new DeviceType();
        $console_web->setName("Console Web");
        $console_web->setIdentifier("console_web");
        $console_web->setIcon("fa fa-gamepad");
        $em->persist($console_web);

        $console_app = new DeviceType();
        $console_app->setName("Console App");
        $console_app->setIdentifier("console_app");
        $console_app->setIcon("fa fa-gamepad");
        $em->persist($console_app);

        $em->flush();
    }
}