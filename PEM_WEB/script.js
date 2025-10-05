// Lamurah Store Interactive JavaScript
// DOM Elements
const themeToggle = document.createElement('button');
let gameCards, priceItems, navLinks, topUpButtons;
let modal = null;

document.addEventListener('DOMContentLoaded', function() {
    // Refresh DOM elements
    refreshDOMElements();
    
    initializeThemeToggle();
    initializeGameCards();
    initializePriceSelection();
    initializeNavigation();
    initializeTopUpModal();
    initializePromoCode();
    initializeTestimonialSlider();
    initializeScrollEffects();
});

// Function to refresh DOM elements
function refreshDOMElements() {
    gameCards = document.querySelectorAll('.game-card');
    priceItems = document.querySelectorAll('.price-item');
    navLinks = document.querySelectorAll('nav a');
    topUpButtons = document.querySelectorAll('.btn-secondary');
}

// Theme Toggle Functionality (Dark Mode)
function initializeThemeToggle() {
    // Create theme toggle button
    themeToggle.innerHTML = '🌙';
    themeToggle.className = 'theme-toggle';
    themeToggle.style.cssText = `
        position: fixed;
        top: 100px;
        right: 20px;
        width: 50px;
        height: 50px;
        border: none;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        backdrop-filter: blur(10px);
        color: white;
        font-size: 1.5rem;
        cursor: pointer;
        transition: all 0.3s ease;
        z-index: 1001;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
    `;
    
    document.body.appendChild(themeToggle);
    
    // Load saved theme
    const savedTheme = localStorage.getItem('lamurah-theme') || 'light';
    if (savedTheme === 'dark') {
        enableDarkMode();
    }
    
    // Theme toggle event listener
    themeToggle.addEventListener('click', toggleTheme);
    themeToggle.addEventListener('mouseenter', () => {
        themeToggle.style.transform = 'scale(1.1)';
    });
    themeToggle.addEventListener('mouseleave', () => {
        themeToggle.style.transform = 'scale(1)';
    });
}

function toggleTheme() {
    const isDark = document.body.classList.contains('dark-theme');
    if (isDark) {
        disableDarkMode();
    } else {
        enableDarkMode();
    }
}

function enableDarkMode() {
    document.body.classList.add('dark-theme');
    themeToggle.innerHTML = '☀️';
    localStorage.setItem('lamurah-theme', 'dark');
    
    // Add dark theme styles
    if (!document.getElementById('dark-theme-styles')) {
        const darkStyles = document.createElement('style');
        darkStyles.id = 'dark-theme-styles';
        darkStyles.textContent = `
            .dark-theme {
                background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%) !important;
            }
            .dark-theme .card, .dark-theme .game-card, .dark-theme .feature-card, .dark-theme .testimonial-card {
                background: rgba(255, 255, 255, 0.05) !important;
                border: 1px solid rgba(255, 255, 255, 0.1) !important;
            }
            .dark-theme header {
                background: rgba(0, 0, 0, 0.5) !important;
            }
        `;
        document.head.appendChild(darkStyles);
    }
}

function disableDarkMode() {
    document.body.classList.remove('dark-theme');
    themeToggle.innerHTML = '🌙';
    localStorage.setItem('lamurah-theme', 'light');
}

// Game Cards Interactive Features
function initializeGameCards() {
    gameCards.forEach(card => {
        // Add hover sound effect (visual feedback)
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-10px) scale(1.02)';
            this.style.transition = 'all 0.3s ease';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0) scale(1)';
        });
        
        // Add click animation
        card.addEventListener('click', function() {
            this.style.transform = 'translateY(-5px) scale(0.98)';
            setTimeout(() => {
                this.style.transform = 'translateY(-10px) scale(1.02)';
            }, 100);
        });
    });
}

