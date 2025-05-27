document.addEventListener('DOMContentLoaded', function () {
  // Tab switching functionality
  const tabButtons = document.querySelectorAll('.tab-btn');
  const tabContents = document.querySelectorAll('.tab-content');

  tabButtons.forEach(button => {
    button.addEventListener('click', function () {
      // Remove active class from all buttons and contents
      tabButtons.forEach(btn => btn.classList.remove('active'));
      tabContents.forEach(content => content.classList.remove('active'));

      // Add active class to clicked button
      this.classList.add('active');

      // Show corresponding content
      const targetId = `${this.dataset.target}-tab`;
      document.getElementById(targetId).classList.add('active');
    });
  });

  // FAQ accordion functionality
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const question = item.querySelector('.faq-question');

    question.addEventListener('click', function () {
      // Toggle active class on the clicked item
      const isActive = item.classList.contains('active');

      // Optional: Close other open FAQs
      faqItems.forEach(faq => faq.classList.remove('active'));

      // Toggle the clicked item
      if (!isActive) {
        item.classList.add('active');
      }
    });
  });

  // Copy cryptocurrency address functionality
  // Copy cryptocurrency address functionality
  const copyButtons = document.querySelectorAll('.copy-btn');

  copyButtons.forEach(button => {
    button.addEventListener('click', async function () {
      const address = this.dataset.address;

      try {
        // Copy using Clipboard API
        await navigator.clipboard.writeText(address);

        // Visual feedback: ganti ikon menjadi checklist
        const originalIcon = this.innerHTML;
        this.innerHTML = '<i class="fa fa-check"></i>';

        setTimeout(() => {
          this.innerHTML = originalIcon;
        }, 1500);
      } catch (error) {
        this.innerHTML = '<i class="fa fa-close"></i>';
      }
    });
  });
  //rate QR codes for cryptocurrency addresses
  const qrContainers = document.querySelectorAll('.qr-container');

  if (typeof QRCode !== 'undefined') {
    qrContainers.forEach(container => {
      const cryptoId = container.id.split('-')[1];
      const addressInput = container.closest('.coin-card').querySelector('.crypto-address');

      if (addressInput) {
        new QRCode(container, {
          text: addressInput.value,
          width: 128,
          height: 128,
          colorDark: "#000000",
          colorLight: "#ffffff",
          correctLevel: QRCode.CorrectLevel.H
        });
      }
    });
  }

  // Animation for donation thank you section
  const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
      if (entry.isIntersecting) {
        entry.target.classList.add('animate-in');
        observer.unobserve(entry.target);
      }
    });
  }, { threshold: 0.2 });

  const thankYouSection = document.querySelector('.donation-thankyou');
  if (thankYouSection) {
    observer.observe(thankYouSection);
  }

  // Theme toggle for donation page
  const prefersDarkScheme = window.matchMedia('(prefers-color-scheme: dark)');
  const currentTheme = localStorage.getItem('theme');

  if (currentTheme === 'dark' || (!currentTheme && prefersDarkScheme.matches)) {
    document.body.classList.add('dark-theme');
  }

  // Responsive adjustments
  function handleResponsiveLayout() {
    const isMobile = window.innerWidth <= 768;
    const coinCards = document.querySelectorAll('.coin-card');

    coinCards.forEach(card => {
      if (isMobile) {
        card.classList.add('mobile-view');
      } else {
        card.classList.remove('mobile-view');
      }
    });
  }

  // Call once on load and add resize listener
  handleResponsiveLayout();
  window.addEventListener('resize', handleResponsiveLayout);
});
