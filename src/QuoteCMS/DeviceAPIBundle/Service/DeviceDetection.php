<?php


namespace QuoteCMS\DeviceAPIBundle\Service;

use Symfony\Component\HttpFoundation\Request;

class DeviceDetection
{
    private $em;
    private $deviceDetector;

    public function __construct($em,$deviceDetectionService)
    {
        $this->em = $em;
        $this->deviceDetector = $deviceDetectionService;
    }

    private function findOneByIddentifier($identifier)
    {
        return $this
            ->em
            ->getRepository("QuoteCMSDeviceAPIBundle:DeviceType")
            ->findOneByIdentifier($identifier);
    }

    public function detectThisDevice(Request $request)
    {
        // This function will return an entity of the device who made this request
        $userAgent = strtolower($request->headers->get('User-Agent'));

        if (strpos($userAgent, "xbox")
            || strpos($userAgent, "nintendobrowser")
            || strpos($userAgent, "playstation"))
        {
            return $this->findOneByIddentifier("console_web");
        }
        elseif ($this->deviceDetector->isMobile())
        {
            return $this->findOneByIddentifier("mobile_web");
        }
        elseif ($this->deviceDetector->isTablet())
        {
            return $this->findOneByIddentifier("tablet_web");
        }
        else
        {
            return $this->findOneByIddentifier("computer_web");
        }
    }
}