// Price Selection System - PERBAIKAN BUG V2
function initializePriceSelection() {
    let selectedPrice = null;
    
    // Use event delegation untuk menghindari masalah dengan dynamic elements
    document.addEventListener('click', function(e) {
        // Check if clicked element is a price item
        if (e.target.closest('.price-item')) {
            e.preventDefault();
            const clickedItem = e.target.closest('.price-item');
            const gameCard = clickedItem.closest('.game-card');
            const topUpBtn = gameCard.querySelector('.btn-secondary');
            
            // Check if clicked item is already selected (toggle functionality)
            if (clickedItem.classList.contains('selected')) {
                // Cancel selection if already selected
                clickedItem.classList.remove('selected');
                clickedItem.style.background = '';
                clickedItem.style.borderLeft = '';
                clickedItem.style.borderRadius = '';
                
                // Reset button to disabled state
                topUpBtn.style.background = 'linear-gradient(45deg, #4ecdc4, #44a08d)';
                topUpBtn.textContent = 'Pilih Item Dulu';
                topUpBtn.disabled = true;
                
                selectedPrice = null;
                
                // Show cancel feedback
                showNotification('Pilihan dibatalkan', 'info');
                return;
            }
            
            // Remove previous selection from ALL game cards
            document.querySelectorAll('.price-item').forEach(p => {
                p.classList.remove('selected');
                p.style.background = '';
                p.style.borderLeft = '';
                p.style.borderRadius = '';
            });
            
            // Reset ALL top up buttons
            document.querySelectorAll('.btn-secondary').forEach(btn => {
                btn.style.background = 'linear-gradient(45deg, #4ecdc4, #44a08d)';
                btn.textContent = 'Pilih Item Dulu';
                btn.disabled = true;
            });
            
            // Add selection to clicked item
            clickedItem.classList.add('selected');
            selectedPrice = clickedItem;
            
            // Add selected style
            clickedItem.style.background = 'rgba(78, 205, 196, 0.2)';
            clickedItem.style.borderLeft = '4px solid #4ecdc4';
            clickedItem.style.borderRadius = '10px';
            
            // Store selection data
            const gameName = gameCard.querySelector('h3').textContent;
            const itemName = clickedItem.querySelector('span:first-child').textContent;
            const price = clickedItem.querySelector('.price-amount').textContent;
            
            console.log('Selected:', { gameName, itemName, price });
            
            // Enable only the specific game's top up button
            topUpBtn.style.background = 'linear-gradient(45deg, #ff6b6b, #ffa500)';
            topUpBtn.textContent = 'Lanjutkan Pembelian';
            topUpBtn.disabled = false;
            
            // Show visual feedback
            showNotification(`Terpilih: ${itemName} - ${price}`, 'success');
        }
    });
    
    // Add function to reset selection
    window.resetPriceSelection = function() {
        document.querySelectorAll('.price-item').forEach(p => {
            p.classList.remove('selected');
            p.style.background = '';
            p.style.borderLeft = '';
            p.style.borderRadius = '';
        });
        
        document.querySelectorAll('.btn-secondary').forEach(btn => {
            btn.style.background = 'linear-gradient(45deg, #4ecdc4, #44a08d)';
            btn.textContent = 'Pilih Item Dulu';
            btn.disabled = true;
        });
        
        selectedPrice = null;
    };
}

// Navigation with Smooth Scrolling
function initializeNavigation() {
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            
            const targetId = this.getAttribute('href');
            if (targetId.startsWith('#')) {
                const targetSection = document.querySelector(targetId);
                if (targetSection) {
                    // Add navigation animation
                    this.style.background = 'rgba(255, 255, 255, 0.2)';
                    setTimeout(() => {
                        this.style.background = '';
                    }, 300);
                    
                    // Smooth scroll to target
                    targetSection.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            }
        });
    });
}

