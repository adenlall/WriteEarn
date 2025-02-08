# Still in development stage
# Blog Subscription Platform with Dynamic Pricing and Revenue Sharing

## Core Features

### User Roles:
- **Publisher**: Can create and manage blogs, set subscription plans, and view earnings.
- **Reader**: Can browse blogs, subscribe to them, and access premium content.
- **Admin**: Manages the platform, monitors transactions, and handles disputes.

### Blog Management:
- Publishers can create, edit, and delete his blogs.
- Each blog can have a free preview (e.g., first paragraph) and premium content.

### Subscription Plans:
- Publishers can define dynamic pricing (e.g., monthly, yearly, or custom plans).
- Platform takes a percentage (e.g., 10%) of each subscription fee.

### Payment Integration:
- Stripe/Paddle for handling subscriptions and payouts.
- Automatic revenue splitting between the platform and publishers.

### Dynamic Offers:
- Publishers can create limited-time discounts or promotions.
- Readers can view available offers before subscribing.

### Content Access Control:
- Premium content is only accessible to subscribed readers.
- Expired subscriptions revoke access automatically.

### Analytics:
- Publishers can view subscription stats, earnings, and reader engagement.
- Admin can view platform-wide metrics (e.g., total revenue, active blogs).

## Tech Stack

### Backend (Laravel):
- **Authentication**: Laravel Sanctum for API auth.
- **Database**: SQLite for relational data (users, blogs, subscriptions).
- **Payment Integration**: Stripe SDK for subscriptions and payouts.
- **Revenue Sharing**: Calculate and distribute earnings using Laravel Queues.
- **Caching**: frequently accessed data (e.g., blog lists).
- **API Endpoints**: RESTful API for Next.js to consume.

### Frontend (Next.js):
- **UI Library**: Tailwind CSS + DaisyUI5 for styling.
- **State Management**: Zustand for managing app state.
- **Authentication**: JWT or session-based auth for secure access.
- **Dynamic Routing**: Next.js dynamic routes for blogs (`/blogs/{id}`).
- **Server-Side Rendering (SSR)**: Pre-render blog pages for SEO.
- **Subscription Management**: Stripe Elements for secure payment forms.

## Database Schema

Here’s a simplified schema for your project:

### Tables:
- **Users**:
  - `id`, `name`, `email`, `password`, `role` (publisher/reader/admin), `stripe_customer_id`, `stripe_account_id` (for publishers).
- **Blogs**:
  - `id`, `title`, `description`, `content`, `preview_content`, `publisher_id` (foreign key), `created_at`, `updated_at`.
- **Subscription Plans**:
  - `id`, `blog_id` (foreign key), `price`, `duration` (e.g., monthly/yearly), `discount`, `is_active`.
- **Subscriptions**:
  - `id`, `reader_id` (foreign key), `plan_id` (foreign key), `start_date`, `end_date`, `status` (active/canceled).
- **Payments**:
  - `id`, `subscription_id` (foreign key), `amount`, `platform_fee`, `publisher_earning`, `status` (success/failed).
- **Offers**:
  - `id`, `plan_id` (foreign key), `discount`, `start_date`, `end_date`.

## Workflow

### Publisher Workflow:
- Sign up as a publisher and connect Stripe account for payouts.
- Create a blog and define subscription plans.
- View earnings and subscription stats.

### Reader Workflow:
- Browse blogs and view free previews.
- Subscribe to a blog using Stripe.
- Access premium content during the subscription period.

### Admin Workflow:
- Monitor platform activity (e.g., new blogs, subscriptions).
- Handle disputes or refunds.
- View platform earnings and payouts.

## Advanced Features

- **Trial Periods**: Allow publishers to offer free trials for their blogs.
- **Referral System**: Reward readers for referring others to subscribe.
- **Content Recommendations**: Use AI/ML to recommend blogs based on reader preferences.
- **Multi-Language Support**: Allow publishers to create blogs in multiple languages.
- **Webhooks**: Use Stripe webhooks to handle payment failures, cancellations, etc.
- **Email Notifications**: Notify readers about new posts, subscription renewals, etc.

## Monetization Ideas

- **Platform Fee**: Take a percentage of each subscription (e.g., 10%).
- **Featured Listings**: Charge publishers for promoting their blogs on the homepage.
- **Advertisements**: Allow publishers to display ads on their blogs (split revenue with the platform).


# 👋 Welcome to any contribution!