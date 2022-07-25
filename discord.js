(function( discord, $, undefined ) {

const iframeContainerClass = `egj-discord-iframe-container`;
const iFrameContainerId = `discordIframeContainer`;


function getVW() {
   return Math.max(document.documentElement.clientWidth || 0, window.innerWidth || 0);;
}

function getVH() {
   return Math.max(document.documentElement.clientHeight || 0, window.innerHeight || 0);;
}

function getData() {
   $.get( '/wp-json/erfindergeist/v1/discord')
      .done(function( data ) {
         render(data);   
      })
      .fail(function( jqxhr, textStatus, error ) {
         var err = textStatus + ", " + error;
         console.log( "Request Failed: " + err );
         renderError();
      });
}

function renderError() {
   var htmlIframeString = `
      <div id="${iFrameContainerId}" class="${iframeContainerClass} egj-discord-fade-in">
         Error Loading data.
      </div>
   `;

   createDiv(htmlIframeString);

   container = document.getElementById(iFrameContainerId);

   setDisplay(container, "block");
}

function render(data) {
   var htmlIframeString = `
      <div id="${iFrameContainerId}" class="${iframeContainerClass} egj-discord-fade-in">
         ${data}
      </div>
   `;

   createDiv(htmlIframeString);

   container = document.getElementById(iFrameContainerId);

   setDisplay(container, "block");
}


discord.toggle = function(){
   if(getVW() < 768 || getVH() < 900) {

      window.location.href = "/discord/";
      return;

   }

   var container = document.getElementById(iFrameContainerId);

   if(!container) {
      getData();
   }
   else {
      if(container.style.display === "none" || container.style.display === '') {
         setDisplay(container, "block");
      }
      else {
         setDisplay(container, "none");
      }
   }
}

function setDisplay(ele, style) {
   ele.style.display = style
}

function createDiv(html) {
   var newDiv = document.createElement('div');
   $(newDiv).html(html);
   document.body.appendChild(newDiv);
}

discord.init = function() {
   
   var htmlBubbleString = `
      <div id="egjDiscordBubbleContainer" class="egj-discord-container">
         <div class="egj-discord-talk-bubble egj-discord-tri egj-discord-border">
            &nbsp;            
         </div>   
      </div>`;

   createDiv(htmlBubbleString);

   const container = document.getElementById("egjDiscordBubbleContainer");
   container.addEventListener('click', event => {
      discord.toggle();
   });

}

}( window.discord = window.discord || {}, jQuery ));

discord.init();