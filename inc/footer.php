    </main>
  </div>
</div>

<!-- Modern Footer -->
<footer class="footer-modern">
  <div class="footer-content">
    <div class="container">
      <div class="row align-items-center">
        <div class="col-md-6 text-center text-md-start">
          <div class="footer-brand">
            <div class="footer-brand-icon">
              <i class="fas fa-users-cog"></i>
            </div>
            <div class="footer-brand-text">
              <span class="fw-bold">Manajemen Pegawai</span>
              <p class="footer-description mb-0">
                Sistem manajemen data pegawai dan jadwal kerja yang modern dan efisien
              </p>
            </div>
          </div>
        </div>
        <div class="col-md-6 text-center text-md-end">
          <div class="footer-links">
            <a href="#" class="footer-link" title="Tentang Kami">
              <i class="fas fa-info-circle"></i>
            </a>
            <a href="#" class="footer-link" title="Bantuan">
              <i class="fas fa-question-circle"></i>
            </a>
            <a href="#" class="footer-link" title="Kontak">
              <i class="fas fa-envelope"></i>
            </a>
            <a href="#" class="footer-link" title="GitHub">
              <i class="fab fa-github"></i>
            </a>
          </div>
        </div>
      </div>
    </div>
  </div>
  
  <!-- Floating Action Button -->
  <div class="floating-action-btn" id="scrollToTop" title="Kembali ke atas">
    <i class="fas fa-arrow-up"></i>
  </div>
</footer>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<!-- Custom Footer Scripts -->
<script>
// Asset loading error handler
window.addEventListener('error', function(e) {
  if (e.target.tagName === 'IMG') {
    console.warn('Image failed to load:', e.target.src);
    // Hide broken images
    e.target.style.display = 'none';
  } else if (e.target.tagName === 'LINK' && e.target.rel === 'stylesheet') {
    console.warn('CSS failed to load:', e.target.href);
  }
}, true);

// Font Awesome loading check
document.addEventListener('DOMContentLoaded', function() {
  // Check if Font Awesome is loaded
  const testIcon = document.createElement('i');
  testIcon.className = 'fas fa-check';
  testIcon.style.visibility = 'hidden';
  document.body.appendChild(testIcon);
  
  const computedStyle = window.getComputedStyle(testIcon);
  if (computedStyle.fontFamily.indexOf('Font Awesome') === -1) {
    console.warn('Font Awesome may not be loaded properly');
    // Try to reload Font Awesome
    const link = document.createElement('link');
    link.rel = 'stylesheet';
    link.href = 'https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css';
    document.head.appendChild(link);
  }
  
  document.body.removeChild(testIcon);
});

// Scroll to top functionality
document.getElementById('scrollToTop').addEventListener('click', function() {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});

// Show/hide scroll to top button
window.addEventListener('scroll', function() {
  const scrollBtn = document.getElementById('scrollToTop');
  if (window.pageYOffset > 300) {
    scrollBtn.classList.add('show');
  } else {
    scrollBtn.classList.remove('show');
  }
});

// Add smooth scrolling to all links
document.querySelectorAll('a[href^="#"]').forEach(anchor => {
  anchor.addEventListener('click', function (e) {
    e.preventDefault();
    const target = document.querySelector(this.getAttribute('href'));
    if (target) {
      target.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
      });
    }
  });
});

// Add loading animation to buttons
document.querySelectorAll('.btn').forEach(button => {
  button.addEventListener('click', function() {
    if (!this.classList.contains('btn-loading')) {
      this.classList.add('btn-loading');
      this.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>Loading...';
      
      // Remove loading state after 2 seconds (for demo purposes)
      setTimeout(() => {
        this.classList.remove('btn-loading');
        // Restore original content if needed
      }, 2000);
    }
  });
});

