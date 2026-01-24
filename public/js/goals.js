document.addEventListener('DOMContentLoaded', () => {
  const panel = document.getElementById('centerPanel');
  const inner = document.getElementById('centerPanelInner');

  function openFrom(sourceId){
    const src = document.getElementById(sourceId);
    inner.innerHTML = src ? src.innerHTML : '';
    panel.classList.remove('d-none');
  }

  function closePanel(){
    panel.classList.add('d-none');
    inner.innerHTML = '';
  }

  document.querySelectorAll('.goal-tab').forEach(btn => {
    btn.addEventListener('click', () => {
      const target = btn.getAttribute('data-target');
      openFrom(target);
    });
  });

});
