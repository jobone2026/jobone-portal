import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// Featured Jobs Category Filter
window.filterJobsByCategory = function(category) {
    const allCards = document.querySelectorAll('.job-card-featured');
    const filterButtons = document.querySelectorAll('.filter-btn');
    
    // Update active button
    filterButtons.forEach(btn => btn.classList.remove('active'));
    event.target.closest('.filter-btn').classList.add('active');
    
    // Filter cards
    allCards.forEach(card => {
        if (category === 'all') {
            card.style.display = 'block';
            return;
        }
        
        const badges = card.querySelectorAll('span');
        let shouldShow = false;
        
        badges.forEach(badge => {
            const text = badge.textContent.toLowerCase().trim();
            
            // Match category
            if (category === 'new' && card.dataset.isNew === 'true') {
                shouldShow = true;
            } else if (category === 'urgent' && card.dataset.isUrgent === 'true') {
                shouldShow = true;
            } else if (category === 'banking' && text.includes('bank')) {
                shouldShow = true;
            } else if (category === 'railway' && text.includes('railway')) {
                shouldShow = true;
            } else if (category === 'ssc' && text.includes('ssc')) {
                shouldShow = true;
            } else if (category === 'upsc' && text.includes('upsc')) {
                shouldShow = true;
            } else if (category === 'allindia' && (text.includes('all india') || text.includes('🇮🇳'))) {
                shouldShow = true;
            }
        });
        
        card.style.display = shouldShow ? 'block' : 'none';
    });
};
