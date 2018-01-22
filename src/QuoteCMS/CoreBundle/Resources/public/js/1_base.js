window.jqueryWindow = $(window);
window.rightPanelE = $("#right_panel");
window.bodyE = $('body');
window.smallLogo = $('#logo-small');
window.bigBanner = $('#big-banner');
window.footerE = $('footer');
window.globalNavBar = $('#global-nav-bar');
window.isBigBanner = (!window.bigBanner.is(":hidden"));
const pixelTrigger = 20;

function isCommentPage()
{
  var hash = document.URL.substr(document.URL.indexOf('#')+1);
  return (hash == "commentaires");
}

function cacheLgDevice()
{
  if (window.LGTestE == null)
  {
    window.bodyE.prepend(
        '<div id = "test-lg" class = "hidden-xs hidden-sm hidden-md"></div>'
    );
    window.LGTestE = $("#test-lg");
  }
  window.isLGDevice =  !window.LGTestE.is(":hidden");
}
cacheLgDevice();

function thisDeviceToucheScreen()
{
  if (window.isTouchScreen == null)
  {
    window.isTouchScreen = !!('ontouchstart' in window);
  }
  return window.isTouchScreen;
}

function cacheMdDevice()
{
  window.isMdDevice = (!window.rightPanelE.is(':hidden'));
}
cacheMdDevice();

function miniNavBar(scrollTo)
{
  if (window.isBigBanner)
  {
    window.isBigBanner = false;
    window.bigBanner.addClass("hidden-lg");
    window.smallLogo.removeClass("hidden-lg");

    var addiTionPixel = 0;
    if (scrollTo)
    {
      window.jqueryWindow.scrollTop(pixelTrigger + 1);
      addiTionPixel = pixelTrigger + 1;
    }
    window.bodyE.css('padding-top', window.globalNavBar.height() + 20 + addiTionPixel);
  }
}

if (isCommentPage())
{
  miniNavBar(false);
}


// Adapt Navabar when MD or LG device and Scroll
function AdaptNavBar()
{
  if (window.jqueryWindow.scrollTop() > pixelTrigger)
  {
    miniNavBar(true);
  }
  else
  {
    if (!window.isBigBanner)
    {
      window.isBigBanner = true;
      window.bigBanner.removeClass("hidden-lg");
      window.smallLogo.addClass("hidden-lg");

      window.bodyE.css('padding-top', window.globalNavBar.height() + 20);
    }
  }
}

// because wee like to put // in the code :D
function DynaNavBar() {
  if (window.isLGDevice && !thisDeviceToucheScreen())
  {
    AdaptNavBar();
  }
  else
  {
    miniNavBar(false);
  }
}

//DynaNavBar();

// This function will bump the footer to the bootom of the page ! (Yeah it's responsive <3)
function BumpTheFooter()
{
  // here we get the real footer size and we margin to the body !
  window.bodyE.css('margin-bottom', window.footerE.height());
  // We are not stupied we register when size of the widon changed !
  window.browserResized = false;
}

// Exec the function for the first time !
BumpTheFooter();

$(window).resize(function() {
  window.browserResized = true;
});

// Each 250 ms wee check if the page has ben resized and if it's done we just adapt it (again it's responsive !)
setInterval(function()
{
  if(window.browserResized)
  {
    window.browserResized = false;
    cacheLgDevice();
    cacheMdDevice();
    DynaNavBar();
    BumpTheFooter();
  }
}, 250);

window.jqueryWindow.scroll( function() {
  DynaNavBar();
});
