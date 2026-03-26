// ==================== AUTH PAGE MODULES ====================
// Password visibility toggle (login + register)
(function () {
    const toggleBtn = document.getElementById('togglePassword');
    const pwdInput  = document.getElementById('password');
    const eyeIcon   = document.getElementById('eyeIcon');

    if (!toggleBtn || !pwdInput) return;

    toggleBtn.addEventListener('click', () => {
        const isText  = pwdInput.type === 'text';
        pwdInput.type = isText ? 'password' : 'text';
        eyeIcon.className = isText ? 'fas fa-eye text-xs' : 'fas fa-eye-slash text-xs';
    });
})();

// ==================== PASSWORD STRENGTH (register only) ====================
(function () {
    const pwdInput     = document.getElementById('password');
    const strengthBar  = document.getElementById('strengthBar');
    const strengthFill = document.getElementById('strengthFill');

    if (!pwdInput || !strengthBar || !strengthFill) return;

    pwdInput.addEventListener('input', () => {
        const val = pwdInput.value;

        if (!val) {
            strengthBar.classList.add('hidden');
            return;
        }

        strengthBar.classList.remove('hidden');

        let score = 0;
        if (val.length >= 8)           score++;
        if (/[A-Z]/.test(val))         score++;
        if (/[0-9]/.test(val))         score++;
        if (/[^A-Za-z0-9]/.test(val))  score++;

        const levels = [
            { w: '25%',  color: 'bg-red-400' },
            { w: '50%',  color: 'bg-orange-400' },
            { w: '75%',  color: 'bg-yellow-400' },
            { w: '100%', color: 'bg-green-500' },
        ];
        const level = levels[Math.max(score - 1, 0)];
        strengthFill.style.width  = level.w;
        strengthFill.className    = `h-full rounded-full transition-all duration-300 ${level.color}`;
    });
})();
