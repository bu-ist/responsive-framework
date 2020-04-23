!function(e,u,p,f){var i=[],t={_version:"3.10.0",_config:{classPrefix:"",enableClasses:!0,enableJSClass:!0,usePrefixes:!0},_q:[],on:function(e,t){var A=this;setTimeout(function(){t(A[e])},0)},addTest:function(e,t,A){i.push({name:e,fn:t,options:A})},addAsyncTest:function(e){i.push({name:null,fn:e})}},s=function(){};s.prototype=t,s=new s;var c=[];function h(e,t){return typeof e===t}var m=p.documentElement,g="svg"===m.nodeName.toLowerCase();function a(e){var t=m.className,A=s._config.classPrefix||"";if(g&&(t=t.baseVal),s._config.enableJSClass){var n=new RegExp("(^|\\s)"+A+"no-js(\\s|$)");t=t.replace(n,"$1"+A+"js$2")}s._config.enableClasses&&(0<e.length&&(t+=" "+A+e.join(" "+A)),g?m.className.baseVal=t:m.className=t)}var A="Moz O ms Webkit",l=t._config.usePrefixes?A.toLowerCase().split(" "):[];function v(){return"function"!=typeof p.createElement?p.createElement(arguments[0]):g?p.createElementNS.call(p,"http://www.w3.org/2000/svg",arguments[0]):p.createElement.apply(p,arguments)}t._domPrefixes=l;var n,o=(n=!("onblur"in m),function(e,t){var A;return!!e&&(t&&"string"!=typeof t||(t=v(t||"div")),!(A=(e="on"+e)in t)&&n&&(t.setAttribute||(t=v("div")),t.setAttribute(e,""),A="function"==typeof t[e],t[e]!==f&&(t[e]=f),t.removeAttribute(e)),A)});t.hasEvent=o,g||function(e,r){var o,i,t=e.html5||{},a=/^<|^(?:button|map|select|textarea|object|iframe|option|optgroup)$/i,s=/^(?:a|b|code|div|fieldset|h1|h2|h3|h4|h5|h6|i|label|li|ol|p|q|span|strong|style|table|tbody|td|th|tr|ul)$/i,A="_html5shiv",n=0,c={};function d(e,t){var A=e.createElement("p"),n=e.getElementsByTagName("head")[0]||e.documentElement;return A.innerHTML="x<style>"+t+"</style>",n.insertBefore(A.lastChild,n.firstChild)}function u(){var e=h.elements;return"string"==typeof e?e.split(" "):e}function p(e){var t=c[e[A]];return t||(t={},n++,e[A]=n,c[n]=t),t}function l(e,t,A){return t||(t=r),i?t.createElement(e):(A||(A=p(t)),!(n=A.cache[e]?A.cache[e].cloneNode():s.test(e)?(A.cache[e]=A.createElem(e)).cloneNode():A.createElem(e)).canHaveChildren||a.test(e)||n.tagUrn?n:A.frag.appendChild(n));var n}function f(e){e||(e=r);var t,A,n=p(e);return!h.shivCSS||o||n.hasCSS||(n.hasCSS=!!d(e,"article,aside,dialog,figcaption,figure,footer,header,hgroup,main,nav,section{display:block}mark{background:#FF0;color:#000}template{display:none}")),i||(t=e,(A=n).cache||(A.cache={},A.createElem=t.createElement,A.createFrag=t.createDocumentFragment,A.frag=A.createFrag()),t.createElement=function(e){return h.shivMethods?l(e,t,A):A.createElem(e)},t.createDocumentFragment=Function("h,f","return function(){var n=f.cloneNode(),c=n.createElement;h.shivMethods&&("+u().join().replace(/[\w\-:]+/g,function(e){return A.createElem(e),A.frag.createElement(e),'c("'+e+'")'})+");return n}")(h,A.frag)),e}!function(){try{var e=r.createElement("a");e.innerHTML="<xyz></xyz>",o="hidden"in e,i=1==e.childNodes.length||function(){r.createElement("a");var e=r.createDocumentFragment();return void 0===e.cloneNode||void 0===e.createDocumentFragment||void 0===e.createElement}()}catch(e){i=o=!0}}();var h={elements:t.elements||"abbr article aside audio bdi canvas data datalist details dialog figcaption figure footer header hgroup main mark meter nav output picture progress section summary template time video",version:"3.7.3",shivCSS:!1!==t.shivCSS,supportsUnknownElements:i,shivMethods:!1!==t.shivMethods,type:"default",shivDocument:f,createElement:l,createDocumentFragment:function(e,t){if(e||(e=r),i)return e.createDocumentFragment();for(var A=(t=t||p(e)).frag.cloneNode(),n=0,o=u(),a=o.length;n<a;n++)A.createElement(o[n]);return A},addElements:function(e,t){var A=h.elements;"string"!=typeof A&&(A=A.join(" ")),"string"!=typeof e&&(e=e.join(" ")),h.elements=A+" "+e,f(t)}};e.html5=h,f(r);var m,g=/^$|\b(?:all|print)\b/,v="html5shiv",y=!(i||(m=r.documentElement,void 0===r.namespaces||void 0===r.parentWindow||void 0===m.applyElement||void 0===m.removeNode||void 0===e.attachEvent));function T(e){for(var t,A=e.attributes,n=A.length,o=e.ownerDocument.createElement(v+":"+e.nodeName);n--;)(t=A[n]).specified&&o.setAttribute(t.nodeName,t.nodeValue);return o.style.cssText=e.style.cssText,o}h.type+=" print",(h.shivPrint=function(i){var s,c,e=p(i),t=i.namespaces,A=i.parentWindow;if(!y||i.printShived)return i;function l(){clearTimeout(e._removeSheetTimer),s&&s.removeNode(!0),s=null}return void 0===t[v]&&t.add(v),A.attachEvent("onbeforeprint",function(){l();for(var e,t,A,n=i.styleSheets,r=[],o=n.length,a=Array(o);o--;)a[o]=n[o];for(;A=a.pop();)if(!A.disabled&&g.test(A.media)){try{t=(e=A.imports).length}catch(e){t=0}for(o=0;o<t;o++)a.push(e[o]);try{r.push(A.cssText)}catch(e){}}r=function(e){for(var t,A=r.reverse().join("").split("{"),n=A.length,o=RegExp("(^|[\\s,>+~])("+u().join("|")+")(?=[[\\s,>+~#.:]|$)","gi"),a="$1"+v+"\\:$2";n--;)(t=A[n]=A[n].split("}"))[t.length-1]=t[t.length-1].replace(o,a),A[n]=t.join("}");return A.join("{")}(),c=function(e){for(var t,A=i.getElementsByTagName("*"),n=A.length,o=RegExp("^(?:"+u().join("|")+")$","i"),a=[];n--;)t=A[n],o.test(t.nodeName)&&a.push(t.applyElement(T(t)));return a}(),s=d(i,r)}),A.attachEvent("onafterprint",function(){!function(e){for(var t=e.length;t--;)e[t].removeNode()}(c),clearTimeout(e._removeSheetTimer),e._removeSheetTimer=setTimeout(l,500)}),i.printShived=!0,i})(r),"object"==typeof module&&module.exports&&(module.exports=h)}(void 0!==u?u:this,p);var d=t._config.usePrefixes?A.split(" "):[];function y(e,t){return!!~(""+e).indexOf(t)}t._cssomPrefixes=d;var r={elem:v("modernizr")};s._q.push(function(){delete r.elem});var T={style:r.elem.style};function w(e,t,A,n){var o,a,r,i,s,c="modernizr",l=v("div"),d=((s=p.body)||((s=v(g?"svg":"body")).fake=!0),s);if(parseInt(A,10))for(;A--;)(r=v("div")).id=n?n[A]:c+(A+1),l.appendChild(r);return(o=v("style")).type="text/css",o.id="s"+c,(d.fake?d:l).appendChild(o),d.appendChild(l),o.styleSheet?o.styleSheet.cssText=e:o.appendChild(p.createTextNode(e)),l.id=c,d.fake&&(d.style.background="",d.style.overflow="hidden",i=m.style.overflow,m.style.overflow="hidden",m.appendChild(d)),a=t(l,e),d.fake?(d.parentNode.removeChild(d),m.style.overflow=i,m.offsetHeight):l.parentNode.removeChild(l),!!a}function E(e){return e.replace(/([A-Z])/g,function(e,t){return"-"+t.toLowerCase()}).replace(/^ms-/,"-ms-")}function b(e){return e.replace(/([a-z])-([a-z])/g,function(e,t,A){return t+A.toUpperCase()}).replace(/^-/,"")}function x(e,t,A,n){if(n=!h(n,"undefined")&&n,!h(A,"undefined")){var o=function(e,t){var A=e.length;if("CSS"in u&&"supports"in u.CSS){for(;A--;)if(u.CSS.supports(E(e[A]),t))return!0;return!1}if("CSSSupportsRule"in u){for(var n=[];A--;)n.push("("+E(e[A])+":"+t+")");return w("@supports ("+(n=n.join(" or "))+") { #modernizr { position: absolute; } }",function(e){return"absolute"===function(e,t,A){var n;if("getComputedStyle"in u){n=getComputedStyle.call(u,e,null);var o=u.console;null!==n?n=n.getPropertyValue(A):o&&o[o.error?"error":"log"].call(o,"getComputedStyle returning null, its possible modernizr test results are inaccurate")}else n=e.currentStyle&&e.currentStyle[A];return n}(e,0,"position")})}return f}(e,A);if(!h(o,"undefined"))return o}for(var a,r,i,s,c,l=["modernizr","tspan","samp"];!T.style&&l.length;)a=!0,T.modElem=v(l.shift()),T.style=T.modElem.style;function d(){a&&(delete T.style,delete T.modElem)}for(i=e.length,r=0;r<i;r++)if(s=e[r],c=T.style[s],y(s,"-")&&(s=b(s)),T.style[s]!==f){if(n||h(A,"undefined"))return d(),"pfx"!==t||s;try{T.style[s]=A}catch(e){}if(T.style[s]!==c)return d(),"pfx"!==t||s}return d(),!1}function R(e,t){return function(){return e.apply(t,arguments)}}function B(e,t,A,n,o){var a=e.charAt(0).toUpperCase()+e.slice(1),r=(e+" "+d.join(a+" ")+a).split(" ");return h(t,"string")||h(t,"undefined")?x(r,t,n,o):function(e,t,A){var n;for(var o in e)if(e[o]in t)return!1===A?e[o]:h(n=t[e[o]],"function")?R(n,A||t):n;return!1}(r=(e+" "+l.join(a+" ")+a).split(" "),t,A)}s._q.unshift(function(){delete T.style}),t.testAllProps=B;var C=function(e){var t,A=S.length,n=u.CSSRule;if(void 0===n)return f;if(!e)return!1;if((t=(e=e.replace(/^@/,"")).replace(/-/g,"_").toUpperCase()+"_RULE")in n)return"@"+e;for(var o=0;o<A;o++){var a=S[o];if(a.toUpperCase()+"_"+t in n)return"@-"+a.toLowerCase()+"-"+e}return!1};t.atRule=C;var F=t.prefixed=function(e,t,A){return 0===e.indexOf("@")?C(e):(-1!==e.indexOf("-")&&(e=b(e)),t?B(e,t,A):B(e,"pfx"))},S=t._config.usePrefixes?" -webkit- -moz- -o- -ms- ".split(" "):["",""];function G(e,t,A){return B(e,f,f,t,A)}t._prefixes=S,t.testAllProps=G;var P=t.testProp=function(e,t,A){return x([e],f,t,A)},k=t.testStyles=w;!function(){var t=v("audio");s.addTest("audio",function(){var e=!1;try{(e=!!t.canPlayType)&&(e=new Boolean(e))}catch(e){}return e});try{t.canPlayType&&(s.addTest("audio.ogg",t.canPlayType('audio/ogg; codecs="vorbis"').replace(/^no$/,"")),s.addTest("audio.mp3",t.canPlayType('audio/mpeg; codecs="mp3"').replace(/^no$/,"")),s.addTest("audio.opus",t.canPlayType('audio/ogg; codecs="opus"')||t.canPlayType('audio/webm; codecs="opus"').replace(/^no$/,"")),s.addTest("audio.wav",t.canPlayType('audio/wav; codecs="1"').replace(/^no$/,"")),s.addTest("audio.m4a",(t.canPlayType("audio/x-m4a;")||t.canPlayType("audio/aac;")).replace(/^no$/,"")))}catch(e){}}(),s.addTest("backgroundsize",G("backgroundSize","100%",!0)),s.addTest("borderimage",G("borderImage","url() 1",!0)),s.addTest("borderradius",G("borderRadius","0px",!0)),s.addTest("boxshadow",G("boxShadow","1px 1px",!0)),s.addTest("canvas",function(){var e=v("canvas");return!(!e.getContext||!e.getContext("2d"))}),s.addTest("canvastext",function(){return!1!==s.canvas&&"function"==typeof v("canvas").getContext("2d").fillText}),s.addTest("cssanimations",G("animationName","a",!0)),function(){s.addTest("csscolumns",function(){var e=!1,t=G("columnCount");try{(e=!!t)&&(e=new Boolean(e))}catch(e){}return e});for(var e,t,A=["Width","Span","Fill","Gap","Rule","RuleColor","RuleStyle","RuleWidth","BreakBefore","BreakAfter","BreakInside"],n=0;n<A.length;n++)e=A[n].toLowerCase(),t=G("column"+A[n]),"breakbefore"!==e&&"breakafter"!==e&&"breakinside"!==e||(t=t||G(A[n])),s.addTest("csscolumns."+e,t)}(),s.addTest("cssgradients",function(){for(var e,t="background-image:",A="",n=0,o=S.length-1;n<o;n++)e=0===n?"to ":"",A+=t+S[n]+"linear-gradient("+e+"left top, #9f9, white);";s._config.usePrefixes&&(A+=t+"-webkit-gradient(linear,left top,right bottom,from(#9f9),to(white));");var a=v("a").style;return a.cssText=A,-1<(""+a.backgroundImage).indexOf("gradient")}),s.addTest("csspositionsticky",function(){var e="position:",t=v("a").style;return t.cssText=e+S.join("sticky;"+e).slice(0,-e.length),-1!==t.position.indexOf("sticky")}),s.addTest("cssreflections",G("boxReflect","above",!0)),s.addTest("csstransforms",function(){return-1===navigator.userAgent.indexOf("Android 2.")&&G("transform","scale(1)",!0)});var Q,M,N,Z="CSS"in u&&"supports"in u.CSS,Y="supportsCSS"in u;s.addTest("supports",Z||Y),s.addTest("csstransforms3d",function(){return!!G("perspective","1px",!0)}),s.addTest("csstransitions",G("transition","all",!0)),s.addTest("flexbox",G("flexBasis","1px",!0)),s.addTest("flexboxlegacy",G("boxDirection","reverse",!0)),M=(Q=navigator.userAgent).match(/w(eb)?osbrowser/gi),N=Q.match(/windows phone/gi)&&Q.match(/iemobile\/([0-9])+/gi)&&9<=parseFloat(RegExp.$1),M||N?s.addTest("fontface",!1):k('@font-face {font-family:"font";src:url("https://")}',function(e,t){var A=p.getElementById("smodernizr"),n=A.sheet||A.styleSheet,o=n?n.cssRules&&n.cssRules[0]?n.cssRules[0].cssText:n.cssText||"":"",a=/src/i.test(o)&&0===o.indexOf(t.split(" ")[0]);s.addTest("fontface",a)}),s.addTest("geolocation","geolocation"in navigator),k('#modernizr{font:0/0 a}#modernizr:after{content:":)";visibility:hidden;font:7px/1 a}',function(e){s.addTest("generatedcontent",6<=e.offsetHeight)}),s.addTest("hashchange",function(){return!1!==o("hashchange",u)&&(p.documentMode===f||7<p.documentMode)}),s.addTest("hsla",function(){var e=v("a").style;return e.cssText="background-color:hsla(120,40%,100%,.5)",y(e.backgroundColor,"rgba")||y(e.backgroundColor,"hsla")}),s.addTest("inlinesvg",function(){var e=v("div");return e.innerHTML="<svg/>","http://www.w3.org/2000/svg"===("undefined"!=typeof SVGRect&&e.firstChild&&e.firstChild.namespaceURI)}),s.addTest("localstorage",function(){var e="modernizr";try{return localStorage.setItem(e,e),localStorage.removeItem(e),!0}catch(e){return!1}}),s.addTest("multiplebgs",function(){var e=v("a").style;return e.cssText="background:url(https://),url(https://),red url(https://)",/(url\s*\(.*?){3}/.test(e.background)}),s.addTest("objectfit",!!F("objectFit"),{aliases:["object-fit"]}),s.addTest("opacity",function(){var e=v("a").style;return e.cssText=S.join("opacity:.55;"),/^0.55$/.test(e.opacity)}),s.addTest("picture","HTMLPictureElement"in u);var V=!0;try{u.postMessage({toString:function(){V=!1}},"*")}catch(e){}s.addTest("postmessage",new Boolean("postMessage"in u)),s.addTest("postmessage.structuredclones",V),s.addTest("requestanimationframe",!!F("requestAnimationFrame",u),{aliases:["raf"]}),s.addTest("rgba",function(){var e=v("a").style;return e.cssText="background-color:rgba(150,255,150,.5)",-1<(""+e.backgroundColor).indexOf("rgba")});var U,I,j={}.toString;function D(e,t){if("object"==typeof e)for(var A in e)U(e,A)&&D(A,e[A]);else{var n=(e=e.toLowerCase()).split("."),o=s[n[0]];if(2===n.length&&(o=o[n[1]]),void 0!==o)return s;t="function"==typeof t?t():t,1===n.length?s[n[0]]=t:(!s[n[0]]||s[n[0]]instanceof Boolean||(s[n[0]]=new Boolean(s[n[0]])),s[n[0]][n[1]]=t),a([(t&&!1!==t?"":"no-")+n.join("-")]),s._trigger(e,t)}return s}s.addTest("smil",function(){return!!p.createElementNS&&/SVGAnimate/.test(j.call(p.createElementNS("http://www.w3.org/2000/svg","animate")))}),s.addTest("svg",!!p.createElementNS&&!!p.createElementNS("http://www.w3.org/2000/svg","svg").createSVGRect),s.addTest("svgclippaths",function(){return!!p.createElementNS&&/SVGClipPath/.test(j.call(p.createElementNS("http://www.w3.org/2000/svg","clipPath")))}),s.addTest("textshadow",P("textShadow","1px 1px")),function(){var t=v("video");s.addTest("video",function(){var e=!1;try{(e=!!t.canPlayType)&&(e=new Boolean(e))}catch(e){}return e});try{t.canPlayType&&(s.addTest("video.ogg",t.canPlayType('video/ogg; codecs="theora"').replace(/^no$/,"")),s.addTest("video.h264",t.canPlayType('video/mp4; codecs="avc1.42E01E"').replace(/^no$/,"")),s.addTest("video.webm",t.canPlayType('video/webm; codecs="vp8, vorbis"').replace(/^no$/,"")),s.addTest("video.vp9",t.canPlayType('video/webm; codecs="vp9"').replace(/^no$/,"")),s.addTest("video.hls",t.canPlayType('application/x-mpegURL; codecs="avc1.42E01E"').replace(/^no$/,"")))}catch(e){}}(),U=h(I={}.hasOwnProperty,"undefined")||h(I.call,"undefined")?function(e,t){return t in e&&h(e.constructor.prototype[t],"undefined")}:function(e,t){return I.call(e,t)},t._l={},t.on=function(e,t){this._l[e]||(this._l[e]=[]),this._l[e].push(t),s.hasOwnProperty(e)&&setTimeout(function(){s._trigger(e,s[e])},0)},t._trigger=function(e,t){if(this._l[e]){var A=this._l[e];setTimeout(function(){var e;for(e=0;e<A.length;e++)(0,A[e])(t)},0),delete this._l[e]}},s._q.push(function(){t.addTest=D}),s.addAsyncTest(function(){var A,n=200,o=5,a=0,r=v("video"),e=r.style;function i(e){a++,clearTimeout(A);var t=e&&"playing"===e.type||0!==r.currentTime;!t&&a<o?A=setTimeout(i,n):(r.removeEventListener("playing",i,!1),D("videoautoplay",t),r.parentNode&&r.parentNode.removeChild(r))}if(s.video&&"autoplay"in r){e.position="absolute",e.height=0,e.width=0;try{if(s.video.ogg)r.src="data:video/ogg;base64,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";else{if(!s.video.h264)return void D("videoautoplay",!1);r.src="data:video/mp4;base64,AAAAIGZ0eXBpc29tAAACAGlzb21pc28yYXZjMW1wNDEAAAAIZnJlZQAAAs1tZGF0AAACrgYF//+q3EXpvebZSLeWLNgg2SPu73gyNjQgLSBjb3JlIDE0OCByMjYwMSBhMGNkN2QzIC0gSC4yNjQvTVBFRy00IEFWQyBjb2RlYyAtIENvcHlsZWZ0IDIwMDMtMjAxNSAtIGh0dHA6Ly93d3cudmlkZW9sYW4ub3JnL3gyNjQuaHRtbCAtIG9wdGlvbnM6IGNhYmFjPTEgcmVmPTMgZGVibG9jaz0xOjA6MCBhbmFseXNlPTB4MzoweDExMyBtZT1oZXggc3VibWU9NyBwc3k9MSBwc3lfcmQ9MS4wMDowLjAwIG1peGVkX3JlZj0xIG1lX3JhbmdlPTE2IGNocm9tYV9tZT0xIHRyZWxsaXM9MSA4eDhkY3Q9MSBjcW09MCBkZWFkem9uZT0yMSwxMSBmYXN0X3Bza2lwPTEgY2hyb21hX3FwX29mZnNldD0tMiB0aHJlYWRzPTEgbG9va2FoZWFkX3RocmVhZHM9MSBzbGljZWRfdGhyZWFkcz0wIG5yPTAgZGVjaW1hdGU9MSBpbnRlcmxhY2VkPTAgYmx1cmF5X2NvbXBhdD0wIGNvbnN0cmFpbmVkX2ludHJhPTAgYmZyYW1lcz0zIGJfcHlyYW1pZD0yIGJfYWRhcHQ9MSBiX2JpYXM9MCBkaXJlY3Q9MSB3ZWlnaHRiPTEgb3Blbl9nb3A9MCB3ZWlnaHRwPTIga2V5aW50PTI1MCBrZXlpbnRfbWluPTEwIHNjZW5lY3V0PTQwIGludHJhX3JlZnJlc2g9MCByY19sb29rYWhlYWQ9NDAgcmM9Y3JmIG1idHJlZT0xIGNyZj0yMy4wIHFjb21wPTAuNjAgcXBtaW49MCBxcG1heD02OSBxcHN0ZXA9NCBpcF9yYXRpbz0xLjQwIGFxPTE6MS4wMACAAAAAD2WIhAA3//728P4FNjuZQQAAAu5tb292AAAAbG12aGQAAAAAAAAAAAAAAAAAAAPoAAAAZAABAAABAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAACAAACGHRyYWsAAABcdGtoZAAAAAMAAAAAAAAAAAAAAAEAAAAAAAAAZAAAAAAAAAAAAAAAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAEAAAAAAAAAAAAAAAAAAEAAAAAAAgAAAAIAAAAAACRlZHRzAAAAHGVsc3QAAAAAAAAAAQAAAGQAAAAAAAEAAAAAAZBtZGlhAAAAIG1kaGQAAAAAAAAAAAAAAAAAACgAAAAEAFXEAAAAAAAtaGRscgAAAAAAAAAAdmlkZQAAAAAAAAAAAAAAAFZpZGVvSGFuZGxlcgAAAAE7bWluZgAAABR2bWhkAAAAAQAAAAAAAAAAAAAAJGRpbmYAAAAcZHJlZgAAAAAAAAABAAAADHVybCAAAAABAAAA+3N0YmwAAACXc3RzZAAAAAAAAAABAAAAh2F2YzEAAAAAAAAAAQAAAAAAAAAAAAAAAAAAAAAAAgACAEgAAABIAAAAAAAAAAEAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAY//8AAAAxYXZjQwFkAAr/4QAYZ2QACqzZX4iIhAAAAwAEAAADAFA8SJZYAQAGaOvjyyLAAAAAGHN0dHMAAAAAAAAAAQAAAAEAAAQAAAAAHHN0c2MAAAAAAAAAAQAAAAEAAAABAAAAAQAAABRzdHN6AAAAAAAAAsUAAAABAAAAFHN0Y28AAAAAAAAAAQAAADAAAABidWR0YQAAAFptZXRhAAAAAAAAACFoZGxyAAAAAAAAAABtZGlyYXBwbAAAAAAAAAAAAAAAAC1pbHN0AAAAJal0b28AAAAdZGF0YQAAAAEAAAAATGF2ZjU2LjQwLjEwMQ=="}}catch(e){return void D("videoautoplay",!1)}r.setAttribute("autoplay",""),e.cssText="display:none",m.appendChild(r),setTimeout(function(){r.addEventListener("playing",i,!1),A=setTimeout(i,n)},0)}else D("videoautoplay",!1)}),s.addTest("webgl",function(){return"WebGLRenderingContext"in u}),function(){var e,t,A,n,o,a;for(var r in i)if(i.hasOwnProperty(r)){if(e=[],(t=i[r]).name&&(e.push(t.name.toLowerCase()),t.options&&t.options.aliases&&t.options.aliases.length))for(A=0;A<t.options.aliases.length;A++)e.push(t.options.aliases[A].toLowerCase());for(n=h(t.fn,"function")?t.fn():t.fn,o=0;o<e.length;o++)1===(a=e[o].split(".")).length?s[a[0]]=n:(s[a[0]]&&(!s[a[0]]||s[a[0]]instanceof Boolean)||(s[a[0]]=new Boolean(s[a[0]])),s[a[0]][a[1]]=n),c.push((n?"":"no-")+a.join("-"))}}(),a(c),delete t.addTest,delete t.addAsyncTest;for(var H=0;H<s._q.length;H++)s._q[H]();e.Modernizr=s}(window,window,document);
//# sourceMappingURL=modernizr.js.map