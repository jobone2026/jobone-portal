/**
 * Web Push Notifications Manager
 * Handles notification subscription, unsubscription, and feedback
 */

class WebNotificationManager {
    constructor() {
        this.vapidPublicKey = document.querySelector('meta[name="vapid-public-key"]')?.content;
        this.isSupported = 'serviceWorker' in navigator && 'PushManager' in window;
        this.subscribeBtn = document.getElementById('notificationToggle');
        this.feedbackBtn = document.getElementById('feedbackBtn');
        this.init();
    }

    async init() {
        if (!this.isSupported) {
            console.log('Push notifications not supported');
            this.hideNotificationUI();
            return;
        }

        // For now, skip service worker registration and just handle UI
        // Check current subscription status
        await this.updateUI();
        
        // Setup event listeners
        this.setupEventListeners();
    }
            this.setupEventListeners();
        } catch (error) {
            console.error('Service Worker registration failed:', error);
        }
    }

    setupEventListeners() {
        if (this.subscribeBtn) {
            this.subscribeBtn.addEventListener('click', () => this.toggleSubscription());
        }

        if (this.feedbackBtn) {
            this.feedbackBtn.addEventListener('click', () => this.showFeedbackModal());
        }
    }

    async toggleSubscription() {
        const permission = await Notification.requestPermission();
        
        if (permission !== 'granted') {
            this.showToast('Please allow notifications in your browser settings', 'warning');
            this.showLoading(false);
            return;
        }

        // For now, just simulate subscription without actual push
        const isSubscribed = localStorage.getItem('notifications_enabled') === 'true';
        
        if (isSubscribed) {
            await this.unsubscribeSimple();
        } else {
            await this.subscribeSimple();
        }
    }

    async subscribeSimple() {
        try {
            this.showLoading(true);

            // Store in localStorage for now
            localStorage.setItem('notifications_enabled', 'true');

            const response = await fetch('/notifications/subscribe', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify({
                    endpoint: 'simple-' + Date.now(),
                    keys: {
                        p256dh: 'simple-key',
                        auth: 'simple-auth'
                    }
                })
            });

            const data = await response.json();

            if (data.success) {
                this.showToast('🔔 Notifications enabled! You\'ll get updates on new jobs', 'success');
                await this.updateUI();
            } else {
                throw new Error(data.message);
            }

        } catch (error) {
            console.error('Subscription failed:', error);
            this.showToast('Failed to enable notifications', 'error');
            localStorage.removeItem('notifications_enabled');
        } finally {
            this.showLoading(false);
        }
    }

    async unsubscribeSimple() {
        try {
            this.showLoading(true);

            localStorage.removeItem('notifications_enabled');
            
            this.showToast('🔕 Notifications disabled', 'info');
            await this.updateUI();

        } catch (error) {
            console.error('Unsubscription failed:', error);
            this.showToast('Failed to disable notifications', 'error');
        } finally {
            this.showLoading(false);
        }
    }

    async updateUI() {
        if (!this.subscribeBtn) return;

        const isSubscribed = localStorage.getItem('notifications_enabled') === 'true';

        if (isSubscribed) {
            this.subscribeBtn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg><span>Notifications ON</span>';
            this.subscribeBtn.style.backgroundColor = '#16a34a';
        } else {
            this.subscribeBtn.innerHTML = '<svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/></svg><span>Enable Notifications</span>';
            this.subscribeBtn.style.backgroundColor = '#2563eb';
        }
    }

    showFeedbackModal() {
        const modal = document.getElementById('feedbackModal');
        if (modal) {
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        }
    }

    hideFeedbackModal() {
        const modal = document.getElementById('feedbackModal');
        if (modal) {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }
    }

    async submitFeedback(formData) {
        try {
            const response = await fetch('/feedback', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                },
                body: JSON.stringify(formData)
            });

            const data = await response.json();

            if (data.success) {
                this.showToast(data.message, 'success');
                this.hideFeedbackModal();
                document.getElementById('feedbackForm').reset();
            } else {
                throw new Error(data.message);
            }

        } catch (error) {
            console.error('Feedback submission failed:', error);
            this.showToast('Failed to submit feedback', 'error');
        }
    }

    showToast(message, type = 'info') {
        const toast = document.createElement('div');
        const colors = {
            success: 'bg-green-500',
            error: 'bg-red-500',
            warning: 'bg-yellow-500',
            info: 'bg-blue-500'
        };

        toast.className = `fixed bottom-4 right-4 ${colors[type]} text-white px-6 py-3 rounded-lg shadow-lg z-50 animate-slide-up`;
        toast.textContent = message;
        document.body.appendChild(toast);

        setTimeout(() => {
            toast.remove();
        }, 4000);
    }

    showLoading(show) {
        if (this.subscribeBtn) {
            this.subscribeBtn.disabled = show;
            if (show) {
                this.subscribeBtn.innerHTML = '<svg class="animate-spin h-5 w-5" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg><span>Loading...</span>';
            }
        }
    }

    hideNotificationUI() {
        if (this.subscribeBtn) {
            this.subscribeBtn.style.display = 'none';
        }
    }

    urlBase64ToUint8Array(base64String) {
        const padding = '='.repeat((4 - base64String.length % 4) % 4);
        const base64 = (base64String + padding).replace(/\-/g, '+').replace(/_/g, '/');
        const rawData = window.atob(base64);
        const outputArray = new Uint8Array(rawData.length);
        for (let i = 0; i < rawData.length; ++i) {
            outputArray[i] = rawData.charCodeAt(i);
        }
        return outputArray;
    }
}

// Initialize when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        window.notificationManager = new WebNotificationManager();
    });
} else {
    window.notificationManager = new WebNotificationManager();
}

// Handle feedback form submission
document.addEventListener('DOMContentLoaded', () => {
    const feedbackForm = document.getElementById('feedbackForm');
    if (feedbackForm) {
        feedbackForm.addEventListener('submit', async (e) => {
            e.preventDefault();
            
            const formData = {
                type: document.getElementById('feedbackType').value,
                message: document.getElementById('feedbackMessage').value,
                email: document.getElementById('feedbackEmail').value,
                page_url: window.location.href
            };

            if (window.notificationManager) {
                await window.notificationManager.submitFeedback(formData);
            }
        });
    }

    // Close modal on outside click
    const modal = document.getElementById('feedbackModal');
    if (modal) {
        modal.addEventListener('click', (e) => {
            if (e.target === modal) {
                window.notificationManager?.hideFeedbackModal();
            }
        });
    }
});
