var Browser = {
    detectBrowser:function()
    {
        var type= 0;
        var userAgent= navigator.userAgent;
        switch (true) {
            //            case (userAgent.match(/ipad/i)!=null):
            //                type= 1;
            //                break; // the ipad

            case (userAgent.match(/ipod/i)!=null || userAgent.match(/iphone/i)!=null):
                type= 1;
                break; // the iphone or ipod

            case (userAgent.match(/android/i)!=null):
                type= 1;
                break; // android

//            case (userAgent.match(/opera mini/i)!=null):
//                type= 1;
//                break; // opera

            case (userAgent.match(/blackberry/i)!=null):
                type= 1; 
                break; // blackberry

            case (userAgent.match(/(pre\/|palm os|palm|hiptop|avantgo|plucker|xiino|blazer|elaine)/i)!=null):
                type= 1; 
                break; // palm os

//            case (userAgent.match(/(iris|3g_t|windows ce|opera mobi|windows ce; smartphone;|windows ce; iemobile)/i)!=null):
//                type= 1; 
//                break; // windows

//            case (userAgent.match(/(mini 9.5|vx1000|lge |m800|e860|u940|ux840|compal|wireless| mobi|ahong|lg380|lgku|lgu900|lg210|lg47|lg920|lg840|lg370|sam-r|mg50|s55|g83|t66|vx400|mk99|d615|d763|el370|sl900|mp500|samu3|samu4|vx10|xda_|samu5|samu6|samu7|samu9|a615|b832|m881|s920|n210|s700|c-810|_h797|mob-x|sk16d|848b|mowser|s580|r800|471x|v120|rim8|c500foma:|160x|x160|480x|x640|t503|w839|i250|sprint|w398samr810|m5252|c7100|mt126|x225|s5330|s820|htil-g1|fly v71|s302|-x113|novarra|k610i|-three|8325rc|8352rc|sanyo|vx54|c888|nx250|n120|mtk |c5588|s710|t880|c5005|i;458x|p404i|s210|c5100|teleca|s940|c500|s590|foma|samsu|vx8|vx9|a1000|_mms|myx|a700|gu1100|bc831|e300|ems100|me701|me702m-three|sd588|s800|8325rc|ac831|mw200|brew |d88|htc\/|htc_touch|355x|m50|km100|d736|p-9521|telco|sl74|ktouch|m4u\/|me702|8325rc|kddi|phone|lg |sonyericsson|samsung|240x|x320|vx10|nokia|sony cmd|motorola|up.browser|up.link|mmp|symbian|smartphone|midp|wap|vodafone|o2|pocket|kindle|mobile|psp|treo)/i)!=null):
//                type= 1; 
//                break; // mobile browser
            
            /* Symbian 3 */
            case (userAgent.search(/Symbian\/3/gi) > -1):
                type= 1;
                break;
            /* midp compatible */
            case userAgent.indexOf('MIDP') > -1:
                type= 1;
                break;
            /* opera mini */
//            case userAgent.indexOf('Opera Mini') > -1:
//                type= 1;
//                break;
            /* MAUI */
            case userAgent.indexOf('MAUI') > -1:
                type= 1;
                break;
            /* mobile safari */
//            case userAgent.search(/Mobile.*Safari/gi) > -1:
//                if (userAgent.indexOf('iPad') > -1) {
//                    type= 0;
//                } else {
//                    type= 1;
//                }
//                break;
            /* Iphone */
            case userAgent.indexOf('iPhone') > -1:
                type= 1;
                break;
            /* Ipod */
            case userAgent.indexOf('iPod') > -1:
                type= 1;
                break;
            /* Android */
            case userAgent.indexOf('Android') > -1:
                type= 1;
                break;
            /* Samsung */
            case userAgent.indexOf('samsung') > -1:
                type= 1;
                break;
            /* LG */
            case userAgent.indexOf('LG') > -1:
                type= 1;
                break;
            /* Motorola */
            case userAgent.indexOf('MOT') > -1:
                type= 1;
                break;
            /* Motorola */
            case userAgent.indexOf('MOTOROLA') > -1:
                type= 1;
                break;
            /* BlackBerry compatible */
            case userAgent.indexOf('BlackBerry') > -1:
                type= 1;
                break;
            /* Nokia */
            case userAgent.indexOf('Nokia') > -1:
            /* IEMobile compatible */
            case userAgent.indexOf('IEMobile') > -1:
                type= 1;
                if (userAgent.indexOf('Windows Phone') > -1) {
                    type= 1;
                }
                break;
            /* HTC */
            case userAgent.indexOf('HTC') > -1:
                type= 1;
                break;
                
            default:
                type= 0;
                break;
        }
        
//        var  tabletDevices = new Array(
//            'PlayBook|RIM Tablet',
////            'iPad|iPad.*Mobile',
//            '^.*Android.*Nexus(?:(?!Mobile).)*$',
//            'Kindle|Silk.*Accelerated',
//            'SAMSUNG.*Tablet|Galaxy.*Tab|GT-P1000|GT-P1010|GT-P6210|GT-P6800|GT-P6810|GT-P7100|GT-P7300|GT-P7310|GT-P7500|GT-P7510|SCH-I800|SCH-I815|SCH-I905|SGH-I957|SGH-I987|SGH-T849|SGH-T859|SGH-T869|SPH-P100|GT-P1000|GT-P3100|GT-P3110|GT-P5100|GT-P5110|GT-P6200|GT-P7300|GT-P7320|GT-P7500|GT-P7510|GT-P7511',
//            'HTC Flyer|HTC Jetstream|HTC-P715a|HTC EVO View 4G|PG41200',
//            'xoom|sholest|MZ615|MZ605|MZ505|MZ601|MZ602|MZ603|MZ604|MZ606|MZ607|MZ608|MZ609|MZ615|MZ616|MZ617',
//            'Transformer|TF101',
//            'Android.*Nook|NookColor|nook browser|BNTV250A|LogicPD Zoom2',
//            'Android.*\b(A100|A101|A200|A500|A501|A510|W500|W500P|W501|W501P)\b',
//            'Android.*(TAB210|TAB211|TAB224|TAB250|TAB260|TAB264|TAB310|TAB360|TAB364|TAB410|TAB411|TAB420|TAB424|TAB450|TAB460|TAB461|TAB464|TAB465|TAB467|TAB468)',
//            'Android.*\bOYO\b|LIFE.*(P9212|P9514|P9516|S9512)|LIFETAB',
//            'AN10G2|AN7bG3|AN7fG3|AN8G3|AN8cG3|AN7G3|AN9G3|AN7dG3|AN7dG3ST|AN7dG3ChildPad|AN10bG3|AN10bG3DT',
//            'Android.*ARCHOS|101G9|80G9',
//            'NOVO7|Novo7Aurora|Novo7Basic|NOVO7PALADIN',
////            'Sony Tablet|Sony Tablet S',
//            'Tablet(?!.*PC)|ViewPad7|LG-V909|MID7015|BNTV250A|LogicPD Zoom2|\bA7EB\b|CatNova8|A1_07|CT704|CT1002|\bM721\b|hp-tablet'
//            );
//	
//        for (i in tabletDevices) {
//            var v_regex = tabletDevices[i];
//            if (eval('userAgent.match(/('+v_regex+')/i)!=null')) {
//                type= 1;
//            }
//        }
        
        return type;
    }
}

