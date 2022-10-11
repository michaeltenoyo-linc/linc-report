/*! For license information please see auth.js.LICENSE.txt */
(()=>{var t={7757:(t,e,r)=>{t.exports=r(5666)},2085:function(t,e){var r;!function(n,o){"use strict";r=function(){return n.Snackbar=function(){var t={current:null},e={text:"Default Text",textColor:"#FFFFFF",width:"auto",showAction:!0,actionText:"Dismiss",actionTextAria:"Dismiss, Description for Screen Readers",alertScreenReader:!1,actionTextColor:"#4CAF50",showSecondButton:!1,secondButtonText:"",secondButtonAria:"Description for Screen Readers",secondButtonTextColor:"#4CAF50",backgroundColor:"#323232",pos:"bottom-left",duration:5e3,customClass:"",onActionClick:function(t){t.style.opacity=0},onSecondButtonClick:function(t){},onClose:function(t){}};t.show=function(n){var o=r(!0,e,n);t.current&&(t.current.style.opacity=0,setTimeout(function(){var t=this.parentElement;t&&t.removeChild(this)}.bind(t.current),500)),t.snackbar=document.createElement("div"),t.snackbar.className="snackbar-container "+o.customClass,t.snackbar.style.width=o.width;var a=document.createElement("p");if(a.style.margin=0,a.style.padding=0,a.style.color=o.textColor,a.style.fontSize="14px",a.style.fontWeight=300,a.style.lineHeight="1em",a.innerHTML=o.text,t.snackbar.appendChild(a),t.snackbar.style.background=o.backgroundColor,o.showSecondButton){var i=document.createElement("button");i.className="action",i.innerHTML=o.secondButtonText,i.setAttribute("aria-label",o.secondButtonAria),i.style.color=o.secondButtonTextColor,i.addEventListener("click",(function(){o.onSecondButtonClick(t.snackbar)})),t.snackbar.appendChild(i)}if(o.showAction){var c=document.createElement("button");c.className="action",c.innerHTML=o.actionText,c.setAttribute("aria-label",o.actionTextAria),c.style.color=o.actionTextColor,c.addEventListener("click",(function(){o.onActionClick(t.snackbar)})),t.snackbar.appendChild(c)}o.duration&&setTimeout(function(){t.current===this&&(t.current.style.opacity=0,t.current.style.top="-100px",t.current.style.bottom="-100px")}.bind(t.snackbar),o.duration),o.alertScreenReader&&t.snackbar.setAttribute("role","alert"),t.snackbar.addEventListener("transitionend",function(e,r){"opacity"===e.propertyName&&"0"===this.style.opacity&&("function"==typeof o.onClose&&o.onClose(this),this.parentElement.removeChild(this),t.current===this&&(t.current=null))}.bind(t.snackbar)),t.current=t.snackbar,document.body.appendChild(t.snackbar);getComputedStyle(t.snackbar).bottom,getComputedStyle(t.snackbar).top;t.snackbar.style.opacity=1,t.snackbar.className="snackbar-container "+o.customClass+" snackbar-pos "+o.pos},t.close=function(){t.current&&(t.current.style.opacity=0)};var r=function(){var t={},e=!1,n=0,o=arguments.length;"[object Boolean]"===Object.prototype.toString.call(arguments[0])&&(e=arguments[0],n++);for(var a=function(n){for(var o in n)Object.prototype.hasOwnProperty.call(n,o)&&(e&&"[object Object]"===Object.prototype.toString.call(n[o])?t[o]=r(!0,t[o],n[o]):t[o]=n[o])};n<o;n++){a(arguments[n])}return t};return t}()}.apply(e,[]),void 0===r||(t.exports=r)}(this)},5666:t=>{var e=function(t){"use strict";var e,r=Object.prototype,n=r.hasOwnProperty,o="function"==typeof Symbol?Symbol:{},a=o.iterator||"@@iterator",i=o.asyncIterator||"@@asyncIterator",c=o.toStringTag||"@@toStringTag";function s(t,e,r){return Object.defineProperty(t,e,{value:r,enumerable:!0,configurable:!0,writable:!0}),t[e]}try{s({},"")}catch(t){s=function(t,e,r){return t[e]=r}}function u(t,e,r,n){var o=e&&e.prototype instanceof v?e:v,a=Object.create(o.prototype),i=new O(n||[]);return a._invoke=function(t,e,r){var n=f;return function(o,a){if(n===h)throw new Error("Generator is already running");if(n===d){if("throw"===o)throw a;return $()}for(r.method=o,r.arg=a;;){var i=r.delegate;if(i){var c=E(i,r);if(c){if(c===y)continue;return c}}if("next"===r.method)r.sent=r._sent=r.arg;else if("throw"===r.method){if(n===f)throw n=d,r.arg;r.dispatchException(r.arg)}else"return"===r.method&&r.abrupt("return",r.arg);n=h;var s=l(t,e,r);if("normal"===s.type){if(n=r.done?d:p,s.arg===y)continue;return{value:s.arg,done:r.done}}"throw"===s.type&&(n=d,r.method="throw",r.arg=s.arg)}}}(t,r,i),a}function l(t,e,r){try{return{type:"normal",arg:t.call(e,r)}}catch(t){return{type:"throw",arg:t}}}t.wrap=u;var f="suspendedStart",p="suspendedYield",h="executing",d="completed",y={};function v(){}function m(){}function b(){}var g={};s(g,a,(function(){return this}));var w=Object.getPrototypeOf,x=w&&w(w(S([])));x&&x!==r&&n.call(x,a)&&(g=x);var k=b.prototype=v.prototype=Object.create(g);function L(t){["next","throw","return"].forEach((function(e){s(t,e,(function(t){return this._invoke(e,t)}))}))}function C(t,e){function r(o,a,i,c){var s=l(t[o],t,a);if("throw"!==s.type){var u=s.arg,f=u.value;return f&&"object"==typeof f&&n.call(f,"__await")?e.resolve(f.__await).then((function(t){r("next",t,i,c)}),(function(t){r("throw",t,i,c)})):e.resolve(f).then((function(t){u.value=t,i(u)}),(function(t){return r("throw",t,i,c)}))}c(s.arg)}var o;this._invoke=function(t,n){function a(){return new e((function(e,o){r(t,n,e,o)}))}return o=o?o.then(a,a):a()}}function E(t,r){var n=t.iterator[r.method];if(n===e){if(r.delegate=null,"throw"===r.method){if(t.iterator.return&&(r.method="return",r.arg=e,E(t,r),"throw"===r.method))return y;r.method="throw",r.arg=new TypeError("The iterator does not provide a 'throw' method")}return y}var o=l(n,t.iterator,r.arg);if("throw"===o.type)return r.method="throw",r.arg=o.arg,r.delegate=null,y;var a=o.arg;return a?a.done?(r[t.resultName]=a.value,r.next=t.nextLoc,"return"!==r.method&&(r.method="next",r.arg=e),r.delegate=null,y):a:(r.method="throw",r.arg=new TypeError("iterator result is not an object"),r.delegate=null,y)}function T(t){var e={tryLoc:t[0]};1 in t&&(e.catchLoc=t[1]),2 in t&&(e.finallyLoc=t[2],e.afterLoc=t[3]),this.tryEntries.push(e)}function j(t){var e=t.completion||{};e.type="normal",delete e.arg,t.completion=e}function O(t){this.tryEntries=[{tryLoc:"root"}],t.forEach(T,this),this.reset(!0)}function S(t){if(t){var r=t[a];if(r)return r.call(t);if("function"==typeof t.next)return t;if(!isNaN(t.length)){var o=-1,i=function r(){for(;++o<t.length;)if(n.call(t,o))return r.value=t[o],r.done=!1,r;return r.value=e,r.done=!0,r};return i.next=i}}return{next:$}}function $(){return{value:e,done:!0}}return m.prototype=b,s(k,"constructor",b),s(b,"constructor",m),m.displayName=s(b,c,"GeneratorFunction"),t.isGeneratorFunction=function(t){var e="function"==typeof t&&t.constructor;return!!e&&(e===m||"GeneratorFunction"===(e.displayName||e.name))},t.mark=function(t){return Object.setPrototypeOf?Object.setPrototypeOf(t,b):(t.__proto__=b,s(t,c,"GeneratorFunction")),t.prototype=Object.create(k),t},t.awrap=function(t){return{__await:t}},L(C.prototype),s(C.prototype,i,(function(){return this})),t.AsyncIterator=C,t.async=function(e,r,n,o,a){void 0===a&&(a=Promise);var i=new C(u(e,r,n,o),a);return t.isGeneratorFunction(r)?i:i.next().then((function(t){return t.done?t.value:i.next()}))},L(k),s(k,c,"Generator"),s(k,a,(function(){return this})),s(k,"toString",(function(){return"[object Generator]"})),t.keys=function(t){var e=[];for(var r in t)e.push(r);return e.reverse(),function r(){for(;e.length;){var n=e.pop();if(n in t)return r.value=n,r.done=!1,r}return r.done=!0,r}},t.values=S,O.prototype={constructor:O,reset:function(t){if(this.prev=0,this.next=0,this.sent=this._sent=e,this.done=!1,this.delegate=null,this.method="next",this.arg=e,this.tryEntries.forEach(j),!t)for(var r in this)"t"===r.charAt(0)&&n.call(this,r)&&!isNaN(+r.slice(1))&&(this[r]=e)},stop:function(){this.done=!0;var t=this.tryEntries[0].completion;if("throw"===t.type)throw t.arg;return this.rval},dispatchException:function(t){if(this.done)throw t;var r=this;function o(n,o){return c.type="throw",c.arg=t,r.next=n,o&&(r.method="next",r.arg=e),!!o}for(var a=this.tryEntries.length-1;a>=0;--a){var i=this.tryEntries[a],c=i.completion;if("root"===i.tryLoc)return o("end");if(i.tryLoc<=this.prev){var s=n.call(i,"catchLoc"),u=n.call(i,"finallyLoc");if(s&&u){if(this.prev<i.catchLoc)return o(i.catchLoc,!0);if(this.prev<i.finallyLoc)return o(i.finallyLoc)}else if(s){if(this.prev<i.catchLoc)return o(i.catchLoc,!0)}else{if(!u)throw new Error("try statement without catch or finally");if(this.prev<i.finallyLoc)return o(i.finallyLoc)}}}},abrupt:function(t,e){for(var r=this.tryEntries.length-1;r>=0;--r){var o=this.tryEntries[r];if(o.tryLoc<=this.prev&&n.call(o,"finallyLoc")&&this.prev<o.finallyLoc){var a=o;break}}a&&("break"===t||"continue"===t)&&a.tryLoc<=e&&e<=a.finallyLoc&&(a=null);var i=a?a.completion:{};return i.type=t,i.arg=e,a?(this.method="next",this.next=a.finallyLoc,y):this.complete(i)},complete:function(t,e){if("throw"===t.type)throw t.arg;return"break"===t.type||"continue"===t.type?this.next=t.arg:"return"===t.type?(this.rval=this.arg=t.arg,this.method="return",this.next="end"):"normal"===t.type&&e&&(this.next=e),y},finish:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.finallyLoc===t)return this.complete(r.completion,r.afterLoc),j(r),y}},catch:function(t){for(var e=this.tryEntries.length-1;e>=0;--e){var r=this.tryEntries[e];if(r.tryLoc===t){var n=r.completion;if("throw"===n.type){var o=n.arg;j(r)}return o}}throw new Error("illegal catch attempt")},delegateYield:function(t,r,n){return this.delegate={iterator:S(t),resultName:r,nextLoc:n},"next"===this.method&&(this.arg=e),y}},t}(t.exports);try{regeneratorRuntime=e}catch(t){"object"==typeof globalThis?globalThis.regeneratorRuntime=e:Function("r","regeneratorRuntime = r")(e)}}},e={};function r(n){var o=e[n];if(void 0!==o)return o.exports;var a=e[n]={exports:{}};return t[n].call(a.exports,a,a.exports,r),a.exports}r.n=t=>{var e=t&&t.__esModule?()=>t.default:()=>t;return r.d(e,{a:e}),e},r.d=(t,e)=>{for(var n in e)r.o(e,n)&&!r.o(t,n)&&Object.defineProperty(t,n,{enumerable:!0,get:e[n]})},r.o=(t,e)=>Object.prototype.hasOwnProperty.call(t,e),(()=>{"use strict";var t=r(7757),e=r.n(t),n=r(2085),o=r.n(n),a=function(t,e){e?$(t).addClass("bg-opacity-75 cursor-default").attr("disabled",!0):$(t).removeClass("bg-opacity-75 cursor-default").attr("disabled",!1)};function i(t,e,r,n,o,a,i){try{var c=t[a](i),s=c.value}catch(t){return void r(t)}c.done?e(s):Promise.resolve(s).then(n,o)}$(document).ajaxComplete(function(){var t,r=(t=e().mark((function t(r,n,a){return e().wrap((function(t){for(;;)switch(t.prev=t.next){case 0:o().show({text:n.responseJSON.message,actionText:"Tutup",duration:2e3,pos:"bottom-center"});case 1:case"end":return t.stop()}}),t)})),function(){var e=this,r=arguments;return new Promise((function(n,o){var a=t.apply(e,r);function c(t){i(a,n,o,c,s,"next",t)}function s(t){i(a,n,o,c,s,"throw",t)}c(void 0)}))});return function(t,e,n){return r.apply(this,arguments)}}()),a('#request-reset-password-form button[type="submit"]',!0),$("#request-reset-password-form input").on("input",(function(){var t=!0;$("#request-reset-password-form input").each((function(){t=""===$(this).val()})),a('#request-reset-password-form button[type="submit"]',!!t)})),$("#request-reset-password-form").on("submit",(function(t){var e=this;t.preventDefault(),$.ajax({url:"/auth/reset-password/request",type:"POST",data:new FormData($(this)[0]),success:function(){$(e).trigger("reset")}})})),a('#reset-password-form button[type="submit"]',!0),$('#reset-password-form input[type="password"]').on("input",(function(){var t=!0;$('#reset-password-form input[type="password"]').each((function(){t=""===$(this).val()})),a('#reset-password-form button[type="submit"]',!!t)})),$("#reset-password-form").on("submit",(function(t){var e=this;t.preventDefault(),$.ajax({url:"/auth/reset-password/reset",type:"POST",data:new FormData($(this)[0]),success:function(){$(e).trigger("reset"),window.location.replace("/")}})}))})()})();