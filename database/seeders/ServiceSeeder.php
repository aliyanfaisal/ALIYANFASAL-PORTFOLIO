<?php

namespace Database\Seeders;

use App\Models\Service;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    public function run(): void
    {
        $services = [
            [
                'title' => 'build, fix or customize wordpress plugin or theme using php',
                'slug' => 'build-or-customize-wordpress-plugin-or-theme-using-php',
                'category' => 'Software Development',
                'description' => 'I am Aliyan Faisal a PHP and WordPress Expert. I can build you any kind of Plugin or Theme or any other Custom Customization to your existing WordPress site.My Expertise:
- Plugin Development
- Customization of WordPress Plugin or Theme
- Theme Development
- Fully-Dynamic and Custom Website
- Elementor Fix
- Custom WordPress features
- WordPress Rest APIs
- WordPress Malware Clean
- Plugin Bugs Fixing
- PHP code Error Fixing
- Astra, Divi, Themeforest, WpBakery, Elementor Pro, WooCommerce, YoastSEO and many other Plugins expert
- Ecommerce Website Development
- Woocommerce CustomizationAlso, I can:
- I offer all kinds of Plugin development some are as followed:
- WooCommerce for eCommerce related plugin
- Integrate payment gateways
- WooCommerce customizations
- Membership Customizations
- Plugin to integrate any kind of API
- Elementor Page Builder Releated Plugin
- Ajax and Dynamic Content
- Shortcodes and Widgets
- jetEngine / Custom Post Type Plugin
- Contact Forms
- Form Builder
- Additional Theme Options
- Custom Meta Boxes
- WooCommerce Cart, Checkout, Order, etc.. enhancement
- Database Data Getting and Setting Plugin
- REST API
- Shortcode
- Metadata Please leave a message before placing an order :)Best regards: Aliyan Faisal',
                'price_from' => 50,
                'rating' => 5,
                'rating_count' => 162,
                'image_url' => 'https://fiverr-res.cloudinary.com/t_main1,q_auto,f_auto/gigs/239974402/original/5fa6cbf61000f2a1c7e9cd9e39d134cba992f15a.png',
                'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal/build-or-customize-wordpress-plugin-or-theme-using-php',
                'featured' => true,
                'sort_order' => 0,
                'packages' => [
                    [
                        'tier' => 'Starter',
                        'price' => 50.0,
                        'delivery_days' => 48,
                        'description' => 'I will customize your existing wordpress plugin',
                        'sort_order' => 0,
                    ],
                    [
                        'tier' => 'Standard',
                        'price' => 80.0,
                        'delivery_days' => 96,
                        'description' => 'I will customize your plugin and add new additional features to it.',
                        'sort_order' => 1,
                    ],
                    [
                        'tier' => 'premium',
                        'price' => 150.0,
                        'delivery_days' => 168,
                        'description' => 'I will build create a custom wordpress plugin from 
scratch',
                        'sort_order' => 2,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Why Me For Plugin Development',
                        'answer' => 'With over 5 years of experience in WordPress custom development, I specialize in creating tailored solutions to meet your specific needs. Before you place an order, I provide a prototype of the plugin to demonstrate my capabilities and ensure it aligns with your expectations. Client satisfaction is',
                        'sort_order' => 0,
                    ],
                    [
                        'question' => 'Do I Build from Scratch or Customize Existing Plugin?',
                        'answer' => 'I offer comprehensive WordPress plugin development services, including creating new plugins from scratch and customizing existing ones based on your specific requirements. If the features you need are available in an existing plugin, I can tailor it to meet your needs. If not, I will develop a custo',
                        'sort_order' => 1,
                    ],
                ],
            ],
            [
                'title' => 'develop modern PHP laravel web apps, rest apis, and fix bugs',
                'slug' => 'develop-website-or-fix-bugs-using-php-laravel-mysql-jquery-and-ajax',
                'category' => 'Software Development',
                'description' => 'As a Full Stack PHP & Laravel Developer, I create modern Laravel web applications and websites from scratch. I specialize in bug fixing, error resolution, and performance improvements in PHP and Laravel projects.Whether you need Laravel web app development, debugging, feature enhancements, or maintenance, I provide reliable, efficient solutions to make your application run smoothly and scale effectively.I love building and improving Laravel web apps, and I\'m here to help turn your ideas into robust, high-performing web solutions.Features:
- Modern Web App Development
- Bug Fixing & Error Troubleshooting
- Single Page Applications (SPA)
- Laravel API Development
- Third-party Service Integrations
- Backend Development for Web or Mobile
- Admin Dashboards / Panels
- Dynamic Web Applications
- Adding or Updating Features
- Documentation & Code Improvements
- Laravel Version Upgrades
- External API & Web Service IntegrationTechnologies:
- PHP 8+,
- Laravel,
- React / VueJS / Blade,
- TailwindCSS and Bootstrap
- MySQL, PostgreSQL, Supabase,
- jQueryI deliver on time and focus on providing 100% client satisfaction.Have any questions? Feel free to reach out.RegardsAliyan Faisal',
                'price_from' => 40,
                'rating' => 5,
                'rating_count' => 21,
                'image_url' => 'https://fiverr-res.cloudinary.com/t_main1,q_auto,f_auto/gigs/182710156/original/e66f3385949ff9311fda905f747cddf5a79f0746.png',
                'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal/develop-website-or-fix-bugs-using-php-laravel-mysql-jquery-and-ajax',
                'featured' => true,
                'sort_order' => 1,
                'packages' => [
                    [
                        'tier' => 'Starter',
                        'price' => 40.0,
                        'delivery_days' => 72,
                        'description' => 'Simple Design, bug fixes, and troubleshooting in Laravel, MySQL, and JavaScript.',
                        'sort_order' => 0,
                    ],
                    [
                        'tier' => 'Standard',
                        'price' => 100.0,
                        'delivery_days' => 144,
                        'description' => 'Advance design updates, bug fixes, and advanced troubleshooting in Laravel, MySQL, and JS',
                        'sort_order' => 1,
                    ],
                    [
                        'tier' => 'Premium Pro',
                        'price' => 200.0,
                        'delivery_days' => 240,
                        'description' => 'Complex design work, major bug fixes, performance improvements, and complex Laravel, MySQL, or JS',
                        'sort_order' => 2,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Why Choose me',
                        'answer' => 'I have over 5 years of experience in PHP and Laravel, with 200+ satisfied clients across freelance platforms. I’m committed to delivering top-quality service with unlimited revisions until your project is completed to your satisfaction.',
                        'sort_order' => 0,
                    ],
                    [
                        'question' => 'What services do you offer for Laravel web apps?',
                        'answer' => 'I provide full Laravel development, including building web applications from scratch, fixing bugs, improving performance, adding new features, and maintaining existing projects.',
                        'sort_order' => 1,
                    ],
                    [
                        'question' => 'Can you fix PHP or Laravel errors in my existing project?',
                        'answer' => 'Yes! I specialize in debugging and resolving PHP/Laravel errors, including fatal errors, database issues, route problems, API integration issues, and more.',
                        'sort_order' => 2,
                    ],
                    [
                        'question' => 'Do you work on custom web applications or only templates?',
                        'answer' => 'I work on both custom-built Laravel apps and existing projects, improving functionality, optimizing performance, and enhancing user experience.',
                        'sort_order' => 3,
                    ],
                    [
                        'question' => 'How do you ensure my web app runs smoothly after bug fixes?',
                        'answer' => 'I follow best practices for Laravel and PHP, thoroughly test the app, check for database and server errors, and ensure all features work correctly before delivery.',
                        'sort_order' => 4,
                    ],
                    [
                        'question' => 'Do you provide ongoing support after delivery?',
                        'answer' => 'Yes! I can provide ongoing maintenance, updates, and bug fixes to ensure your Laravel application continues to run smoothly and securely.',
                        'sort_order' => 5,
                    ],
                ],
            ],
            [
                'title' => 'build ai woocommerce automation for store products, orders, chatbot',
                'slug' => 'do-ai-woocommerce-automation-for-store-products-orders-emails-seo-chatbot',
                'category' => 'AI Development',
                'description' => 'Turn your WooCommerce store into a fully automated, AI-powered business.I build AI WooCommerce automation, AI assistants, SaaS workflows, and external integrations that automate your store, reduce manual work, and improve customer experience.Whether you need an AI chatbot, AI shopping assistant, email automation, or custom API integrations, I can build a solution tailored to your business.
- AI Assistant & Shopping: AI helps customers find products and buy faster.
- AI Chatbot: 24/7 support trained on your products, FAQs, and policies.
- SaaS & API Integrations: Connect WooCommerce with CRMs, Google Sheets, Airtable, Notion, Slack, Discord, payment gateways, and more.
- Workflow Automation: Automate products, orders, customer support, and repetitive tasks.
- AI Product SEO: Generate SEO descriptions, FAQs, and optimize product content.
- Email Automation: Smart follow-ups, abandoned cart recovery, upsells, and post-purchase flows.
- Fraud Detection: Detect suspicious, duplicate, and unpaid orders.You\'ll Get:
- AI WooCommerce automation
- AI chatbot & AI assistant
- SaaS & external integrations
- Email automation
- Custom AI workflowsLeave a message before placing an Order! Thanks :)',
                'price_from' => 90,
                'rating' => 5,
                'rating_count' => 3,
                'image_url' => 'https://fiverr-res.cloudinary.com/t_main1,q_auto,f_auto/gigs/476824125/original/53c8f04abfb61b679d74928ecf0c74acd16aac6c.png',
                'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal/do-ai-woocommerce-automation-for-store-products-orders-emails-seo-chatbot',
                'featured' => true,
                'sort_order' => 2,
                'packages' => [
                    [
                        'tier' => 'Starter Automation',
                        'price' => 90.0,
                        'delivery_days' => 48,
                        'description' => '-> AI chatbot
-> WooCommerce integration
-> FAQ training
-> Product Q&A',
                        'sort_order' => 0,
                    ],
                    [
                        'tier' => 'Smart Store Automation',
                        'price' => 200.0,
                        'delivery_days' => 168,
                        'description' => '-> Basic AI assistant
-> AI products
-> Automation with Social Media
-> AI Customer support',
                        'sort_order' => 1,
                    ],
                    [
                        'tier' => 'Advanced AI WooCommerce Automation',
                        'price' => 500.0,
                        'delivery_days' => 336,
                        'description' => '-> AI shopping assistant
-> Advanced AI chatbot
-> AI maintenance assistant
-> SaaS Automation',
                        'sort_order' => 2,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'What is AI WooCommerce automation?',
                        'answer' => 'AI WooCommerce automation uses artificial intelligence to automate tasks in your WooCommerce store, such as product recommendations, abandoned cart recovery, SEO optimization, smart email flows, fraud detection, and customer support. It helps increase conversions while reducing manual work.',
                        'sort_order' => 0,
                    ],
                    [
                        'question' => 'How can AI increase my WooCommerce sales?',
                        'answer' => 'AI boosts sales by recommending products, recovering abandoned carts, sending targeted emails, optimizing SEO, and creating smart upsells — all to increase conversions and improve customer experience.',
                        'sort_order' => 1,
                    ],
                    [
                        'question' => 'Will AI optimize my product SEO?',
                        'answer' => 'Yes. I provide AI-powered SEO optimization, including:
- SEO-friendly product descriptions
- Keyword-rich content
- Meta titles and descriptions
- AI-generated FAQs

This helps improve search rankings.',
                        'sort_order' => 2,
                    ],
                    [
                        'question' => 'Do you provide WooCommerce abandoned cart automation?',
                        'answer' => 'Yes. I set up automated abandoned cart recovery systems that send reminder emails and discount offers to recover lost sales and boost revenue.',
                        'sort_order' => 3,
                    ],
                    [
                        'question' => 'Can you add an AI chatbot to my WooCommerce store?',
                        'answer' => 'Yes. I can integrate a custom AI chatbot trained on your store products, FAQs, and policies. It can:
- Answer customer questions 24/7
- Recommend products
- Reduce support workload
- Improve engagement',
                        'sort_order' => 4,
                    ],
                    [
                        'question' => 'Can you automate order management in WooCommerce?',
                        'answer' => 'Absolutely. I can automate:
- Order status updates
- Fraud detection
- Unpaid order handling
- Customer tagging
- Post-purchase follow-ups',
                        'sort_order' => 5,
                    ],
                    [
                        'question' => 'What technology will you use for AI WooCommerce automation?',
                        'answer' => 'I use either existing AI APIs like OpenAI, Gemini, or DeepSeek, or a custom AI model built and deployed on your server with Python. Both options automate tasks like product recommendations, abandoned cart recovery, smart emails, and SEO optimization.',
                        'sort_order' => 6,
                    ],
                ],
            ],
            [
                'title' => 'build customize and fix bugs in your woocommerce website',
                'slug' => 'build-shop-single-product-cart-checkout-pages-using-elementor-woocommerce',
                'category' => 'Website Development',
                'description' => 'Hey there, I am Aliyan Faisal a PHP WordPress Expert with more than 5 years of experience. I can build you an extraordinary E-Commerce Website with custom design and features.I will be using Elementor Pro along with WooCommerce to setup an E-Store for you.This package will include:
- Website Setup for E-Commerce
- Installation of Plugins ( Elementor and WooCommerce)
- Custom Design that you want ( not the usual dull design that comes with WooCommerce, this will be a custom design )
- Custom Features if you want to use Custom Coding
- Shop, Product, Cart, Checkout, Profile, Registration / Login, User Dashboard, and other pages
- Filters for you: Every kind of filter that you want on your shop page
- Archive Product, Single Product Search, Header, Footer, and Custom Loop pages
- Good Admin Setups like order invoices, alerts, marketing
- Figma / Adobe XD design of your Store into a WordPress website using Elementor Pro and some AddonsThe design will be exactly the same as you want and your every requirement will be fulfilled in time before your deadlines.I am always ready to start off the work as early as possible and surely impress you with my services.Leave me a message before any Order.',
                'price_from' => 80,
                'rating' => 5,
                'rating_count' => 1,
                'image_url' => 'https://fiverr-res.cloudinary.com/t_main1,q_auto,f_auto/gigs/312377312/original/7d229865b4eaefee55761f9fe752cc065e7144f9.png',
                'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal/build-shop-single-product-cart-checkout-pages-using-elementor-woocommerce',
                'featured' => false,
                'sort_order' => 3,
                'packages' => [
                    [
                        'tier' => 'Starter',
                        'price' => 80.0,
                        'delivery_days' => 120,
                        'description' => 'Woocommerce customization and bug fix with your Custom Design using Woocommerce',
                        'sort_order' => 0,
                    ],
                    [
                        'tier' => 'Economy',
                        'price' => 100.0,
                        'delivery_days' => 168,
                        'description' => 'Customization of Woocommerce pages Design with filters, bug fix and custom functionalities',
                        'sort_order' => 1,
                    ],
                    [
                        'tier' => 'Recommended',
                        'price' => 150.0,
                        'delivery_days' => 240,
                        'description' => 'Your design with custom features exact same design for your whole website with filters,SEO, Bug Fix',
                        'sort_order' => 2,
                    ],
                ],
                'faqs' => [
                ],
            ],
            [
                'title' => 'design custom website, header, elementor pro, woocommerce, figma2wp',
                'slug' => 'develop-and-design-any-website-or-landing-page-with-elementor-pro-theme-builder',
                'category' => 'Software Development',
                'description' => 'Are you looking to design your Website the way you want? You are at right place. I can design your Website according to your Custom Requirements or from FIGMA :)I specialize in high-quality design with Elementor Pro Theme Builder / Custom Code, including tailored Custom Headers, Footers, Archive, and Single Post Pages that are consistent with your brand identity. Whether it\'s a reference site or a Figma file, I can design the same Website professionally via Elementor or a Custom Theme/Plugin.You\'ll get
- Custom Header and Footer Design that reflects your brand and improves navigation.
- Dynamic Archive, Single, Search, Profile and Landing Pages for optimized and flexible development
- WooCommerce Custom Page like Shop, Single Product, Filters, Cart, Checkout and Profile Pages
- Responsive Design: Your pages will look great on PCs, tablets, and mobile devices.
- SEO-Friendly: Optimized for search engines to boost website rankings.
- Quick loading speed: Built using performance in mind for a better user experience.Take your website to the next level with a custom design that\'s not only visually appealing but also functional and user-friendly.Leave a message before placing an Order :)',
                'price_from' => 80,
                'rating' => 5,
                'rating_count' => 1,
                'image_url' => 'https://fiverr-res.cloudinary.com/t_main1,q_auto,f_auto/gigs/414092919/original/dc21adf6e26c58f413a37aa7937e2765dcacb973.png',
                'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal/develop-and-design-any-website-or-landing-page-with-elementor-pro-theme-builder',
                'featured' => false,
                'sort_order' => 4,
                'packages' => [
                    [
                        'tier' => 'Starter',
                        'price' => 80.0,
                        'delivery_days' => 48,
                        'description' => 'Create 2 custom page as per Client Requirements using Elementor pro',
                        'sort_order' => 0,
                    ],
                    [
                        'tier' => 'Economical',
                        'price' => 130.0,
                        'delivery_days' => 96,
                        'description' => 'Design a Design with custom Header, footer and templates',
                        'sort_order' => 1,
                    ],
                    [
                        'tier' => 'Business',
                        'price' => 200.0,
                        'delivery_days' => 240,
                        'description' => 'Develop a complete Custom WordPress website/Store using Elementor pro Theme Builder',
                        'sort_order' => 2,
                    ],
                ],
                'faqs' => [
                ],
            ],
            [
                'title' => 'build an ecommerce store website using wordpress and woocommerce',
                'slug' => 'build-a-ecommerce-website-store-shop-wordpress-jetengine-woocommerce-plugin',
                'category' => 'Website Maintenance',
                'description' => 'Hello :D,I\'m Aliyan Faisal, an experienced E-Commerce developer specializing in WooCommerce. I\'m here to bring your E-Commerce store to life.What I Offer: Tailored Store: Get a unique E-Commerce store designed to engage and convert visitors.WooCommerce Integration: Seamlessly integrate WooCommerce for product management and secure payments.User Experience: Optimize your store\'s layout for a smooth and satisfying customer journey.Custom Features & Design: Enjoy a captivating visual identity that aligns with your brand values.Plugin Integration: Enhance your store\'s functionality with essential plugins. ( Payment, Marketing, Inventory, Multi-Vendor etc )And Many More...Why Choose Me:Expertise: With 6 years of experience & Level 2 Seller.Timely Delivery: Count on prompt project completion without compromising quality.Communication: Stay updated at every development stage for a successful project. Quality Assurance: Your glitch-free, secure, and market-ready store is my priority.Collaboration: I work closely with you to understand your goals and preferences.Let\'s elevate your online business.Please Contact Before leaving an Order.Best Regards,Aliyan Faisal',
                'price_from' => 30,
                'rating' => 0,
                'rating_count' => 0,
                'image_url' => 'https://fiverr-res.cloudinary.com/t_main1,q_auto,f_auto/gigs/334070803/original/8b793ea1371117ac32d725db5be3b0ee169a61df.png',
                'fiverr_url' => 'https://www.fiverr.com/aliyanfaisal/build-a-ecommerce-website-store-shop-wordpress-jetengine-woocommerce-plugin',
                'featured' => false,
                'sort_order' => 5,
                'packages' => [
                    [
                        'tier' => 'Starter',
                        'price' => 30.0,
                        'delivery_days' => 48,
                        'description' => 'You will get woocommerce plugin setup with some theme customizations.',
                        'sort_order' => 0,
                    ],
                    [
                        'tier' => 'Economy',
                        'price' => 70.0,
                        'delivery_days' => 120,
                        'description' => 'You will get a complete store built on woocommerce but with few UI customization.',
                        'sort_order' => 1,
                    ],
                    [
                        'tier' => 'Pro',
                        'price' => 150.0,
                        'delivery_days' => 240,
                        'description' => 'Economy pack + Full UI customization and custom features.',
                        'sort_order' => 2,
                    ],
                ],
                'faqs' => [
                    [
                        'question' => 'Why People Choose me?',
                        'answer' => 'I have my another GIG for Custom Wordpress where I worked for a long time along with other Freelance platforms. Check my profile.

Why Me:
Expertise: With 6 years of experience & Level 2 Seller.
Timely Delivery:
Fast and Effective Communication: 
Quality Assurance:',
                        'sort_order' => 0,
                    ],
                    [
                        'question' => 'Do I create Custom Features for Ecommerce stores?',
                        'answer' => 'Yes, I do. That is my real expertise. I build custom Plugin to add Custom Features that you do not find on your Theme or Plugin Marketplace.
I have always provided the best services to my Clients on my Custom Plugin GIG here on this Account. Check it out :)',
                        'sort_order' => 1,
                    ],
                    [
                        'question' => 'Which Plugin I Use For Custom Designs?',
                        'answer' => 'I use Elementor Plugin along with Custom Code Templates to provide the best possible look that my Clients ask for.',
                        'sort_order' => 2,
                    ],
                    [
                        'question' => 'Which Plugin I use for Product Management and Inventory.',
                        'answer' => 'Surely, Woocommerce plugin, It is the most powerful and popular plugin for ecommerce stores,
I add custom features to it to make it super powerful and fulfill my client\'s needs.',
                        'sort_order' => 3,
                    ],
                    [
                        'question' => 'If any Question',
                        'answer' => 'Feel Free To Contact Me. I can provide FREE CONSULTATION :)',
                        'sort_order' => 4,
                    ],
                ],
            ],
        ];

        foreach ($services as $data) {
            $packages = $data['packages'];
            $faqs = $data['faqs'];
            unset($data['packages'], $data['faqs']);

            $service = Service::updateOrCreate(['slug' => $data['slug']], $data);
            $service->packages()->delete();
            $service->faqs()->delete();
            foreach ($packages as $package) {
                $package['delivery_days'] = (int) max(1, round($package['delivery_days'] / 24));
                $service->packages()->create($package);
            }
            foreach ($faqs as $faq) {
                $service->faqs()->create($faq);
            }
        }
    }
}
