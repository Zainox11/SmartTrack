/* =====================================================
   SmartTrack — Core App JS
   ===================================================== */

/* ── Sidebar ── */
const Sidebar = (() => {
    const open  = () => { document.getElementById('sidebar')?.classList.add('open'); document.getElementById('sidebarOverlay')?.classList.add('show'); document.body.style.overflow='hidden'; };
    const close = () => { document.getElementById('sidebar')?.classList.remove('open'); document.getElementById('sidebarOverlay')?.classList.remove('show'); document.body.style.overflow=''; };
    const toggle = () => document.getElementById('sidebar')?.classList.contains('open') ? close() : open();
    return { open, close, toggle };
})();

/* ── Toast Notification ── */
const Toast = (() => {
    const show = (msg, type = 'success', dur = 3200) => {
        const cfg = {
            success:{ bg:'#F0FDF4',border:'#86EFAC',txt:'#166534',icon:'✓' },
            error:  { bg:'#FEF2F2',border:'#FECACA',txt:'#DC2626',icon:'✕' },
            info:   { bg:'#EFF6FF',border:'#BFDBFE',txt:'#1D4ED8',icon:'ℹ' },
            warning:{ bg:'#FFFBEB',border:'#FCD34D',txt:'#92400E',icon:'⚠' },
        };
        const c = cfg[type]||cfg.success;
        const el = document.createElement('div');
        el.style.cssText = `position:fixed;bottom:24px;right:24px;z-index:99999;background:${c.bg};border:1.5px solid ${c.border};border-radius:10px;padding:12px 16px;display:flex;align-items:center;gap:10px;box-shadow:0 8px 28px rgba(0,0,0,.10);min-width:220px;max-width:340px;font-size:13px;color:${c.txt};opacity:0;transform:translateY(10px);transition:all .3s ease;`;
        el.innerHTML = `<span style="font-size:15px;font-weight:700;">${c.icon}</span><span>${msg}</span>`;
        document.body.appendChild(el);
        requestAnimationFrame(()=>requestAnimationFrame(()=>{ el.style.opacity='1'; el.style.transform='translateY(0)'; }));
        setTimeout(()=>{ el.style.opacity='0'; el.style.transform='translateY(10px)'; setTimeout(()=>el.remove(),350); }, dur);
    };
    return { show };
})();

/* ── Animated Counter ── */
const Counter = (() => {
    const animate = el => {
        const target = parseInt(el.dataset.count,10); if(isNaN(target)) return;
        let start=0; const step=target/(1200/16);
        const t=setInterval(()=>{ start=Math.min(start+step,target); el.textContent=Math.floor(start); if(start>=target) clearInterval(t); },16);
    };
    return { initAll:()=>document.querySelectorAll('[data-count]').forEach(animate) };
})();

/* ── Donut Chart (SVG) ── */
const Donut = (() => {
    const draw = (svgEl, pct, color='#00C9A7', track='rgba(255,255,255,0.20)') => {
        const r=34,cx=40,cy=40,circ=2*Math.PI*r,filled=(pct/100)*circ;
        svgEl.setAttribute('viewBox','0 0 80 80'); svgEl.setAttribute('width','80'); svgEl.setAttribute('height','80');
        svgEl.innerHTML = `<circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="${track}" stroke-width="7"/><circle cx="${cx}" cy="${cy}" r="${r}" fill="none" stroke="${color}" stroke-width="7" stroke-dasharray="${filled} ${circ}" stroke-dashoffset="${circ*.25}" stroke-linecap="round"/>`;
    };
    return { initAll:()=>document.querySelectorAll('[data-donut]').forEach(el=>draw(el,parseFloat(el.dataset.donut)||0,el.dataset.donutColor||'#00C9A7',el.dataset.donutTrack||'rgba(255,255,255,0.20)')) };
})();

/* ── Sparkline (SVG) ── */
const Sparkline = (() => {
    const draw = (svgEl,values,color='rgba(255,255,255,0.85)',fill='rgba(255,255,255,0.15)') => {
        const W=120,H=52,max=Math.max(...values),min=Math.min(...values),range=max-min||1;
        const pts=values.map((v,i)=>`${(i/(values.length-1))*W},${H-((v-min)/range)*(H-8)-4}`);
        svgEl.setAttribute('viewBox',`0 0 ${W} ${H}`); svgEl.setAttribute('width',W); svgEl.setAttribute('height',H);
        svgEl.innerHTML=`<polygon points="0,${H} ${pts.join(' ')} ${W},${H}" fill="${fill}"/><polyline points="${pts.join(' ')}" fill="none" stroke="${color}" stroke-width="2" stroke-linejoin="round" stroke-linecap="round"/>`;
    };
    return { initAll:()=>document.querySelectorAll('[data-spark]').forEach(el=>draw(el,el.dataset.spark.split(',').map(Number),el.dataset.sparkColor||'rgba(255,255,255,0.85)',el.dataset.sparkFill||'rgba(255,255,255,0.15)')) };
})();

/* ── Progress Bar Animate ── */
const ProgressBars = { init:()=>setTimeout(()=>document.querySelectorAll('.pb-fill[data-w]').forEach(el=>{ el.style.width='0'; setTimeout(()=>el.style.width=el.dataset.w,100); }),300) };

/* ── Table Search Filter ── */
const TableSearch = {
    init:(inputSel,tableSel)=>{
        const input=document.querySelector(inputSel); if(!input) return;
        input.addEventListener('input',()=>{
            const val=input.value.toLowerCase().trim();
            document.querySelectorAll(`${tableSel} tbody tr`).forEach(tr=>{ tr.style.display=!val||tr.textContent.toLowerCase().includes(val)?'':'none'; });
        });
    }
};

/* ── Confirm Delete ── */
function confirmDelete(msg){ return confirm(msg||'Delete this? This cannot be undone.'); }

/* ── DOMContentLoaded ── */
document.addEventListener('DOMContentLoaded',()=>{
    Counter.initAll();
    Donut.initAll();
    Sparkline.initAll();
    ProgressBars.init();
    TableSearch.init('#topbarSearch','.data-table');

    document.getElementById('menuToggle')    ?.addEventListener('click',Sidebar.toggle);
    document.getElementById('sidebarOverlay')?.addEventListener('click',Sidebar.close);

    /* Auto-dismiss flash message */
    const flash=document.querySelector('.flash-alert');
    if(flash) setTimeout(()=>{ flash.style.opacity='0'; flash.style.transition='opacity 0.5s'; setTimeout(()=>flash.remove(),500); },4000);

    /* Confirm delete on links with data-confirm */
    document.querySelectorAll('a[data-confirm]').forEach(link=>{
        link.addEventListener('click',e=>{ if(!confirm(link.dataset.confirm)) e.preventDefault(); });
    });
});