// Top Up Modal System - PERBAIKAN BUG V2
function initializeTopUpModal() {
    // Create modal HTML
    modal = document.createElement('div');
    modal.className = 'top-up-modal';
    modal.style.cssText = `
        display: none;
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background: rgba(0, 0, 0, 0.8);
        backdrop-filter: blur(5px);
        z-index: 2000;
        justify-content: center;
        align-items: center;
    `;
    
    modal.innerHTML = `
        <div class="modal-content" style="
            background: rgba(255, 255, 255, 0.1);
            backdrop-filter: blur(15px);
            border-radius: 20px;
            padding: 30px;
            max-width: 500px;
            width: 90%;
            color: white;
            border: 1px solid rgba(255, 255, 255, 0.2);
        ">
            <div class="modal-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <h3>Form Top Up</h3>
                <button class="close-modal" style="
                    background: none;
                    border: none;
                    color: white;
                    font-size: 24px;
                    cursor: pointer;
                    padding: 5px;
                ">&times;</button>
            </div>
            <form class="top-up-form">
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="user-id" style="display: block; margin-bottom: 5px;">User ID / Player ID:</label>
                    <input type="text" id="user-id" placeholder="Masukkan User ID" style="
                        width: 100%;
                        padding: 12px;
                        border: 1px solid rgba(255, 255, 255, 0.3);
                        border-radius: 10px;
                        background: rgba(255, 255, 255, 0.1);
                        color: white;
                        backdrop-filter: blur(10px);
                    " required>
                </div>
                <div class="form-group" style="margin-bottom: 20px;">
                    <label for="phone" style="display: block; margin-bottom: 5px;">Nomor WhatsApp:</label>
                    <input type="tel" id="phone" placeholder="Contoh: 08123456789" style="
                        width: 100%;
                        padding: 12px;
                        border: 1px solid rgba(255, 255, 255, 0.3);
                        border-radius: 10px;
                        background: rgba(255, 255, 255, 0.1);
                        color: white;
                        backdrop-filter: blur(10px);
                    " required>
                </div>
                <div class="selected-item" style="
                    background: rgba(78, 205, 196, 0.2);
                    padding: 15px;
                    border-radius: 10px;
                    margin-bottom: 20px;
                    border-left: 4px solid #4ecdc4;
                ">
                    <p><strong>Game:</strong> <span id="selected-game">-</span></p>
                    <p><strong>Item:</strong> <span id="selected-item">-</span></p>
                    <p><strong>Harga:</strong> <span id="selected-price">-</span></p>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; margin-top: 10px;">
                    Proses Pembayaran
                </button>
            </form>
        </div>
    `;
    
    document.body.appendChild(modal);
    
    // Modal event listeners - PERBAIKAN BUG V2
    const closeBtn = modal.querySelector('.close-modal');
    const form = modal.querySelector('.top-up-form');
    
    closeBtn.addEventListener('click', () => {
        modal.style.display = 'none';
        // Reset price selection when modal is closed
        if (window.resetPriceSelection) {
            window.resetPriceSelection();
        }
    });
    
    modal.addEventListener('click', (e) => {
        if (e.target === modal) {
            modal.style.display = 'none';
            // Reset price selection when modal is closed
            if (window.resetPriceSelection) {
                window.resetPriceSelection();
            }
        }
    });
    
    // Use event delegation for top up buttons - PERBAIKAN UTAMA
    document.addEventListener('click', function(e) {
        if (e.target.classList.contains('btn-secondary') && !e.target.disabled) {
            e.preventDefault();
            
            const gameCard = e.target.closest('.game-card');
            const selectedPriceItem = gameCard.querySelector('.price-item.selected');
            
            if (!selectedPriceItem) {
                showNotification('Silakan pilih paket diamond/UC terlebih dahulu!', 'warning');
                return;
            }
            
            // Fill modal with selected data
            const gameName = gameCard.querySelector('h3').textContent;
            const itemName = selectedPriceItem.querySelector('span:first-child').textContent;
            const price = selectedPriceItem.querySelector('.price-amount').textContent;
            
            modal.querySelector('#selected-game').textContent = gameName;
            modal.querySelector('#selected-item').textContent = itemName;
            modal.querySelector('#selected-price').textContent = price;
            
            modal.style.display = 'flex';
        }
    });
    
    // Form submission - PERBAIKAN BUG
    form.addEventListener('submit', function(e) {
        e.preventDefault();
        
        const userId = document.getElementById('user-id').value;
        const phone = document.getElementById('phone').value;
        const game = modal.querySelector('#selected-game').textContent;
        const item = modal.querySelector('#selected-item').textContent;
        const price = modal.querySelector('#selected-price').textContent;
        
        // Simulate processing
        showNotification('Memproses pesanan...', 'info');
        
        setTimeout(() => {
            showNotification('Pesanan berhasil dibuat! Silakan cek WhatsApp untuk instruksi pembayaran.', 'success');
            modal.style.display = 'none';
            form.reset();
            
            // Reset price selection after successful order
            if (window.resetPriceSelection) {
                window.resetPriceSelection();
            }
            
            // Generate WhatsApp link
            const message = `Halo Lamurah Store!%0A%0ASaya ingin melakukan top up:%0AGame: ${game}%0AItem: ${item}%0AHarga: ${price}%0AUser ID: ${userId}%0A%0ATerima kasih!`;
            const whatsappUrl = `https://wa.me/6281234567890?text=${message}`;
            
            setTimeout(() => {
                if (confirm('Buka WhatsApp untuk melanjutkan pembayaran?')) {
                    window.open(whatsappUrl, '_blank');
                }
            }, 2000);
            
        }, 2000);
    });
    
    // Add ESC key listener to close modal
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && modal && modal.style.display === 'flex') {
            modal.style.display = 'none';
            if (window.resetPriceSelection) {
                window.resetPriceSelection();
            }
        }
    });
}

