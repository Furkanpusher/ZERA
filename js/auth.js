 // Page toggle functionality
        function togglePage() {
            const body = document.getElementById('auth-body');
            body.classList.toggle('show-register');
            
            // Update page title
            const isRegister = body.classList.contains('show-register');
            document.title = isRegister ? 'Sign Up - Zera' : 'Sign In - Zera';
        }

        // Form handling
       
       

        // Google auth simulation
        document.querySelectorAll('.google-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                const originalText = this.textContent;
                this.textContent = 'Connecting to Google...';
                this.disabled = true;
                
                setTimeout(() => {
                    alert('Signed in with Google successfully!');
                    this.textContent = originalText;
                    this.disabled = false;
                }, 1500);
            });
        });

        // Input focus animations
        document.querySelectorAll('input').forEach(input => {
            input.addEventListener('focus', function() {
                this.parentElement.style.transform = 'scale(1.02)';
            });
            
            input.addEventListener('blur', function() {
                this.parentElement.style.transform = 'scale(1)';
            });
        });

        // URL-based page switching
        if (window.location.hash === '#register') {
            document.getElementById('auth-body').classList.add('show-register');
        }

    // Success message baloncuğu otomatik kaybolsun
// Success message baloncuğu otomatik kaybolsun ve yönlendirsin
document.addEventListener("DOMContentLoaded", function() {
    const msg = document.getElementById("successMsg");
    if(msg){
        setTimeout(() => {
            msg.style.opacity = "0";
            setTimeout(() => { msg.style.display = "none"; }, 500);
        }, 2500); // 2.5 saniye sonra kaybolur ve yönlendirir
        setTimeout(() => {
            window.location.href = "index.php";
        }, 2500);
    }
});


// 2 şifre aynı mı kontrolü nerde? 
// eğer o email ile kayıtlı kullanıcı varsa, uyarı verilmeli
// 