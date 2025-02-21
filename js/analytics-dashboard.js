// Custom Google Analytics Dashboard Configuration
const dashboardConfig = {
    // SEO Performance Dashboard
    seo: {
        reportType: 'SEO_PERFORMANCE',
        metrics: [
            'organicSearches',
            'organicClicks',
            'averagePosition'
        ],
        dimensions: [
            'query',
            'page',
            'device'
        ]
    },
    
    // Backlink Analysis Dashboard
    backlinks: {
        reportType: 'BACKLINK_ANALYSIS',
        metrics: [
            'totalBacklinks',
            'newBacklinks',
            'lostBacklinks'
        ],
        dimensions: [
            'sourceDomain',
            'targetPage',
            'linkType'
        ]
    },
    
    // Competitor Analysis Dashboard
    competitors: {
        reportType: 'COMPETITOR_ANALYSIS',
        metrics: [
            'marketShare',
            'rankingPosition',
            'visibilityScore'
        ],
        dimensions: [
            'competitor',
            'keyword',
            'page'
        ]
    }
};

// Create custom dashboards
function createCustomDashboards() {
    Object.entries(dashboardConfig).forEach(([dashboardType, config]) => {
        gtag('config', 'AW-16520059025', {
            'custom_map': {
                'dimension1': config.reportType,
                'metric1': config.metrics.join(','),
                'dimension2': config.dimensions.join(',')
            }
        });
    });
}

// Initialize dashboards when Analytics is ready
window.addEventListener('load', createCustomDashboards); 