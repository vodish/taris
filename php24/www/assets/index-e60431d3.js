var fl=Object.defineProperty;var ul=(t,e,l)=>e in t?fl(t,e,{enumerable:!0,configurable:!0,writable:!0,value:l}):t[e]=l;var ie=(t,e,l)=>(ul(t,typeof e!="symbol"?e+"":e,l),l);const xe=Object.freeze(Object.defineProperty({__proto__:null,get accessText(){return ft},get api(){return Ee},get apierr(){return Ge},get get(){return xt},get href(){return Se},get isProject(){return mt},get lineHtml(){return Ue},get lineText(){return st},get logList(){return rl},get packBc(){return dt},get packMenu(){return Pe},get packStart(){return se},get packTitle(){return pt},get packTree(){return Re},get parse(){return _t},get pref(){return z},get treeText(){return rt},get url(){return Ne},get userList(){return ze}},Symbol.toStringTag,{value:"Module"}));(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const i of document.querySelectorAll('link[rel="modulepreload"]'))n(i);new MutationObserver(i=>{for(const s of i)if(s.type==="childList")for(const r of s.addedNodes)r.tagName==="LINK"&&r.rel==="modulepreload"&&n(r)}).observe(document,{childList:!0,subtree:!0});function l(i){const s={};return i.integrity&&(s.integrity=i.integrity),i.referrerPolicy&&(s.referrerPolicy=i.referrerPolicy),i.crossOrigin==="use-credentials"?s.credentials="include":i.crossOrigin==="anonymous"?s.credentials="omit":s.credentials="same-origin",s}function n(i){if(i.ep)return;i.ep=!0;const s=l(i);fetch(i.href,s)}})();function N(){}function Qt(t){return t()}function Et(){return Object.create(null)}function re(t){t.forEach(Qt)}function ut(t){return typeof t=="function"}function Q(t,e){return t!=t?e==e:t!==e||t&&typeof t=="object"||typeof t=="function"}function cl(t){return Object.keys(t).length===0}function Zt(t,...e){if(t==null){for(const n of e)n(void 0);return N}const l=t.subscribe(...e);return l.unsubscribe?()=>l.unsubscribe():l}function xt(t){let e;return Zt(t,l=>e=l)(),e}function M(t,e,l){t.$$.on_destroy.push(Zt(e,l))}const ol=typeof window<"u"?window:typeof globalThis<"u"?globalThis:global;function p(t,e){t.appendChild(e)}function b(t,e,l){t.insertBefore(e,l||null)}function g(t){t.parentNode&&t.parentNode.removeChild(t)}function Te(t,e){for(let l=0;l<t.length;l+=1)t[l]&&t[l].d(e)}function h(t){return document.createElement(t)}function al(t){return document.createElementNS("http://www.w3.org/2000/svg",t)}function O(t){return document.createTextNode(t)}function w(){return O(" ")}function Me(){return O("")}function C(t,e,l,n){return t.addEventListener(e,l,n),()=>t.removeEventListener(e,l,n)}function el(t){return function(e){return e.preventDefault(),t.call(this,e)}}function a(t,e,l){l==null?t.removeAttribute(e):t.getAttribute(e)!==l&&t.setAttribute(e,l)}function _l(t){return Array.from(t.childNodes)}function W(t,e){e=""+e,t.data!==e&&(t.data=e)}function Ve(t,e){t.value=e??""}function qe(t,e,l,n){l==null?t.style.removeProperty(e):t.style.setProperty(e,l,n?"important":"")}class ml{constructor(e=!1){ie(this,"is_svg",!1);ie(this,"e");ie(this,"n");ie(this,"t");ie(this,"a");this.is_svg=e,this.e=this.n=null}c(e){this.h(e)}m(e,l,n=null){this.e||(this.is_svg?this.e=al(l.nodeName):this.e=h(l.nodeType===11?"TEMPLATE":l.nodeName),this.t=l.tagName!=="TEMPLATE"?l:l.content,this.c(e)),this.i(n)}h(e){this.e.innerHTML=e,this.n=Array.from(this.e.nodeName==="TEMPLATE"?this.e.content.childNodes:this.e.childNodes)}i(e){for(let l=0;l<this.n.length;l+=1)b(this.t,this.n[l],e)}p(e){this.d(),this.h(e),this.i(this.a)}d(){this.n.forEach(g)}}let He;function Ae(t){He=t}function tl(){if(!He)throw new Error("Function called outside component initialization");return He}function ct(t){tl().$$.on_mount.push(t)}function dl(t){tl().$$.on_destroy.push(t)}const we=[],De=[];let Le=[];const tt=[],pl=Promise.resolve();let lt=!1;function hl(){lt||(lt=!0,pl.then(ll))}function nt(t){Le.push(t)}function ot(t){tt.push(t)}const et=new Set;let ve=0;function ll(){if(ve!==0)return;const t=He;do{try{for(;ve<we.length;){const e=we[ve];ve++,Ae(e),gl(e.$$)}}catch(e){throw we.length=0,ve=0,e}for(Ae(null),we.length=0,ve=0;De.length;)De.pop()();for(let e=0;e<Le.length;e+=1){const l=Le[e];et.has(l)||(et.add(l),l())}Le.length=0}while(we.length);for(;tt.length;)tt.pop()();lt=!1,et.clear(),Ae(t)}function gl(t){if(t.fragment!==null){t.update(),re(t.before_update);const e=t.dirty;t.dirty=[-1],t.fragment&&t.fragment.p(t.ctx,e),t.after_update.forEach(nt)}}function bl(t){const e=[],l=[];Le.forEach(n=>t.indexOf(n)===-1?e.push(n):l.push(n)),l.forEach(n=>n()),Le=e}const Fe=new Set;let _e;function me(){_e={r:0,c:[],p:_e}}function de(){_e.r||re(_e.c),_e=_e.p}function L(t,e){t&&t.i&&(Fe.delete(t),t.i(e))}function E(t,e,l,n){if(t&&t.o){if(Fe.has(t))return;Fe.add(t),_e.c.push(()=>{Fe.delete(t),n&&(l&&t.d(1),n())}),t.o(e)}else n&&n()}function Y(t){return(t==null?void 0:t.length)!==void 0?t:Array.from(t)}function at(t,e,l){const n=t.$$.props[e];n!==void 0&&(t.$$.bound[n]=l,l(t.$$.ctx[n]))}function F(t){t&&t.c()}function I(t,e,l){const{fragment:n,after_update:i}=t.$$;n&&n.m(e,l),nt(()=>{const s=t.$$.on_mount.map(Qt).filter(ut);t.$$.on_destroy?t.$$.on_destroy.push(...s):re(s),t.$$.on_mount=[]}),i.forEach(nt)}function B(t,e){const l=t.$$;l.fragment!==null&&(bl(l.after_update),re(l.on_destroy),l.fragment&&l.fragment.d(e),l.on_destroy=l.fragment=null,l.ctx=[])}function kl(t,e){t.$$.dirty[0]===-1&&(we.push(t),hl(),t.$$.dirty.fill(0)),t.$$.dirty[e/31|0]|=1<<e%31}function Z(t,e,l,n,i,s,r,f=[-1]){const u=He;Ae(t);const c=t.$$={fragment:null,ctx:[],props:s,update:N,not_equal:i,bound:Et(),on_mount:[],on_destroy:[],on_disconnect:[],before_update:[],after_update:[],context:new Map(e.context||(u?u.$$.context:[])),callbacks:Et(),dirty:f,skip_bound:!1,root:e.target||u.$$.root};r&&r(c.root);let o=!1;if(c.ctx=l?l(t,e.props||{},(m,_,...$)=>{const v=$.length?$[0]:_;return c.ctx&&i(c.ctx[m],c.ctx[m]=v)&&(!c.skip_bound&&c.bound[m]&&c.bound[m](v),o&&kl(t,m)),_}):[],c.update(),o=!0,re(c.before_update),c.fragment=n?n(c.ctx):!1,e.target){if(e.hydrate){const m=_l(e.target);c.fragment&&c.fragment.l(m),m.forEach(g)}else c.fragment&&c.fragment.c();e.intro&&L(t.$$.fragment),I(t,e.target,e.anchor),ll()}Ae(u)}class x{constructor(){ie(this,"$$");ie(this,"$$set")}$destroy(){B(this,1),this.$destroy=N}$on(e,l){if(!ut(l))return N;const n=this.$$.callbacks[e]||(this.$$.callbacks[e]=[]);return n.push(l),()=>{const i=n.indexOf(l);i!==-1&&n.splice(i,1)}}$set(e){this.$$set&&!cl(e)&&(this.$$.skip_bound=!0,this.$$set(e),this.$$.skip_bound=!1)}}const vl="4";typeof window<"u"&&(window.__svelte||(window.__svelte={v:new Set})).v.add(vl);const $e=[];function U(t,e=N){let l;const n=new Set;function i(f){if(Q(t,f)&&(t=f,l)){const u=!$e.length;for(const c of n)c[1](),$e.push(c,t);if(u){for(let c=0;c<$e.length;c+=2)$e[c][0]($e[c+1]);$e.length=0}}}function s(f){i(f(t))}function r(f,u=N){const c=[f,u];return n.add(c),n.size===1&&(l=e(i,s)||N),f(t),()=>{n.delete(c),n.size===0&&l&&(l(),l=null)}}return{set:i,update:s,subscribe:r}}let it=document.getElementById("rtoken"),St=JSON.parse(it.innerText);it.parentNode.removeChild(it);function nl(){let t=_t(window.location.pathname);Ne.set(t),t.level[0]&&t.level[0]!=xt(se)&&z(window.location.pathname)}function Se(t){typeof t=="object"&&t.srcElement.tagName=="A"&&(t.preventDefault(),t=t.srcElement.pathname),window.location.pathname!=t&&(window.history.pushState({},"",t),Ne.set(_t(t)))}function z(t,e,l){typeof t=="object"&&t.srcElement.tagName=="A"&&(t.preventDefault(),t=t.srcElement.pathname);let n={href:t};for(let i in e||{})n[i]=e[i];Ee(n,i=>{for(let s in i)xe[s]&&xe[s].set&&xe[s].set(i[s]);Se(i.href||t),typeof l=="function"&&l(i)})}function _t(t){let e=t=="/"?[]:t.substring(1).split("/"),l=[];return e.map((n,i)=>l[i]=`${i?l[i-1]:""}/${n}`),{path:t,level:e,dir:l}}function Ee(t,e){t.rtoken=St;let l=new FormData;il(l,t);let n=new XMLHttpRequest;n.open("POST","/api"),n.send(l),n.onload=()=>{let i={};try{i=JSON.parse(n.response)}catch{Ge.set(n.response)}i.rtoken&&(St=i.rtoken,Ge.set("")),e(i)}}function il(t,e,l){e&&typeof e=="object"&&!(e instanceof Date)&&!(e instanceof File)&&!(e instanceof Blob)?Object.keys(e).forEach(n=>il(t,e[n],l?`${l}[${n}]`:n)):t.append(l,e??"")}let Ne=U(),Ge=U(""),ze=U(!1),se=U(!1),mt=U(!1),dt=U([]),Re=U([]),Pe=U({name:""}),pt=U(""),rt=U(""),Ue=U(""),st=U(""),ft=U(""),rl=U([]);nl();window.addEventListener("popstate",nl);const{document:$l}=ol;function Mt(t,e,l){const n=t.slice();return n[12]=e[l],n}function wl(t){let e,l,n,i,s,r,f,u,c,o,m,_=t[4]!=""&&Nt(t);function $(y,P){return y[3]>0?Ll:Tl}let v=$(t),k=v(t);return{c(){e=h("div"),l=h("div"),n=h("div"),n.textContent="Код из письма",i=w(),_&&_.c(),s=w(),r=h("input"),u=w(),k.c(),c=Me(),a(r,"class",f="code "+(t[4]==""?"":"err")),a(r,"maxlength","4"),a(r,"autocomplete","off"),a(r,"id","code"),a(e,"class","login")},m(y,P){b(y,e,P),p(e,l),p(l,n),p(l,i),_&&_.m(l,null),p(e,s),p(e,r),Ve(r,t[1]),b(y,u,P),k.m(y,P),b(y,c,P),o||(m=[C(r,"input",t[9]),C(r,"keyup",t[7])],o=!0)},p(y,P){y[4]!=""?_?_.p(y,P):(_=Nt(y),_.c(),_.m(l,null)):_&&(_.d(1),_=null),P&16&&f!==(f="code "+(y[4]==""?"":"err"))&&a(r,"class",f),P&2&&r.value!==y[1]&&Ve(r,y[1]),v===(v=$(y))&&k?k.p(y,P):(k.d(1),k=v(y),k&&(k.c(),k.m(c.parentNode,c)))},d(y){y&&(g(e),g(u),g(c)),_&&_.d(),k.d(y),o=!1,re(m)}}}function yl(t){let e,l,n,i,s,r;return{c(){e=h("form"),l=h("input"),n=w(),i=h("button"),i.textContent="Taris",a(l,"class","email"),a(l,"type","email"),a(l,"name","email"),l.required=!0,a(l,"placeholder","Емеил для входа"),a(l,"title","Емеил для входа"),a(l,"id","email"),a(i,"class","send"),a(e,"class","login")},m(f,u){b(f,e,u),p(e,l),Ve(l,t[0]),p(e,n),p(e,i),s||(r=[C(l,"input",t[8]),C(e,"submit",el(t[6]))],s=!0)},p(f,u){u&1&&l.value!==f[0]&&Ve(l,f[0])},d(f){f&&g(e),s=!1,re(r)}}}function Nt(t){let e,l;return{c(){e=h("div"),l=O(t[4]),a(e,"class","err")},m(n,i){b(n,e,i),p(e,l)},p(n,i){i&16&&W(l,n[4])},d(n){n&&g(e)}}}function Tl(t){let e,l,n,i;return{c(){e=h("div"),l=h("a"),l.textContent="Повторить вход",a(l,"href","/"),a(l,"class","back"),a(e,"class","note")},m(s,r){b(s,e,r),p(e,l),n||(i=C(l,"click",el(t[10])),n=!0)},p:N,d(s){s&&g(e),n=!1,i()}}}function Ll(t){let e,l,n,i,s;return{c(){e=h("div"),l=O("Повторить отправку через "),n=h("span"),i=O(t[3]),s=O(" сек"),a(n,"class","delay"),a(e,"class","note wait")},m(r,f){b(r,e,f),p(e,l),p(e,n),p(n,i),p(e,s)},p(r,f){f&8&&W(i,r[3])},d(r){r&&g(e)}}}function Pt(t){let e,l=Y(t[5]),n=[];for(let i=0;i<l.length;i+=1)n[i]=Ct(Mt(t,l,i));return{c(){e=h("div");for(let i=0;i<n.length;i+=1)n[i].c();a(e,"class","userlist")},m(i,s){b(i,e,s);for(let r=0;r<n.length;r+=1)n[r]&&n[r].m(e,null)},p(i,s){if(s&32){l=Y(i[5]);let r;for(r=0;r<l.length;r+=1){const f=Mt(i,l,r);n[r]?n[r].p(f,s):(n[r]=Ct(f),n[r].c(),n[r].m(e,null))}for(;r<n.length;r+=1)n[r].d(1);n.length=l.length}},d(i){i&&g(e),Te(n,i)}}}function Ct(t){let e,l=t[12].email+"",n,i,s,r;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[12].start)},m(f,u){b(f,e,u),p(e,n),s||(r=C(e,"click",z),s=!0)},p(f,u){u&32&&l!==(l=f[12].email+"")&&W(n,l),u&32&&i!==(i="/"+f[12].start)&&a(e,"href",i)},d(f){f&&g(e),s=!1,r()}}}function El(t){let e,l,n,i,s,r,f,u,c,o;function m(k,y){if(k[2]=="email")return yl;if(k[2]=="code")return wl}let _=m(t),$=_&&_(t),v=t[5]&&t[5].length&&Pt(t);return{c(){e=w(),l=h("div"),n=h("div"),i=h("div"),$&&$.c(),s=w(),v&&v.c(),r=w(),f=h("h3"),u=h("a"),u.textContent="Что здесь происходит?",$l.title="Taris - система работы с текстовыми файлами",a(i,"class","auth"),a(u,"href","/151"),a(f,"class","about"),a(l,"class","main1")},m(k,y){b(k,e,y),b(k,l,y),p(l,n),p(n,i),$&&$.m(i,null),p(n,s),v&&v.m(n,null),p(l,r),p(l,f),p(f,u),c||(o=C(u,"click",z),c=!0)},p(k,[y]){_===(_=m(k))&&$?$.p(k,y):($&&$.d(1),$=_&&_(k),$&&($.c(),$.m(i,null))),k[5]&&k[5].length?v?v.p(k,y):(v=Pt(k),v.c(),v.m(n,null)):v&&(v.d(1),v=null)},i:N,o:N,d(k){k&&(g(e),g(l)),$&&$.d(),v&&v.d(),c=!1,o()}}}function Sl(t,e,l){let n;M(t,ze,k=>l(5,n=k));let i="",s="",r="email",f,u="",c=!1;ct(()=>{document.getElementById("email").focus(),n==!1&&Ee({userList:1,wait:["userList"]},k=>ze.set(k.userList))});function o(){l(2,r="code"),l(1,s=""),l(4,u=""),l(3,f=60),setTimeout(()=>{document.getElementById("code").focus()},0);let k=setInterval(()=>{l(3,f--,f),!(f>0)&&clearInterval(k)},1e3);Ee({userGetCode:i},y=>{y.ok!="ok"&&l(4,u="")})}function m(){l(1,s=s.replace(/\D+/g,"")),s.length==4&&c===!1?(c=!0,Ee({userCheckCode:i,code:s},k=>{if(k.err)return l(4,u=k.err);k.packStart&&(ze.set(k.userList),se.set(k.packStart),mt.set(k.isProject),dt.set(k.packBc),Re.set(k.packTree),Pe.set(k.packMenu),pt.set(k.packTitle),Ue.set(k.lineHtml),Se(k.href))})):s.length<4&&(c=!1,l(4,u=""))}function _(){i=this.value,l(0,i)}function $(){s=this.value,l(1,s)}return[i,s,r,f,u,n,o,m,_,$,()=>l(2,r="email")]}class Ml extends x{constructor(e){super(),Z(this,e,Sl,El,Q,{})}}function Nl(t){let e;return{c(){e=h("div"),a(e,"id","ace9"),a(e,"class","ace")},m(l,n){b(l,e,n)},p:N,i:N,o:N,d(l){l&&g(e)}}}function Pl(t,e,l){let{value:n=""}=e,i;return ct(()=>{i=ace.edit("ace9"),i.session.setMode("ace/mode/html"),i.setOptions({minLines:10,fontSize:"14px",fontFamily:"monospace",showPrintMargin:!1,showGutter:!0,useWorker:!1,maxLines:1111,wrap:!0}),i.setValue(n,1),i.on("change",()=>l(0,n=i.getValue())),i.focus();let s=sessionStorage.getItem("gotoLine");i.gotoLine(s||1)}),dl(()=>{var s=i.getSelectionRange().start.row;sessionStorage.setItem("gotoLine",s+1)}),t.$$set=s=>{"value"in s&&l(0,n=s.value)},[n]}class Cl extends x{constructor(e){super(),Z(this,e,Pl,Nl,Q,{value:0})}}function Ot(t){let e,l,n;function i(r){t[3](r)}let s={};return t[1]!==void 0&&(s.value=t[1]),e=new Cl({props:s}),De.push(()=>at(e,"value",i)),{c(){F(e.$$.fragment)},m(r,f){I(e,r,f),n=!0},p(r,f){const u={};!l&&f&2&&(l=!0,u.value=r[1],ot(()=>l=!1)),e.$set(u)},i(r){n||(L(e.$$.fragment,r),n=!0)},o(r){E(e.$$.fragment,r),n=!1},d(r){B(e,r)}}}function Ol(t){let e,l,n,i,s,r,f,u=t[0]&&Ot(t);return{c(){u&&u.c(),e=w(),l=h("br"),n=w(),i=h("button"),i.textContent="Сохранить",a(i,"id","ctrl-s")},m(c,o){u&&u.m(c,o),b(c,e,o),b(c,l,o),b(c,n,o),b(c,i,o),s=!0,r||(f=C(i,"click",t[2]),r=!0)},p(c,[o]){c[0]?u?(u.p(c,o),o&1&&L(u,1)):(u=Ot(c),u.c(),L(u,1),u.m(e.parentNode,e)):u&&(me(),E(u,1,1,()=>{u=null}),de())},i(c){s||(L(u),s=!0)},o(c){E(u),s=!1},d(c){c&&(g(e),g(l),g(n),g(i)),u&&u.d(c),r=!1,f()}}}function jl(t,e,l){let n,i;M(t,se,f=>l(0,n=f)),M(t,st,f=>l(1,i=f));function s(){Ee({pack:n,line:i,wait:["lineHtml","packMenu"]},f=>{Ue.set(f.lineHtml),Pe.set(f.packMenu),Se(`/${n}`)})}document.onkeydown=f=>{["KeyS","Enter"].includes(f.code)&&(f.ctrlKey||f.metaKey)&&(f.preventDefault(),s())};function r(f){i=f,st.set(i)}return[n,i,s,r]}class Al extends x{constructor(e){super(),Z(this,e,jl,Ol,Q,{})}}function jt(t,e,l){const n=t.slice();return n[4]=e[l],n}function At(t){let e,l=t[4].name+"",n,i,s,r,f;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[4].id),a(e,"class",s=t[4]._prj)},m(u,c){b(u,e,c),p(e,n),r||(f=C(e,"click",z),r=!0)},p(u,c){c&1&&l!==(l=u[4].name+"")&&W(n,l),c&1&&i!==(i="/"+u[4].id)&&a(e,"href",i),c&1&&s!==(s=u[4]._prj)&&a(e,"class",s)},d(u){u&&g(e),r=!1,f()}}}function Ht(t){let e,l,n,i=t[4].id&&At(t);return{c(){e=h("div"),i&&i.c(),l=w(),a(e,"class",n=t[4]._act+(t[4].id?"":"empty")),qe(e,"margin-left",t[4].space/2+"ch")},m(s,r){b(s,e,r),i&&i.m(e,null),p(e,l)},p(s,r){s[4].id?i?i.p(s,r):(i=At(s),i.c(),i.m(e,l)):i&&(i.d(1),i=null),r&1&&n!==(n=s[4]._act+(s[4].id?"":"empty"))&&a(e,"class",n),r&1&&qe(e,"margin-left",s[4].space/2+"ch")},d(s){s&&g(e),i&&i.d()}}}function Hl(t){let e,l,n,i,s=Y(t[0]),r=[];for(let f=0;f<s.length;f+=1)r[f]=Ht(jt(t,s,f));return{c(){e=h("div"),l=h("div");for(let f=0;f<r.length;f+=1)r[f].c();n=w(),i=h("div"),a(l,"class","tree"),a(i,"class","file"),a(e,"class","pro")},m(f,u){b(f,e,u),p(e,l);for(let c=0;c<r.length;c+=1)r[c]&&r[c].m(l,null);p(e,n),p(e,i),i.innerHTML=t[1]},p(f,[u]){if(u&1){s=Y(f[0]);let c;for(c=0;c<s.length;c+=1){const o=jt(f,s,c);r[c]?r[c].p(o,u):(r[c]=Ht(o),r[c].c(),r[c].m(l,null))}for(;c<r.length;c+=1)r[c].d(1);r.length=s.length}u&2&&(i.innerHTML=f[1])},i:N,o:N,d(f){f&&g(e),Te(r,f)}}}function Dl(t,e,l){let n,i,s,r;return M(t,se,f=>l(2,n=f)),M(t,Pe,f=>l(3,i=f)),M(t,Re,f=>l(0,s=f)),M(t,Ue,f=>l(1,r=f)),document.onkeydown=f=>{i.line!=null&&["KeyS","Enter"].includes(f.code)&&(f.ctrlKey||f.metaKey)&&(f.preventDefault(),z(`/${n}/line`))},[s,r]}class Il extends x{constructor(e){super(),Z(this,e,Dl,Hl,Q,{})}}function Bl(t){let e;return{c(){e=h("div"),a(e,"id","ace9"),a(e,"class","ace")},m(l,n){b(l,e,n)},p:N,i:N,o:N,d(l){l&&g(e)}}}function Kl(t,e,l){let{value:n=""}=e;return ct(()=>{let i=ace.edit("ace9");i.session.setMode("ace/mode/yaml"),i.setOptions({minLines:10,fontSize:"14px",fontFamily:"monospace",showPrintMargin:!1,showGutter:!0,useWorker:!1,maxLines:1111,wrap:!1}),i.setValue(n,1),i.on("change",()=>l(0,n=i.getValue())),i.focus()}),t.$$set=i=>{"value"in i&&l(0,n=i.value)},[n]}class sl extends x{constructor(e){super(),Z(this,e,Kl,Bl,Q,{value:0})}}function Dt(t){let e,l,n;function i(r){t[3](r)}let s={};return t[0]!==void 0&&(s.value=t[0]),e=new sl({props:s}),De.push(()=>at(e,"value",i)),{c(){F(e.$$.fragment)},m(r,f){I(e,r,f),n=!0},p(r,f){const u={};!l&&f&1&&(l=!0,u.value=r[0],ot(()=>l=!1)),e.$set(u)},i(r){n||(L(e.$$.fragment,r),n=!0)},o(r){E(e.$$.fragment,r),n=!1},d(r){B(e,r)}}}function Fl(t){let e,l,n,i,s,r,f,u=t[1]&&Dt(t);return{c(){u&&u.c(),e=w(),l=h("br"),n=w(),i=h("button"),i.textContent="Сохранить",a(i,"id","ctrl-s")},m(c,o){u&&u.m(c,o),b(c,e,o),b(c,l,o),b(c,n,o),b(c,i,o),s=!0,r||(f=C(i,"click",t[2]),r=!0)},p(c,[o]){c[1]?u?(u.p(c,o),o&2&&L(u,1)):(u=Dt(c),u.c(),L(u,1),u.m(e.parentNode,e)):u&&(me(),E(u,1,1,()=>{u=null}),de())},i(c){s||(L(u),s=!0)},o(c){E(u),s=!1},d(c){c&&(g(e),g(l),g(n),g(i)),u&&u.d(c),r=!1,f()}}}function zl(t,e,l){let n,i;M(t,rt,f=>l(0,n=f)),M(t,se,f=>l(1,i=f));function s(){z(`/${i}`,{tree:n})}document.onkeydown=f=>{["KeyS","Enter"].includes(f.code)&&(f.ctrlKey||f.metaKey)&&(f.preventDefault(),s())};function r(f){n=f,rt.set(n)}return[n,i,s,r]}class Vl extends x{constructor(e){super(),Z(this,e,zl,Fl,Q,{})}}function It(t){let e,l,n;function i(r){t[4](r)}let s={};return t[1]!==void 0&&(s.value=t[1]),e=new sl({props:s}),De.push(()=>at(e,"value",i)),{c(){F(e.$$.fragment)},m(r,f){I(e,r,f),n=!0},p(r,f){const u={};!l&&f&2&&(l=!0,u.value=r[1],ot(()=>l=!1)),e.$set(u)},i(r){n||(L(e.$$.fragment,r),n=!0)},o(r){E(e.$$.fragment,r),n=!1},d(r){B(e,r)}}}function ql(t){let e,l,n,i,s,r,f,u,c=t[2]&&It(t);return{c(){c&&c.c(),e=w(),l=h("br"),n=w(),i=h("button"),s=O("Сохранить"),a(i,"id","ctrl-s"),a(i,"class",t[0])},m(o,m){c&&c.m(o,m),b(o,e,m),b(o,l,m),b(o,n,m),b(o,i,m),p(i,s),r=!0,f||(u=C(i,"click",t[3]),f=!0)},p(o,[m]){o[2]?c?(c.p(o,m),m&4&&L(c,1)):(c=It(o),c.c(),L(c,1),c.m(e.parentNode,e)):c&&(me(),E(c,1,1,()=>{c=null}),de()),(!r||m&1)&&a(i,"class",o[0])},i(o){r||(L(c),r=!0)},o(o){E(c),r=!1},d(o){o&&(g(e),g(l),g(n),g(i)),c&&c.d(o),f=!1,u()}}}function Gl(t,e,l){let n,i;M(t,ft,u=>l(1,n=u)),M(t,se,u=>l(2,i=u));let s="";function r(){z(`/${i}/access`,{access:n,wait:["accessText"]}),l(0,s="active"),setTimeout(()=>l(0,s=""),500)}document.onkeydown=u=>{["KeyS","Enter"].includes(u.code)&&(u.ctrlKey||u.metaKey)&&(u.preventDefault(),r())};function f(u){n=u,ft.set(n)}return[s,n,i,r,f]}class Rl extends x{constructor(e){super(),Z(this,e,Gl,ql,Q,{})}}function Bt(t,e,l){const n=t.slice();return n[2]=e[l],n}function Kt(t){let e,l,n=t[2].created+"",i,s,r,f=t[2].author_email+"",u,c,o,m=t[2].target_name+"",_,$,v,k,y=t[2].up_name+"",P,X,le,pe,Ce;return{c(){e=h("tr"),l=h("td"),i=O(n),s=w(),r=h("td"),u=O(f),c=w(),o=h("td"),_=O(m),$=w(),v=h("td"),k=h("a"),P=O(y),le=w(),a(k,"href",X="/"+t[1]+"/logUp/"+t[2].id)},m(K,ee){b(K,e,ee),p(e,l),p(l,i),p(e,s),p(e,r),p(r,u),p(e,c),p(e,o),p(o,_),p(e,$),p(e,v),p(v,k),p(k,P),p(e,le),pe||(Ce=C(k,"click",z),pe=!0)},p(K,ee){ee&1&&n!==(n=K[2].created+"")&&W(i,n),ee&1&&f!==(f=K[2].author_email+"")&&W(u,f),ee&1&&m!==(m=K[2].target_name+"")&&W(_,m),ee&1&&y!==(y=K[2].up_name+"")&&W(P,y),ee&3&&X!==(X="/"+K[1]+"/logUp/"+K[2].id)&&a(k,"href",X)},d(K){K&&g(e),pe=!1,Ce()}}}function Ul(t){let e,l,n,i,s,r,f,u=Y(t[0]),c=[];for(let o=0;o<u.length;o+=1)c[o]=Kt(Bt(t,u,o));return{c(){e=h("p"),e.textContent='Если вы пользуетесь только для себя, то у вас не возникнет вопроса из серии "чьи ручонки что-то изменили?"',l=w(),n=h("br"),i=w(),s=h("br"),r=w(),f=h("table");for(let o=0;o<c.length;o+=1)c[o].c();a(f,"class","loglist")},m(o,m){b(o,e,m),b(o,l,m),b(o,n,m),b(o,i,m),b(o,s,m),b(o,r,m),b(o,f,m);for(let _=0;_<c.length;_+=1)c[_]&&c[_].m(f,null)},p(o,[m]){if(m&3){u=Y(o[0]);let _;for(_=0;_<u.length;_+=1){const $=Bt(o,u,_);c[_]?c[_].p($,m):(c[_]=Kt($),c[_].c(),c[_].m(f,null))}for(;_<c.length;_+=1)c[_].d(1);c.length=u.length}},i:N,o:N,d(o){o&&(g(e),g(l),g(n),g(i),g(s),g(r),g(f)),Te(c,o)}}}function Jl(t,e,l){let n,i;return M(t,rl,s=>l(0,n=s)),M(t,se,s=>l(1,i=s)),[n,i]}class Wl extends x{constructor(e){super(),Z(this,e,Jl,Ul,Q,{})}}function Ft(t){let e;function l(s,r){return s[5]==s[0]?Yl:Xl}let n=l(t),i=n(t);return{c(){i.c(),e=Me()},m(s,r){i.m(s,r),b(s,e,r)},p(s,r){n===(n=l(s))&&i?i.p(s,r):(i.d(1),i=n(s),i&&(i.c(),i.m(e.parentNode,e)))},d(s){s&&g(e),i.d(s)}}}function Xl(t){let e,l=t[6][t[0]]+"",n,i,s;return{c(){e=h("a"),a(e,"href",t[1]),a(e,"class",n="a "+t[2]),a(e,"title",t[3])},m(r,f){b(r,e,f),e.innerHTML=l,i||(s=C(e,"click",function(){ut(t[4])&&t[4].apply(this,arguments)}),i=!0)},p(r,f){t=r,f&65&&l!==(l=t[6][t[0]]+"")&&(e.innerHTML=l),f&2&&a(e,"href",t[1]),f&4&&n!==(n="a "+t[2])&&a(e,"class",n),f&8&&a(e,"title",t[3])},d(r){r&&g(e),i=!1,s()}}}function Yl(t){let e,l=t[6][t[0]]+"",n;return{c(){e=h("span"),a(e,"class",n="a "+t[0]+" "+t[2]),a(e,"title",t[3])},m(i,s){b(i,e,s),e.innerHTML=l},p(i,s){s&65&&l!==(l=i[6][i[0]]+"")&&(e.innerHTML=l),s&5&&n!==(n="a "+i[0]+" "+i[2])&&a(e,"class",n),s&8&&a(e,"title",i[3])},d(i){i&&g(e)}}}function Ql(t){let e,l=t[0]in t[6]&&Ft(t);return{c(){l&&l.c(),e=Me()},m(n,i){l&&l.m(n,i),b(n,e,i)},p(n,[i]){n[0]in n[6]?l?l.p(n,i):(l=Ft(n),l.c(),l.m(e.parentNode,e)):l&&(l.d(1),l=null)},i:N,o:N,d(n){n&&g(e),l&&l.d(n)}}}function Zl(t,e,l){let n,i,s;M(t,Ne,m=>l(7,i=m)),M(t,Pe,m=>l(6,s=m));let{key:r}=e,{href:f}=e,{cls:u=""}=e,{title:c=""}=e,{click:o=z}=e;return t.$$set=m=>{"key"in m&&l(0,r=m.key),"href"in m&&l(1,f=m.href),"cls"in m&&l(2,u=m.cls),"title"in m&&l(3,c=m.title),"click"in m&&l(4,o=m.click)},t.$$.update=()=>{t.$$.dirty&128&&l(5,n=i.level[1]||"view")},[r,f,u,c,o,n,s,i]}class ye extends x{constructor(e){super(),Z(this,e,Zl,Ql,Q,{key:0,href:1,cls:2,title:3,click:4})}}function zt(t,e,l){const n=t.slice();return n[11]=e[l],n}function Vt(t,e,l){const n=t.slice();return n[11]=e[l],n}function qt(t,e,l){const n=t.slice();return n[11]=e[l],n}function Gt(t){let e,l,n,i,s=t[11].name+"",r,f,u,c,o;return{c(){e=h("i"),n=w(),i=h("a"),r=O(s),a(e,"class",l="sep "+t[11]._pub+" "+t[11]._cur),a(i,"href",f="/"+t[11].id),a(i,"class",u=t[11]._cur)},m(m,_){b(m,e,_),b(m,n,_),b(m,i,_),p(i,r),c||(o=C(i,"click",z),c=!0)},p(m,_){_&2&&l!==(l="sep "+m[11]._pub+" "+m[11]._cur)&&a(e,"class",l),_&2&&s!==(s=m[11].name+"")&&W(r,s),_&2&&f!==(f="/"+m[11].id)&&a(i,"href",f),_&2&&u!==(u=m[11]._cur)&&a(i,"class",u)},d(m){m&&(g(e),g(n),g(i)),c=!1,o()}}}function Rt(t){let e,l=t[11].name+"",n,i,s,r,f;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[11].id),a(e,"class",s=t[11]._cur+" "+t[11]._pub+" nav")},m(u,c){b(u,e,c),p(e,n),r||(f=C(e,"click",z),r=!0)},p(u,c){c&2&&l!==(l=u[11].name+"")&&W(n,l),c&2&&i!==(i="/"+u[11].id)&&a(e,"href",i),c&2&&s!==(s=u[11]._cur+" "+u[11]._pub+" nav")&&a(e,"class",s)},d(u){u&&g(e),r=!1,f()}}}function xl(t){let e;return{c(){e=h("div"),a(e,"class","empty")},m(l,n){b(l,e,n)},p:N,d(l){l&&g(e)}}}function en(t){let e,l=t[11].name+"",n,i,s,r,f;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[11].id),a(e,"class",s=t[11]._prj+" "+t[11]._act+(t[11].id?"":"empty")),qe(e,"padding-left",t[11].space/2+"ch")},m(u,c){b(u,e,c),p(e,n),r||(f=C(e,"click",z),r=!0)},p(u,c){c&256&&l!==(l=u[11].name+"")&&W(n,l),c&256&&i!==(i="/"+u[11].id)&&a(e,"href",i),c&256&&s!==(s=u[11]._prj+" "+u[11]._act+(u[11].id?"":"empty"))&&a(e,"class",s),c&256&&qe(e,"padding-left",u[11].space/2+"ch")},d(u){u&&g(e),r=!1,f()}}}function Ut(t){let e;function l(s,r){return s[11].id?en:xl}let n=l(t),i=n(t);return{c(){i.c(),e=Me()},m(s,r){i.m(s,r),b(s,e,r)},p(s,r){n===(n=l(s))&&i?i.p(s,r):(i.d(1),i=n(s),i&&(i.c(),i.m(e.parentNode,e)))},d(s){s&&g(e),i.d(s)}}}function Jt(t){let e,l,n,i,s="&#9741;",r,f,u,c;return l=new ye({props:{key:"view",href:"/"+t[3].level[0]}}),{c(){e=h("div"),F(l.$$.fragment),n=w(),i=h("a"),a(i,"href",r="/"+t[3].level[0]+"/accessLink"),a(i,"class","a icon"),a(i,"title","Поделиться ссылкой"),a(e,"class","group1")},m(o,m){b(o,e,m),I(l,e,null),p(e,n),p(e,i),i.innerHTML=s,f=!0,u||(c=C(i,"click",t[10]),u=!0)},p(o,m){const _={};m&8&&(_.href="/"+o[3].level[0]),l.$set(_),(!f||m&8&&r!==(r="/"+o[3].level[0]+"/accessLink"))&&a(i,"href",r)},i(o){f||(L(l.$$.fragment,o),f=!0)},o(o){E(l.$$.fragment,o),f=!1},d(o){o&&g(e),B(l),u=!1,c()}}}function Wt(t){let e,l,n,i,s;l=new ye({props:{key:"tree",href:"/"+t[3].level[0]+"/tree"}});let r=t[9]===!1&&Xt(t),f=t[9]===!0&&Yt(t);return{c(){e=h("div"),F(l.$$.fragment),n=w(),r&&r.c(),i=w(),f&&f.c(),a(e,"class","group1")},m(u,c){b(u,e,c),I(l,e,null),p(e,n),r&&r.m(e,null),p(e,i),f&&f.m(e,null),s=!0},p(u,c){const o={};c&8&&(o.href="/"+u[3].level[0]+"/tree"),l.$set(o),u[9]===!1?r?r.p(u,c):(r=Xt(u),r.c(),r.m(e,i)):r&&(r.d(1),r=null),u[9]===!0?f?f.p(u,c):(f=Yt(u),f.c(),f.m(e,null)):f&&(f.d(1),f=null)},i(u){s||(L(l.$$.fragment,u),s=!0)},o(u){E(l.$$.fragment,u),s=!1},d(u){u&&g(e),B(l),r&&r.d(),f&&f.d()}}}function Xt(t){let e,l,n,i,s;return{c(){e=h("a"),l=O("+"),a(e,"href",n="/"+t[3].level[0]+"/treeAdd"),a(e,"class","a icon"),a(e,"title","Выделить проект")},m(r,f){b(r,e,f),p(e,l),i||(s=C(e,"click",z),i=!0)},p(r,f){f&8&&n!==(n="/"+r[3].level[0]+"/treeAdd")&&a(e,"href",n)},d(r){r&&g(e),i=!1,s()}}}function Yt(t){let e,l,n,i,s;return{c(){e=h("a"),l=O("-"),a(e,"href",n="/"+t[3].level[0]+"/treeDel"),a(e,"class","a icon"),a(e,"title","Отменить проект")},m(r,f){b(r,e,f),p(e,l),i||(s=C(e,"click",z),i=!0)},p(r,f){f&8&&n!==(n="/"+r[3].level[0]+"/treeDel")&&a(e,"href",n)},d(r){r&&g(e),i=!1,s()}}}function tn(t){let e,l;return e=new Wl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function ln(t){let e,l;return e=new Rl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function nn(t){let e,l;return e=new Vl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function rn(t){let e,l;return e=new Al({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function sn(t){let e,l;return e=new Il({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function fn(t){let e,l,n,i,s,r,f,u,c,o,m,_,$=t[4].name+"",v,k,y,P,X,le,pe,Ce,K,ee,he,Oe,Ie=t[2].name+"",Je,Be,ht,H,We,fe,gt,Xe,ue,bt,ce,kt,oe,Ke,Ye,R,J,je,te,Qe,vt;document.title=e=t[7];let ge=Y(t[1]),V=[];for(let d=0;d<ge.length;d+=1)V[d]=Gt(qt(t,ge,d));let be=Y(t[1]),q=[];for(let d=0;d<be.length;d+=1)q[d]=Rt(Vt(t,be,d));let ke=Y(t[8]),G=[];for(let d=0;d<ke.length;d+=1)G[d]=Ut(zt(t,ke,d));let j="view"in t[2]&&Jt(t);fe=new ye({props:{key:"line",href:"/"+t[3].level[0]+"/line"}});let A="tree"in t[2]&&Wt(t);ue=new ye({props:{key:"access",href:"/"+t[3].level[0]+"/access"}}),ce=new ye({props:{key:"log",href:"/"+t[3].level[0]+"/log"}}),oe=new ye({props:{key:"bye",href:"/bye/"+t[6]}});const $t=[sn,rn,nn,ln,tn],ae=[];function wt(d,S){return d[0]=="view"?0:d[0]=="line"?1:d[0]=="tree"?2:d[0]=="access"?3:d[0]=="log"?4:-1}return~(R=wt(t))&&(J=ae[R]=$t[R](t)),{c(){l=w(),n=h("div"),i=h("div"),s=h("a"),s.textContent="Taris",r=w();for(let d=0;d<V.length;d+=1)V[d].c();f=w(),u=h("div"),c=h("i"),m=w(),_=h("span"),v=O($),k=w(),y=h("div"),P=h("div"),X=h("div"),le=h("a"),le.textContent="Taris",pe=w();for(let d=0;d<q.length;d+=1)q[d].c();Ce=w(),K=h("div");for(let d=0;d<G.length;d+=1)G[d].c();ee=w(),he=h("div"),Oe=h("div"),Je=O(Ie),ht=w(),H=h("div"),j&&j.c(),We=w(),F(fe.$$.fragment),gt=w(),A&&A.c(),Xe=w(),F(ue.$$.fragment),bt=w(),F(ce.$$.fragment),kt=w(),F(oe.$$.fragment),Ye=w(),J&&J.c(),je=Me(),a(s,"href","/"),a(s,"class","logo"),a(i,"class","bc"),a(c,"class",o="sep "+t[4]._cur+" "+t[4]._pub),a(_,"class","name"),a(le,"href","/"),a(le,"class","logo"),a(X,"class","bc2"),a(K,"class","tree2"),a(P,"class","wrap"),a(y,"class","menu"),a(u,"class","bcm"),a(Oe,"class",Be="name "+t[5]),a(H,"class",Ke="menu "+t[5]),a(he,"class","burger"),a(n,"class","nav1")},m(d,S){b(d,l,S),b(d,n,S),p(n,i),p(i,s),p(i,r);for(let D=0;D<V.length;D+=1)V[D]&&V[D].m(i,null);p(n,f),p(n,u),p(u,c),p(u,m),p(u,_),p(_,v),p(u,k),p(u,y),p(y,P),p(P,X),p(X,le),p(X,pe);for(let D=0;D<q.length;D+=1)q[D]&&q[D].m(X,null);p(P,Ce),p(P,K);for(let D=0;D<G.length;D+=1)G[D]&&G[D].m(K,null);p(n,ee),p(n,he),p(he,Oe),p(Oe,Je),p(he,ht),p(he,H),j&&j.m(H,null),p(H,We),I(fe,H,null),p(H,gt),A&&A.m(H,null),p(H,Xe),I(ue,H,null),p(H,bt),I(ce,H,null),p(H,kt),I(oe,H,null),b(d,Ye,S),~R&&ae[R].m(d,S),b(d,je,S),te=!0,Qe||(vt=[C(s,"click",Se),C(le,"click",Se)],Qe=!0)},p(d,[S]){if((!te||S&128)&&e!==(e=d[7])&&(document.title=e),S&2){ge=Y(d[1]);let T;for(T=0;T<ge.length;T+=1){const ne=qt(d,ge,T);V[T]?V[T].p(ne,S):(V[T]=Gt(ne),V[T].c(),V[T].m(i,null))}for(;T<V.length;T+=1)V[T].d(1);V.length=ge.length}if((!te||S&16&&o!==(o="sep "+d[4]._cur+" "+d[4]._pub))&&a(c,"class",o),(!te||S&16)&&$!==($=d[4].name+"")&&W(v,$),S&2){be=Y(d[1]);let T;for(T=0;T<be.length;T+=1){const ne=Vt(d,be,T);q[T]?q[T].p(ne,S):(q[T]=Rt(ne),q[T].c(),q[T].m(X,null))}for(;T<q.length;T+=1)q[T].d(1);q.length=be.length}if(S&256){ke=Y(d[8]);let T;for(T=0;T<ke.length;T+=1){const ne=zt(d,ke,T);G[T]?G[T].p(ne,S):(G[T]=Ut(ne),G[T].c(),G[T].m(K,null))}for(;T<G.length;T+=1)G[T].d(1);G.length=ke.length}(!te||S&4)&&Ie!==(Ie=d[2].name+"")&&W(Je,Ie),(!te||S&32&&Be!==(Be="name "+d[5]))&&a(Oe,"class",Be),"view"in d[2]?j?(j.p(d,S),S&4&&L(j,1)):(j=Jt(d),j.c(),L(j,1),j.m(H,We)):j&&(me(),E(j,1,1,()=>{j=null}),de());const D={};S&8&&(D.href="/"+d[3].level[0]+"/line"),fe.$set(D),"tree"in d[2]?A?(A.p(d,S),S&4&&L(A,1)):(A=Wt(d),A.c(),L(A,1),A.m(H,Xe)):A&&(me(),E(A,1,1,()=>{A=null}),de());const yt={};S&8&&(yt.href="/"+d[3].level[0]+"/access"),ue.$set(yt);const Tt={};S&8&&(Tt.href="/"+d[3].level[0]+"/log"),ce.$set(Tt);const Lt={};S&64&&(Lt.href="/bye/"+d[6]),oe.$set(Lt),(!te||S&32&&Ke!==(Ke="menu "+d[5]))&&a(H,"class",Ke);let Ze=R;R=wt(d),R!==Ze&&(J&&(me(),E(ae[Ze],1,1,()=>{ae[Ze]=null}),de()),~R?(J=ae[R],J||(J=ae[R]=$t[R](d),J.c()),L(J,1),J.m(je.parentNode,je)):J=null)},i(d){te||(L(j),L(fe.$$.fragment,d),L(A),L(ue.$$.fragment,d),L(ce.$$.fragment,d),L(oe.$$.fragment,d),L(J),te=!0)},o(d){E(j),E(fe.$$.fragment,d),E(A),E(ue.$$.fragment,d),E(ce.$$.fragment,d),E(oe.$$.fragment,d),E(J),te=!1},d(d){d&&(g(l),g(n),g(Ye),g(je)),Te(V,d),Te(q,d),Te(G,d),j&&j.d(),B(fe),A&&A.d(),B(ue),B(ce),B(oe),~R&&ae[R].d(d),Qe=!1,re(vt)}}}function un(t,e,l){let n,i,s,r,f,u,c,o,m,_;M(t,dt,v=>l(1,f=v)),M(t,Pe,v=>l(2,u=v)),M(t,Ne,v=>l(3,c=v)),M(t,pt,v=>l(7,o=v)),M(t,Re,v=>l(8,m=v)),M(t,mt,v=>l(9,_=v));function $(v){z(v,{},k=>navigator.clipboard.writeText(`https://taris.pro${k.href}`))}return t.$$.update=()=>{t.$$.dirty&8&&l(0,n=c.level[1]||""),t.$$.dirty&1&&l(0,n={[n]:"view",line:"line",tree:"tree",access:"access",log:"log"}[n]),t.$$.dirty&2&&l(6,i=f[0]?f[0].name:""),t.$$.dirty&4&&l(5,s=Object.keys(u).length<2?"empty":""),t.$$.dirty&2&&l(4,r=f[0]?f[f.length-1]:"")},[n,f,u,c,r,s,i,o,m,_,$]}class cn extends x{constructor(e){super(),Z(this,e,un,fn,Q,{})}}function on(t){let e,l;return e=new cn({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function an(t){let e,l;return e=new Ml({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function _n(t){let e,l=t[0]!=""?`<pre class="apierr">${t[0]}</pre>`:"",n,i,s,r,f,u;const c=[an,on],o=[];function m(_,$){return $&2&&(i=null),_[1].path=="/"?0:(i==null&&(i=Number(_[1].level[0])>0),i?1:-1)}return~(s=m(t,-1))&&(r=o[s]=c[s](t)),{c(){e=new ml(!1),n=w(),r&&r.c(),f=Me(),e.a=n},m(_,$){e.m(l,_,$),b(_,n,$),~s&&o[s].m(_,$),b(_,f,$),u=!0},p(_,[$]){(!u||$&1)&&l!==(l=_[0]!=""?`<pre class="apierr">${_[0]}</pre>`:"")&&e.p(l);let v=s;s=m(_,$),s!==v&&(r&&(me(),E(o[v],1,1,()=>{o[v]=null}),de()),~s?(r=o[s],r||(r=o[s]=c[s](_),r.c()),L(r,1),r.m(f.parentNode,f)):r=null)},i(_){u||(L(r),u=!0)},o(_){E(r),u=!1},d(_){_&&(e.d(),g(n),g(f)),~s&&o[s].d(_)}}}function mn(t,e,l){let n,i;return M(t,Ge,s=>l(0,n=s)),M(t,Ne,s=>l(1,i=s)),[n,i]}class dn extends x{constructor(e){super(),Z(this,e,mn,_n,Q,{})}}new dn({target:document.getElementById("app")});