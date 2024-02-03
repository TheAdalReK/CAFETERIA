/*Main Principal*/


/*Login*/
const $btnSignIn= document.querySelector('.sign-in-btn'),
      $btnSignUp = document.querySelector('.sign-up-btn'),  
      $signUp = document.querySelector('.sign-up'),
      $signIn  = document.querySelector('.sign-in');

document.addEventListener('click', e => {
    if (e.target === $btnSignIn || e.target === $btnSignUp) {
        $signIn.classList.toggle('active');
        $signUp.classList.toggle('active')
    }
});

/*Regresar del formulario*/
const regresarBtn = document.getElementById("regresar-btn");
regresarBtn.addEventListener("click", function() {
	window.location.href = "index.php";
});