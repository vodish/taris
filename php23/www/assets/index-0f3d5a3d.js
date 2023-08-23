var xe=Object.defineProperty;var Ee=(t,e,r)=>e in t?xe(t,e,{enumerable:!0,configurable:!0,writable:!0,value:r}):t[e]=r;var S=(t,e,r)=>(Ee(t,typeof e!="symbol"?e+"":e,r),r);(function(){const e=document.createElement("link").relList;if(e&&e.supports&&e.supports("modulepreload"))return;for(const i of document.querySelectorAll('link[rel="modulepreload"]'))n(i);new MutationObserver(i=>{for(const c of i)if(c.type==="childList")for(const u of c.addedNodes)u.tagName==="LINK"&&u.rel==="modulepreload"&&n(u)}).observe(document,{childList:!0,subtree:!0});function r(i){const c={};return i.integrity&&(c.integrity=i.integrity),i.referrerPolicy&&(c.referrerPolicy=i.referrerPolicy),i.crossOrigin==="use-credentials"?c.credentials="include":i.crossOrigin==="anonymous"?c.credentials="omit":c.credentials="same-origin",c}function n(i){if(i.ep)return;i.ep=!0;const c=r(i);fetch(i.href,c)}})();function y(){}function $e(t){return t()}function de(){return Object.create(null)}function j(t){t.forEach($e)}function he(t){return typeof t=="function"}function P(t,e){return t!=t?e==e:t!==e||t&&typeof t=="object"||typeof t=="function"}function Pe(t){return Object.keys(t).length===0}function Le(t,...e){if(t==null){for(const n of e)n(void 0);return y}const r=t.subscribe(...e);return r.unsubscribe?()=>r.unsubscribe():r}function W(t,e,r){t.$$.on_destroy.push(Le(e,r))}function x(t,e){t.appendChild(e)}function d(t,e,r){t.insertBefore(e,r||null)}function a(t){t.parentNode&&t.parentNode.removeChild(t)}function $(t){return document.createElement(t)}function Ne(t){return document.createElementNS("http://www.w3.org/2000/svg",t)}function X(t){return document.createTextNode(t)}function v(){return X(" ")}function ie(){return X("")}function H(t,e,r,n){return t.addEventListener(e,r,n),()=>t.removeEventListener(e,r,n)}function Q(t,e,r){r==null?t.removeAttribute(e):t.getAttribute(e)!==r&&t.setAttribute(e,r)}function Ae(t){return Array.from(t.childNodes)}class Ce{constructor(e=!1){S(this,"is_svg",!1);S(this,"e");S(this,"n");S(this,"t");S(this,"a");this.is_svg=e,this.e=this.n=null}c(e){this.h(e)}m(e,r,n=null){this.e||(this.is_svg?this.e=Ne(r.nodeName):this.e=$(r.nodeType===11?"TEMPLATE":r.nodeName),this.t=r.tagName!=="TEMPLATE"?r:r.content,this.c(e)),this.i(n)}h(e){this.e.innerHTML=e,this.n=Array.from(this.e.nodeName==="TEMPLATE"?this.e.content.childNodes:this.e.childNodes)}i(e){for(let r=0;r<this.n.length;r+=1)d(this.t,this.n[r],e)}p(e){this.d(),this.h(e),this.i(this.a)}d(){this.n.forEach(a)}}let R;function K(t){R=t}function be(){if(!R)throw new Error("Function called outside component initialization");return R}function ge(t){be().$$.on_mount.push(t)}function ce(t){be().$$.on_destroy.push(t)}const B=[],U=[];let G=[];const te=[],Me=Promise.resolve();let ne=!1;function Oe(){ne||(ne=!0,Me.then(ye))}function re(t){G.push(t)}function se(t){te.push(t)}const ee=new Set;let I=0;function ye(){if(I!==0)return;const t=R;do{try{for(;I<B.length;){const e=B[I];I++,K(e),Te(e.$$)}}catch(e){throw B.length=0,I=0,e}for(K(null),B.length=0,I=0;U.length;)U.pop()();for(let e=0;e<G.length;e+=1){const r=G[e];ee.has(r)||(ee.add(r),r())}G.length=0}while(B.length);for(;te.length;)te.pop()();ne=!1,ee.clear(),K(t)}function Te(t){if(t.fragment!==null){t.update(),j(t.before_update);const e=t.dirty;t.dirty=[-1],t.fragment&&t.fragment.p(t.ctx,e),t.after_update.forEach(re)}}function Se(t){const e=[],r=[];G.forEach(n=>t.indexOf(n)===-1?e.push(n):r.push(n)),r.forEach(n=>n()),G=e}const J=new Set;let z;function ve(){z={r:0,c:[],p:z}}function ke(){z.r||j(z.c),z=z.p}function k(t,e){t&&t.i&&(J.delete(t),t.i(e))}function w(t,e,r,n){if(t&&t.o){if(J.has(t))return;J.add(t),z.c.push(()=>{J.delete(t),n&&(r&&t.d(1),n())}),t.o(e)}else n&&n()}function le(t,e,r){const n=t.$$.props[e];n!==void 0&&(t.$$.bound[n]=r,r(t.$$.ctx[n]))}function A(t){t&&t.c()}function L(t,e,r){const{fragment:n,after_update:i}=t.$$;n&&n.m(e,r),re(()=>{const c=t.$$.on_mount.map($e).filter(he);t.$$.on_destroy?t.$$.on_destroy.push(...c):j(c),t.$$.on_mount=[]}),i.forEach(re)}function N(t,e){const r=t.$$;r.fragment!==null&&(Se(r.after_update),j(r.on_destroy),r.fragment&&r.fragment.d(e),r.on_destroy=r.fragment=null,r.ctx=[])}function Ve(t,e){t.$$.dirty[0]===-1&&(B.push(t),Oe(),t.$$.dirty.fill(0)),t.$$.dirty[e/31|0]|=1<<e%31}function C(t,e,r,n,i,c,u,o=[-1]){const l=R;K(t);const s=t.$$={fragment:null,ctx:[],props:c,update:y,not_equal:i,bound:de(),on_mount:[],on_destroy:[],on_disconnect:[],before_update:[],after_update:[],context:new Map(e.context||(l?l.$$.context:[])),callbacks:de(),dirty:o,skip_bound:!1,root:e.target||l.$$.root};u&&u(s.root);let m=!1;if(s.ctx=r?r(t,e.props||{},(h,_,...f)=>{const p=f.length?f[0]:_;return s.ctx&&i(s.ctx[h],s.ctx[h]=p)&&(!s.skip_bound&&s.bound[h]&&s.bound[h](p),m&&Ve(t,h)),_}):[],s.update(),m=!0,j(s.before_update),s.fragment=n?n(s.ctx):!1,e.target){if(e.hydrate){const h=Ae(e.target);s.fragment&&s.fragment.l(h),h.forEach(a)}else s.fragment&&s.fragment.c();e.intro&&k(t.$$.fragment),L(t,e.target,e.anchor),ye()}K(l)}class M{constructor(){S(this,"$$");S(this,"$$set")}$destroy(){N(this,1),this.$destroy=y}$on(e,r){if(!he(r))return y;const n=this.$$.callbacks[e]||(this.$$.callbacks[e]=[]);return n.push(r),()=>{const i=n.indexOf(r);i!==-1&&n.splice(i,1)}}$set(e){this.$$set&&!Pe(e)&&(this.$$.skip_bound=!0,this.$$set(e),this.$$.skip_bound=!1)}}const ze="4";typeof window<"u"&&(window.__svelte||(window.__svelte={v:new Set})).v.add(ze);const q=[];function Y(t,e=y){let r;const n=new Set;function i(o){if(P(t,o)&&(t=o,r)){const l=!q.length;for(const s of n)s[1](),q.push(s,t);if(l){for(let s=0;s<q.length;s+=2)q[s][0](q[s+1]);q.length=0}}}function c(o){i(o(t))}function u(o,l=y){const s=[o,l];return n.add(s),n.size===1&&(r=e(i,c)||y),o(t),()=>{n.delete(s),n.size===0&&r&&(r(),r=null)}}return{set:i,update:c,subscribe:u}}let oe=Y({});ue();window.addEventListener("popstate",ue);function ue(){let t=window.location.pathname,e=t=="/"?[]:t.substring(1).split("/"),r=[];e.map((n,i)=>r[i]=`${i?r[i-1]:""}/${n}`),oe.set({path:t,level:e,dir:r})}function D(t=""){window.location.pathname!=t&&(window.history.pushState({},"",t),ue())}function je(t){let e,r,n;return{c(){e=$("hr"),r=v(),n=$("div"),n.textContent="Main.svelte"},m(i,c){d(i,e,c),d(i,r,c),d(i,n,c)},p:y,i:y,o:y,d(i){i&&(a(e),a(r),a(n))}}}class Fe extends M{constructor(e){super(),C(this,e,null,je,P,{})}}let Ie=Y("<div>yyy</div>"),_e=Y("line_content"),pe=Y("tree_content"),me=Y("access_content");function qe(t){let e;return{c(){e=$("div"),Q(e,"id","ace9"),Q(e,"class","ace")},m(r,n){d(r,e,n)},p:y,i:y,o:y,d(r){r&&a(e)}}}function Be(t,e,r){let{value:n=""}=e;return ge(()=>{let i=ace.edit("ace9");i.session.setMode("ace/mode/html"),i.setOptions({minLines:10,fontSize:"13px",fontFamily:"var(--font1)",showPrintMargin:!1,showGutter:!0,useWorker:!1,maxLines:1111,wrap:!0}),i.setValue(n,1),i.on("change",()=>r(0,n=i.getValue()))}),t.$$set=i=>{"value"in i&&r(0,n=i.value)},[n]}class He extends M{constructor(e){super(),C(this,e,Be,qe,P,{value:0})}}function De(t){let e,r,n,i,c,u,o,l,s;function m(_){t[1](_)}let h={};return t[0]!==void 0&&(h.value=t[0]),o=new He({props:h}),U.push(()=>le(o,"value",m)),{c(){e=$("p"),e.textContent="PackLine",r=v(),n=$("hr"),i=v(),c=$("br"),u=v(),A(o.$$.fragment)},m(_,f){d(_,e,f),d(_,r,f),d(_,n,f),d(_,i,f),d(_,c,f),d(_,u,f),L(o,_,f),s=!0},p(_,[f]){const p={};!l&&f&1&&(l=!0,p.value=_[0],se(()=>l=!1)),o.$set(p)},i(_){s||(k(o.$$.fragment,_),s=!0)},o(_){w(o.$$.fragment,_),s=!1},d(_){_&&(a(e),a(r),a(n),a(i),a(c),a(u)),N(o,_)}}}function Ge(t,e,r){let n;W(t,_e,c=>r(0,n=c)),ce(()=>{console.log("сохранить line_content на сервере")});function i(c){n=c,_e.set(n)}return[n,i]}class We extends M{constructor(e){super(),C(this,e,Ge,De,P,{})}}function Ke(t){let e,r,n,i,c,u,o,l;return{c(){e=$("p"),e.textContent="PackView",r=v(),n=$("hr"),i=v(),c=$("br"),u=v(),o=new Ce(!1),l=ie(),o.a=l},m(s,m){d(s,e,m),d(s,r,m),d(s,n,m),d(s,i,m),d(s,c,m),d(s,u,m),o.m(t[0],s,m),d(s,l,m)},p(s,[m]){m&1&&o.p(s[0])},i:y,o:y,d(s){s&&(a(e),a(r),a(n),a(i),a(c),a(u),a(l),o.d())}}}function Re(t,e,r){let n;return W(t,Ie,i=>r(0,n=i)),[n]}class Ue extends M{constructor(e){super(),C(this,e,Re,Ke,P,{})}}function Ye(t){let e;return{c(){e=$("div"),Q(e,"id","ace9"),Q(e,"class","ace")},m(r,n){d(r,e,n)},p:y,i:y,o:y,d(r){r&&a(e)}}}function Je(t,e,r){let{value:n=""}=e;return ge(()=>{let i=ace.edit("ace9");i.session.setMode("ace/mode/yaml"),i.setOptions({minLines:10,fontSize:"13px",fontFamily:"var(--font1)",showPrintMargin:!1,showGutter:!0,useWorker:!1,maxLines:1111,wrap:!0}),i.setValue(n,1),i.on("change",()=>r(0,n=i.getValue()))}),t.$$set=i=>{"value"in i&&r(0,n=i.value)},[n]}class we extends M{constructor(e){super(),C(this,e,Je,Ye,P,{value:0})}}function Qe(t){let e,r,n;function i(u){t[1](u)}let c={};return t[0]!==void 0&&(c.value=t[0]),e=new we({props:c}),U.push(()=>le(e,"value",i)),{c(){A(e.$$.fragment)},m(u,o){L(e,u,o),n=!0},p(u,[o]){const l={};!r&&o&1&&(r=!0,l.value=u[0],se(()=>r=!1)),e.$set(l)},i(u){n||(k(e.$$.fragment,u),n=!0)},o(u){w(e.$$.fragment,u),n=!1},d(u){N(e,u)}}}function Xe(t,e,r){let n;W(t,pe,c=>r(0,n=c)),ce(()=>{console.log("сохранить дерево проекта на сервере")});function i(c){n=c,pe.set(n)}return[n,i]}class Ze extends M{constructor(e){super(),C(this,e,Xe,Qe,P,{})}}function et(t){let e,r,n,i,c;function u(l){t[1](l)}let o={};return t[0]!==void 0&&(o.value=t[0]),n=new we({props:o}),U.push(()=>le(n,"value",u)),{c(){e=$("p"),e.textContent="PackAccess",r=v(),A(n.$$.fragment)},m(l,s){d(l,e,s),d(l,r,s),L(n,l,s),c=!0},p(l,[s]){const m={};!i&&s&1&&(i=!0,m.value=l[0],se(()=>i=!1)),n.$set(m)},i(l){c||(k(n.$$.fragment,l),c=!0)},o(l){w(n.$$.fragment,l),c=!1},d(l){l&&(a(e),a(r)),N(n,l)}}}function tt(t,e,r){let n;W(t,me,c=>r(0,n=c)),ce(()=>{console.log("обновить права на сервере")});function i(c){n=c,me.set(n)}return[n,i]}class nt extends M{constructor(e){super(),C(this,e,tt,et,P,{})}}function rt(t){let e,r;return e=new nt({}),{c(){A(e.$$.fragment)},m(n,i){L(e,n,i),r=!0},i(n){r||(k(e.$$.fragment,n),r=!0)},o(n){w(e.$$.fragment,n),r=!1},d(n){N(e,n)}}}function it(t){let e,r;return e=new Ze({}),{c(){A(e.$$.fragment)},m(n,i){L(e,n,i),r=!0},i(n){r||(k(e.$$.fragment,n),r=!0)},o(n){w(e.$$.fragment,n),r=!1},d(n){N(e,n)}}}function ct(t){let e,r;return e=new We({}),{c(){A(e.$$.fragment)},m(n,i){L(e,n,i),r=!0},i(n){r||(k(e.$$.fragment,n),r=!0)},o(n){w(e.$$.fragment,n),r=!1},d(n){N(e,n)}}}function st(t){let e,r;return e=new Ue({}),{c(){A(e.$$.fragment)},m(n,i){L(e,n,i),r=!0},i(n){r||(k(e.$$.fragment,n),r=!0)},o(n){w(e.$$.fragment,n),r=!1},d(n){N(e,n)}}}function lt(t){let e,r,n,i,c,u,o,l,s,m,h,_,f,p,O,b,E,F;const fe=[st,ct,it,rt],V=[];function ae(g,T){return g[0].level[1]==null?0:g[0].level[1]=="line"?1:g[0].level[1]=="tree"?2:g[0].level[1]=="access"?3:-1}return~(f=ae(t))&&(p=V[f]=fe[f](t)),{c(){e=$("hr"),r=v(),n=$("h4"),i=X(`Pack: \r
  `),c=$("button"),c.textContent="View",u=v(),o=$("button"),o.textContent="Line",l=v(),s=$("button"),s.textContent="Tree",m=v(),h=$("button"),h.textContent="Access",_=v(),p&&p.c(),O=ie()},m(g,T){d(g,e,T),d(g,r,T),d(g,n,T),x(n,i),x(n,c),x(n,u),x(n,o),x(n,l),x(n,s),x(n,m),x(n,h),d(g,_,T),~f&&V[f].m(g,T),d(g,O,T),b=!0,E||(F=[H(c,"click",t[1]),H(o,"click",t[2]),H(s,"click",t[3]),H(h,"click",t[4])],E=!0)},p(g,[T]){let Z=f;f=ae(g),f!==Z&&(p&&(ve(),w(V[Z],1,1,()=>{V[Z]=null}),ke()),~f?(p=V[f],p||(p=V[f]=fe[f](g),p.c()),k(p,1),p.m(O.parentNode,O)):p=null)},i(g){b||(k(p),b=!0)},o(g){w(p),b=!1},d(g){g&&(a(e),a(r),a(n),a(_),a(O)),~f&&V[f].d(g),E=!1,j(F)}}}function ot(t,e,r){let n;return W(t,oe,l=>r(0,n=l)),[n,()=>D("/1"),()=>D("/1/line"),()=>D("/1/tree"),()=>D("/1/access")]}class ut extends M{constructor(e){super(),C(this,e,ot,lt,P,{})}}function ft(t){let e,r;return e=new ut({}),{c(){A(e.$$.fragment)},m(n,i){L(e,n,i),r=!0},i(n){r||(k(e.$$.fragment,n),r=!0)},o(n){w(e.$$.fragment,n),r=!1},d(n){N(e,n)}}}function at(t){let e,r;return e=new Fe({}),{c(){A(e.$$.fragment)},m(n,i){L(e,n,i),r=!0},i(n){r||(k(e.$$.fragment,n),r=!0)},o(n){w(e.$$.fragment,n),r=!1},d(n){N(e,n)}}}function dt(t){let e,r,n,i,c,u,o,l,s,m,h,_;const f=[at,ft],p=[];function O(b,E){return b[0].path=="/"?0:+b[0].level[0]?1:-1}return~(o=O(t))&&(l=p[o]=f[o](t)),{c(){e=$("h3"),r=X(`Default: 
  `),n=$("button"),n.textContent="Main",i=v(),c=$("button"),c.textContent="Pack",u=v(),l&&l.c(),s=ie()},m(b,E){d(b,e,E),x(e,r),x(e,n),x(e,i),x(e,c),d(b,u,E),~o&&p[o].m(b,E),d(b,s,E),m=!0,h||(_=[H(n,"click",t[1]),H(c,"click",t[2])],h=!0)},p(b,[E]){let F=o;o=O(b),o!==F&&(l&&(ve(),w(p[F],1,1,()=>{p[F]=null}),ke()),~o?(l=p[o],l||(l=p[o]=f[o](b),l.c()),k(l,1),l.m(s.parentNode,s)):l=null)},i(b){m||(k(l),m=!0)},o(b){w(l),m=!1},d(b){b&&(a(e),a(u),a(s)),~o&&p[o].d(b),h=!1,j(_)}}}function _t(t,e,r){let n;return W(t,oe,u=>r(0,n=u)),[n,()=>D("/"),()=>D("/1")]}class pt extends M{constructor(e){super(),C(this,e,_t,dt,P,{})}}console.log(document.body.dataset.key);new pt({target:document.getElementById("app")});
