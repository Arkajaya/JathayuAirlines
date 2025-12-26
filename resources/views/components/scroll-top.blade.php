<!-- Fixed Scroll to Top Button -->
<button id="scrollToTopBtn" 
        class="fixed bottom-6 right-6 z-50 bg-gradient-to-br from-primary to-secondary text-white w-14 h-14 rounded-full shadow-2xl hover:shadow-3xl hover:scale-110 transition-all duration-300 flex items-center justify-center opacity-0 invisible"
        aria-label="Scroll to top">
    <i class="fas fa-chevron-up text-xl"></i>
</button>

<style>
    /* Smooth scroll for the whole page */
    html {
        scroll-behavior: smooth;
    }
    
    /* Button animation */
    #scrollToTopBtn.show {
        opacity: 1 !important;
        visibility: visible !important;
        animation: fadeInUp 0.3s ease-out;
    }
    
    @keyframes fadeInUp {
        from {
            opacity: 0;
            transform: translateY(20px);
        }
        to {
            opacity: 1;
            transform: translateY(0);
        }
    }
    
    @keyframes bounce {
        0%, 20%, 50%, 80%, 100% {
            transform: translateY(0) scale(1);
        }
        40% {
            transform: translateY(-10px) scale(1.1);
        }
        60% {
            transform: translateY(-5px) scale(1.05);
        }
    }
    
    .bounce-animation {
        animation: bounce 1s;
    }
</style>

<script>
    // Wait for DOM to be fully loaded
    document.addEventListener('DOMContentLoaded', function() {
        const scrollBtn = document.getElementById('scrollToTopBtn');
        
        // Function to show/hide button based on scroll position
        function toggleScrollButton() {
            if (window.pageYOffset > 300) {
                scrollBtn.classList.add('show');
                scrollBtn.classList.remove('opacity-0', 'invisible');
            } else {
                scrollBtn.classList.remove('show');
                scrollBtn.classList.add('opacity-0', 'invisible');
            }
        }
        
        // Initial check
        toggleScrollButton();
        
        // Listen to scroll events
        window.addEventListener('scroll', toggleScrollButton);
        
        // Smooth scroll to top function
        function scrollToTop() {
            // Method 1: Using window.scrollTo (modern browsers)
            if ('scrollBehavior' in document.documentElement.style) {
                window.scrollTo({
                    top: 0,
                    behavior: 'smooth'
                });
            } 
            // Method 2: Using requestAnimationFrame for smooth animation (fallback)
            else {
                const duration = 500; // milliseconds
                const start = window.pageYOffset;
                const startTime = performance.now();
                
                function scrollStep(timestamp) {
                    const currentTime = timestamp || performance.now();
                    const timeElapsed = currentTime - startTime;
                    const progress = Math.min(timeElapsed / duration, 1);
                    
                    // Easing function (easeInOutCubic)
                    const easeInOutCubic = t => {
                        return t < 0.5 
                            ? 4 * t * t * t 
                            : (t - 1) * (2 * t - 2) * (2 * t - 2) + 1;
                    };
                    
                    const easedProgress = easeInOutCubic(progress);
                    window.scrollTo(0, start * (1 - easedProgress));
                    
                    if (timeElapsed < duration) {
                        requestAnimationFrame(scrollStep);
                    }
                }
                
                requestAnimationFrame(scrollStep);
            }
            
            // Add bounce animation to button
            scrollBtn.classList.add('bounce-animation');
            setTimeout(() => {
                scrollBtn.classList.remove('bounce-animation');
            }, 1000);
        }
        
        // Attach click event
        scrollBtn.addEventListener('click', function(e) {
            e.preventDefault();
            scrollToTop();
        });
        
        // Alternative: Add smooth scroll to all anchor links that point to #
        document.querySelectorAll('a[href="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                if (this.getAttribute('href') === '#') {
                    e.preventDefault();
                    scrollToTop();
                }
            });
        });
    });
    
    // Fallback for older browsers
    if (!('scrollBehavior' in document.documentElement.style)) {
        console.log('Smooth scroll polyfill might be needed for very old browsers');
    }
</script>