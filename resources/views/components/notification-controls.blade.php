<!-- Notification & Feedback Controls -->
<div class="fixed bottom-4 right-4 z-40 flex flex-col gap-3">
    <!-- Enable Notifications Button -->
    <button 
        id="notificationToggle"
        class="flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105"
        title="Enable push notifications for new jobs"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path d="M10 2a6 6 0 00-6 6v3.586l-.707.707A1 1 0 004 14h12a1 1 0 00.707-1.707L16 11.586V8a6 6 0 00-6-6zM10 18a3 3 0 01-3-3h6a3 3 0 01-3 3z"/>
        </svg>
        <span class="font-medium">Enable Notifications</span>
    </button>

    <!-- Feedback Button -->
    <button 
        id="feedbackBtn"
        class="flex items-center gap-2 bg-purple-600 hover:bg-purple-700 text-white px-4 py-3 rounded-full shadow-lg transition-all duration-300 hover:scale-105"
        title="Send us your feedback"
    >
        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
            <path fill-rule="evenodd" d="M18 10c0 3.866-3.582 7-8 7a8.841 8.841 0 01-4.083-.98L2 17l1.338-3.123C2.493 12.767 2 11.434 2 10c0-3.866 3.582-7 8-7s8 3.134 8 7zM7 9H5v2h2V9zm8 0h-2v2h2V9zM9 9h2v2H9V9z" clip-rule="evenodd"/>
        </svg>
        <span class="font-medium">Feedback</span>
    </button>
</div>

<!-- Feedback Modal -->
<div id="feedbackModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 items-center justify-center p-4">
    <div class="bg-white rounded-lg shadow-xl max-w-md w-full p-6 relative animate-scale-in">
        <!-- Close Button -->
        <button 
            onclick="window.notificationManager?.hideFeedbackModal()"
            class="absolute top-4 right-4 text-gray-400 hover:text-gray-600"
        >
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>

        <!-- Modal Header -->
        <div class="mb-6">
            <h3 class="text-2xl font-bold text-gray-900 mb-2">Send Feedback</h3>
            <p class="text-gray-600">We'd love to hear from you! Your feedback helps us improve.</p>
        </div>

        <!-- Feedback Form -->
        <form id="feedbackForm" class="space-y-4">
            <!-- Feedback Type -->
            <div>
                <label for="feedbackType" class="block text-sm font-medium text-gray-700 mb-2">
                    Feedback Type
                </label>
                <select 
                    id="feedbackType" 
                    name="type"
                    required
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                >
                    <option value="general">General Feedback</option>
                    <option value="bug">Report a Bug</option>
                    <option value="feature">Feature Request</option>
                </select>
            </div>

            <!-- Message -->
            <div>
                <label for="feedbackMessage" class="block text-sm font-medium text-gray-700 mb-2">
                    Your Message <span class="text-red-500">*</span>
                </label>
                <textarea 
                    id="feedbackMessage" 
                    name="message"
                    rows="4"
                    required
                    maxlength="1000"
                    placeholder="Tell us what you think..."
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent resize-none"
                ></textarea>
                <p class="text-xs text-gray-500 mt-1">Maximum 1000 characters</p>
            </div>

            <!-- Email (Optional) -->
            <div>
                <label for="feedbackEmail" class="block text-sm font-medium text-gray-700 mb-2">
                    Email (Optional)
                </label>
                <input 
                    type="email" 
                    id="feedbackEmail" 
                    name="email"
                    placeholder="your@email.com"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-transparent"
                />
                <p class="text-xs text-gray-500 mt-1">We'll only use this to respond to your feedback</p>
            </div>

            <!-- Submit Button -->
            <div class="flex gap-3 pt-2">
                <button 
                    type="button"
                    onclick="window.notificationManager?.hideFeedbackModal()"
                    class="flex-1 px-4 py-2 border border-gray-300 text-gray-700 rounded-lg hover:bg-gray-50 transition-colors"
                >
                    Cancel
                </button>
                <button 
                    type="submit"
                    class="flex-1 px-4 py-2 bg-purple-600 text-white rounded-lg hover:bg-purple-700 transition-colors font-medium"
                >
                    Send Feedback
                </button>
            </div>
        </form>
    </div>
</div>

<!-- Add custom animations -->
<style>
    @keyframes slide-up {
        from {
            transform: translateY(100%);
            opacity: 0;
        }
        to {
            transform: translateY(0);
            opacity: 1;
        }
    }

    @keyframes scale-in {
        from {
            transform: scale(0.9);
            opacity: 0;
        }
        to {
            transform: scale(1);
            opacity: 1;
        }
    }

    .animate-slide-up {
        animation: slide-up 0.3s ease-out;
    }

    .animate-scale-in {
        animation: scale-in 0.2s ease-out;
    }
</style>
