# GCE Website - Development Context

## Business Context

**Grove City Events** is a community newsletter curating local events for 1,200+ subscribers in the Grove City area. The website serves as:
- Central hub for event discovery and listings
- Event Partner submission platform (reduces manual curation)
- Integration point with the weekly email newsletter (powered by Airtable → Zapier → Sendy)

**Key Metrics**
- 40-51% email open rates
- Strong community engagement and trust

## Content Standards
- **Factual accuracy:** Never infer or fabricate details — only use explicitly provided information
- **SEO-friendly:** Substantial, search-optimized event descriptions
- **Tone:** Warm, authentic, community-focused (no excessive formatting/embellishment)
- **Format guidance:** Event descriptions should be meaty enough for search while remaining readable

## Current Development Focus
- Testing automation via The Events Calendar API to reduce manual event entry
- Evaluating featured event sponsorships ($100/week) as revenue stream
- Maintaining content quality while scaling event management

## Important Integrations
- Events entered via The Events Calendar plugin feed into the newsletter pipeline
- Event Partner submissions reduce manual curation workload
- Website acts as source of truth for community event information

## Project Overview
Grove City Events website built on WordPress with Divi child theme. Events are managed through The Events Calendar plugin with custom templates for display and styling.

## Tech Stack
- **CMS:** WordPress
- **Theme:** Divi (child theme in `/`)
- **Events:** The Events Calendar plugin
- **Custom Templates:** Custom Tribe Events templates nested in theme

## Directory Structure
```
/
├── assets/          # CSS, JS, images
├── tribe-events/    # Custom Events Calendar templates
├── functions.php    # Child theme functions
├── style.css        # Theme stylesheet
└── [other Divi files]
```

## Key Files
- **functions.php** - Child theme customizations, hooks, filters
- **tribe-events/** - Overridden Events Calendar templates
- **style.css** - Additional custom styles (enqueued via functions.php)

## Important Notes
- Do not edit parent Divi theme files — all customizations go in child theme
- Events Calendar templates follow Tribe's structure (must be in `/tribe-events/`)
- CSS is enqueued via functions.php, not in header
- Changes sync via VS Code SFTP to `/public_html/wp-content/themes/divi-child`

## Development Workflow
1. Edit files locally
2. Test in local development environment or staging
3. Commit to GitHub
4. Push to live server via SFTP sync
5. Verify on live site

## Common Tasks
- Add/modify event templates → edit files in `/tribe-events/`
- Add custom styles → add to `style.css`
- Add custom functions → add to `functions.php`