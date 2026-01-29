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

---

## Divi JSON Layout Generation

For scalable, portable, and client-editable page layouts, we generate complete Divi JSON files that can be imported directly into the Divi Library and deployed to any page.

### Why Divi JSON Instead of PHP Templates

**Benefits:**
- ✅ Portable across projects and client sites
- ✅ Fully editable in Divi visual builder (client-friendly)
- ✅ No PHP knowledge required for customization
- ✅ Version controlled and reusable
- ✅ Works on any WordPress site with Divi

**When to Use:**
- Complete page layouts (dashboards, landing pages)
- Reusable sections (headers, footers, CTAs)
- Interactive components that need to be client-editable
- Layouts you'll use across multiple client projects

**When NOT to Use:**
- Site-specific functionality requiring PHP
- Templates that need dynamic WordPress queries
- Highly custom functionality that Divi can't handle

### Divi JSON Structure

```json
{
  "context": "et_builder_layouts",
  "data": {
    "1": {
      "ID": 1,
      "post_date": "2025-01-25 20:00:00",
      "post_date_gmt": "2025-01-26 01:00:00",
      "post_content": "[DIVI_SHORTCODES_HERE]",
      "post_title": "Layout Name",
      "post_excerpt": "",
      "post_status": "publish",
      "post_type": "et_pb_layout",
      "post_meta": {
        "_et_pb_built_for_post_type": ["page"]
      },
      "terms": {
        "3": {
          "name": "not_global",
          "slug": "not_global",
          "taxonomy": "scope"
        },
        "5": {
          "name": "regular",
          "slug": "regular",
          "taxonomy": "module_width"
        },
        "6": {
          "name": "layout",
          "slug": "layout",
          "taxonomy": "layout_type"
        }
      }
    }
  },
  "presets": "",
  "global_colors": "",
  "images": {},
  "thumbnails": []
}
```

**Key Fields:**
- `context`: Always `"et_builder_layouts"`
- `post_content`: The actual Divi shortcodes
- `post_title`: Name shown in Divi Library
- `terms.layout_type`: 
  - Use `"layout"` for complete pages
  - Use `"section"` for reusable sections

### Divi Shortcode Hierarchy

```
Section (et_pb_section)
  └─ Row (et_pb_row)
      └─ Column (et_pb_column)
          └─ Modules (et_pb_text, et_pb_code, etc.)
```

**Common Modules:**
- `et_pb_section` - Container for rows, controls background/spacing
- `et_pb_row` - Contains columns, defines column structure
- `et_pb_column` - Contains modules (types: `"4_4"`, `"1_2"`, `"1_3"`, etc.)
- `et_pb_text` - Formatted text and HTML
- `et_pb_code` - Custom HTML/CSS/JavaScript
- `et_pb_image` - Images
- `et_pb_button` - Buttons with links

### CRITICAL: What Doesn't Work in Divi Visual Builder

**🚫 DO NOT USE `et_pb_row_inner` (Inner Rows)**

Inner rows cause parsing errors in Divi's visual builder and make content non-editable.

**❌ WRONG:**
```
[et_pb_column type="3_4"]
  [et_pb_row_inner column_structure="1_2,1_2"]
    [et_pb_column_inner type="1_2"]
      [et_pb_blurb]Content[/et_pb_blurb]
    [/et_pb_column_inner]
  [/et_pb_row_inner]
[/et_pb_column]
```

**✅ CORRECT: Use Code Modules with CSS Grid**
```
[et_pb_column type="3_4"]
  [et_pb_code]
    <div class="my-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
      <div>Content 1</div>
      <div>Content 2</div>
    </div>
    <style>
    @media (max-width: 980px) {
      .my-grid { grid-template-columns: 1fr !important; }
    }
    </style>
  [/et_pb_code]
[/et_pb_column]
```

### Multi-Column Layout Pattern

For any multi-column grid layout, use this pattern:

```html
[et_pb_code admin_label="My Grid Section" _builder_version="4.27.5"]
<div class="unique-grid-name" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
  <div style="background: #fff; padding: 20px; border-radius: 8px;">
    <h3>Column 1</h3>
    <p>Content here</p>
  </div>
  <div style="background: #fff; padding: 20px; border-radius: 8px;">
    <h3>Column 2</h3>
    <p>Content here</p>
  </div>
  <div style="background: #fff; padding: 20px; border-radius: 8px;">
    <h3>Column 3</h3>
    <p>Content here</p>
  </div>
</div>
<style>
@media (max-width: 980px) {
  .unique-grid-name { grid-template-columns: 1fr !important; }
}
</style>
[/et_pb_code]
```

