document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle for mobile
    const sidebarToggle = document.getElementById('sidebarToggle');
    const sidebar = document.querySelector('.sidebar');
    const mainContent = document.querySelector('.main-content');
    
    if (sidebarToggle) {
        sidebarToggle.addEventListener('click', function() {
            sidebar.classList.toggle('active');
        });
    }
    
    // Close sidebar when clicking outside on mobile
    document.addEventListener('click', function(event) {
        const isClickInsideSidebar = sidebar.contains(event.target);
        const isClickOnToggle = sidebarToggle && sidebarToggle.contains(event.target);
        
        if (!isClickInsideSidebar && !isClickOnToggle && window.innerWidth < 992 && sidebar.classList.contains('active')) {
            sidebar.classList.remove('active');
        }
    });
    
    // Active menu item
    const currentLocation = window.location.href;
    const menuItems = document.querySelectorAll('.nav-link');
    
    menuItems.forEach(item => {
        if (currentLocation.includes(item.getAttribute('href'))) {
            item.classList.add('active');
            // Expand parent if in a submenu
            const parentSection = item.closest('.nav-section');
            if (parentSection) {
                const submenu = parentSection.querySelector('.submenu');
                if (submenu) {
                    submenu.style.display = 'block';
                }
            }
        }
    });
    
    // Form validation
    const forms = document.querySelectorAll('form');
    
    forms.forEach(form => {
        form.addEventListener('submit', function(event) {
            const requiredFields = form.querySelectorAll('[required]');
            let isValid = true;
            
            requiredFields.forEach(field => {
                if (!field.value.trim()) {
                    isValid = false;
                    field.classList.add('is-invalid');
                    
                    // Create error message if it doesn't exist
                    let errorMessage = field.nextElementSibling;
                    if (!errorMessage || !errorMessage.classList.contains('invalid-feedback')) {
                        errorMessage = document.createElement('div');
                        errorMessage.classList.add('invalid-feedback');
                        errorMessage.textContent = 'Field ini wajib diisi';
                        field.parentNode.insertBefore(errorMessage, field.nextSibling);
                    }
                } else {
                    field.classList.remove('is-invalid');
                    const errorMessage = field.nextElementSibling;
                    if (errorMessage && errorMessage.classList.contains('invalid-feedback')) {
                        errorMessage.remove();
                    }
                }
            });
            
            if (!isValid) {
                event.preventDefault();
            }
        });
    });
    
    // Image preview for file inputs
    const fileInputs = document.querySelectorAll('input[type="file"]');
    
    fileInputs.forEach(input => {
        input.addEventListener('change', function() {
            const previewContainer = document.querySelector('.image-preview');
            if (!previewContainer) return;
            
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                
                reader.onload = function(e) {
                    previewContainer.innerHTML = `<img src="${e.target.result}" class="img-thumbnail" style="max-height: 200px">`;
                    previewContainer.style.display = 'block';
                }
                
                reader.readAsDataURL(this.files[0]);
            }
        });
    });
    
    // Confirm delete
    const deleteButtons = document.querySelectorAll('.delete-btn, a[href*="delete"]');
    
    deleteButtons.forEach(button => {
        button.addEventListener('click', function(event) {
            if (!confirm('Apakah Anda yakin ingin menghapus item ini?')) {
                event.preventDefault();
            }
        });
    });
    
    // Tooltips
    const tooltipTriggers = document.querySelectorAll('[data-bs-toggle="tooltip"]');
    if (tooltipTriggers.length > 0 && typeof bootstrap !== 'undefined') {
        tooltipTriggers.forEach(trigger => {
            new bootstrap.Tooltip(trigger);
        });
    }
    
    // Date range picker initialization
    const dateRangeInputs = document.querySelectorAll('input[type="date"]');
    if (dateRangeInputs.length > 0) {
        // Set default date for empty date inputs
        dateRangeInputs.forEach(input => {
            if (!input.value) {
                const today = new Date();
                const year = today.getFullYear();
                let month = today.getMonth() + 1;
                let day = today.getDate();
                
                month = month < 10 ? '0' + month : month;
                day = day < 10 ? '0' + day : day;
                
                if (input.name === 'tawal') {
                    // First day of current month
                    input.value = `${year}-${month}-01`;
                } else if (input.name === 'takhir') {
                    input.value = `${year}-${month}-${day}`;
                }
            }
        });
    }
    
    // Add animation classes to elements
    const animateElements = document.querySelectorAll('.card, .stat-card, .menu-card, .form-container');
    animateElements.forEach(element => {
        element.classList.add('fade-in');
    });
});