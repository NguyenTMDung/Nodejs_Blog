"use strict";(self.webpackChunkwebpackWcBlocksFrontendJsonp=self.webpackChunkwebpackWcBlocksFrontendJsonp||[]).push([[28],{1579:(t,e,o)=>{o.r(e),o.d(e,{Block:()=>i,default:()=>u});var l=o(1609),n=o(851),r=o(2796),s=o(3249),a=o(7723),c=o(1616);const i=t=>{const{textAlign:e}=t,o=(0,s.p)(t),{product:c}=(0,r.useProductDataContext)(),i=(0,n.A)(o.className,"wc-block-components-product-average-rating",{[`has-text-align-${e}`]:e});return(0,l.createElement)("div",{className:i,style:o.style},Number(c.average_rating)>0?c.average_rating:(0,a.__)("No ratings","woocommerce"))},u=(0,c.withProductDataContext)(i)},3249:(t,e,o)=>{o.d(e,{p:()=>i});var l=o(851),n=o(3993),r=o(1194),s=o(9786);function a(t={}){const e={};return(0,s.getCSSRules)(t,{selector:""}).forEach((t=>{e[t.key]=t.value})),e}function c(t,e){return t&&e?`has-${(0,r.c)(e)}-${t}`:""}const i=t=>{const e=(t=>{const e=(0,n.isObject)(t)?t:{style:{}};let o=e.style;return(0,n.isString)(o)&&(o=JSON.parse(o)||{}),(0,n.isObject)(o)||(o={}),{...e,style:o}})(t),o=function(t){var e,o,r,s,i,u,d;const{backgroundColor:v,textColor:y,gradient:g,style:f}=t,m=c("background-color",v),p=c("color",y),b=function(t){if(t)return`has-${t}-gradient-background`}(g),h=b||(null==f||null===(e=f.color)||void 0===e?void 0:e.gradient);return{className:(0,l.A)(p,b,{[m]:!h&&!!m,"has-text-color":y||(null==f||null===(o=f.color)||void 0===o?void 0:o.text),"has-background":v||(null==f||null===(r=f.color)||void 0===r?void 0:r.background)||g||(null==f||null===(s=f.color)||void 0===s?void 0:s.gradient),"has-link-color":(0,n.isObject)(null==f||null===(i=f.elements)||void 0===i?void 0:i.link)?null==f||null===(u=f.elements)||void 0===u||null===(d=u.link)||void 0===d?void 0:d.color:void 0}),style:a({color:(null==f?void 0:f.color)||{}})}}(e),r=function(t){var e;const o=(null===(e=t.style)||void 0===e?void 0:e.border)||{};return{className:function(t){var e;const{borderColor:o,style:n}=t,r=o?c("border-color",o):"";return(0,l.A)({"has-border-color":!!o||!(null==n||null===(e=n.border)||void 0===e||!e.color),[r]:!!r})}(t),style:a({border:o})}}(e),s=function(t){var e;return{className:void 0,style:a({spacing:(null===(e=t.style)||void 0===e?void 0:e.spacing)||{}})}}(e),i=(t=>{const e=(0,n.isObject)(t.style.typography)?t.style.typography:{},o=(0,n.isString)(e.fontFamily)?e.fontFamily:"";return{className:t.fontFamily?`has-${t.fontFamily}-font-family`:o,style:{fontSize:t.fontSize?`var(--wp--preset--font-size--${t.fontSize})`:e.fontSize,fontStyle:e.fontStyle,fontWeight:e.fontWeight,letterSpacing:e.letterSpacing,lineHeight:e.lineHeight,textDecoration:e.textDecoration,textTransform:e.textTransform}}})(e);return{className:(0,l.A)(i.className,o.className,r.className,s.className),style:{...i.style,...o.style,...r.style,...s.style}}}}}]);