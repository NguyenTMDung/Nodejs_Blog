(()=>{"use strict";var e={};function t(e,t){(null==t||t>e.length)&&(t=e.length);for(var n=0,r=new Array(t);n<t;n++)r[n]=e[n];return r}e.n=t=>{var n=t&&t.__esModule?()=>t.default:()=>t;return e.d(n,{a:n}),n},e.d=(t,n)=>{for(var r in n)e.o(n,r)&&!e.o(t,r)&&Object.defineProperty(t,r,{enumerable:!0,get:n[r]})},e.o=(e,t)=>Object.prototype.hasOwnProperty.call(e,t);const n=window.tinymce;var r=e.n(n),o=function(e){return Object.keys(e).map((function(t){return{text:e[Number(t)],value:t}}))},a=function(e,t){return{text:t.getLang("code_snippets.insert_source_menu"),onclick:function(){e.windowManager.open({title:t.getLang("code_snippets.insert_source_title"),body:[{type:"listbox",name:"id",label:t.getLang("code_snippets.snippet_label"),values:o(t.getLang("code_snippets.all_snippets"))},{type:"checkbox",name:"line_numbers",label:t.getLang("code_snippets.show_line_numbers_label")}],onsubmit:function(t){var n=parseInt(t.data.id,10);if(n){var r="";t.data.line_numbers&&(r+=" line_numbers=true"),e.insertContent("[code_snippet_source id=".concat(n).concat(r,"]"))}}},{})}}},i=function(e,n){return{text:n.getLang("code_snippets.insert_content_menu"),onclick:function(){e.windowManager.open({title:n.getLang("code_snippets.insert_content_title"),body:[{type:"listbox",name:"id",label:n.getLang("code_snippets.snippet_label"),values:o(n.getLang("code_snippets.content_snippets"))},{type:"checkbox",name:"php",label:n.getLang("code_snippets.php_att_label")},{type:"checkbox",name:"format",label:n.getLang("code_snippets.format_att_label")},{type:"checkbox",name:"shortcodes",label:n.getLang("code_snippets.shortcodes_att_label")}],onsubmit:function(n){var r,o,a=parseInt(n.data.id,10);if(a){for(var i="",c=0,s=Object.entries(n.data);c<s.length;c++){var l=(r=s[c],o=2,function(e){if(Array.isArray(e))return e}(r)||function(e,t){var n=null==e?null:"undefined"!=typeof Symbol&&e[Symbol.iterator]||e["@@iterator"];if(null!=n){var r,o,a,i,c=[],s=!0,l=!1;try{if(a=(n=n.call(e)).next,0===t){if(Object(n)!==n)return;s=!1}else for(;!(s=(r=a.call(n)).done)&&(c.push(r.value),c.length!==t);s=!0);}catch(e){l=!0,o=e}finally{try{if(!s&&null!=n.return&&(i=n.return(),Object(i)!==i))return}finally{if(l)throw o}}return c}}(r,o)||function(e,n){if(e){if("string"==typeof e)return t(e,n);var r=Object.prototype.toString.call(e).slice(8,-1);return"Object"===r&&e.constructor&&(r=e.constructor.name),"Map"===r||"Set"===r?Array.from(e):"Arguments"===r||/^(?:Ui|I)nt(?:8|16|32)(?:Clamped)?Array$/.test(r)?t(e,n):void 0}}(r,o)||function(){throw new TypeError("Invalid attempt to destructure non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}()),p=l[0],u=l[1];"id"!==p&&u&&(i+=" ".concat(p,"=").concat(u))}e.insertContent("[code_snippet id=".concat(a).concat(i,"]"))}}},{})}}};r().PluginManager.add("code_snippets",(function(e){var t=r().activeEditor;e.addButton("code_snippets",{icon:"code",menu:[a(e,t),i(e,t)],type:"menubutton"})}))})();