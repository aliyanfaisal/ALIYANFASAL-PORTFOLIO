<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\Category;
use App\Models\Project;
use App\Models\Service;
use App\Models\Setting;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

class SitemapController extends Controller
{
    public function index(): Sitemap
    {
        $latestPostUpdate = $this->latest(BlogPost::published()->max('updated_at'));

        $sitemap = Sitemap::create()
            ->add($this->url(route('home'), Url::CHANGE_FREQUENCY_WEEKLY, 1.0, $latestPostUpdate))
            ->add($this->url(route('about'), Url::CHANGE_FREQUENCY_MONTHLY, 0.6, $this->latest(Setting::query()->max('updated_at'))))
            ->add($this->url(route('projects.index'), Url::CHANGE_FREQUENCY_WEEKLY, 0.7, $this->latest(Project::query()->max('updated_at'))))
            ->add($this->url(route('services.index'), Url::CHANGE_FREQUENCY_MONTHLY, 0.7, $this->latest(Service::query()->max('updated_at'))))
            ->add($this->url(route('blog.index'), Url::CHANGE_FREQUENCY_DAILY, 0.8, $latestPostUpdate))
            ->add($this->url(route('contact.create'), Url::CHANGE_FREQUENCY_MONTHLY, 0.5));

        Service::orderBy('sort_order')->get()->each(fn (Service $service) => $sitemap->add(
            $this->url(route('services.show', $service), Url::CHANGE_FREQUENCY_MONTHLY, 0.6, $service->updated_at)
        ));

        Category::query()
            ->whereHas('posts', fn ($query) => $query->published())
            ->withMax(['posts as latest_post_update' => fn ($query) => $query->published()], 'updated_at')
            ->orderBy('name')
            ->get()
            ->each(fn (Category $category) => $sitemap->add(
                $this->url(
                    route('blog.category', $category),
                    Url::CHANGE_FREQUENCY_WEEKLY,
                    0.6,
                    $this->latest($category->latest_post_update, $category->updated_at),
                )
            ));

        BlogPost::published()
            ->get(['slug', 'updated_at'])
            ->each(fn (BlogPost $post) => $sitemap->add(
                $this->url(route('blog.show', $post), Url::CHANGE_FREQUENCY_MONTHLY, 0.6, $post->updated_at)
            ));

        return $sitemap;
    }

    private function url(string $location, string $changeFrequency, float $priority, ?CarbonInterface $lastModified = null): Url
    {
        $url = Url::create($location)->setChangeFrequency($changeFrequency)->setPriority($priority);

        return $lastModified ? $url->setLastModificationDate($lastModified) : $url;
    }

    /**
     * The most recent of the given timestamps, or null when none are known.
     */
    private function latest(mixed ...$timestamps): ?CarbonInterface
    {
        $dates = collect($timestamps)->filter()->map(fn ($timestamp) => Carbon::parse($timestamp));

        return $dates->isEmpty() ? null : $dates->max();
    }
}