// Notification System
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `notification ${type}`;
    notification.textContent = message;
    notification.style.cssText = `
        position: fixed;
        top: 20px;
        right: 20px;
        padding: 15px 20px;
        border-radius: 10px;
        color: white;
        font-weight: bold;
        z-index: 3000;
        max-width: 300px;
        backdrop-filter: blur(10px);
        transform: translateX(400px);
        transition: all 0.3s ease;
    `;
    
    // Set background based on type
    const colors = {
        info: 'linear-gradient(45deg, #45b7d1, #4ecdc4)',
        success: 'linear-gradient(45deg, #4ecdc4, #44a08d)',
        warning: 'linear-gradient(45deg, #ffa500, #ff8c00)',
        error: 'linear-gradient(45deg, #ff6b6b, #ff5252)'
    };
    
    notification.style.background = colors[type];
    document.body.appendChild(notification);
    
    // Animate in
    setTimeout(() => {
        notification.style.transform = 'translateX(0)';
    }, 100);
    
    // Auto remove
    setTimeout(() => {
        notification.style.transform = 'translateX(400px)';
        setTimeout(() => {
            if (document.body.contains(notification)) {
                document.body.removeChild(notification);
            }
        }, 300);
    }, 4000);
}

// Promo Code System
function initializePromoCode() {
    const promoCard = document.querySelector('.promo-card');
    const promoCode = document.querySelector('.promo-code');
    
    if (promoCode) {
        promoCode.addEventListener('click', function() {
            // Copy to clipboard
            navigator.clipboard.writeText('WELCOME10').then(() => {
                showNotification('Kode promo berhasil disalin!', 'success');
                
                // Visual feedback
                this.style.background = 'rgba(78, 205, 196, 0.3)';
                this.style.transform = 'scale(1.05)';
                
                setTimeout(() => {
                    this.style.background = 'rgba(255, 255, 255, 0.2)';
                    this.style.transform = 'scale(1)';
                }, 200);
            }).catch(() => {
                showNotification('Gagal menyalin kode promo', 'error');
            });
        });
        
        promoCode.style.cursor = 'pointer';
        promoCode.title = 'Klik untuk menyalin kode promo';
    }
}

