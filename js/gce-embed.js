/**
 * GCE Embed Auto-Resize Handler
 * Automatically resizes Grove City Events calendar embeds
 */
(function() {
    'use strict';
    
    // Listen for resize messages from GCE iframes
    window.addEventListener('message', function(e) {
        // Only accept messages from Grove City Events
        if (e.origin !== 'https://grovecityevents.com') {
            return;
        }
        
        // Check if this is a resize message
        if (e.data && e.data.type === 'gce-resize') {
            // Find all GCE embed iframes and resize them
            var iframes = document.querySelectorAll('iframe.gce-embed');
            
            iframes.forEach(function(iframe) {
                iframe.style.height = e.data.height + 'px';
            });
        }
    });
})();