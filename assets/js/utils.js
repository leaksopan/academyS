// Utility functions for the application

// Base URL for the application
const baseUrl = document.querySelector('meta[name="base-url"]').getAttribute('content') || '/';

// Format date to a readable format
function formatDate(dateString) {
    const options = { year: 'numeric', month: 'long', day: 'numeric' };
    return new Date(dateString).toLocaleDateString('id-ID', options);
}

// Format time elapsed since a given date
function timeAgo(dateString) {
    const date = new Date(dateString);
    const now = new Date();
    const seconds = Math.floor((now - date) / 1000);
    
    let interval = Math.floor(seconds / 31536000);
    if (interval >= 1) {
        return interval + ' tahun yang lalu';
    }
    
    interval = Math.floor(seconds / 2592000);
    if (interval >= 1) {
        return interval + ' bulan yang lalu';
    }
    
    interval = Math.floor(seconds / 86400);
    if (interval >= 1) {
        return interval + ' hari yang lalu';
    }
    
    interval = Math.floor(seconds / 3600);
    if (interval >= 1) {
        return interval + ' jam yang lalu';
    }
    
    interval = Math.floor(seconds / 60);
    if (interval >= 1) {
        return interval + ' menit yang lalu';
    }
    
    return 'baru saja';
}

// Truncate text to a specified length
function truncateText(text, maxLength) {
    if (text.length <= maxLength) {
        return text;
    }
    
    return text.substring(0, maxLength) + '...';
}

// Format number with thousand separator
function formatNumber(number) {
    return number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
}

// Validate email format
function isValidEmail(email) {
    const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    return emailRegex.test(email);
}

// Get URL parameters
function getUrlParameter(name) {
    name = name.replace(/[\[]/, '\\[').replace(/[\]]/, '\\]');
    const regex = new RegExp('[\\?&]' + name + '=([^&#]*)');
    const results = regex.exec(location.search);
    return results === null ? '' : decodeURIComponent(results[1].replace(/\+/g, ' '));
}

// Copy text to clipboard
function copyToClipboard(text) {
    const textarea = document.createElement('textarea');
    textarea.value = text;
    textarea.style.position = 'fixed';
    document.body.appendChild(textarea);
    textarea.select();
    
    try {
        const successful = document.execCommand('copy');
        document.body.removeChild(textarea);
        return successful;
    } catch (err) {
        document.body.removeChild(textarea);
        return false;
    }
}

// Show toast notification
function showToast(message, type = 'info', duration = 3000) {
    // Check if toast container exists, if not create it
    let toastContainer = document.getElementById('toast-container');
    
    if (!toastContainer) {
        toastContainer = document.createElement('div');
        toastContainer.id = 'toast-container';
        toastContainer.style.position = 'fixed';
        toastContainer.style.top = '20px';
        toastContainer.style.right = '20px';
        toastContainer.style.zIndex = '9999';
        document.body.appendChild(toastContainer);
    }
    
    // Create toast element
    const toast = document.createElement('div');
    toast.className = `toast toast-${type}`;
    toast.style.minWidth = '250px';
    toast.style.margin = '10px 0';
    toast.style.padding = '15px';
    toast.style.borderRadius = '4px';
    toast.style.boxShadow = '0 2px 5px rgba(0,0,0,0.2)';
    toast.style.opacity = '0';
    toast.style.transition = 'opacity 0.3s ease-in-out';
    
    // Set background color based on type
    switch (type) {
        case 'success':
            toast.style.backgroundColor = '#4CAF50';
            toast.style.color = 'white';
            break;
        case 'error':
            toast.style.backgroundColor = '#F44336';
            toast.style.color = 'white';
            break;
        case 'warning':
            toast.style.backgroundColor = '#FF9800';
            toast.style.color = 'white';
            break;
        default:
            toast.style.backgroundColor = '#2196F3';
            toast.style.color = 'white';
    }
    
    // Set message
    toast.textContent = message;
    
    // Add close button
    const closeButton = document.createElement('span');
    closeButton.style.float = 'right';
    closeButton.style.cursor = 'pointer';
    closeButton.style.marginLeft = '10px';
    closeButton.innerHTML = '&times;';
    closeButton.addEventListener('click', function() {
        removeToast(toast);
    });
    
    toast.insertBefore(closeButton, toast.firstChild);
    
    // Add toast to container
    toastContainer.appendChild(toast);
    
    // Show toast
    setTimeout(() => {
        toast.style.opacity = '1';
    }, 10);
    
    // Auto remove after duration
    setTimeout(() => {
        removeToast(toast);
    }, duration);
    
    // Function to remove toast
    function removeToast(toastElement) {
        toastElement.style.opacity = '0';
        setTimeout(() => {
            toastContainer.removeChild(toastElement);
            
            // Remove container if empty
            if (toastContainer.children.length === 0) {
                document.body.removeChild(toastContainer);
            }
        }, 300);
    }
}

// Debounce function to limit how often a function can be called
function debounce(func, wait) {
    let timeout;
    
    return function executedFunction(...args) {
        const later = () => {
            clearTimeout(timeout);
            func(...args);
        };
        
        clearTimeout(timeout);
        timeout = setTimeout(later, wait);
    };
}

// Add event listener with debounce
function addDebouncedEventListener(element, event, handler, wait) {
    const debouncedHandler = debounce(handler, wait);
    element.addEventListener(event, debouncedHandler);
    return debouncedHandler;
}

// Format file size
function formatFileSize(bytes) {
    if (bytes === 0) return '0 Bytes';
    
    const k = 1024;
    const sizes = ['Bytes', 'KB', 'MB', 'GB', 'TB'];
    const i = Math.floor(Math.log(bytes) / Math.log(k));
    
    return parseFloat((bytes / Math.pow(k, i)).toFixed(2)) + ' ' + sizes[i];
} 