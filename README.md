# Local Business Directory for WordPress

A professional, high-performance WordPress plugin designed to create and manage a comprehensive local business directory. This plugin allows website owners to showcase local businesses with a rich set of features, custom categorization, and a seamless user experience.

![WordPress Plugin](https://img.shields.io/badge/WordPress-Plugin-blue?logo=wordpress)
![PHP](https://img.shields.io/badge/PHP-8.0+-777BB4?logo=php)
![License](https://img.shields.io/badge/License-MIT-green)

## Key Features

### For Visitors
- **Advanced AJAX Search**: Lightning-fast search with real-time filtering by category, industry (rubro), and zone without page reloads.
- **Interactive Business Profiles**: Dedicated single pages for each business featuring:
    - **Visual Gallery**: Responsive image carousel with lightbox effect.
    - **Direct Contact**: One-click call and a modern **WhatsApp Chat Popup** with automated personalized greeting and interactive input.
    - **Location Integration**: Integrated Google Maps for easy navigation.
    - **Operational Hours**: Clear and organized business schedule.
- **Fully Responsive**: Optimized for all devices (Mobile, Tablet, Desktop).

### For Administrators
- **Custom Post Type (CPT)**: Specialized "Negocio" post type for easy management.
- **Flexible Taxonomies**: Three flat taxonomies for precise classification:
    - `business_rubro` (Industry/Trade)
    - `business_categoria` (Category)
    - `business_zona` (Zone/Location)
- **Rich Metadata**: Custom metaboxes to manage logos, taglines, contact details, social media links, and operational hours.
- **Shortcode-Driven**: Easily embed the business search and directory anywhere on your site using shortcodes.

## Installation

1. **Download**: Clone or download this repository.
2. **Upload**: Upload the `local-business-directory` folder to your WordPress installation at `/wp-content/plugins/`.
3. **Activate**: Go to the WordPress Admin Dashboard $\rightarrow$ **Plugins** $\rightarrow$ **Activate** "Local Business Directory".
4. **Configure**: Start adding businesses via the new "Negocios" menu in the sidebar.

## Usage

### Adding a Business
Navigate to **Negocios $\rightarrow$ Add New**. Fill in the title, description, and the custom fields (WhatsApp, Phone, Address, Hours, Gallery, etc.).

### Displaying the Directory
Use the provided shortcodes in your pages or posts:
- `[lbd_search]` - Renders the advanced AJAX search form and the business results grid.

## Technical Stack

- **Backend**: PHP (WordPress Plugin API)
- **Frontend**: HTML5, CSS3 (Modern CSS Variables), Vanilla JavaScript (ES6+)
- **Data**: WordPress Custom Post Types & Meta Data
- **API**: WordPress AJAX API for real-time searching

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.

---
Developed by [Esteban Selvaggi](https://github.com/selvaggiesteban)
