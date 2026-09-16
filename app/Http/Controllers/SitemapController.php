<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Sitemap
    {
        $sitemap = Sitemap::create()
            ->add(Url::create(route('home'))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(1.0))
            ->add(Url::create(route('about'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.6))
            ->add(Url::create(route('projects.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_WEEKLY)->setPriority(0.7))
            ->add(Url::create(route('services.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.7))
            ->add(Url::create(route('blog.index'))->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)->setPriority(0.8))
            ->add(Url::create(route('contact.create'))->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)->setPriority(0.5));

        BlogPost::published()
            ->get(['slug', 'updated_at'])
            ->each(fn (BlogPost $post) => $sitemap->add(
                Url::create(route('blog.show', $post))
                    ->setLastModificationDate($post->updated_at)
                    ->setChangeFrequency(Url::CHANGE_FREQUENCY_MONTHLY)
                    ->setPriority(0.6)
            ));

        return $sitemap;
    }
}
