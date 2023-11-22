const contactbtns = document.querySelectorAll('.contact_btn');
const contactForm = document.querySelector('.contactForm');
const modale = document.querySelector('.contact-box')
contactbtns.forEach(contactbtn => {
    contactbtn.addEventListener('click', () => {
        contactForm.classList.toggle('hide');
    })
});

window.addEventListener('click', (e) => {
    if (e.target == contactForm){
        console.log(e);
        contactForm.classList.toggle('hide');
    }
    
})