**Key Requirements:**
1. ✅ Add a unique class name to the grid div (e.g., `action-cards-grid`)
2. ✅ Include inline styles for desktop layout
3. ✅ Include `<style>` tag with media query for mobile
4. ✅ Use **980px** as breakpoint (matches Divi's mobile menu)
5. ✅ Use `!important` in media query to override inline styles

### Mobile Responsiveness

**Divi Breakpoints:**
- Desktop: 981px+
- Tablet: 768px - 980px
- Mobile: 767px and below

**Mobile Menu Breakpoint:** 980px (use this for layout stacking)

**Mobile-Specific Attributes:**
```
custom_padding_tablet="20px|20px|20px|20px|true|true"
custom_padding_phone="10px|10px|10px|10px|true|true"
custom_padding_last_edited="on|phone"
```

### CSS Class Integration

**Build Order (CRITICAL):**

1. **First:** Write CSS in `style.css` with all component classes
2. **Then:** Generate Divi JSON that references those classes via `module_class`

**Example:**

In `style.css`:
```css
.dashboard-container {
  display: flex;
  min-height: 100vh;
  background: #f5f7fa;
}

.ep-sidebar {
  width: 280px;
  background: #1a2238;
  padding: 30px 20px;
}
```

In Divi JSON:
```
[et_pb_section module_class="dashboard-container" ...]
  [et_pb_column module_class="ep-sidebar" ...]
```

**How It Works:**
- Child theme `functions.php` enqueues `style.css`
- Divi adds `module_class` to the HTML element
- Styles automatically apply
- Client can still edit in visual builder

### Import and Deployment

**To Import:**
1. Divi → Divi Library → Import & Export
2. Upload JSON file
3. Layout appears in library

**To Use:**
1. Edit page with Divi Builder
2. Click purple dots → "Load From Library"
3. Select imported layout
4. Customize in visual builder

**Client Editing:**
- Text, colors, spacing all editable
- JavaScript in code modules editable
- No technical knowledge needed

### Example: Event Partner Dashboard

**Files Created:**
- `event-partner-sidebar.json` - Reusable sidebar section
- `event-partner-dashboard-complete.json` - Complete layout with sample content
- `style.css` - All dashboard CSS classes

**Structure:**
```
Section (dashboard-container)
  Row (1_4, 3_4 columns)
    Column 1/4 (ep-sidebar)
      - Sidebar header
      - Quick action buttons
      - Upgrade prompt
      - Help links
    Column 3/4 (ep-main-content)
      - Welcome section
      - Action cards (code module with CSS Grid)
      - Value props (code module with CSS Grid)
      - Paid services (code module with CSS Grid)
      - Resources section
```

**Key Learnings:**
- ❌ Inner rows broke visual builder editing
- ✅ Code modules with CSS Grid worked perfectly
- ✅ Class names required on divs for media queries to work
- ✅ 980px breakpoint matches Divi mobile menu
- ✅ Everything is client-editable after import

### Checklist for Divi JSON Generation

Before creating a JSON file:

1. ✅ CSS written in `style.css` with all component classes
2. ✅ Classes tested and working on dev site
3. ✅ Design finalized and approved

When generating JSON:

1. ✅ Set `"context": "et_builder_layouts"`
2. ✅ Use proper `layout_type` taxonomy
3. ✅ Include `fb_built="1"` on sections
4. ✅ Use `_builder_version="4.27.5"` on all modules
5. ✅ Nest properly: Section → Row → Column → Modules
6. ✅ Use correct column types
7. ✅ Add `module_class` for CSS hooks
8. ✅ Use `et_pb_code` for multi-column grids (NOT inner rows)
9. ✅ Include class names on grid divs
10. ✅ Include mobile media queries at 980px
11. ✅ Test JavaScript in code modules
12. ✅ Provide responsive overrides when needed

### Common Patterns

**2-Column Grid:**
```html
<div class="two-col-grid" style="display: grid; grid-template-columns: 1fr 1fr; gap: 20px;">
  <div>Column 1</div>
  <div>Column 2</div>
</div>
<style>
@media (max-width: 980px) {
  .two-col-grid { grid-template-columns: 1fr !important; }
}
</style>
```

**3-Column Grid:**
```html
<div class="three-col-grid" style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
  <div>Column 1</div>
  <div>Column 2</div>
  <div>Column 3</div>
</div>
<style>
@media (max-width: 980px) {
  .three-col-grid { grid-template-columns: 1fr !important; }
}
</style>
```

**Card with Hover Effect:**
```html
<a href="/link/" style="background: #fff; padding: 30px; border-radius: 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); text-decoration: none; display: block; transition: all 0.2s;" onmouseover="this.style.boxShadow='0 4px 12px rgba(0,0,0,0.15)'; this.style.transform='translateY(-2px)';" onmouseout="this.style.boxShadow='0 1px 3px rgba(0,0,0,0.1)'; this.style.transform='translateY(0)';">
  <h3>Card Title</h3>
  <p>Card content</p>
</a>
```

### Troubleshooting

**"Oops! An Error Has Occurred" when editing:**
- Check for inner rows (`et_pb_row_inner`) - replace with code modules
- Verify all shortcodes are properly closed
- Check for special characters in JSON (escape properly)

**Grids not stacking on mobile:**
- Add class name to the grid div
- Verify media query uses the class name
- Check breakpoint is 980px
- Add `!important` to override inline styles

**Styles not applying:**
- Verify `style.css` is uploaded and enqueued
- Check `module_class` attribute matches CSS class name
- Clear browser cache and WordPress cache
- Check for CSS specificity issues

---

## Important Notes
- Do not edit parent Divi theme files — all customizations go in child theme
- Events Calendar templates follow Tribe's structure (must be in `/tribe-events/`)
- CSS is enqueued via functions.php, not in header
- Changes sync via VS Code SFTP to `/public_html/wp-content/themes/divi-child`
- For portable layouts, use Divi JSON generation instead of PHP templates
