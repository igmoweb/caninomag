function cli_show_cookiebar(o){function t(){s.set(c,"yes",_),r()}function e(){return s.set(c,"yes",_),a.notify_animate_hide?l.slideUp(a.animate_speed_hide):l.hide(),d.slideDown(a.animate_speed_show),!1}function n(){window.pageYOffset>100&&!s.read(c)&&(e(),a.scroll_close_reload===!0&&location.reload(),window.removeEventListener("scroll",n,!1))}function i(){a.notify_animate_show?l.slideDown(a.animate_speed_show):l.show(),d.hide()}function r(){a.notify_animate_show?d.slideDown(a.animate_speed_show):d.show(),l.slideUp(a.animate_speed_show)}var s={set:function(o,t,e){if(e){var n=new Date;n.setTime(n.getTime()+24*e*60*60*1e3);var i="; expires="+n.toGMTString()}else var i="";document.cookie=o+"="+t+i+"; path=/"},read:function(o){for(var t=o+"=",e=document.cookie.split(";"),n=0;n<e.length;n++){for(var i=e[n];" "==i.charAt(0);)i=i.substring(1,i.length);if(0===i.indexOf(t))return i.substring(t.length,i.length)}return null},erase:function(o){this.set(o,"",-1)},exists:function(o){return null!==this.read(o)}},c="viewed_cookie_policy",_=365,u=o.settings;if("function"!=typeof JSON.parse)return void console.log("CookieLawInfo requires JSON.parse but your browser doesn't support it");var a=JSON.parse(u),l=jQuery(a.notify_div_id),d=jQuery(a.showagain_div_id);jQuery("#cookie_hdr_accept"),jQuery("#cookie_hdr_decline"),jQuery("#cookie_hdr_moreinfo"),jQuery("#cookie_hdr_settings");l.hide(),a.showagain_tab||d.hide();var f={"background-color":a.background,color:a.text,"font-family":a.font_family};"top"==a.notify_position_vertical?(a.header_fix===!0&&(f.position="fixed"),f.top="0"):f.bottom="0";var h={"background-color":a.background,color:l1hs(a.text),position:"fixed","font-family":a.font_family};if(a.border_on){var b="border-"+a.notify_position_vertical;h.border="1px solid "+l1hs(a.border),h[b]="none"}"top"==a.notify_position_vertical?(a.border_on&&(f["border-bottom"]="4px solid "+l1hs(a.border)),h.top="0"):"bottom"==a.notify_position_vertical&&(a.border_on&&(f["border-top"]="4px solid "+l1hs(a.border)),f.position="fixed",f.bottom="0",h.bottom="0"),"left"==a.notify_position_horizontal?h.left=a.showagain_x_position:"right"==a.notify_position_horizontal&&(h.right=a.showagain_x_position),l.css(f),d.css(h),s.exists(c)?l.hide():i(),a.show_once_yn&&setTimeout(t,a.show_once);var p=jQuery(".cli-plugin-main-button");p.css("color",a.button_1_link_colour),a.button_1_as_button&&(p.css("background-color",a.button_1_button_colour),p.hover(function(){jQuery(this).css("background-color",a.button_1_button_hover)},function(){jQuery(this).css("background-color",a.button_1_button_colour)}));var y=jQuery(".cli-plugin-main-link");y.css("color",a.button_2_link_colour),a.button_2_as_button&&(y.css("background-color",a.button_2_button_colour),y.hover(function(){jQuery(this).css("background-color",a.button_2_button_hover)},function(){jQuery(this).css("background-color",a.button_2_button_colour)})),d.click(function(o){o.preventDefault(),d.slideUp(a.animate_speed_hide,function(){l.slideDown(a.animate_speed_show)})}),jQuery("#cookielawinfo-cookie-delete").click(function(){return s.erase(c),!1}),jQuery("#cookie_action_close_header").click(function(o){o.preventDefault(),e()}),a.scroll_close===!0&&window.addEventListener("scroll",n,!1)}function l1hs(o){return"#"!=o.charAt(0)?"#"+o:(o=o.substring(1,o.length),l1hs(o))}