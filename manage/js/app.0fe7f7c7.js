(function(e){function t(t){for(var a,o,c=t[0],s=t[1],u=t[2],l=0,f=[];l<c.length;l++)o=c[l],r[o]&&f.push(r[o][0]),r[o]=0;for(a in s)Object.prototype.hasOwnProperty.call(s,a)&&(e[a]=s[a]);d&&d(t);while(f.length)f.shift()();return i.push.apply(i,u||[]),n()}function n(){for(var e,t=0;t<i.length;t++){for(var n=i[t],a=!0,o=1;o<n.length;o++){var c=n[o];0!==r[c]&&(a=!1)}a&&(i.splice(t--,1),e=s(s.s=n[0]))}return e}var a={},o={app:0},r={app:0},i=[];function c(e){return s.p+"js/"+({}[e]||e)+"."+{"chunk-0491f49b":"f02bdf4a","chunk-0a1e37a7":"65385662","chunk-343d9d1a":"88c8c217","chunk-42fedf99":"d52bc428","chunk-603dc3a8":"4a558655","chunk-67abfb0e":"480c800a","chunk-7b463a6b":"70f5f920","chunk-b0cfc03c":"a7ac83f6","chunk-c46c7c9c":"893c416c","chunk-d13de660":"b850a58c","chunk-1293d2c0":"3c532825","chunk-6ad97f95":"efbe6444","chunk-f0dca122":"b392d6d5","chunk-205b7996":"c673f064","chunk-348970ee":"abe992bb","chunk-2d0ba6b0":"fe1ee78f","chunk-9f281750":"4d5593d3","chunk-f407804c":"5e540409"}[e]+".js"}function s(t){if(a[t])return a[t].exports;var n=a[t]={i:t,l:!1,exports:{}};return e[t].call(n.exports,n,n.exports,s),n.l=!0,n.exports}s.e=function(e){var t=[],n={"chunk-0491f49b":1,"chunk-0a1e37a7":1,"chunk-343d9d1a":1,"chunk-42fedf99":1,"chunk-603dc3a8":1,"chunk-67abfb0e":1,"chunk-7b463a6b":1,"chunk-b0cfc03c":1,"chunk-c46c7c9c":1,"chunk-d13de660":1,"chunk-1293d2c0":1,"chunk-6ad97f95":1,"chunk-f0dca122":1,"chunk-205b7996":1,"chunk-348970ee":1,"chunk-9f281750":1,"chunk-f407804c":1};o[e]?t.push(o[e]):0!==o[e]&&n[e]&&t.push(o[e]=new Promise(function(t,n){for(var a="css/"+({}[e]||e)+"."+{"chunk-0491f49b":"1513cdef","chunk-0a1e37a7":"395acf99","chunk-343d9d1a":"df070956","chunk-42fedf99":"0dc416de","chunk-603dc3a8":"d3a8df98","chunk-67abfb0e":"e8d1075f","chunk-7b463a6b":"d87258c6","chunk-b0cfc03c":"f23fe0c8","chunk-c46c7c9c":"0dc416de","chunk-d13de660":"27da4795","chunk-1293d2c0":"fb360758","chunk-6ad97f95":"731970ee","chunk-f0dca122":"06aa74e7","chunk-205b7996":"e9769515","chunk-348970ee":"0c71f764","chunk-2d0ba6b0":"31d6cfe0","chunk-9f281750":"15c61445","chunk-f407804c":"0dc416de"}[e]+".css",r=s.p+a,i=document.getElementsByTagName("link"),c=0;c<i.length;c++){var u=i[c],l=u.getAttribute("data-href")||u.getAttribute("href");if("stylesheet"===u.rel&&(l===a||l===r))return t()}var f=document.getElementsByTagName("style");for(c=0;c<f.length;c++){u=f[c],l=u.getAttribute("data-href");if(l===a||l===r)return t()}var d=document.createElement("link");d.rel="stylesheet",d.type="text/css",d.onload=t,d.onerror=function(t){var a=t&&t.target&&t.target.src||r,i=new Error("Loading CSS chunk "+e+" failed.\n("+a+")");i.code="CSS_CHUNK_LOAD_FAILED",i.request=a,delete o[e],d.parentNode.removeChild(d),n(i)},d.href=r;var m=document.getElementsByTagName("head")[0];m.appendChild(d)}).then(function(){o[e]=0}));var a=r[e];if(0!==a)if(a)t.push(a[2]);else{var i=new Promise(function(t,n){a=r[e]=[t,n]});t.push(a[2]=i);var u,l=document.createElement("script");l.charset="utf-8",l.timeout=120,s.nc&&l.setAttribute("nonce",s.nc),l.src=c(e),u=function(t){l.onerror=l.onload=null,clearTimeout(f);var n=r[e];if(0!==n){if(n){var a=t&&("load"===t.type?"missing":t.type),o=t&&t.target&&t.target.src,i=new Error("Loading chunk "+e+" failed.\n("+a+": "+o+")");i.type=a,i.request=o,n[1](i)}r[e]=void 0}};var f=setTimeout(function(){u({type:"timeout",target:l})},12e4);l.onerror=l.onload=u,document.head.appendChild(l)}return Promise.all(t)},s.m=e,s.c=a,s.d=function(e,t,n){s.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},s.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},s.t=function(e,t){if(1&t&&(e=s(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(s.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var a in e)s.d(n,a,function(t){return e[t]}.bind(null,a));return n},s.n=function(e){var t=e&&e.__esModule?function(){return e["default"]}:function(){return e};return s.d(t,"a",t),t},s.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},s.p="",s.oe=function(e){throw console.error(e),e};var u=window["webpackJsonp"]=window["webpackJsonp"]||[],l=u.push.bind(u);u.push=t,u=u.slice();for(var f=0;f<u.length;f++)t(u[f]);var d=l;i.push([0,"chunk-vendors"]),n()})({0:function(e,t,n){e.exports=n("56d7")},"0f5b":function(e,t,n){e.exports=n.p+"img/img_admin_logo.11f9e811.png"},2423:function(e,t,n){},"33ec":function(e,t,n){},"37a8":function(e,t,n){"use strict";var a=n("c262"),o=n.n(a);o.a},"3af0":function(e,t,n){e.exports=n.p+"img/img_avatar.a0e88e83.png"},"3daa":function(e,t,n){},4360:function(e,t,n){"use strict";var a=n("2b0e"),o=n("2f62"),r=n("c24f"),i=n("c276"),c={state:{userName:"",nickName:"",hasGetInfo:!1,token:Object(i["j"])(),access:[]},mutations:{setUserName:function(e,t){e.userName=t},setNickName:function(e,t){e.nickName=t},setToken:function(e,t){e.token=t,Object(i["r"])(t)},setHasGetInfo:function(e,t){e.hasGetInfo=t},setAccess:function(e,t){e.access=t}},actions:{handleLogin:function(e,t){var n=e.commit,a=t.userName,o=t.passWord;return a=a.trim(),new Promise(function(e,t){Object(r["c"])({userName:a,passWord:o}).then(function(t){var a=t.data;"y"===a.status&&n("setToken",a.data.token),e(a)}).catch(function(e){t(e)})})},handleStuffLogin:function(e,t){var n=e.commit,a=t.ticket,o=t.time;return a=a.trim(),new Promise(function(e,t){Object(r["d"])({ticket:a,time:o}).then(function(t){var a=t.data;"y"===a.status&&n("setToken",a.data.token),e(a)}).catch(function(e){t(e)})})},getUserInfo:function(e){e.state;var t=e.commit;return new Promise(function(e,n){Object(r["b"])().then(function(a){var o=a.data;"y"===o.status?(t("setUserName",o.data.username),t("setNickName",o.data.nickname),t("setHasGetInfo",!0),t("setAccess",o.data.roles),e(o)):n(o)}).catch(function(e){n(e)})})},handleLogOut:function(e){e.state;var t=e.commit;return new Promise(function(e,n){t("setToken",""),t("setAccess",[]),e()})},userCan:function(e,t){var n=e.state;return n.access.indexOf(t)>-1}}},s=(n("20d6"),n("7f7f"),n("75fc")),u=n("a18c"),l=n("ddb9"),f=n("f121"),d=f["a"].homeName,m=function(e,t){var n=Object(i["f"])(e.tagNavList,t);e.tagNavList=e.tagNavList.filter(function(e){return!Object(i["m"])(e,t)}),void 0!=t.meta.goBack?u["a"].go(-1):u["a"].push(n)},h={state:{breadCrumbList:[],tagNavList:[],homeRoute:{},local:Object(i["k"])("local"),errorList:[],hasReadErrorPage:!1},getters:{menuList:function(e,t,n){return Object(i["d"])(l["a"],n.user.access)},errorCount:function(e){return e.errorList.length}},mutations:{setBreadCrumb:function(e,t){e.breadCrumbList=Object(i["b"])(t,e.homeRoute)},setHomeRoute:function(e,t){e.homeRoute=Object(i["c"])(t,d)},setTagNavList:function(e,t){var n=[];n=t?Object(s["a"])(t):Object(i["i"])()||[],n[0]&&n[0].name!==d&&n.shift();var a=n.findIndex(function(e){return e.name===d});if(a>0){var o=n.splice(a,1)[0];n.unshift(o)}e.tagNavList=n,Object(i["p"])(Object(s["a"])(n))},closeTag:function(e,t){var n=e.tagNavList.filter(function(e){return Object(i["m"])(e,t)});t=n[0]?n[0]:null,t&&m(e,t)},closePageAndGoBack:function(e,t){t.meta.goBack=!0,m(e,t)},addTag:function(e,t){var n=t.route,a=t.type,o=void 0===a?"unshift":a,r=Object(i["h"])(n);Object(i["n"])(e.tagNavList,r)||("push"===o?e.tagNavList.push(r):r.name===d?e.tagNavList.unshift(r):e.tagNavList.splice(1,0,r),Object(i["p"])(Object(s["a"])(e.tagNavList)))},setLocal:function(e,t){Object(i["l"])("local",t),e.local=t},addError:function(e,t){e.errorList.push(t)},setHasReadErrorLoggerStatus:function(e){var t=!(arguments.length>1&&void 0!==arguments[1])||arguments[1];e.hasReadErrorPage=t}},actions:{}},p=(n("ac6a"),n("456d"),n("6b6c")),g=function(){var e={service:"common.constants"};return p["a"].request({url:"/",data:e,method:"post"})},v={state:{constants:{}},mutations:{setConstants:function(e,t){e.constants=t}},actions:{getConstants:function(e){var t=e.state,n=e.commit;return Object.keys(t.constants).length>0?t.constants:new Promise(function(e,t){g().then(function(a){var o=a.data;"y"===o.status?(n("setConstants",o.data),e(o.data)):t(o)}).catch(function(e){t(e)})})}}};a["default"].use(o["a"]);t["a"]=new o["a"].Store({state:{},mutations:{},actions:{},modules:{user:c,common:v,app:h}})},"48e2":function(e,t,n){"use strict";var a=n("ac8e"),o=n.n(a);o.a},"56d7":function(e,t,n){"use strict";n.r(t);n("cadf"),n("551c"),n("f751"),n("097d");var a=n("2b0e"),o=n("e069"),r=n.n(o),i=n("a18c"),c=n("4360"),s=n("f121"),u=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{attrs:{id:"app"}},[n("router-view")],1)},l=[],f={name:"App"},d=f,m=(n("7c55"),n("2877")),h=Object(m["a"])(d,u,l,!1,null,null,null),p=h.exports;n("ca62"),n("33ec");a["default"].use(r.a),a["default"].config.productionTip=!1,a["default"].prototype.$config=s["a"],new a["default"]({el:"#app",router:i["a"],store:c["a"],render:function(e){return e(p)}})},"6b6c":function(e,t,n){"use strict";n("ac6a"),n("456d");var a=n("d225"),o=n("b0b4"),r=n("bc3a"),i=n.n(r),c=(n("4360"),n("c276")),s=function(e){e.statusText,e.status,e.request.responseURL},u=function(){function e(){var t=arguments.length>0&&void 0!==arguments[0]?arguments[0]:baseURL;Object(a["a"])(this,e),this.baseUrl=t,this.queue={}}return Object(o["a"])(e,[{key:"getInsideConfig",value:function(){var e=(new Date).getTime(),t={baseURL:this.baseUrl,headers:{"x-authorization":Object(c["j"])(),"x-req-time":e,"x-req-key":Object(c["g"])(e-2048)}};return t}},{key:"destroy",value:function(e){delete this.queue[e],Object.keys(this.queue).length}},{key:"interceptors",value:function(e,t){var n=this;e.interceptors.request.use(function(e){return Object.keys(n.queue).length,n.queue[t]=!0,e},function(e){return Promise.reject(e)}),e.interceptors.response.use(function(e){n.destroy(t);var a=e.data,o=e.status;return 401===a.errcode&&(Object(c["r"])(""),setTimeout(function(){window.location.href="/"},1e3)),{data:a,status:o}},function(e){n.destroy(t);var a=e.response;if(!a){var o=JSON.parse(JSON.stringify(e)),r=o.request,i=r.statusText,c=r.status,u=o.config;a={statusText:i,status:c,request:{responseURL:u.url}}}return s(a),Promise.reject(e)})}},{key:"request",value:function(e){var t=i.a.create();return e=Object.assign(this.getInsideConfig(),e),this.interceptors(t,e.url),t(e)}}]),e}(),l=u,f=n("f121"),d=f["a"].baseUrl.pro,m=new l(d);t["a"]=m},"7c55":function(e,t,n){"use strict";var a=n("2423"),o=n.n(a);o.a},"90de":function(e,t,n){"use strict";n.d(t,"a",function(){return o}),n.d(t,"b",function(){return r}),n.d(t,"c",function(){return i}),n.d(t,"g",function(){return c}),n.d(t,"f",function(){return s}),n.d(t,"e",function(){return u}),n.d(t,"d",function(){return l});n("456d"),n("c5f6");var a=n("75fc"),o=(n("ac6a"),n("4f7f"),n("5df3"),n("1c4c"),function(e,t){if(e.length&&t){var n=-1,a=e.length;while(++n<a){var o=e[n];t(o,n,e)}}}),r=function(e,t){return Array.from(new Set([].concat(Object(a["a"])(e),Object(a["a"])(t))))},i=function(e,t){return e.some(function(e){return t.indexOf(e)>-1})};function c(e,t){for(var n=0;n<t.length;n++)if(e===t[n])return!0;return!1}var s=function(){return document.addEventListener?function(e,t,n){e&&t&&n&&e.addEventListener(t,n,!1)}:function(e,t,n){e&&t&&n&&e.attachEvent("on"+t,n)}}(),u=function(){return document.removeEventListener?function(e,t,n){e&&t&&e.removeEventListener(t,n,!1)}:function(e,t,n){e&&t&&e.detachEvent("on"+t,n)}}(),l=function(e,t){var n=Object.keys(e),a=Object.keys(t);return n.length===a.length&&(0===n.length&&0===a.length||!n.some(function(n){return e[n]!=t[n]}))}},a18c:function(e,t,n){"use strict";n("7f7f");var a=n("2b0e"),o=n("8c4f"),r=n("ddb9"),i=n("4360"),c=n("e069"),s=n.n(c),u=n("c276"),l=n("f121"),f=l["a"].homeName;a["default"].use(o["a"]);var d=new o["a"]({routes:r["a"]}),m="login",h=function(e,t,n){Object(u["a"])(e.name,t,r["a"])?n():n({replace:!0,name:"error_401"})};s.a.LoadingBar.config({height:1}),d.beforeEach(function(e,t,n){s.a.LoadingBar.start();var a=Object(u["j"])();void 0!=e.meta.needLogin&&!1===e.meta.needLogin?n():a||e.name===m?a||e.name!==m?a&&e.name===m?n({name:f}):i["a"].state.user.hasGetInfo?h(e,i["a"].state.user.access,n):i["a"].dispatch("getUserInfo").then(function(t){h(e,t.access,n),i["a"].dispatch("getConstants")}).catch(function(){Object(u["r"])(""),n({name:m})}):n():n({name:m})}),d.afterEach(function(e){Object(u["q"])(e,d.app),s.a.LoadingBar.finish(),window.scrollTo(0,0)}),t["a"]=d},ac8e:function(e,t,n){},af9b:function(e,t,n){},b399:function(e,t,n){"use strict";var a=n("af9b"),o=n.n(a);o.a},c24f:function(e,t,n){"use strict";n.d(t,"c",function(){return o}),n.d(t,"d",function(){return r}),n.d(t,"b",function(){return i}),n.d(t,"e",function(){return c}),n.d(t,"a",function(){return s});var a=n("6b6c"),o=function(e){var t=e.userName,n=e.passWord,o={service:"login",userName:t,passWord:n};return a["a"].request({url:"/",data:o,method:"post"})},r=function(e){var t=e.ticket,n=e.time,o={service:"login.stuff",ticket:t,time:n};return a["a"].request({url:"/",data:o,method:"post"})},i=function(){var e={service:"user.getInfo"};return a["a"].request({url:"/",data:e,method:"post"})},c=function(e){return e.service="user.updatePassword",a["a"].request({url:"/",data:e,method:"post"})},s=function(){var e={service:"user.getStatistics"};return a["a"].request({url:"/",data:e,method:"post"})}},c262:function(e,t,n){},c276:function(e,t,n){"use strict";n.d(t,"j",function(){return m}),n.d(t,"r",function(){return h}),n.d(t,"g",function(){return p}),n.d(t,"d",function(){return b}),n.d(t,"b",function(){return y}),n.d(t,"h",function(){return k}),n.d(t,"s",function(){return w}),n.d(t,"p",function(){return O}),n.d(t,"i",function(){return N}),n.d(t,"c",function(){return j}),n.d(t,"e",function(){return L}),n.d(t,"a",function(){return T}),n.d(t,"f",function(){return C}),n.d(t,"m",function(){return x}),n.d(t,"n",function(){return B}),n.d(t,"l",function(){return S}),n.d(t,"k",function(){return $}),n.d(t,"o",function(){return M}),n.d(t,"q",function(){return P});n("ac6a"),n("28a5"),n("20d6");var a=n("75fc"),o=n("cebc"),r=(n("7f7f"),n("6b54"),n("f121")),i=n("90de"),c=n("3452"),s=n.n(c),u=r["a"].title,l=r["a"].tokenKey,f=r["a"].a5125655af8fdc01,d=r["a"].b8cef37f16a27ce,m=function(){var e=window.localStorage.getItem(l);return e||""},h=function(e){window.localStorage.setItem(l,e)},p=function(e){var t=s.a.enc.Utf8.parse(e),n=s.a.enc.Utf8.parse(f),a=s.a.enc.Utf8.parse(d),o=s.a.AES.encrypt(t,n,{iv:a,mode:s.a.mode.CBC,padding:s.a.pad.ZeroPadding});return o.toString()},g=function(e){return e.children&&0!==e.children.length},v=function(e,t){var n=e.name;return"_"===n.substring(0,1)&&(n=n.substring(1)),t.indexOf(n)>-1},b=function e(t,n){var a=[];return Object(i["a"])(t,function(t){if(!t.meta||t.meta&&!t.meta.hideInMenu){var o={icon:t.meta&&t.meta.icon||"",name:t.name,meta:t.meta};(g(t)||t.meta&&t.meta.showAlways)&&v(t,n)&&(o.children=e(t.children,n)),t.meta&&t.meta.href&&(o.href=t.meta.href),v(t,n)&&a.push(o)}}),a},y=function(e,t){var n=Object(o["a"])({},t,{icon:t.meta.icon}),r=e.matched;if(r.some(function(e){return e.name===t.name}))return[n];var i=r.filter(function(e){return void 0===e.meta||!e.meta.hideInBread}).map(function(t){var n=Object(o["a"])({},t.meta);n.title&&"function"===typeof n.title&&(n.__titleIsFunction__=!0,n.title=n.title(e));var a={icon:t.meta&&t.meta.icon||"",name:t.name,meta:n};return a});return i=i.filter(function(e){return!e.meta.hideInMenu}),[Object(o["a"])({},n,{to:t.path})].concat(Object(a["a"])(i))},k=function(e){var t=Object(o["a"])({},e),n=Object(o["a"])({},e.meta),a="";return n.title&&("function"===typeof n.title?(n.__titleIsFunction__=!0,a=n.title(t)):a=n.title),n.title=a,t.meta=n,t},w=function(e,t){var n=e.meta,a=n.title;n.__titleIsFunction__;if(a)return a=e.meta&&e.meta.title||e.name,a},O=function(e){localStorage.tagNaveList=JSON.stringify(e)},N=function(){var e=localStorage.tagNaveList;return e?JSON.parse(e):[]},j=function e(t){var n=arguments.length>1&&void 0!==arguments[1]?arguments[1]:"home",a=-1,o=t.length,r={};while(++a<o){var i=t[a];if(i.children&&i.children.length){var c=e(i.children,n);if(c.name)return c}else i.name===n&&(r=i)}return r},L=function(e,t){var n=t.name,o=t.path,r=t.meta,i=Object(a["a"])(e);return i.findIndex(function(e){return e.name===n})>=0?i:(i.push({name:n,path:o,meta:r}),i)},_=function(e,t){return!t.meta||!t.meta.access||Object(i["c"])(e,t.meta.access)},T=function(e,t,n){var a=function n(a){return a.some(function(a){return a.children&&a.children.length?n(a.children):a.name===e?_(t,a):void 0})};return a(n)},C=function(e,t){var n={};if(2===e.length)n=j(e);else{var a=e.findIndex(function(e){return x(e,t)});n=a===e.length-1?e[e.length-2]:e[a+1]}return n},I=function(e,t){var n=-1;while(++n<e)t(n)},x=function(e,t){var n=e.params||{},a=t.params||{},o=e.query||{},r=t.query||{};return e.name===t.name&&Object(i["d"])(n,a)&&Object(i["d"])(o,r)},B=function(e,t){var n=e.length,a=!1;return I(n,function(n){x(e[n],t)&&(a=!0)}),a},S=function(e,t){localStorage.setItem(e,t)},$=function(e){return localStorage.getItem(e)||""},M=function(e){var t=arguments.length>1&&void 0!==arguments[1]?arguments[1]:0,n=arguments.length>2?arguments[2]:void 0,a=arguments.length>3&&void 0!==arguments[3]?arguments[3]:500,o=arguments.length>4?arguments[4]:void 0;window.requestAnimationFrame||(window.requestAnimationFrame=window.webkitRequestAnimationFrame||window.mozRequestAnimationFrame||window.msRequestAnimationFrame||function(e){return window.setTimeout(e,1e3/60)});var r=Math.abs(t-n),i=Math.ceil(r/a*50),c=function t(n,a,r){if(n!==a){var i=n+r>a?a:n+r;n>a&&(i=n-r<a?a:n-r),e===window?window.scrollTo(i,i):e.scrollTop=i,window.requestAnimationFrame(function(){return t(i,a,r)})}else o&&o()};c(t,n,i)},P=function(e,t){var n=k(e),a=w(n,t),o=a?"".concat(a," - ").concat(u):u;window.document.title=o}},ca62:function(e,t,n){},cb21:function(e,t,n){"use strict";var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n(e.iconType,{tag:"component",attrs:{type:e.iconName,color:e.iconColor,size:e.iconSize}})},o=[],r=(n("c5f6"),function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("i",{class:"iconfont icon-"+e.type,style:e.styles})}),i=[],c={name:"Icons",props:{type:{type:String,required:!0},color:{type:String,default:"#5c6b77"},size:{type:Number,default:16}},computed:{styles:function(){return{fontSize:"".concat(this.size,"px"),color:this.color}}}},s=c,u=n("2877"),l=Object(u["a"])(s,r,i,!1,null,null,null),f=l.exports,d=f,m={name:"CommonIcon",components:{Icons:d},props:{type:{type:String,required:!0},color:String,size:Number},computed:{iconType:function(){return 0===this.type.indexOf("_")?"Icons":"Icon"},iconName:function(){return"Icons"===this.iconType?this.getCustomIconName(this.type):this.type},iconSize:function(){return this.size||("Icons"===this.iconType?12:void 0)},iconColor:function(){return this.color||""}},methods:{getCustomIconName:function(e){return e.slice(1)}}},h=m,p=Object(u["a"])(h,a,o,!1,null,null,null),g=p.exports;t["a"]=g},ddb9:function(e,t,n){"use strict";var a=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"layout"},[n("Layout",[n("Header",{staticClass:"layout-header"},[n("Menu",{staticClass:"layout-menu",attrs:{mode:"horizontal","active-name":e.$route.name},on:{"on-select":e.turnToPage}},[n("div",{staticClass:"layout-logo"},[n("img",{attrs:{src:e.logo}})]),n("div",{staticClass:"user-avatar"},[n("Avatar",{staticStyle:{"background-color":"#87d068"},attrs:{icon:"ios-person"}})],1),e._e(),n("header-menu",{ref:"headerMenu",staticClass:"layout-nav",attrs:{"menu-list":e.menuList}})],1)],1),n("Content",{staticClass:"main-content-con"},[n("Layout",{staticClass:"main-layout-con"},[n("div",{staticClass:"tag-nav-wrapper"},[n("tags-nav",{attrs:{value:e.$route,list:e.tagNavList},on:{input:e.handleClick,"on-close":e.handleCloseTag}})],1),n("Content",{staticClass:"content-wrapper"},[n("keep-alive",{attrs:{include:e.cacheList}},[n("router-view")],1),n("ABackTop",{attrs:{height:100,bottom:80,right:50,container:".content-wrapper"}})],1)],1)],1),n("Footer")],1)],1)},o=[],r=(n("7514"),n("28a5"),n("cebc")),i=(n("7f7f"),n("75fc")),c=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",[e._l(e.menuList,function(t){return[t.children&&1===t.children.length?[e.showChildren(t)?n("header-menu-item",{key:"menu-"+t.name,attrs:{"parent-item":t}}):n("menu-item",{key:"menu-"+t.children[0].name,attrs:{name:e.getNameOrHref(t,!0)}},[n("common-icon",{attrs:{type:t.children[0].icon||""}}),n("span",[e._v(e._s(e.showTitle(t.children[0])))])],1)]:[e.showChildren(t)?n("header-menu-item",{key:"menu-"+t.name,attrs:{"parent-item":t}}):n("menu-item",{key:"menu-"+t.name,attrs:{name:e.getNameOrHref(t)}},[n("common-icon",{attrs:{type:t.icon||""}}),n("span",[e._v(e._s(e.showTitle(t)))])],1)]]})],2)},s=[],u=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("Submenu",{attrs:{name:""+e.parentName}},[n("template",{slot:"title"},[n("common-icon",{attrs:{type:e.parentItem.icon||""}}),n("span",[e._v(e._s(e.showTitle(e.parentItem)))])],1),e._l(e.children,function(t){return[t.children&&1===t.children.length?[e.showChildren(t)?n("side-menu-item",{key:"menu-"+t.name,attrs:{"parent-item":t}}):n("menu-item",{key:"menu-"+t.children[0].name,attrs:{name:e.getNameOrHref(t,!0)}},[n("common-icon",{attrs:{type:t.children[0].icon||""}}),n("span",[e._v(e._s(e.showTitle(t.children[0])))])],1)]:[e.showChildren(t)?n("side-menu-item",{key:"menu-"+t.name,attrs:{"parent-item":t}}):n("menu-item",{key:"menu-"+t.name,attrs:{name:e.getNameOrHref(t)}},[n("common-icon",{attrs:{type:t.icon||""}}),n("span",[e._v(e._s(e.showTitle(t)))])],1)]]})],2)},l=[],f=n("cb21"),d=n("c276"),m={components:{CommonIcon:f["a"]},methods:{showTitle:function(e){return Object(d["s"])(e,this)},showChildren:function(e){return e.children&&(e.children.length>1||e.meta&&e.meta.showAlways)},getNameOrHref:function(e,t){return e.href?"isTurnByHref_".concat(e.href):t?e.children[0].name:e.name}}},h=(n("c5f6"),{props:{parentItem:{type:Object,default:function(){}},theme:String,iconSize:Number},computed:{parentName:function(){return this.parentItem.name},children:function(){return this.parentItem.children},textColor:function(){return"dark"===this.theme?"#fff":"#495060"}}}),p={name:"SideMenuItem",mixins:[m,h]},g=p,v=n("2877"),b=Object(v["a"])(g,u,l,!1,null,null,null),y=b.exports,k=n("90de"),w={name:"HeaderMenu",mixins:[m],components:{HeaderMenuItem:y},props:{menuList:{type:Array,default:function(){return[]}}},data:function(){return{openedNames:[]}},methods:{handleSelect:function(e){this.$emit("on-select",e)},getOpenedNamesByActiveName:function(e){return this.$route.matched.map(function(e){return e.name}).filter(function(t){return t!==e})},updateOpenName:function(e){e===this.$config.homeName?this.openedNames=[]:this.openedNames=this.getOpenedNamesByActiveName(e)}},computed:{textColor:function(){return"dark"===this.theme?"#fff":"#495060"}},watch:{activeName:function(e){this.accordion?this.openedNames=this.getOpenedNamesByActiveName(e):this.openedNames=Object(k["b"])(this.openedNames,this.getOpenedNamesByActiveName(e))},openNames:function(e){this.openedNames=e},openedNames:function(){this.$nextTick(function(){})}},mounted:function(){this.openedNames=Object(k["b"])(this.openedNames,this.getOpenedNamesByActiveName(name))}},O=w,N=(n("b399"),Object(v["a"])(O,c,s,!1,null,"7c3cccc4",null)),j=N.exports,L=j,_=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"tags-nav"},[n("div",{staticClass:"close-con"},[n("Dropdown",{staticStyle:{"margin-top":"7px"},attrs:{transfer:""},on:{"on-click":e.handleTagsOption}},[n("Button",{attrs:{size:"small",type:"text"}},[n("Icon",{attrs:{size:18,type:"ios-close-circle-outline"}})],1),n("DropdownMenu",{attrs:{slot:"list"},slot:"list"},[n("DropdownItem",{attrs:{name:"close-all"}},[e._v("关闭所有")]),n("DropdownItem",{attrs:{name:"close-others"}},[e._v("关闭其他")])],1)],1)],1),n("ul",{directives:[{name:"show",rawName:"v-show",value:e.visible,expression:"visible"}],staticClass:"contextmenu",style:{left:e.contextMenuLeft+"px",top:e.contextMenuTop+"px"}},e._l(e.menuList,function(t,a){return n("li",{key:a,on:{click:function(t){return e.handleTagsOption(a)}}},[e._v(e._s(t))])}),0),n("div",{staticClass:"btn-con left-btn"},[n("Button",{attrs:{type:"text"},on:{click:function(t){return e.handleScroll(240)}}},[n("Icon",{attrs:{size:18,type:"ios-arrow-back"}})],1)],1),n("div",{staticClass:"btn-con right-btn"},[n("Button",{attrs:{type:"text"},on:{click:function(t){return e.handleScroll(-240)}}},[n("Icon",{attrs:{size:18,type:"ios-arrow-forward"}})],1)],1),n("div",{ref:"scrollOuter",staticClass:"scroll-outer",on:{DOMMouseScroll:e.handlescroll,mousewheel:e.handlescroll}},[n("div",{ref:"scrollBody",staticClass:"scroll-body",style:{left:e.tagBodyLeft+"px"}},[n("transition-group",{attrs:{name:"taglist-moving-animation"}},e._l(e.list,function(t,a){return n("Tag",{key:"tag-nav-"+a,ref:"tagsPageOpened",refInFor:!0,attrs:{type:"dot",name:t.name,"data-route-item":t,closable:t.name!==e.$config.homeName,color:e.isCurrentTag(t)?"primary":"default"},on:{"on-close":function(n){return e.handleClose(t)}},nativeOn:{click:function(n){return e.handleClick(t)},contextmenu:function(n){return n.preventDefault(),e.contextMenu(t,n)}}},[e._v(e._s(e.showTitleInside(t)))])}),1)],1)])])},T=[],C=(n("ac6a"),n("6762"),n("2fdb"),n("e069")),I={before_close_normal:function(e){C["Modal"].confirm({title:"确定要关闭这一页吗",onOk:function(){e(!0)},onCancel:function(){e(!1)}})}},x=I,B={name:"TagsNav",props:{value:Object,list:{type:Array,default:function(){return[]}}},data:function(){return{tagBodyLeft:0,rightOffset:40,outerPadding:4,contextMenuLeft:0,contextMenuTop:0,visible:!1,menuList:{others:"关闭其他",all:"关闭所有"}}},computed:{currentRouteObj:function(){var e=this.value,t=e.name,n=e.params,a=e.query;return{name:t,params:n,query:a}}},methods:{handlescroll:function(e){var t=e.type,n=0;"DOMMouseScroll"!==t&&"mousewheel"!==t||(n=e.wheelDelta?e.wheelDelta:40*-(e.detail||0)),this.handleScroll(n)},handleScroll:function(e){var t=this.$refs.scrollOuter.offsetWidth,n=this.$refs.scrollBody.offsetWidth;e>0?this.tagBodyLeft=Math.min(0,this.tagBodyLeft+e):t<n?this.tagBodyLeft<-(n-t)?this.tagBodyLeft=this.tagBodyLeft:this.tagBodyLeft=Math.max(this.tagBodyLeft+e,t-n):this.tagBodyLeft=0},handleTagsOption:function(e){var t=this;if(e.includes("all")){var n=this.list.filter(function(e){return e.name===t.$config.homeName});this.$emit("on-close",n,"all")}else if(e.includes("others")){var a=this.list.filter(function(e){return Object(d["m"])(t.currentRouteObj,e)||e.name===t.$config.homeName});this.$emit("on-close",a,"others",this.currentRouteObj),setTimeout(function(){t.getTagElementByRoute(t.currentRouteObj)},100)}},handleClose:function(e){var t=this;e.meta&&e.meta.beforeCloseName&&e.meta.beforeCloseName in x?new Promise(x[e.meta.beforeCloseName]).then(function(n){n&&t.close(e)}):this.close(e)},close:function(e){var t=this.list.filter(function(t){return!Object(d["m"])(e,t)});this.$emit("on-close",t,void 0,e)},handleClick:function(e){this.$emit("input",e)},showTitleInside:function(e){return Object(d["s"])(e,this)},isCurrentTag:function(e){return Object(d["m"])(this.currentRouteObj,e)},moveToView:function(e){var t=this.$refs.scrollOuter.offsetWidth,n=this.$refs.scrollBody.offsetWidth;n<t?this.tagBodyLeft=0:e.offsetLeft<-this.tagBodyLeft?this.tagBodyLeft=-e.offsetLeft+this.outerPadding:e.offsetLeft>-this.tagBodyLeft&&e.offsetLeft+e.offsetWidth<-this.tagBodyLeft+t?this.tagBodyLeft=Math.min(0,t-e.offsetWidth-e.offsetLeft-this.outerPadding):this.tagBodyLeft=-(e.offsetLeft-(t-this.outerPadding-e.offsetWidth))},getTagElementByRoute:function(e){var t=this;this.$nextTick(function(){t.refsTag=t.$refs.tagsPageOpened,t.refsTag.forEach(function(n,a){if(Object(d["m"])(e,n.$attrs["data-route-item"])){var o=t.refsTag[a].$el;t.moveToView(o)}})})},contextMenu:function(e,t){if(e.name!==this.$config.homeName){this.visible=!0;var n=this.$el.getBoundingClientRect().left;this.contextMenuLeft=t.clientX-n+10,this.contextMenuTop=t.clientY-64}},closeMenu:function(){this.visible=!1}},watch:{$route:function(e){this.getTagElementByRoute(e)},visible:function(e){e?document.body.addEventListener("click",this.closeMenu):document.body.removeEventListener("click",this.closeMenu)}},mounted:function(){var e=this;setTimeout(function(){e.getTagElementByRoute(e.$route)},200)}},S=B,$=(n("37a8"),Object(v["a"])(S,_,T,!1,null,null,null)),M=$.exports,P=M,E=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{staticClass:"user-avatar-dropdown"},[n("Dropdown",{on:{"on-click":e.handleClick}},[n("Badge",[n("Avatar",{attrs:{src:e.userAvatar}})],1),n("Icon",{attrs:{size:18,type:"md-arrow-dropdown"}}),n("DropdownMenu",{attrs:{slot:"list"},slot:"list"},[n("DropdownItem",{attrs:{name:"password"}},[n("Icon",{attrs:{type:"md-lock",size:13}}),e._v(" 修改密码")],1),n("DropdownItem",{attrs:{name:"logout"}},[n("Icon",{attrs:{type:"md-power",size:13}}),e._v(" 退出登录")],1)],1)],1),n("Modal",{attrs:{title:"修改密码",width:"300px","mask-closable":!1,"ok-text":"保存"},model:{value:e.modal,callback:function(t){e.modal=t},expression:"modal"}},[n("Form",{ref:"passwordForm",attrs:{model:e.form,"label-width":80,rules:e.ruleValidate},nativeOn:{keydown:function(t){return!t.type.indexOf("key")&&e._k(t.keyCode,"enter",13,t.key,"Enter")?null:e.handleSubmit(t)}}},[n("FormItem",{attrs:{label:"原密码",prop:"oldPassword"}},[n("Input",{attrs:{type:"password",placeholder:"请输入原密码"},model:{value:e.form.oldPassword,callback:function(t){e.$set(e.form,"oldPassword",t)},expression:"form.oldPassword"}})],1),n("FormItem",{attrs:{label:"原密码",prop:"newPassword"}},[n("Input",{attrs:{type:"password",placeholder:"请设置新密码"},model:{value:e.form.newPassword,callback:function(t){e.$set(e.form,"newPassword",t)},expression:"form.newPassword"}})],1)],1),n("div",{attrs:{slot:"footer"},slot:"footer"},[n("Button",{attrs:{type:"default"},on:{click:function(t){e.modal=!1}}},[e._v("取消")]),n("Button",{attrs:{type:"primary",loading:e.saving},on:{click:e.handleSubmit}},[e._v("保存")])],1)],1)],1)},q=[],A=(n("3daa"),n("2f62")),R=n("c24f"),z={name:"User",props:{userAvatar:{type:String,default:""},messageUnreadCount:{type:Number,default:0},passwordRoles:{type:Array,default:function(){return[{required:!0,message:"请输入密码",trigger:"blur"}]}}},data:function(){return{modal:!1,saving:!1,form:{newPassword:"",oldPassword:""}}},computed:{ruleValidate:function(){return{newPassword:this.passwordRoles,oldPassword:this.passwordRoles}}},methods:Object(r["a"])({},Object(A["b"])(["handleLogOut"]),{logout:function(){var e=this;this.$Modal.confirm({title:"退出登录",content:"确定要退出登录么？",onOk:function(){e.handleLogOut().then(function(){e.$router.push({name:"login"})})}})},password:function(){this.modal=!0},handleClick:function(e){switch(e){case"logout":this.logout();break;case"password":this.password();break}},updatePassword:function(){var e=this;this.saving=!0,Object(R["e"])(this.form).then(function(t){e.saving=!1;var n=t.data;"y"===n.status?(e.$Message.success(n.msg),e.modal=!1,e.formReset()):e.$Message.error(n.msg)})},handleSubmit:function(){var e=this;this.$refs.passwordForm.validate(function(t){t&&e.updatePassword()})},formReset:function(){this.$refs.passwordForm.resetFields()}})},D=z,H=Object(v["a"])(D,E,q,!1,null,null,null),U=H.exports,F=U,W=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("div",{class:e.classes,style:e.styles,on:{click:e.back}},[e._t("default",[n("div",{class:e.innerClasses},[n("i",{staticClass:"ivu-icon ivu-icon-ios-arrow-up"})])])],2)},G=[],J=n("bd86"),V="ivu-back-top",K={name:"ABackTop",props:{height:{type:Number,default:400},bottom:{type:Number,default:30},right:{type:Number,default:30},duration:{type:Number,default:1e3},container:{type:null,default:window}},data:function(){return{backTop:!1}},mounted:function(){Object(k["f"])(this.containerEle,"scroll",this.handleScroll),Object(k["f"])(this.containerEle,"resize",this.handleScroll)},beforeDestroy:function(){Object(k["e"])(this.containerEle,"scroll",this.handleScroll),Object(k["e"])(this.containerEle,"resize",this.handleScroll)},computed:{classes:function(){return["".concat(V),Object(J["a"])({},"".concat(V,"-show"),this.backTop)]},styles:function(){return{bottom:"".concat(this.bottom,"px"),right:"".concat(this.right,"px")}},innerClasses:function(){return"".concat(V,"-inner")},containerEle:function(){return this.container===window?window:document.querySelector(this.container)}},methods:{handleScroll:function(){this.backTop=this.containerEle.scrollTop>=this.height},back:function(){var e="string"===typeof this.container?this.containerEle:document.documentElement||document.body,t=e.scrollTop;Object(d["o"])(this.containerEle,t,0,this.duration),this.$emit("on-click")}}},Q=K,X=Object(v["a"])(Q,W,G,!1,null,null,null),Y=X.exports,Z=Y,ee=n("0f5b"),te=n.n(ee),ne=n("3af0"),ae=n.n(ne),oe={name:"MainHorizontal",components:{HeaderMenu:L,TagsNav:P,ABackTop:Z,User:F},data:function(){return{logo:te.a}},computed:{tagNavList:function(){return this.$store.state.app.tagNavList},tagRouter:function(){return this.$store.state.app.tagRouter},menuList:function(){return this.$store.getters.menuList},cacheList:function(){var e=["ParentView"].concat(Object(i["a"])(this.tagNavList.length?this.tagNavList.filter(function(e){return!(e.meta&&e.meta.notCache)}).map(function(e){return e.name}):[]));return e},userAvatar:function(){return ae.a}},methods:Object(r["a"])({},Object(A["c"])(["setBreadCrumb","setTagNavList","addTag","setLocal","setHomeRoute","closeTag"]),Object(A["b"])(["handleLogin","getUnreadMessageCount"]),{turnToPage:function(e){var t={},n=t.name,a=t.params,o=t.query;"string"===typeof e?n=e:(n=e.name,a=e.params,o=e.query),n.indexOf("isTurnByHref_")>-1?window.open(n.split("_")[1]):this.$router.push({name:n,params:a,query:o})},handleCloseTag:function(e,t,n){"others"!==t&&("all"===t?this.turnToPage(this.$config.homeName):Object(d["m"])(this.$route,n)&&this.closeTag(n)),this.setTagNavList(e)},handleClick:function(e){this.turnToPage(e)}}),watch:{$route:function(e){var t=e.name,n=e.query,a=e.params,o=e.meta;this.addTag({route:{name:t,query:n,params:a,meta:o},type:"push"}),this.setBreadCrumb(e),this.setTagNavList(Object(d["e"])(this.tagNavList,e)),this.$refs.headerMenu.updateOpenName(e.name)}},mounted:function(){var e=this;this.setTagNavList(),this.setHomeRoute(ue);var t=this.$route,n=t.name,a=t.params,o=t.query,r=t.meta;this.addTag({route:{name:n,params:a,query:o,meta:r}}),this.setBreadCrumb(this.$route),this.tagNavList.find(function(t){return t.name===e.$route.name})||this.$router.push({name:this.$config.homeName})}},re=oe,ie=(n("48e2"),Object(v["a"])(re,a,o,!1,null,"a96c9214",null)),ce=ie.exports,se=ce,ue=t["a"]=[{path:"/",name:"_home",meta:{hideInMenu:!0},redirect:"/manage/home"},{path:"/manage",name:"_Home",component:se,redirect:"/manage/home",children:[{path:"home",name:"Home",meta:{title:"首页",icon:"md-home",hideInMenu:!1},component:function(e){return n.e("chunk-7b463a6b").then(function(){var t=[n("d791")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/manage/settings",name:"Settings",meta:{icon:"md-cog",title:"系统设置",hideInMenu:!1},component:se,children:[{path:"groups",name:"Settings_Groups",meta:{title:"系统用户组",icon:"ios-people",hideInMenu:!1},component:function(e){return n.e("chunk-603dc3a8").then(function(){var t=[n("727f")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"users",name:"Settings_Users",meta:{title:"系统用户",icon:"md-people",hideInMenu:!1},component:function(e){return n.e("chunk-0a1e37a7").then(function(){var t=[n("eb0b")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/manage/login",name:"login",meta:{title:"登录",hideInMenu:!0},component:function(e){return n.e("chunk-0491f49b").then(function(){var t=[n("ad2a")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"/manage/data",name:"_Data",component:se,meta:{icon:"logo-buffer",title:"公共数据维护",hideInBread:!0},children:[{path:"country",name:"Data_Country",meta:{title:"国家管理",icon:"md-globe",hideInMenu:!1},component:function(e){return Promise.all([n.e("chunk-d13de660"),n.e("chunk-1293d2c0"),n.e("chunk-6ad97f95")]).then(function(){var t=[n("de5b")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"city",name:"Data_City",meta:{title:"城市管理",icon:"md-football",hideInMenu:!1},component:function(e){return Promise.all([n.e("chunk-d13de660"),n.e("chunk-9f281750")]).then(function(){var t=[n("5a76")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"lang",name:"Data_Lang",meta:{title:"公共语言",icon:"md-planet",hideInMenu:!1},component:function(e){return n.e("chunk-b0cfc03c").then(function(){var t=[n("9662")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"banner",name:"Data_Media",meta:{title:"首页BANNER",icon:"md-cube",hideInMenu:!1},component:function(e){return Promise.all([n.e("chunk-d13de660"),n.e("chunk-2d0ba6b0")]).then(function(){var t=[n("36b9")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/manage/brokers",name:"_Brokers",component:se,meta:{hideInBread:!0},children:[{path:"index",name:"Brokers",meta:{title:"经纪人管理",icon:"ios-contacts"},component:function(e){return n.e("chunk-67abfb0e").then(function(){var t=[n("230c")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/manage/buildings",name:"_Buildings",component:se,meta:{hideInBread:!0},children:[{path:"index",name:"Buildings",meta:{title:"楼盘管理",icon:"ios-apps"},component:function(e){return Promise.all([n.e("chunk-d13de660"),n.e("chunk-1293d2c0"),n.e("chunk-f0dca122"),n.e("chunk-348970ee")]).then(function(){var t=[n("fcf0")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/manage/presales",name:"_Presales",component:se,meta:{hideInBread:!0},children:[{path:"index",name:"Presales",meta:{title:"楼花管理",icon:"ios-football"},component:function(e){return Promise.all([n.e("chunk-d13de660"),n.e("chunk-1293d2c0"),n.e("chunk-f0dca122"),n.e("chunk-205b7996")]).then(function(){var t=[n("6a23")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/manage/customers",name:"_Customers",component:se,meta:{hideInBread:!0},children:[{path:"index",name:"Customers",meta:{title:"客户管理",icon:"ios-people"},component:function(e){return n.e("chunk-343d9d1a").then(function(){var t=[n("d8a5")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},{path:"/401",name:"error_401",meta:{hideInMenu:!0,needLogin:!1},component:function(e){return n.e("chunk-f407804c").then(function(){var t=[n("ec55")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"*",name:"error_404",meta:{hideInMenu:!0,needLogin:!1},component:function(e){return n.e("chunk-42fedf99").then(function(){var t=[n("2754")];e.apply(null,t)}.bind(this)).catch(n.oe)}},{path:"/500",name:"error_500",meta:{hideInMenu:!0,needLogin:!1},component:function(e){return n.e("chunk-c46c7c9c").then(function(){var t=[n("b3ff")];e.apply(null,t)}.bind(this)).catch(n.oe)}}]},f121:function(e,t,n){"use strict";t["a"]={title:"SQUIRREAL后台管理系统",cookieExpires:90,baseUrl:{dev:"/admin",pro:"/admin"},homeName:"Home",tokenKey:"Authorization",a5125655af8fdc01:"9ef1c0d959184b3f",b8cef37f16a27ce:"67f3a39255edbb4e"}}});