/*const parentContainer = document.querySelector('.about');
parentContainer.addEventListener('click', event=>{
    const current = event.target;
    const isReadMoreBtn = current.className.includes('read-more-btn');
    if(!isReadMoreBtn) return;
    const currentText = event.target.parentNode.querySelector('.read-more-text');
    currentText.classList.toggle('read-more-text--show');
    current.textContent = current.textContent.includes('Read More') ? "Read Less..." : "Read More...";
})*/
//const parent=document.querySelector('.about')
const read=document.querySelector('.read-more-btn')
const r=document.querySelector('.read-more-text')
const rl=document.querySelector('#less')
read.addEventListener('click',function(e){
    r.style.display='inline-block'
    read.style.display='none'
})
rl.addEventListener('click',function(e){
    r.style.display='none'
    read.style.display='inline-block'
})
