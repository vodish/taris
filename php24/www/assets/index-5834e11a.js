var ul=Object.defineProperty;var cl=(t,e,l)=>e in t?ul(t,e,{enumerable:!0,configurable:!0,writable:!0,value:l}):t[e]=l;var re=(t,e,l)=>(cl(t,typeof e!="symbol"?e+"":e,l),l);const xe=Object.freeze(Object.defineProperty({__proto__:null,get accessText(){return ft},get api(){return pe},get apierr(){return Ge},get get(){return ct},get href(){return Se},get isProject(){return _t},get lineHtml(){return Ue},get lineText(){return st},get logList(){return rl},get packBc(){return pt},get packMenu(){return Pe},get packStart(){return ne},get packTitle(){return ht},get packTree(){return Re},get parse(){return mt},get pref(){return z},get treeText(){return rt},get url(){return Ne},get userList(){return ze}},Symbol.toStringTag,{value:"Module"}));(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const i of document.querySelectorAll('link[rel="modulepreload"]'))n(i);new MutationObserver(i=>{for(const s of i)if(s.type==="childList")for(const r of s.addedNodes)r.tagName==="LINK"&&r.rel==="modulepreload"&&n(r)}).observe(document,{childList:!0,subtree:!0});function l(i){const s={};return i.integrity&&(s.integrity=i.integrity),i.referrerPolicy&&(s.referrerPolicy=i.referrerPolicy),i.crossOrigin==="use-credentials"?s.credentials="include":i.crossOrigin==="anonymous"?s.credentials="omit":s.credentials="same-origin",s}function n(i){if(i.ep)return;i.ep=!0;const s=l(i);fetch(i.href,s)}})();function N(){}function Zt(t){return t()}function St(){return Object.create(null)}function se(t){t.forEach(Zt)}function ut(t){return typeof t=="function"}function Q(t,e){return t!=t?e==e:t!==e||t&&typeof t=="object"||typeof t=="function"}function ol(t){return Object.keys(t).length===0}function xt(t,...e){if(t==null){for(const n of e)n(void 0);return N}const l=t.subscribe(...e);return l.unsubscribe?()=>l.unsubscribe():l}function ct(t){let e;return xt(t,l=>e=l)(),e}function M(t,e,l){t.$$.on_destroy.push(xt(e,l))}const al=typeof window<"u"?window:typeof globalThis<"u"?globalThis:global;function p(t,e){t.appendChild(e)}function b(t,e,l){t.insertBefore(e,l||null)}function g(t){t.parentNode&&t.parentNode.removeChild(t)}function Le(t,e){for(let l=0;l<t.length;l+=1)t[l]&&t[l].d(e)}function h(t){return document.createElement(t)}function dl(t){return document.createElementNS("http://www.w3.org/2000/svg",t)}function O(t){return document.createTextNode(t)}function $(){return O(" ")}function Me(){return O("")}function C(t,e,l,n){return t.addEventListener(e,l,n),()=>t.removeEventListener(e,l,n)}function el(t){return function(e){return e.preventDefault(),t.call(this,e)}}function a(t,e,l){l==null?t.removeAttribute(e):t.getAttribute(e)!==l&&t.setAttribute(e,l)}function ml(t){return Array.from(t.childNodes)}function W(t,e){e=""+e,t.data!==e&&(t.data=e)}function Ve(t,e){t.value=e??""}function qe(t,e,l,n){l==null?t.style.removeProperty(e):t.style.setProperty(e,l,n?"important":"")}class _l{constructor(e=!1){re(this,"is_svg",!1);re(this,"e");re(this,"n");re(this,"t");re(this,"a");this.is_svg=e,this.e=this.n=null}c(e){this.h(e)}m(e,l,n=null){this.e||(this.is_svg?this.e=dl(l.nodeName):this.e=h(l.nodeType===11?"TEMPLATE":l.nodeName),this.t=l.tagName!=="TEMPLATE"?l:l.content,this.c(e)),this.i(n)}h(e){this.e.innerHTML=e,this.n=Array.from(this.e.nodeName==="TEMPLATE"?this.e.content.childNodes:this.e.childNodes)}i(e){for(let l=0;l<this.n.length;l+=1)b(this.t,this.n[l],e)}p(e){this.d(),this.h(e),this.i(this.a)}d(){this.n.forEach(g)}}let De;function Ae(t){De=t}function tl(){if(!De)throw new Error("Function called outside component initialization");return De}function ot(t){tl().$$.on_mount.push(t)}function pl(t){tl().$$.on_destroy.push(t)}const ye=[],He=[];let Ee=[];const tt=[],hl=Promise.resolve();let lt=!1;function gl(){lt||(lt=!0,hl.then(ll))}function nt(t){Ee.push(t)}function at(t){tt.push(t)}const et=new Set;let we=0;function ll(){if(we!==0)return;const t=De;do{try{for(;we<ye.length;){const e=ye[we];we++,Ae(e),bl(e.$$)}}catch(e){throw ye.length=0,we=0,e}for(Ae(null),ye.length=0,we=0;He.length;)He.pop()();for(let e=0;e<Ee.length;e+=1){const l=Ee[e];et.has(l)||(et.add(l),l())}Ee.length=0}while(ye.length);for(;tt.length;)tt.pop()();lt=!1,et.clear(),Ae(t)}function bl(t){if(t.fragment!==null){t.update(),se(t.before_update);const e=t.dirty;t.dirty=[-1],t.fragment&&t.fragment.p(t.ctx,e),t.after_update.forEach(nt)}}function vl(t){const e=[],l=[];Ee.forEach(n=>t.indexOf(n)===-1?e.push(n):l.push(n)),l.forEach(n=>n()),Ee=e}const Fe=new Set;let de;function me(){de={r:0,c:[],p:de}}function _e(){de.r||se(de.c),de=de.p}function L(t,e){t&&t.i&&(Fe.delete(t),t.i(e))}function E(t,e,l,n){if(t&&t.o){if(Fe.has(t))return;Fe.add(t),de.c.push(()=>{Fe.delete(t),n&&(l&&t.d(1),n())}),t.o(e)}else n&&n()}function Y(t){return(t==null?void 0:t.length)!==void 0?t:Array.from(t)}function dt(t,e,l){const n=t.$$.props[e];n!==void 0&&(t.$$.bound[n]=l,l(t.$$.ctx[n]))}function F(t){t&&t.c()}function I(t,e,l){const{fragment:n,after_update:i}=t.$$;n&&n.m(e,l),nt(()=>{const s=t.$$.on_mount.map(Zt).filter(ut);t.$$.on_destroy?t.$$.on_destroy.push(...s):se(s),t.$$.on_mount=[]}),i.forEach(nt)}function B(t,e){const l=t.$$;l.fragment!==null&&(vl(l.after_update),se(l.on_destroy),l.fragment&&l.fragment.d(e),l.on_destroy=l.fragment=null,l.ctx=[])}function kl(t,e){t.$$.dirty[0]===-1&&(ye.push(t),gl(),t.$$.dirty.fill(0)),t.$$.dirty[e/31|0]|=1<<e%31}function Z(t,e,l,n,i,s,r,f=[-1]){const u=De;Ae(t);const c=t.$$={fragment:null,ctx:[],props:s,update:N,not_equal:i,bound:St(),on_mount:[],on_destroy:[],on_disconnect:[],before_update:[],after_update:[],context:new Map(e.context||(u?u.$$.context:[])),callbacks:St(),dirty:f,skip_bound:!1,root:e.target||u.$$.root};r&&r(c.root);let o=!1;if(c.ctx=l?l(t,e.props||{},(m,d,...w)=>{const k=w.length?w[0]:d;return c.ctx&&i(c.ctx[m],c.ctx[m]=k)&&(!c.skip_bound&&c.bound[m]&&c.bound[m](k),o&&kl(t,m)),d}):[],c.update(),o=!0,se(c.before_update),c.fragment=n?n(c.ctx):!1,e.target){if(e.hydrate){const m=ml(e.target);c.fragment&&c.fragment.l(m),m.forEach(g)}else c.fragment&&c.fragment.c();e.intro&&L(t.$$.fragment),I(t,e.target,e.anchor),ll()}Ae(u)}class x{constructor(){re(this,"$$");re(this,"$$set")}$destroy(){B(this,1),this.$destroy=N}$on(e,l){if(!ut(l))return N;const n=this.$$.callbacks[e]||(this.$$.callbacks[e]=[]);return n.push(l),()=>{const i=n.indexOf(l);i!==-1&&n.splice(i,1)}}$set(e){this.$$set&&!ol(e)&&(this.$$.skip_bound=!0,this.$$set(e),this.$$.skip_bound=!1)}}const wl="4";typeof window<"u"&&(window.__svelte||(window.__svelte={v:new Set})).v.add(wl);const $e=[];function U(t,e=N){let l;const n=new Set;function i(f){if(Q(t,f)&&(t=f,l)){const u=!$e.length;for(const c of n)c[1](),$e.push(c,t);if(u){for(let c=0;c<$e.length;c+=2)$e[c][0]($e[c+1]);$e.length=0}}}function s(f){i(f(t))}function r(f,u=N){const c=[f,u];return n.add(c),n.size===1&&(l=e(i,s)||N),f(t),()=>{n.delete(c),n.size===0&&l&&(l(),l=null)}}return{set:i,update:s,subscribe:r}}let it=document.getElementById("rtoken"),Mt=JSON.parse(it.innerText);it.parentNode.removeChild(it);function nl(){let t=mt(window.location.pathname);Ne.set(t),t.level[0]&&t.level[0]!=ct(ne)&&z(window.location.pathname)}function Se(t){typeof t=="object"&&t.srcElement.tagName=="A"&&(t.preventDefault(),t=t.srcElement.pathname),window.location.pathname!=t&&(window.history.pushState({},"",t),Ne.set(mt(t)))}function z(t,e,l){typeof t=="object"&&t.srcElement.tagName=="A"&&(t.preventDefault(),t=t.srcElement.pathname);let n={href:t};for(let i in e||{})n[i]=e[i];pe(n,i=>{for(let s in i)xe[s]&&xe[s].set&&xe[s].set(i[s]);Se(i.href||t),typeof l=="function"&&l(i)})}function mt(t){let e=t=="/"?[]:t.substring(1).split("/"),l=[];return e.map((n,i)=>l[i]=`${i?l[i-1]:""}/${n}`),{path:t,level:e,dir:l}}function pe(t,e){t.rtoken=Mt;let l=t.constructor.name=="FormData"?t:new FormData;il(l,t);let n=new XMLHttpRequest;n.open("POST","/api"),n.send(l),n.onload=()=>{let i={};try{i=JSON.parse(n.response)}catch{Ge.set(n.response)}i.rtoken&&(Mt=i.rtoken,Ge.set("")),e(i)}}function il(t,e,l){e&&typeof e=="object"&&!(e instanceof Date)&&!(e instanceof File)&&!(e instanceof Blob)?Object.keys(e).forEach(n=>il(t,e[n],l?`${l}[${n}]`:n)):t.append(l,e??"")}let Ne=U(),Ge=U(""),ze=U(!1),ne=U(!1),_t=U(!1),pt=U([]),Re=U([]),Pe=U({name:""}),ht=U(""),rt=U(""),Ue=U(""),st=U(""),ft=U(""),rl=U([]);nl();window.addEventListener("popstate",nl);const{document:$l}=al;function Nt(t,e,l){const n=t.slice();return n[12]=e[l],n}function yl(t){let e,l,n,i,s,r,f,u,c,o,m,d=t[4]!=""&&Pt(t);function w(y,P){return y[3]>0?El:Ll}let k=w(t),v=k(t);return{c(){e=h("div"),l=h("div"),n=h("div"),n.textContent="Код из письма",i=$(),d&&d.c(),s=$(),r=h("input"),u=$(),v.c(),c=Me(),a(r,"class",f="code "+(t[4]==""?"":"err")),a(r,"maxlength","4"),a(r,"autocomplete","off"),a(r,"id","code"),a(e,"class","login")},m(y,P){b(y,e,P),p(e,l),p(l,n),p(l,i),d&&d.m(l,null),p(e,s),p(e,r),Ve(r,t[1]),b(y,u,P),v.m(y,P),b(y,c,P),o||(m=[C(r,"input",t[9]),C(r,"keyup",t[7])],o=!0)},p(y,P){y[4]!=""?d?d.p(y,P):(d=Pt(y),d.c(),d.m(l,null)):d&&(d.d(1),d=null),P&16&&f!==(f="code "+(y[4]==""?"":"err"))&&a(r,"class",f),P&2&&r.value!==y[1]&&Ve(r,y[1]),k===(k=w(y))&&v?v.p(y,P):(v.d(1),v=k(y),v&&(v.c(),v.m(c.parentNode,c)))},d(y){y&&(g(e),g(u),g(c)),d&&d.d(),v.d(y),o=!1,se(m)}}}function Tl(t){let e,l,n,i,s,r;return{c(){e=h("form"),l=h("input"),n=$(),i=h("button"),i.textContent="Taris",a(l,"class","email"),a(l,"type","email"),a(l,"name","email"),l.required=!0,a(l,"placeholder","Емеил для входа"),a(l,"title","Емеил для входа"),a(l,"id","email"),a(i,"class","send"),a(e,"class","login")},m(f,u){b(f,e,u),p(e,l),Ve(l,t[0]),p(e,n),p(e,i),s||(r=[C(l,"input",t[8]),C(e,"submit",el(t[6]))],s=!0)},p(f,u){u&1&&l.value!==f[0]&&Ve(l,f[0])},d(f){f&&g(e),s=!1,se(r)}}}function Pt(t){let e,l;return{c(){e=h("div"),l=O(t[4]),a(e,"class","err")},m(n,i){b(n,e,i),p(e,l)},p(n,i){i&16&&W(l,n[4])},d(n){n&&g(e)}}}function Ll(t){let e,l,n,i;return{c(){e=h("div"),l=h("a"),l.textContent="Повторить вход",a(l,"href","/"),a(l,"class","back"),a(e,"class","note")},m(s,r){b(s,e,r),p(e,l),n||(i=C(l,"click",el(t[10])),n=!0)},p:N,d(s){s&&g(e),n=!1,i()}}}function El(t){let e,l,n,i,s;return{c(){e=h("div"),l=O("Повторить отправку через "),n=h("span"),i=O(t[3]),s=O(" сек"),a(n,"class","delay"),a(e,"class","note wait")},m(r,f){b(r,e,f),p(e,l),p(e,n),p(n,i),p(e,s)},p(r,f){f&8&&W(i,r[3])},d(r){r&&g(e)}}}function Ct(t){let e,l=Y(t[5]),n=[];for(let i=0;i<l.length;i+=1)n[i]=Ot(Nt(t,l,i));return{c(){e=h("div");for(let i=0;i<n.length;i+=1)n[i].c();a(e,"class","userlist")},m(i,s){b(i,e,s);for(let r=0;r<n.length;r+=1)n[r]&&n[r].m(e,null)},p(i,s){if(s&32){l=Y(i[5]);let r;for(r=0;r<l.length;r+=1){const f=Nt(i,l,r);n[r]?n[r].p(f,s):(n[r]=Ot(f),n[r].c(),n[r].m(e,null))}for(;r<n.length;r+=1)n[r].d(1);n.length=l.length}},d(i){i&&g(e),Le(n,i)}}}function Ot(t){let e,l=t[12].email+"",n,i,s,r;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[12].start)},m(f,u){b(f,e,u),p(e,n),s||(r=C(e,"click",z),s=!0)},p(f,u){u&32&&l!==(l=f[12].email+"")&&W(n,l),u&32&&i!==(i="/"+f[12].start)&&a(e,"href",i)},d(f){f&&g(e),s=!1,r()}}}function Sl(t){let e,l,n,i,s,r,f,u,c,o;function m(v,y){if(v[2]=="email")return Tl;if(v[2]=="code")return yl}let d=m(t),w=d&&d(t),k=t[5]&&t[5].length&&Ct(t);return{c(){e=$(),l=h("div"),n=h("div"),i=h("div"),w&&w.c(),s=$(),k&&k.c(),r=$(),f=h("h3"),u=h("a"),u.textContent="Что здесь происходит?",$l.title="Taris - система работы с текстовыми файлами",a(i,"class","auth"),a(u,"href","/151"),a(f,"class","about"),a(l,"class","main1")},m(v,y){b(v,e,y),b(v,l,y),p(l,n),p(n,i),w&&w.m(i,null),p(n,s),k&&k.m(n,null),p(l,r),p(l,f),p(f,u),c||(o=C(u,"click",z),c=!0)},p(v,[y]){d===(d=m(v))&&w?w.p(v,y):(w&&w.d(1),w=d&&d(v),w&&(w.c(),w.m(i,null))),v[5]&&v[5].length?k?k.p(v,y):(k=Ct(v),k.c(),k.m(n,null)):k&&(k.d(1),k=null)},i:N,o:N,d(v){v&&(g(e),g(l)),w&&w.d(),k&&k.d(),c=!1,o()}}}function Ml(t,e,l){let n;M(t,ze,v=>l(5,n=v));let i="",s="",r="email",f,u="",c=!1;ot(()=>{document.getElementById("email").focus(),n==!1&&pe({userList:1,wait:["userList"]},v=>ze.set(v.userList))});function o(){l(2,r="code"),l(1,s=""),l(4,u=""),l(3,f=60),setTimeout(()=>{document.getElementById("code").focus()},0);let v=setInterval(()=>{l(3,f--,f),!(f>0)&&clearInterval(v)},1e3);pe({userGetCode:i},y=>{y.ok!="ok"&&l(4,u="")})}function m(){l(1,s=s.replace(/\D+/g,"")),s.length==4&&c===!1?(c=!0,pe({userCheckCode:i,code:s},v=>{if(v.err)return l(4,u=v.err);v.packStart&&(ze.set(v.userList),ne.set(v.packStart),_t.set(v.isProject),pt.set(v.packBc),Re.set(v.packTree),Pe.set(v.packMenu),ht.set(v.packTitle),Ue.set(v.lineHtml),Se(v.href))})):s.length<4&&(c=!1,l(4,u=""))}function d(){i=this.value,l(0,i)}function w(){s=this.value,l(1,s)}return[i,s,r,f,u,n,o,m,d,w,()=>l(2,r="email")]}class Nl extends x{constructor(e){super(),Z(this,e,Ml,Sl,Q,{})}}function sl(t){var e=(t.clipboardData||t.originalEvent.clipboardData).items;for(var l in e){if(e[l].kind!=="file"&&e[l].type!="image/png")continue;let n=new FormData;n.set("pack",ct(ne)),n.set("attach","clipboard"),n.append("clipboard",e[l].getAsFile(),"clipboard"),pe(n,i=>{window.ace9.execCommand("paste",`<img src="${i.clipboard}" />`),navigator.clipboard.writeText("")})}}function Pl(t){let e;return{c(){e=h("div"),a(e,"id","ace9"),a(e,"class","ace")},m(l,n){b(l,e,n)},p:N,i:N,o:N,d(l){l&&g(e)}}}function Cl(t,e,l){let{value:n=""}=e;return document.onpaste=sl,ot(()=>{window.ace9=ace.edit("ace9"),window.ace9.session.setMode("ace/mode/html"),window.ace9.setOptions({minLines:10,fontSize:"14px",fontFamily:"monospace",showPrintMargin:!1,showGutter:!1,useWorker:!1,maxLines:1111,wrap:!0}),window.ace9.setValue(n,1),window.ace9.on("change",()=>l(0,n=window.ace9.getValue())),window.ace9.focus();let i=sessionStorage.getItem("gotoLine");window.ace9.gotoLine(i||1)}),pl(()=>{var i=window.ace9.getSelectionRange().start.row;sessionStorage.setItem("gotoLine",i+1),delete window.ace9}),t.$$set=i=>{"value"in i&&l(0,n=i.value)},[n]}class Ol extends x{constructor(e){super(),Z(this,e,Cl,Pl,Q,{value:0})}}function jt(t){let e,l,n;function i(r){t[3](r)}let s={};return t[1]!==void 0&&(s.value=t[1]),e=new Ol({props:s}),He.push(()=>dt(e,"value",i)),{c(){F(e.$$.fragment)},m(r,f){I(e,r,f),n=!0},p(r,f){const u={};!l&&f&2&&(l=!0,u.value=r[1],at(()=>l=!1)),e.$set(u)},i(r){n||(L(e.$$.fragment,r),n=!0)},o(r){E(e.$$.fragment,r),n=!1},d(r){B(e,r)}}}function jl(t){let e,l,n,i,s,r,f,u=t[0]&&jt(t);return{c(){u&&u.c(),e=$(),l=h("br"),n=$(),i=h("button"),i.textContent="Сохранить",a(i,"id","ctrl-s")},m(c,o){u&&u.m(c,o),b(c,e,o),b(c,l,o),b(c,n,o),b(c,i,o),s=!0,r||(f=C(i,"click",t[2]),r=!0)},p(c,[o]){c[0]?u?(u.p(c,o),o&1&&L(u,1)):(u=jt(c),u.c(),L(u,1),u.m(e.parentNode,e)):u&&(me(),E(u,1,1,()=>{u=null}),_e())},i(c){s||(L(u),s=!0)},o(c){E(u),s=!1},d(c){c&&(g(e),g(l),g(n),g(i)),u&&u.d(c),r=!1,f()}}}function Al(t,e,l){let n,i;M(t,ne,f=>l(0,n=f)),M(t,st,f=>l(1,i=f)),document.onpaste=sl;function s(){pe({pack:n,line:i,wait:["lineHtml","packMenu"]},f=>{Ue.set(f.lineHtml),Pe.set(f.packMenu),Se(`/${n}`)})}document.onkeydown=f=>{["KeyS","Enter"].includes(f.code)&&(f.ctrlKey||f.metaKey)&&(f.preventDefault(),s())};function r(f){i=f,st.set(i)}return[n,i,s,r]}class Dl extends x{constructor(e){super(),Z(this,e,Al,jl,Q,{})}}function At(t,e,l){const n=t.slice();return n[4]=e[l],n}function Dt(t){let e,l=t[4].name+"",n,i,s,r,f;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[4].id),a(e,"class",s=t[4]._prj)},m(u,c){b(u,e,c),p(e,n),r||(f=C(e,"click",z),r=!0)},p(u,c){c&1&&l!==(l=u[4].name+"")&&W(n,l),c&1&&i!==(i="/"+u[4].id)&&a(e,"href",i),c&1&&s!==(s=u[4]._prj)&&a(e,"class",s)},d(u){u&&g(e),r=!1,f()}}}function Ht(t){let e,l,n,i=t[4].id&&Dt(t);return{c(){e=h("div"),i&&i.c(),l=$(),a(e,"class",n=t[4]._act+(t[4].id?"":"empty")),qe(e,"margin-left",t[4].space/2+"ch")},m(s,r){b(s,e,r),i&&i.m(e,null),p(e,l)},p(s,r){s[4].id?i?i.p(s,r):(i=Dt(s),i.c(),i.m(e,l)):i&&(i.d(1),i=null),r&1&&n!==(n=s[4]._act+(s[4].id?"":"empty"))&&a(e,"class",n),r&1&&qe(e,"margin-left",s[4].space/2+"ch")},d(s){s&&g(e),i&&i.d()}}}function Hl(t){let e,l,n,i,s=Y(t[0]),r=[];for(let f=0;f<s.length;f+=1)r[f]=Ht(At(t,s,f));return{c(){e=h("div"),l=h("div");for(let f=0;f<r.length;f+=1)r[f].c();n=$(),i=h("div"),a(l,"class","tree"),a(i,"class","file"),a(e,"class","pro")},m(f,u){b(f,e,u),p(e,l);for(let c=0;c<r.length;c+=1)r[c]&&r[c].m(l,null);p(e,n),p(e,i),i.innerHTML=t[1]},p(f,[u]){if(u&1){s=Y(f[0]);let c;for(c=0;c<s.length;c+=1){const o=At(f,s,c);r[c]?r[c].p(o,u):(r[c]=Ht(o),r[c].c(),r[c].m(l,null))}for(;c<r.length;c+=1)r[c].d(1);r.length=s.length}u&2&&(i.innerHTML=f[1])},i:N,o:N,d(f){f&&g(e),Le(r,f)}}}function Il(t,e,l){let n,i,s,r;return M(t,ne,f=>l(2,n=f)),M(t,Pe,f=>l(3,i=f)),M(t,Re,f=>l(0,s=f)),M(t,Ue,f=>l(1,r=f)),document.onkeydown=f=>{i.line!=null&&["KeyS","Enter"].includes(f.code)&&(f.ctrlKey||f.metaKey)&&(f.preventDefault(),z(`/${n}/line`))},[s,r]}class Bl extends x{constructor(e){super(),Z(this,e,Il,Hl,Q,{})}}function Kl(t){let e;return{c(){e=h("div"),a(e,"id","ace9"),a(e,"class","ace")},m(l,n){b(l,e,n)},p:N,i:N,o:N,d(l){l&&g(e)}}}function Fl(t,e,l){let{value:n=""}=e;return ot(()=>{let i=ace.edit("ace9");i.session.setMode("ace/mode/yaml"),i.setOptions({minLines:10,fontSize:"14px",fontFamily:"monospace",showPrintMargin:!1,showGutter:!1,useWorker:!1,maxLines:1111,wrap:!1}),i.setValue(n,1),i.on("change",()=>l(0,n=i.getValue())),i.focus()}),t.$$set=i=>{"value"in i&&l(0,n=i.value)},[n]}class fl extends x{constructor(e){super(),Z(this,e,Fl,Kl,Q,{value:0})}}function It(t){let e,l,n;function i(r){t[3](r)}let s={};return t[0]!==void 0&&(s.value=t[0]),e=new fl({props:s}),He.push(()=>dt(e,"value",i)),{c(){F(e.$$.fragment)},m(r,f){I(e,r,f),n=!0},p(r,f){const u={};!l&&f&1&&(l=!0,u.value=r[0],at(()=>l=!1)),e.$set(u)},i(r){n||(L(e.$$.fragment,r),n=!0)},o(r){E(e.$$.fragment,r),n=!1},d(r){B(e,r)}}}function zl(t){let e,l,n,i,s,r,f,u=t[1]&&It(t);return{c(){u&&u.c(),e=$(),l=h("br"),n=$(),i=h("button"),i.textContent="Сохранить",a(i,"id","ctrl-s")},m(c,o){u&&u.m(c,o),b(c,e,o),b(c,l,o),b(c,n,o),b(c,i,o),s=!0,r||(f=C(i,"click",t[2]),r=!0)},p(c,[o]){c[1]?u?(u.p(c,o),o&2&&L(u,1)):(u=It(c),u.c(),L(u,1),u.m(e.parentNode,e)):u&&(me(),E(u,1,1,()=>{u=null}),_e())},i(c){s||(L(u),s=!0)},o(c){E(u),s=!1},d(c){c&&(g(e),g(l),g(n),g(i)),u&&u.d(c),r=!1,f()}}}function Vl(t,e,l){let n,i;M(t,rt,f=>l(0,n=f)),M(t,ne,f=>l(1,i=f));function s(){z(`/${i}`,{tree:n})}document.onkeydown=f=>{["KeyS","Enter"].includes(f.code)&&(f.ctrlKey||f.metaKey)&&(f.preventDefault(),s())};function r(f){n=f,rt.set(n)}return[n,i,s,r]}class ql extends x{constructor(e){super(),Z(this,e,Vl,zl,Q,{})}}function Bt(t){let e,l,n;function i(r){t[4](r)}let s={};return t[1]!==void 0&&(s.value=t[1]),e=new fl({props:s}),He.push(()=>dt(e,"value",i)),{c(){F(e.$$.fragment)},m(r,f){I(e,r,f),n=!0},p(r,f){const u={};!l&&f&2&&(l=!0,u.value=r[1],at(()=>l=!1)),e.$set(u)},i(r){n||(L(e.$$.fragment,r),n=!0)},o(r){E(e.$$.fragment,r),n=!1},d(r){B(e,r)}}}function Gl(t){let e,l,n,i,s,r,f,u,c=t[2]&&Bt(t);return{c(){c&&c.c(),e=$(),l=h("br"),n=$(),i=h("button"),s=O("Сохранить"),a(i,"id","ctrl-s"),a(i,"class",t[0])},m(o,m){c&&c.m(o,m),b(o,e,m),b(o,l,m),b(o,n,m),b(o,i,m),p(i,s),r=!0,f||(u=C(i,"click",t[3]),f=!0)},p(o,[m]){o[2]?c?(c.p(o,m),m&4&&L(c,1)):(c=Bt(o),c.c(),L(c,1),c.m(e.parentNode,e)):c&&(me(),E(c,1,1,()=>{c=null}),_e()),(!r||m&1)&&a(i,"class",o[0])},i(o){r||(L(c),r=!0)},o(o){E(c),r=!1},d(o){o&&(g(e),g(l),g(n),g(i)),c&&c.d(o),f=!1,u()}}}function Rl(t,e,l){let n,i;M(t,ft,u=>l(1,n=u)),M(t,ne,u=>l(2,i=u));let s="";function r(){z(`/${i}/access`,{access:n,wait:["accessText"]}),l(0,s="active"),setTimeout(()=>l(0,s=""),500)}document.onkeydown=u=>{["KeyS","Enter"].includes(u.code)&&(u.ctrlKey||u.metaKey)&&(u.preventDefault(),r())};function f(u){n=u,ft.set(n)}return[s,n,i,r,f]}class Ul extends x{constructor(e){super(),Z(this,e,Rl,Gl,Q,{})}}function Kt(t,e,l){const n=t.slice();return n[2]=e[l],n}function Ft(t){let e,l,n=t[2].created+"",i,s,r,f=t[2].author_email+"",u,c,o,m=t[2].target_name+"",d,w,k,v,y=t[2].up_name+"",P,X,le,he,Ce;return{c(){e=h("tr"),l=h("td"),i=O(n),s=$(),r=h("td"),u=O(f),c=$(),o=h("td"),d=O(m),w=$(),k=h("td"),v=h("a"),P=O(y),le=$(),a(v,"href",X="/"+t[1]+"/logUp/"+t[2].id)},m(K,ee){b(K,e,ee),p(e,l),p(l,i),p(e,s),p(e,r),p(r,u),p(e,c),p(e,o),p(o,d),p(e,w),p(e,k),p(k,v),p(v,P),p(e,le),he||(Ce=C(v,"click",z),he=!0)},p(K,ee){ee&1&&n!==(n=K[2].created+"")&&W(i,n),ee&1&&f!==(f=K[2].author_email+"")&&W(u,f),ee&1&&m!==(m=K[2].target_name+"")&&W(d,m),ee&1&&y!==(y=K[2].up_name+"")&&W(P,y),ee&3&&X!==(X="/"+K[1]+"/logUp/"+K[2].id)&&a(v,"href",X)},d(K){K&&g(e),he=!1,Ce()}}}function Jl(t){let e,l,n,i,s,r,f,u=Y(t[0]),c=[];for(let o=0;o<u.length;o+=1)c[o]=Ft(Kt(t,u,o));return{c(){e=h("p"),e.textContent='Если вы пользуетесь только для себя, то у вас не возникнет вопроса из серии "чьи ручонки что-то изменили?"',l=$(),n=h("br"),i=$(),s=h("br"),r=$(),f=h("table");for(let o=0;o<c.length;o+=1)c[o].c();a(f,"class","loglist")},m(o,m){b(o,e,m),b(o,l,m),b(o,n,m),b(o,i,m),b(o,s,m),b(o,r,m),b(o,f,m);for(let d=0;d<c.length;d+=1)c[d]&&c[d].m(f,null)},p(o,[m]){if(m&3){u=Y(o[0]);let d;for(d=0;d<u.length;d+=1){const w=Kt(o,u,d);c[d]?c[d].p(w,m):(c[d]=Ft(w),c[d].c(),c[d].m(f,null))}for(;d<c.length;d+=1)c[d].d(1);c.length=u.length}},i:N,o:N,d(o){o&&(g(e),g(l),g(n),g(i),g(s),g(r),g(f)),Le(c,o)}}}function Wl(t,e,l){let n,i;return M(t,rl,s=>l(0,n=s)),M(t,ne,s=>l(1,i=s)),[n,i]}class Xl extends x{constructor(e){super(),Z(this,e,Wl,Jl,Q,{})}}function zt(t){let e;function l(s,r){return s[5]==s[0]?Ql:Yl}let n=l(t),i=n(t);return{c(){i.c(),e=Me()},m(s,r){i.m(s,r),b(s,e,r)},p(s,r){n===(n=l(s))&&i?i.p(s,r):(i.d(1),i=n(s),i&&(i.c(),i.m(e.parentNode,e)))},d(s){s&&g(e),i.d(s)}}}function Yl(t){let e,l=t[6][t[0]]+"",n,i,s;return{c(){e=h("a"),a(e,"href",t[1]),a(e,"class",n="a "+t[2]),a(e,"title",t[3])},m(r,f){b(r,e,f),e.innerHTML=l,i||(s=C(e,"click",function(){ut(t[4])&&t[4].apply(this,arguments)}),i=!0)},p(r,f){t=r,f&65&&l!==(l=t[6][t[0]]+"")&&(e.innerHTML=l),f&2&&a(e,"href",t[1]),f&4&&n!==(n="a "+t[2])&&a(e,"class",n),f&8&&a(e,"title",t[3])},d(r){r&&g(e),i=!1,s()}}}function Ql(t){let e,l=t[6][t[0]]+"",n;return{c(){e=h("span"),a(e,"class",n="a "+t[0]+" "+t[2]),a(e,"title",t[3])},m(i,s){b(i,e,s),e.innerHTML=l},p(i,s){s&65&&l!==(l=i[6][i[0]]+"")&&(e.innerHTML=l),s&5&&n!==(n="a "+i[0]+" "+i[2])&&a(e,"class",n),s&8&&a(e,"title",i[3])},d(i){i&&g(e)}}}function Zl(t){let e,l=t[0]in t[6]&&zt(t);return{c(){l&&l.c(),e=Me()},m(n,i){l&&l.m(n,i),b(n,e,i)},p(n,[i]){n[0]in n[6]?l?l.p(n,i):(l=zt(n),l.c(),l.m(e.parentNode,e)):l&&(l.d(1),l=null)},i:N,o:N,d(n){n&&g(e),l&&l.d(n)}}}function xl(t,e,l){let n,i,s;M(t,Ne,m=>l(7,i=m)),M(t,Pe,m=>l(6,s=m));let{key:r}=e,{href:f}=e,{cls:u=""}=e,{title:c=""}=e,{click:o=z}=e;return t.$$set=m=>{"key"in m&&l(0,r=m.key),"href"in m&&l(1,f=m.href),"cls"in m&&l(2,u=m.cls),"title"in m&&l(3,c=m.title),"click"in m&&l(4,o=m.click)},t.$$.update=()=>{t.$$.dirty&128&&l(5,n=i.level[1]||"view")},[r,f,u,c,o,n,s,i]}class Te extends x{constructor(e){super(),Z(this,e,xl,Zl,Q,{key:0,href:1,cls:2,title:3,click:4})}}function Vt(t,e,l){const n=t.slice();return n[11]=e[l],n}function qt(t,e,l){const n=t.slice();return n[11]=e[l],n}function Gt(t,e,l){const n=t.slice();return n[11]=e[l],n}function Rt(t){let e,l,n,i,s=t[11].name+"",r,f,u,c,o;return{c(){e=h("i"),n=$(),i=h("a"),r=O(s),a(e,"class",l="sep "+t[11]._pub+" "+t[11]._cur),a(i,"href",f="/"+t[11].id),a(i,"class",u=t[11]._cur)},m(m,d){b(m,e,d),b(m,n,d),b(m,i,d),p(i,r),c||(o=C(i,"click",z),c=!0)},p(m,d){d&2&&l!==(l="sep "+m[11]._pub+" "+m[11]._cur)&&a(e,"class",l),d&2&&s!==(s=m[11].name+"")&&W(r,s),d&2&&f!==(f="/"+m[11].id)&&a(i,"href",f),d&2&&u!==(u=m[11]._cur)&&a(i,"class",u)},d(m){m&&(g(e),g(n),g(i)),c=!1,o()}}}function Ut(t){let e,l=t[11].name+"",n,i,s,r,f;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[11].id),a(e,"class",s=t[11]._cur+" "+t[11]._pub+" nav")},m(u,c){b(u,e,c),p(e,n),r||(f=C(e,"click",z),r=!0)},p(u,c){c&2&&l!==(l=u[11].name+"")&&W(n,l),c&2&&i!==(i="/"+u[11].id)&&a(e,"href",i),c&2&&s!==(s=u[11]._cur+" "+u[11]._pub+" nav")&&a(e,"class",s)},d(u){u&&g(e),r=!1,f()}}}function en(t){let e;return{c(){e=h("div"),a(e,"class","empty")},m(l,n){b(l,e,n)},p:N,d(l){l&&g(e)}}}function tn(t){let e,l=t[11].name+"",n,i,s,r,f;return{c(){e=h("a"),n=O(l),a(e,"href",i="/"+t[11].id),a(e,"class",s=t[11]._prj+" "+t[11]._act+(t[11].id?"":"empty")),qe(e,"padding-left",t[11].space/2+"ch")},m(u,c){b(u,e,c),p(e,n),r||(f=C(e,"click",z),r=!0)},p(u,c){c&256&&l!==(l=u[11].name+"")&&W(n,l),c&256&&i!==(i="/"+u[11].id)&&a(e,"href",i),c&256&&s!==(s=u[11]._prj+" "+u[11]._act+(u[11].id?"":"empty"))&&a(e,"class",s),c&256&&qe(e,"padding-left",u[11].space/2+"ch")},d(u){u&&g(e),r=!1,f()}}}function Jt(t){let e;function l(s,r){return s[11].id?tn:en}let n=l(t),i=n(t);return{c(){i.c(),e=Me()},m(s,r){i.m(s,r),b(s,e,r)},p(s,r){n===(n=l(s))&&i?i.p(s,r):(i.d(1),i=n(s),i&&(i.c(),i.m(e.parentNode,e)))},d(s){s&&g(e),i.d(s)}}}function Wt(t){let e,l,n,i,s="&#9741;",r,f,u,c;return l=new Te({props:{key:"view",href:"/"+t[3].level[0]}}),{c(){e=h("div"),F(l.$$.fragment),n=$(),i=h("a"),a(i,"href",r="/"+t[3].level[0]+"/accessLink"),a(i,"class","a icon"),a(i,"title","Поделиться ссылкой"),a(e,"class","group1")},m(o,m){b(o,e,m),I(l,e,null),p(e,n),p(e,i),i.innerHTML=s,f=!0,u||(c=C(i,"click",t[10]),u=!0)},p(o,m){const d={};m&8&&(d.href="/"+o[3].level[0]),l.$set(d),(!f||m&8&&r!==(r="/"+o[3].level[0]+"/accessLink"))&&a(i,"href",r)},i(o){f||(L(l.$$.fragment,o),f=!0)},o(o){E(l.$$.fragment,o),f=!1},d(o){o&&g(e),B(l),u=!1,c()}}}function Xt(t){let e,l,n,i,s;l=new Te({props:{key:"tree",href:"/"+t[3].level[0]+"/tree"}});let r=t[9]===!1&&Yt(t),f=t[9]===!0&&Qt(t);return{c(){e=h("div"),F(l.$$.fragment),n=$(),r&&r.c(),i=$(),f&&f.c(),a(e,"class","group1")},m(u,c){b(u,e,c),I(l,e,null),p(e,n),r&&r.m(e,null),p(e,i),f&&f.m(e,null),s=!0},p(u,c){const o={};c&8&&(o.href="/"+u[3].level[0]+"/tree"),l.$set(o),u[9]===!1?r?r.p(u,c):(r=Yt(u),r.c(),r.m(e,i)):r&&(r.d(1),r=null),u[9]===!0?f?f.p(u,c):(f=Qt(u),f.c(),f.m(e,null)):f&&(f.d(1),f=null)},i(u){s||(L(l.$$.fragment,u),s=!0)},o(u){E(l.$$.fragment,u),s=!1},d(u){u&&g(e),B(l),r&&r.d(),f&&f.d()}}}function Yt(t){let e,l,n,i,s;return{c(){e=h("a"),l=O("+"),a(e,"href",n="/"+t[3].level[0]+"/treeAdd"),a(e,"class","a icon"),a(e,"title","Выделить проект")},m(r,f){b(r,e,f),p(e,l),i||(s=C(e,"click",z),i=!0)},p(r,f){f&8&&n!==(n="/"+r[3].level[0]+"/treeAdd")&&a(e,"href",n)},d(r){r&&g(e),i=!1,s()}}}function Qt(t){let e,l,n,i,s;return{c(){e=h("a"),l=O("-"),a(e,"href",n="/"+t[3].level[0]+"/treeDel"),a(e,"class","a icon"),a(e,"title","Отменить проект")},m(r,f){b(r,e,f),p(e,l),i||(s=C(e,"click",z),i=!0)},p(r,f){f&8&&n!==(n="/"+r[3].level[0]+"/treeDel")&&a(e,"href",n)},d(r){r&&g(e),i=!1,s()}}}function ln(t){let e,l;return e=new Xl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function nn(t){let e,l;return e=new Ul({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function rn(t){let e,l;return e=new ql({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function sn(t){let e,l;return e=new Dl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function fn(t){let e,l;return e=new Bl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function un(t){let e,l,n,i,s,r,f,u,c,o,m,d,w=(t[4].name||"")+"",k,v,y,P,X,le,he,Ce,K,ee,ge,Oe,Ie=t[2].name+"",Je,Be,gt,D,We,fe,bt,Xe,ue,vt,ce,kt,oe,Ke,Ye,R,J,je,te,Qe,wt;document.title=e=t[7];let be=Y(t[1]),V=[];for(let _=0;_<be.length;_+=1)V[_]=Rt(Gt(t,be,_));let ve=Y(t[1]),q=[];for(let _=0;_<ve.length;_+=1)q[_]=Ut(qt(t,ve,_));let ke=Y(t[8]),G=[];for(let _=0;_<ke.length;_+=1)G[_]=Jt(Vt(t,ke,_));let j="view"in t[2]&&Wt(t);fe=new Te({props:{key:"line",href:"/"+t[3].level[0]+"/line"}});let A="tree"in t[2]&&Xt(t);ue=new Te({props:{key:"access",href:"/"+t[3].level[0]+"/access"}}),ce=new Te({props:{key:"log",href:"/"+t[3].level[0]+"/log"}}),oe=new Te({props:{key:"bye",href:"/bye/"+t[6]}});const $t=[fn,sn,rn,nn,ln],ae=[];function yt(_,S){return _[0]=="view"?0:_[0]=="line"?1:_[0]=="tree"?2:_[0]=="access"?3:_[0]=="log"?4:-1}return~(R=yt(t))&&(J=ae[R]=$t[R](t)),{c(){l=$(),n=h("div"),i=h("div"),s=h("a"),s.textContent="Taris",r=$();for(let _=0;_<V.length;_+=1)V[_].c();f=$(),u=h("div"),c=h("i"),m=$(),d=h("span"),k=O(w),v=$(),y=h("div"),P=h("div"),X=h("div"),le=h("a"),le.textContent="Taris",he=$();for(let _=0;_<q.length;_+=1)q[_].c();Ce=$(),K=h("div");for(let _=0;_<G.length;_+=1)G[_].c();ee=$(),ge=h("div"),Oe=h("div"),Je=O(Ie),gt=$(),D=h("div"),j&&j.c(),We=$(),F(fe.$$.fragment),bt=$(),A&&A.c(),Xe=$(),F(ue.$$.fragment),vt=$(),F(ce.$$.fragment),kt=$(),F(oe.$$.fragment),Ye=$(),J&&J.c(),je=Me(),a(s,"href","/"),a(s,"class","logo"),a(i,"class","bc"),a(c,"class",o="sep "+t[4]._cur+" "+t[4]._pub),a(d,"class","name"),a(le,"href","/"),a(le,"class","logo"),a(X,"class","bc2"),a(K,"class","tree2"),a(P,"class","wrap"),a(y,"class","menu"),a(u,"class","bcm"),a(Oe,"class",Be="name "+t[5]),a(D,"class",Ke="menu "+t[5]),a(ge,"class","burger"),a(n,"class","nav1")},m(_,S){b(_,l,S),b(_,n,S),p(n,i),p(i,s),p(i,r);for(let H=0;H<V.length;H+=1)V[H]&&V[H].m(i,null);p(n,f),p(n,u),p(u,c),p(u,m),p(u,d),p(d,k),p(u,v),p(u,y),p(y,P),p(P,X),p(X,le),p(X,he);for(let H=0;H<q.length;H+=1)q[H]&&q[H].m(X,null);p(P,Ce),p(P,K);for(let H=0;H<G.length;H+=1)G[H]&&G[H].m(K,null);p(n,ee),p(n,ge),p(ge,Oe),p(Oe,Je),p(ge,gt),p(ge,D),j&&j.m(D,null),p(D,We),I(fe,D,null),p(D,bt),A&&A.m(D,null),p(D,Xe),I(ue,D,null),p(D,vt),I(ce,D,null),p(D,kt),I(oe,D,null),b(_,Ye,S),~R&&ae[R].m(_,S),b(_,je,S),te=!0,Qe||(wt=[C(s,"click",Se),C(le,"click",Se)],Qe=!0)},p(_,[S]){if((!te||S&128)&&e!==(e=_[7])&&(document.title=e),S&2){be=Y(_[1]);let T;for(T=0;T<be.length;T+=1){const ie=Gt(_,be,T);V[T]?V[T].p(ie,S):(V[T]=Rt(ie),V[T].c(),V[T].m(i,null))}for(;T<V.length;T+=1)V[T].d(1);V.length=be.length}if((!te||S&16&&o!==(o="sep "+_[4]._cur+" "+_[4]._pub))&&a(c,"class",o),(!te||S&16)&&w!==(w=(_[4].name||"")+"")&&W(k,w),S&2){ve=Y(_[1]);let T;for(T=0;T<ve.length;T+=1){const ie=qt(_,ve,T);q[T]?q[T].p(ie,S):(q[T]=Ut(ie),q[T].c(),q[T].m(X,null))}for(;T<q.length;T+=1)q[T].d(1);q.length=ve.length}if(S&256){ke=Y(_[8]);let T;for(T=0;T<ke.length;T+=1){const ie=Vt(_,ke,T);G[T]?G[T].p(ie,S):(G[T]=Jt(ie),G[T].c(),G[T].m(K,null))}for(;T<G.length;T+=1)G[T].d(1);G.length=ke.length}(!te||S&4)&&Ie!==(Ie=_[2].name+"")&&W(Je,Ie),(!te||S&32&&Be!==(Be="name "+_[5]))&&a(Oe,"class",Be),"view"in _[2]?j?(j.p(_,S),S&4&&L(j,1)):(j=Wt(_),j.c(),L(j,1),j.m(D,We)):j&&(me(),E(j,1,1,()=>{j=null}),_e());const H={};S&8&&(H.href="/"+_[3].level[0]+"/line"),fe.$set(H),"tree"in _[2]?A?(A.p(_,S),S&4&&L(A,1)):(A=Xt(_),A.c(),L(A,1),A.m(D,Xe)):A&&(me(),E(A,1,1,()=>{A=null}),_e());const Tt={};S&8&&(Tt.href="/"+_[3].level[0]+"/access"),ue.$set(Tt);const Lt={};S&8&&(Lt.href="/"+_[3].level[0]+"/log"),ce.$set(Lt);const Et={};S&64&&(Et.href="/bye/"+_[6]),oe.$set(Et),(!te||S&32&&Ke!==(Ke="menu "+_[5]))&&a(D,"class",Ke);let Ze=R;R=yt(_),R!==Ze&&(J&&(me(),E(ae[Ze],1,1,()=>{ae[Ze]=null}),_e()),~R?(J=ae[R],J||(J=ae[R]=$t[R](_),J.c()),L(J,1),J.m(je.parentNode,je)):J=null)},i(_){te||(L(j),L(fe.$$.fragment,_),L(A),L(ue.$$.fragment,_),L(ce.$$.fragment,_),L(oe.$$.fragment,_),L(J),te=!0)},o(_){E(j),E(fe.$$.fragment,_),E(A),E(ue.$$.fragment,_),E(ce.$$.fragment,_),E(oe.$$.fragment,_),E(J),te=!1},d(_){_&&(g(l),g(n),g(Ye),g(je)),Le(V,_),Le(q,_),Le(G,_),j&&j.d(),B(fe),A&&A.d(),B(ue),B(ce),B(oe),~R&&ae[R].d(_),Qe=!1,se(wt)}}}function cn(t,e,l){let n,i,s,r,f,u,c,o,m,d;M(t,pt,k=>l(1,f=k)),M(t,Pe,k=>l(2,u=k)),M(t,Ne,k=>l(3,c=k)),M(t,ht,k=>l(7,o=k)),M(t,Re,k=>l(8,m=k)),M(t,_t,k=>l(9,d=k));function w(k){z(k,{},v=>navigator.clipboard.writeText(`https://taris.pro${v.href}`))}return t.$$.update=()=>{t.$$.dirty&8&&l(0,n=c.level[1]||""),t.$$.dirty&1&&l(0,n={[n]:"view",line:"line",tree:"tree",access:"access",log:"log"}[n]),t.$$.dirty&2&&l(6,i=f[0]?f[0].name:""),t.$$.dirty&4&&l(5,s=Object.keys(u).length<2?"empty":""),t.$$.dirty&2&&l(4,r=f[0]?f[f.length-1]:"")},[n,f,u,c,r,s,i,o,m,d,w]}class on extends x{constructor(e){super(),Z(this,e,cn,un,Q,{})}}function an(t){let e,l;return e=new on({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function dn(t){let e,l;return e=new Nl({}),{c(){F(e.$$.fragment)},m(n,i){I(e,n,i),l=!0},i(n){l||(L(e.$$.fragment,n),l=!0)},o(n){E(e.$$.fragment,n),l=!1},d(n){B(e,n)}}}function mn(t){let e,l=t[0]!=""?`<pre class="apierr">${t[0]}</pre>`:"",n,i,s,r,f,u;const c=[dn,an],o=[];function m(d,w){return w&2&&(i=null),d[1].path=="/"?0:(i==null&&(i=Number(d[1].level[0])>0),i?1:-1)}return~(s=m(t,-1))&&(r=o[s]=c[s](t)),{c(){e=new _l(!1),n=$(),r&&r.c(),f=Me(),e.a=n},m(d,w){e.m(l,d,w),b(d,n,w),~s&&o[s].m(d,w),b(d,f,w),u=!0},p(d,[w]){(!u||w&1)&&l!==(l=d[0]!=""?`<pre class="apierr">${d[0]}</pre>`:"")&&e.p(l);let k=s;s=m(d,w),s!==k&&(r&&(me(),E(o[k],1,1,()=>{o[k]=null}),_e()),~s?(r=o[s],r||(r=o[s]=c[s](d),r.c()),L(r,1),r.m(f.parentNode,f)):r=null)},i(d){u||(L(r),u=!0)},o(d){E(r),u=!1},d(d){d&&(e.d(),g(n),g(f)),~s&&o[s].d(d)}}}function _n(t,e,l){let n,i;return M(t,Ge,s=>l(0,n=s)),M(t,Ne,s=>l(1,i=s)),[n,i]}class pn extends x{constructor(e){super(),Z(this,e,_n,mn,Q,{})}}new pn({target:document.getElementById("app")});
