<div id="reading-progress" class="fixed top-0 left-0 w-0 h-1 z-50 bg-gradient-to-r from-indigo-500 via-purple-500 to-pink-500 shadow-lg shadow-indigo-500/50 opacity-0 transition-opacity duration-300">
    <div class="absolute inset-0 bg-white/20 animate-pulse"></div>
</div>

<script>
(function() {
    const progressBar = document.getElementById('reading-progress');
    
    if (progressBar) {
        function updateProgress() {
            const scrollTop = window.scrollY;
            const docHeight = document.documentElement.scrollHeight - window.innerHeight;
            const progress = docHeight > 0 ? (scrollTop / docHeight) * 100 : 0;
            
            progressBar.style.width = Math.min(progress, 100) + '%';
            
            if (scrollTop > 100) {
                progressBar.classList.remove('opacity-0');
                progressBar.classList.add('opacity-100');
            } else {
                progressBar.classList.add('opacity-0');
                progressBar.classList.remove('opacity-100');
            }
        }
        
        window.addEventListener('scroll', updateProgress, { passive: true });
        window.addEventListener('resize', updateProgress, { passive: true });
        updateProgress();
    }
})();
</script>