// Testimonial Slider
function initializeTestimonialSlider() {
    const testimonials = document.querySelectorAll('.testimonial-card');
    let currentTestimonial = 0;
    
    if (testimonials.length > 0) {
        // Add navigation dots
        const testimonialSection = document.getElementById('testimoni');
        const dotsContainer = document.createElement('div');
        dotsContainer.className = 'testimonial-dots';
        dotsContainer.style.cssText = `
            text-align: center;
            margin-top: 30px;
        `;
        
        testimonials.forEach((_, index) => {
            const dot = document.createElement('button');
            dot.className = 'testimonial-dot';
            dot.style.cssText = `
                width: 12px;
                height: 12px;
                border-radius: 50%;
                border: none;
                margin: 0 5px;
                background: rgba(255, 255, 255, 0.3);
                cursor: pointer;
                transition: all 0.3s ease;
            `;
            
            dot.addEventListener('click', () => {
                showTestimonial(index);
            });
            
            dotsContainer.appendChild(dot);
        });
        
        testimonialSection.appendChild(dotsContainer);
        
        function showTestimonial(index) {
            // Hide all testimonials
            testimonials.forEach((testimonial, i) => {
                if (i === index) {
                    testimonial.style.display = 'block';
                    testimonial.style.animation = 'fadeInUp 0.6s ease-out';
                } else {
                    testimonial.style.display = 'none';
                }
            });
            
            // Update dots
            const dots = dotsContainer.querySelectorAll('.testimonial-dot');
            dots.forEach((dot, i) => {
                if (i === index) {
                    dot.style.background = '#4ecdc4';
                    dot.style.transform = 'scale(1.2)';
                } else {
                    dot.style.background = 'rgba(255, 255, 255, 0.3)';
                    dot.style.transform = 'scale(1)';
                }
            });
            
            currentTestimonial = index;
        }
        
        // Auto-rotate testimonials
        setInterval(() => {
            currentTestimonial = (currentTestimonial + 1) % testimonials.length;
            showTestimonial(currentTestimonial);
        }, 5000);
        
        // Initialize first testimonial
        showTestimonial(0);
    }
}

// Scroll Effects and Animations
function initializeScrollEffects() {
    // Parallax effect for banner
    const banner = document.querySelector('.banner-image');
    
    window.addEventListener('scroll', () => {
        const scrolled = window.pageYOffset;
        const rate = scrolled * -0.5;
        
        if (banner) {
            banner.style.transform = `translateY(${rate}px)`;
        }
    });
    
    // Scroll-triggered animations
    const animateOnScroll = document.querySelectorAll('.card, .game-card, .feature-card');
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.style.animation = 'fadeInUp 0.6s ease-out forwards';
                entry.target.style.opacity = '1';
            }
        });
    }, {
        threshold: 0.1
    });
    
    animateOnScroll.forEach(element => {
        element.style.opacity = '0';
        observer.observe(element);
    });
}

// Add loading animation
window.addEventListener('load', function() {
    // Remove any loading screen if exists
    const loader = document.getElementById('loader');
    if (loader) {
        loader.style.opacity = '0';
        setTimeout(() => {
            loader.remove();
        }, 500);
    }
    
    // Show welcome message
    setTimeout(() => {
        showNotification('Selamat datang di Lamurah Store!', 'success');
    }, 1000);
});

// Add some utility functions
function formatCurrency(amount) {
    return new Intl.NumberFormat('id-ID', {
        style: 'currency',
        currency: 'IDR'
    }).format(amount);
}

function validateUserId(userId, gameType) {
    // Simple validation - in real app you'd validate against game servers
    const patterns = {
        'Mobile Legends': /^\d{7,10}$/,
        'Free Fire': /^\d{8,12}$/,
        'PUBG Mobile': /^\d{8,10}$/,
        'Genshin Impact': /^\d{9}$/
    };
    
    return patterns[gameType] ? patterns[gameType].test(userId) : true;
}

console.log('Lamurah Store JavaScript initialized successfully!');