/*
  evol-colorpicker 3.2.6
  (c) 2016 Olivier Giulieri
  http://evoluteur.github.io/colorpicker/
*/
!function(a,b){var c=0,d=window.navigator.userAgent,e=d.indexOf("MSIE ")>0,f=e?"-ie":"",g=!e&&(/mozilla/.test(d.toLowerCase())&&!/webkit/.test(d.toLowerCase())),h=[],i=["ffffff","000000","eeece1","1f497d","4f81bd","c0504d","9bbb59","8064a2","4bacc6","f79646"],j=["f2f2f2","7f7f7f","ddd9c3","c6d9f0","dbe5f1","f2dcdb","ebf1dd","e5e0ec","dbeef3","fdeada","d8d8d8","595959","c4bd97","8db3e2","b8cce4","e5b9b7","d7e3bc","ccc1d9","b7dde8","fbd5b5","bfbfbf","3f3f3f","938953","548dd4","95b3d7","d99694","c3d69b","b2a2c7","92cddc","fac08f","a5a5a5","262626","494429","17365d","366092","953734","76923c","5f497a","31859b","e36c09","7f7f7f","0c0c0c","1d1b10","0f243e","244061","632423","4f6128","3f3151","205867","974806"],k=["c00000","ff0000","ffc000","ffff00","92d050","00b050","00b0f0","0070c0","002060","7030a0"],l=[["003366","336699","3366cc","003399","000099","0000cc","000066"],["006666","006699","0099cc","0066cc","0033cc","0000ff","3333ff","333399"],["669999","009999","33cccc","00ccff","0099ff","0066ff","3366ff","3333cc","666699"],["339966","00cc99","00ffcc","00ffff","33ccff","3399ff","6699ff","6666ff","6600ff","6600cc"],["339933","00cc66","00ff99","66ffcc","66ffff","66ccff","99ccff","9999ff","9966ff","9933ff","9900ff"],["006600","00cc00","00ff00","66ff99","99ffcc","ccffff","ccccff","cc99ff","cc66ff","cc33ff","cc00ff","9900cc"],["003300","009933","33cc33","66ff66","99ff99","ccffcc","ffffff","ffccff","ff99ff","ff66ff","ff00ff","cc00cc","660066"],["333300","009900","66ff33","99ff66","ccff99","ffffcc","ffcccc","ff99cc","ff66cc","ff33cc","cc0099","993399"],["336600","669900","99ff33","ccff66","ffff99","ffcc99","ff9999","ff6699","ff3399","cc3399","990099"],["666633","99cc00","ccff33","ffff66","ffcc66","ff9966","ff6666","ff0066","d60094","993366"],["a58800","cccc00","ffff00","ffcc00","ff9933","ff6600","ff0033","cc0066","660033"],["996633","cc9900","ff9900","cc6600","ff3300","ff0000","cc0000","990033"],["663300","996600","cc3300","993300","990000","800000","993333"]],m="#0000ffff",n=function(a){var b=a.toString(16);return 1==b.length&&(b="0"+b),b},o=function(a){return n(Number(a))},p=function(a){var b=n(a);return b+b+b},q=function(a){if(a.length>10){var b=1+a.indexOf("("),c=a.indexOf(")"),d=a.substring(b,c).split(",");return["#",o(d[0]),o(d[1]),o(d[2])].join("")}return a};a.widget("evol.colorpicker",{version:"3.2.6",options:{color:null,customTheme:null,showOn:"both",hideButton:!1,displayIndicator:!0,transparentColor:!1,history:!0,defaultPalette:"theme",strings:"Theme Colors,Standard Colors,Web Colors,Theme Colors,Back to Palette,History,No history yet."},_active:!1,_create:function(){var b=this;switch(this._paletteIdx="theme"==this.options.defaultPalette?1:2,this._id="evo-cp"+c++,this._enabled=!0,this.options.showOn=this.options.hideButton?"focus":this.options.showOn,this.element.get(0).tagName){case"INPUT":var d=this.options.color,h=this.element,i=("focus"===this.options.showOn?"":"evo-pointer ")+"evo-colorind"+(g?"-ff":f)+(this.options.hideButton?" evo-hidden-button":""),j="";this._isPopup=!0,this._palette=null;var k=h.val();null!==d?d!=k&&h.val(d).change():""!==k&&(d=this.options.color=k),d===m?i+=" evo-transparent":j=null!==d?"background-color:"+d:"",h.addClass("colorPicker "+this._id).wrap('<div style="width:'+(this.options.hideButton?this.element.width():this.element.width()+32)+"px;"+(e?"margin-bottom:-21px;":"")+(g?"padding:1px 0;":"")+'" class="evo-cp-wrap"></div>').after('<div class="'+i+'" style="'+j+'"></div>').on("keyup onpaste",function(c){var d=a(this).val();d!=b.options.color&&b._setValue(d,!0)});var l=this.options.showOn;"both"!==l&&"focus"!==l||h.on("focus",function(){b.showPalette()}),"both"!==l&&"button"!==l||h.next().on("click",function(a){return a.stopPropagation(),b.showPalette(),!1});break;default:this._isPopup=!1,this._palette=this.element.html(this._paletteHTML()).attr("aria-haspopup","true"),this._bindColors()}if(this.options.history&&(d&&this._add2History(d),this.options.initialHistory)){var n=this.options.initialHistory;for(var o in n)this._add2History(n[o])}},_paletteHTML:function(){var a=this._paletteIdx=Math.abs(this._paletteIdx),b=this.options,c=b.strings.split(","),d='<div class="evo-pop'+f+' ui-widget ui-widget-content ui-corner-all"'+(this._isPopup?' style="position:absolute"':"")+"><span>"+this["_paletteHTML"+a]()+'</span><div class="evo-more"><a href="javascript:void(0)">'+c[1+a]+"</a>";return b.history&&(d+='<a href="javascript:void(0)" class="evo-hist">'+c[5]+"</a>"),d+="</div>",b.displayIndicator&&(d+=this._colorIndHTML(this.options.color)+this._colorIndHTML("")),d+="</div>"},_colorIndHTML:function(a){var b=e?"evo-colorbox-ie ":"",c="";return a?a===m?b+="evo-transparent":c="background-color:"+a:c="display:none",'<div class="evo-color" style="float:left"><div style="'+c+'" class="'+b+'"></div><span>'+(a?a:"")+"</span></div>"},_paletteHTML1:function(){var a,b=this.options,c=b.strings.split(","),d='<td style="background-color:',g=e?'"><div style="width:2px;"></div></td>':'"><span/></td>',h='<tr><th colspan="10" class="ui-widget-content">',l='<table class="evo-palette'+f+'">'+h+c[0]+"</th></tr><tr>";if(b.customTheme)for(a=0,ml=b.customTheme.length;a<ml;a++)l+=d+b.customTheme[a]+g;else{for(d+="#",a=0;a<10;a++)l+=d+i[a]+g;for(l+="</tr>",e||(l+='<tr><th colspan="10"></th></tr>'),l+='<tr class="top">',a=0;a<10;a++)l+=d+j[a]+g;for(var m=1;m<4;m++)for(l+='</tr><tr class="in">',a=0;a<10;a++)l+=d+j[10*m+a]+g;for(l+='</tr><tr class="bottom">',a=40;a<50;a++)l+=d+j[a]+g;for(l+="</tr>"+h,b.transparentColor&&(l+='<div class="evo-transparent evo-tr-box"></div>'),l+=c[1]+"</th></tr><tr>",a=0;a<10;a++)l+=d+k[a]+g}return l+="</tr></table>"},_paletteHTML2:function(){for(var a,b,c='<td style="background-color:#',d=e?'"><div style="width:5px;"></div></td>':'"><span/></td>',g='<table class="evo-palette2'+f+'"><tr>',h="</tr></table>",i='<div class="evo-palcenter">',j=0,k=l.length;j<k;j++){i+=g;var m=l[j];for(a=0,b=m.length;a<b;a++)i+=c+m[a]+d;i+=h}i+='<div class="evo-sep"/>';var n="";for(i+=g,a=255;a>10;a-=10)i+=c+p(a)+d,a-=10,n+=c+p(a)+d;return i+=h+g+n+h+"</div>"},_switchPalette:function(b){if(this._enabled){var c,d,e,f=this.options,g=f.strings.split(",");if(a(b).hasClass("evo-hist")){var i='<table class="evo-palette"><tr><th class="ui-widget-content">'+g[5]+'</th></tr></tr></table><div class="evo-cHist">';if(0===h.length)i+="<p>&nbsp;"+g[6]+"</p>";else for(var j=h.length-1;j>-1;j--)9===h[j].length?f.transparentColor&&(i+='<div class="evo-transparent"></div>'):i+='<div style="background-color:'+h[j]+'"></div>';i+="</div>",c=-this._paletteIdx,d=i,e=g[4]}else this._paletteIdx<0?(c=-this._paletteIdx,this._palette.find(".evo-hist").show()):c=2==this._paletteIdx?1:2,d=this["_paletteHTML"+c](),e=g[c+1],this._paletteIdx=c;this._paletteIdx=c;var k=this._palette.find(".evo-more").prev().html(d).end().children().eq(0).html(e);c<0&&k.next().hide()}},_downOrUpPositioning:function(){for(var a=this.element,b=0;null!==a&&b<100;){if("visible"!=a.css("overflow")){var c=this._palette.offset().top+this._palette.height(),d=a.offset().top+a.height(),e=this._palette.offset().top-this._palette.height()-this.element.outerHeight(),f=a.offset().top,g=c>d&&e>f;g?this._palette.css({bottom:this.element.outerHeight()+"px"}):this._palette.css({bottom:"auto"});break}if("HTML"==a[0].tagName)break;a=a.offsetParent(),b++}},showPalette:function(){if(this._enabled&&(this._active=!0,a(".colorPicker").not("."+this._id).colorpicker("hidePalette"),null===this._palette)){this._palette=this.element.next().after(this._paletteHTML()).next().on("click",function(a){return a.stopPropagation(),!1}),this._bindColors();var b=this;this._isPopup&&(this._downOrUpPositioning(),a(document.body).on("click."+b._id,function(a){a.target!=b.element.get(0)&&b.hidePalette()}).on("keyup."+b._id,function(a){27===a.keyCode&&b.hidePalette()}))}return this},hidePalette:function(){if(this._isPopup&&this._palette){a(document.body).off("click."+this._id);var b=this;this._palette.off("mouseover click","td,.evo-transparent").fadeOut(function(){b._palette.remove(),b._palette=b._cTxt=null}).find(".evo-more a").off("click")}return this},_bindColors:function(){var b=this,c=this.options,d=this._palette.find("div.evo-color"),e=c.history?"td,.evo-cHist>div":"td";c.transparentColor&&(e+=",.evo-transparent"),this._cTxt1=d.eq(0).children().eq(0),this._cTxt2=d.eq(1).children().eq(0),this._palette.on("click",e,function(c){if(b._enabled){var d=a(this);b._setValue(d.hasClass("evo-transparent")?m:q(d.attr("style").substring(17))),b._active=!1}}).on("mouseover",e,function(c){if(b._enabled){var d=a(this),e=d.hasClass("evo-transparent")?m:q(d.attr("style").substring(17));b.options.displayIndicator&&b._setColorInd(e,2),b._active&&b.element.trigger("mouseover.color",e)}}).find(".evo-more a").on("click",function(){b._switchPalette(this)})},val:function(a){return"undefined"==typeof a?this.options.color:(this._setValue(a),this)},_setValue:function(a,b){a=a.replace(/ /g,""),this.options.color=a,this._isPopup?(b||this.hidePalette(),this._setBoxColor(this.element.val(a).change().next(),a)):this._setColorInd(a,1),this.options.history&&this._paletteIdx>0&&this._add2History(a),this.element.trigger("change.color",a)},_setColorInd:function(a,b){var c=this["_cTxt"+b];this._setBoxColor(c,a),c.next().html(a)},_setBoxColor:function(a,b){b===m?a.addClass("evo-transparent").removeAttr("style"):a.removeClass("evo-transparent").attr("style","background-color:"+b)},_setOption:function(a,b){"color"==a?this._setValue(b,!0):this.options[a]=b},_add2History:function(a){for(var b=h.length,c=0;c<b;c++)if(a==h[c])return;b>27&&h.shift(),h.push(a)},clear:function(){this.hidePalette().val("")},enable:function(){var a=this.element;return this._isPopup?a.removeAttr("disabled"):a.css({opacity:"1","pointer-events":"auto"}),"focus"!==this.options.showOn&&this.element.next().addClass("evo-pointer"),a.removeAttr("aria-disabled"),this._enabled=!0,this},disable:function(){var a=this.element;return this._isPopup?a.attr("disabled","disabled"):(this.hidePalette(),a.css({opacity:"0.3","pointer-events":"none"})),"focus"!==this.options.showOn&&this.element.next().removeClass("evo-pointer"),a.attr("aria-disabled","true"),this._enabled=!1,this},isDisabled:function(){return!this._enabled},destroy:function(){a(document.body).off("click."+this._id),this._palette&&(this._palette.off("mouseover click","td,.evo-cHist>div,.evo-transparent").find(".evo-more a").off("click"),this._isPopup&&this._palette.remove(),this._palette=this._cTxt=null),this._isPopup&&this.element.next().off("click").remove().end().off("focus").unwrap(),this.element.removeClass("colorPicker "+this.id).empty(),a.Widget.prototype.destroy.call(this)}})}(jQuery);