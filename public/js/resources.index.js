(()=>{const e=document.getElementById("sidebar"),t=document.getElementById("sidebar-toggle"),s=document.getElementById("catalog");t.addEventListener("click",(()=>{const t=e.classList.contains("hidden");e.classList.toggle("hidden",!t),e.classList.toggle("w-64",!t),e.classList.toggle("w-full",t),s.classList.toggle("hidden",t)})),window.addEventListener("resize",(function(){const s=e.classList.contains("hidden");window.innerWidth>=640&&!s&&t.click()}))})();
