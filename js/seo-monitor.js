class SEOMonitor {
    constructor() {
        this.competitors = [
            'competitor1.com',
            'competitor2.com',
            'competitor3.com'
        ];
        this.lastAuditDate = localStorage.getItem('lastBacklinkAudit') || null;
    }

    async runBacklinkAudit() {
        const currentDate = new Date().toISOString();
        
        try {
            // Check own backlinks
            const ownBacklinks = await this.checkBacklinks(window.location.hostname);
            
            // Check competitor backlinks
            const competitorData = await Promise.all(
                this.competitors.map(async competitor => {
                    const backlinks = await this.checkBacklinks(competitor);
                    return { domain: competitor, backlinks };
                })
            );
            
            // Send data to Google Analytics
            this.sendToAnalytics(ownBacklinks, competitorData);
            
            // Store audit date
            localStorage.setItem('lastBacklinkAudit', currentDate);
            
            return {
                status: 'success',
                ownBacklinks,
                competitorData,
                auditDate: currentDate
            };
        } catch (error) {
            console.error('Backlink audit failed:', error);
            return { status: 'error', message: error.message };
        }
    }

    async checkBacklinks(domain) {
        const response = await fetch('/api/check-backlinks', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ domain })
        });
        return await response.json();
    }

    sendToAnalytics(ownBacklinks, competitorData) {
        gtag('event', 'backlink_audit', {
            'event_category': 'SEO',
            'event_label': 'Backlink Comparison',
            'own_backlinks': ownBacklinks.data.total,
            'competitor_data': JSON.stringify(competitorData)
        });
    }
}

// Initialize and schedule audits
document.addEventListener('DOMContentLoaded', () => {
    const seoMonitor = new SEOMonitor();
    
    // Run audit if it hasn't been run in the last week
    const lastAudit = localStorage.getItem('lastBacklinkAudit');
    if (!lastAudit || Date.now() - new Date(lastAudit) > 7 * 24 * 60 * 60 * 1000) {
        seoMonitor.runBacklinkAudit();
    }
}); 