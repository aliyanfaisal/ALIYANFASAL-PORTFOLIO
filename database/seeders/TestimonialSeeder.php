<?php

namespace Database\Seeders;

use App\Models\Testimonial;
use Illuminate\Database\Seeder;

class TestimonialSeeder extends Seeder
{
    public function run(): void
    {
        $testimonials = [
            // From aliyanfaisal.com
            [
                'client_name' => 'Abeer Akmal',
                'country' => null,
                'source' => 'Website',
                'content' => 'Aliyan has very nice communication skills and he did the perfect job in quick time. I am really impressed with his approach.',
            ],
            [
                'client_name' => 'Ravi',
                'country' => null,
                'source' => 'Website',
                'content' => 'According to me this is the best Freelancer Laravel PHP specialist on Fiverr. I would 100 percent ask everyone to get their work done from Aliyan.',
            ],
            [
                'client_name' => 'Azhar Murad',
                'country' => null,
                'source' => 'Website',
                'content' => 'Aliyan did a great job. I really satisfy with his working style. I highly recommend him!',
            ],
            [
                'client_name' => 'Carpyi',
                'country' => null,
                'source' => 'Website',
                'content' => 'This guy is fire! He completed the work under 1 day when a previous dev could not in 3 days. Aliyan Faisal is a genius!',
            ],
            // Real Fiverr gig reviews
            [
                'client_name' => 'sarabreen467',
                'country' => 'Canada',
                'source' => 'Fiverr',
                'content' => 'Just amazing work as always, such good proper responses and very easy to work with.',
            ],
            [
                'client_name' => 'gtowais',
                'country' => 'United States',
                'source' => 'Fiverr',
                'content' => 'Great person to work with! Really goes above and beyond to get exactly what is needed in the project. Great attention to customer satisfaction. Really recommend Aliyan!',
            ],
            [
                'client_name' => 'mickaelsebban',
                'country' => 'United States',
                'source' => 'Fiverr',
                'content' => 'Not only has Ali met all requirements, including last-minute additions, but he went beyond! Highly recommended.',
            ],
            [
                'client_name' => 'gasppp',
                'country' => 'France',
                'source' => 'Fiverr',
                'content' => "I truly recommend him for his work, for his understanding and his reactivity. I'll work again and again with him.",
            ],
            [
                'client_name' => 'mehdi1560',
                'country' => 'Morocco',
                'source' => 'Fiverr',
                'content' => 'Great experience! He solved perfectly my Laravel issue. I will come back to work with you again inchallah, thank you brother.',
            ],
            [
                'client_name' => 'sarabreen467',
                'country' => 'Canada',
                'source' => 'Fiverr',
                'content' => 'Did an amazing job, we had some hiccups along the way but he fixed it and handled it like a true professional!',
            ],
            [
                'client_name' => 'nesbiz26',
                'country' => 'Israel',
                'source' => 'Fiverr',
                'content' => 'Another amazing project bro, thank you.',
            ],
            [
                'client_name' => 'hugomercier',
                'country' => 'France',
                'source' => 'Fiverr',
                'content' => 'Very good work, thanks. Perfect work again, thanks a lot!',
            ],
            [
                'client_name' => 'motownhvac',
                'country' => 'United States',
                'source' => 'Fiverr',
                'content' => 'Great work as always, thank you Ali.',
            ],
            [
                'client_name' => 'showmore280',
                'country' => 'Spain',
                'source' => 'Fiverr',
                'content' => 'Very professional.',
            ],
            [
                'client_name' => 'tggagch',
                'country' => 'Switzerland',
                'source' => 'Fiverr',
                'content' => 'Sehr zufrieden! (Very satisfied!)',
            ],
        ];

        Testimonial::query()->delete();

        foreach ($testimonials as $i => $testimonial) {
            $testimonial['rating'] = 5;
            $testimonial['sort_order'] = $i;
            Testimonial::create($testimonial);
        }
    }
}