function setCookie(name,value,expires,path,domain,secure){
    var today=new Date();
    today.setTime(today.getTime());
    if(expires){
        expires=expires*1000*60*60;
    }
    var expires_date=new Date(today.getTime()+(expires));
    document.cookie=name+"="+escape(value)+
    ((expires)?";expires="+expires_date.toGMTString():"")+
    ((path)?";path="+path:"")+
    ((domain)?";domain="+domain:"")+
    ((secure)?";secure":"");
}
function getCookie(name){
    var start=document.cookie.indexOf(name+"=");
    var len=start+name.length+1;
    if((!start)&&(name!=document.cookie.substring(0,name.length))){
        return null;
    }
    if(start==-1)return null;
    var end=document.cookie.indexOf(";",len);
    if(end==-1)end=document.cookie.length;
    return unescape(document.cookie.substring(len,end));
}

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
    results = regex.exec(location.search);
    return results == null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

var type=0;
type=Browser.detectBrowser();
var ck=getParameterByName('ck');
if(ck==1 && !getCookie("ck"))
    setCookie("ck", 99, 4, "/", "", "");//4 gio

if(type==0 && ck==9){
    setCookie("ck", 9, 4, "/", "", "");//4 gio
    location.href='http://m.xoso.com' + location.pathname + location.search;
//    location.href='http://xoso-mobilev2.com' + location.pathname + location.search;
}

if (type>0 && getCookie("ck")!=99)
    location.href='http://m.xoso.com' + location.pathname + location.search;
//    location.href='http://xoso-mobilev2.com' + location.pathname + location.search;
if(window.location.host=='xoso.com')
    location.href='http://www.xoso.com' + location.pathname + location.search;
$(document).ready(function(){
    if(type>0) $('#mobilev').html('<a href="http://m.xoso.com/">Mobile version</a>');
});