// Add tooltip functionality
document.querySelectorAll('[title]').forEach(element => {
  element.addEventListener('mouseenter', function() {
    const tooltip = document.createElement('div');
    tooltip.className = 'custom-tooltip';
    tooltip.textContent = this.getAttribute('title');
    document.body.appendChild(tooltip);
    
    const rect = this.getBoundingClientRect();
    tooltip.style.left = rect.left + (rect.width / 2) - (tooltip.offsetWidth / 2) + 'px';
    tooltip.style.top = rect.top - tooltip.offsetHeight - 10 + 'px';
  });
  
  element.addEventListener('mouseleave', function() {
    const tooltip = document.querySelector('.custom-tooltip');
    if (tooltip) {
      tooltip.remove();
    }
  });
});
</script>

<!-- Footer Styles -->
<style>
.footer-modern {
  background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%);
  color: white;
  padding: 2rem 0 1rem;
  margin-top: auto;
  position: relative;
  overflow: hidden;
  flex-shrink: 0;
  border-top: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-modern::before {
  content: '';
  position: absolute;
  top: 0;
  left: 0;
  right: 0;
  height: 1px;
  background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
}

.footer-content {
  position: relative;
  z-index: 1;
}

.footer-brand {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 0.5rem;
}

.footer-brand-icon {
  width: 50px;
  height: 50px;
  background: linear-gradient(135deg, var(--primary-color), var(--primary-dark));
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  font-size: 1.25rem;
  box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
}

.footer-brand-text {
  flex: 1;
}

.footer-brand-text span {
  font-size: 1.25rem;
  display: block;
  margin-bottom: 0.25rem;
}

.footer-description {
  color: rgba(255, 255, 255, 0.7);
  font-size: 0.9rem;
  line-height: 1.5;
}

.footer-links {
  margin-bottom: 1rem;
  display: flex;
  justify-content: center;
  gap: 0.5rem;
}

.footer-link {
  display: inline-flex;
  align-items: center;
  justify-content: center;
  width: 45px;
  height: 45px;
  background: rgba(255, 255, 255, 0.1);
  color: white;
  border-radius: 50%;
  text-decoration: none;
  transition: var(--transition);
  backdrop-filter: blur(10px);
  border: 1px solid rgba(255, 255, 255, 0.1);
}

.footer-link:hover {
  background: var(--primary-color);
  color: white;
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
  border-color: var(--primary-color);
}

.footer-copyright {
  color: rgba(255, 255, 255, 0.6);
  font-size: 0.85rem;
  text-align: center;
}

/* Floating Action Button */
.floating-action-btn {
  position: fixed;
  bottom: 2rem;
  right: 2rem;
  width: 50px;
  height: 50px;
  background: var(--primary-color);
  color: white;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
  cursor: pointer;
  transition: all 0.3s ease;
  opacity: 0;
  visibility: hidden;
  transform: translateY(20px);
  box-shadow: 0 4px 20px rgba(79, 70, 229, 0.3);
  z-index: 1000;
}

.floating-action-btn.show {
  opacity: 1;
  visibility: visible;
  transform: translateY(0);
}

.floating-action-btn:hover {
  background: var(--primary-dark);
  transform: translateY(-3px);
  box-shadow: 0 8px 25px rgba(79, 70, 229, 0.4);
}

/* Button Loading State */
.btn-loading {
  pointer-events: none;
  opacity: 0.8;
}

/* Custom Tooltip */
.custom-tooltip {
  position: fixed;
  background: rgba(0, 0, 0, 0.9);
  color: white;
  padding: 0.5rem 0.75rem;
  border-radius: 6px;
  font-size: 0.8rem;
  z-index: 10000;
  pointer-events: none;
  animation: tooltipFadeIn 0.2s ease-in;
}

@keyframes tooltipFadeIn {
  from {
    opacity: 0;
    transform: translateY(5px);
  }
  to {
    opacity: 1;
    transform: translateY(0);
  }
}

/* Responsive Footer */
@media (max-width: 768px) {
  .footer-modern {
    padding: 1.5rem 0 1rem;
  }
  
  .footer-brand {
    font-size: 1.1rem;
  }
  
  .footer-description {
    font-size: 0.85rem;
  }
  
  .floating-action-btn {
    bottom: 1rem;
    right: 1rem;
    width: 45px;
    height: 45px;
  }
}
</style>

</body>
</html> 