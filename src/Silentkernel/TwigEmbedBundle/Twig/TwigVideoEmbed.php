<?php
namespace Silentkernel\TwigEmbedBundle\Twig;

class TwigVideoEmbed extends \Twig_Extension
{
	CONST ErrorMessage = "<b>This host is not supported</b>";
		
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('embed_video', array($this, 'embedFilter'), array('is_safe' => array('html')) ),
        );
    }
	
	private function generateIframe($url, $host, $id)
	{
		return '<div class="shadowed embed-responsive embed-responsive-16by9">
  				<iframe allowfullscreen class="embed-responsive-item" src="'.$url.'"></iframe>
			</div>';
	}
	
	private function generateYoutubeEmbed($path)
	{
		$id = $path;
		// remove the ?watch= from youtube.com 
		if (strpos($id, "watchv=") > 0)
			$id = str_replace("watchv=", "", $id);
		
		// remove the /
		$id = str_replace("/", "", $id);
		
		// remove over param if there is one (youtube.com URL)
        if (strpos($id, "&") > 0)
        {
            $posList = strpos($id, "&");
            $id = substr($id, 0, $posList);
        }

		// (Youtu.be URL)
		elseif (strpos($id, "list=") > 0)
		{
			$posList = strpos($id, "list=");
			$id = substr($id, 0, $posList);
		}

		
		return $this->generateIframe("//youtube.com/embed/".$id,"Youtube", $id); 
	}
	
	private function generateDailymotion($host, $path)
	{
		$id = str_replace("/", "", $path);
		if ($host == "dailymotion.com")
		{
			$id = str_replace("video", "", $id);
			$undersocrePos = strpos($id, "_");
			$id = substr($id, 0, $undersocrePos);
		}
		return $this->generateIframe("//dailymotion.com/embed/video/".$id,"Dailymotion", $id); 
	}

    public function embedFilter($url)
    {		
		if(!filter_var($url, FILTER_VALIDATE_URL)){
			// We don't know where string comme from so we don't use Twig_exception (to prevent page load fail)
		  	return self::ErrorMessage;
		}
		
		// remove the www. (easeyer later)
		if (strpos($url, "www.") > 0)
			$url = str_replace("www.","",$url);
		
		$urlArray = parse_url($url);
		/* 
		$pathAndQuery will be showed in an iframe, this filter is "html safe", washing $pathAndQuery to be sure that our filter will not allow injection (wo don't know original url come from even if twig must wash it...).
		*/
		if (isset($urlArray["query"]))
			$pathAndQuery = htmlspecialchars($urlArray["path"] . $urlArray["query"]);
		else
			$pathAndQuery = htmlspecialchars($urlArray["path"]);

		switch ($urlArray["host"])
		{
			// Youtube
			case "youtube.com":
				return $this->generateYoutubeEmbed($pathAndQuery);
				break;
			case "youtu.be":
				return $this->generateYoutubeEmbed($pathAndQuery);
				break;
			// Dailymotion
			case "dailymotion.com":
				return $this->generateDailymotion($urlArray["host"], $pathAndQuery);
				break;
			case "dai.ly":
			return $this->generateDailymotion($urlArray["host"], $pathAndQuery);
				break;	
			default:
				return self::ErrorMessage;
				break;	
		}
	}

    public function getName()
    {
        return 'silentkernel_twig_video_embed';
    }
}