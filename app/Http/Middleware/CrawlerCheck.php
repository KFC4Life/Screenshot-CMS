<?php

namespace App\Http\Middleware;

use App\Models\CrawlStatus;

class CrawlerCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

        // Discord
        if(Crawler::isCrawler('Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)')) {
            $crawl = new CrawlStatus();
            $crawl->screenshot_id = $request->path();
            $crawl->platform = 'discord';
            $crawl->save();
        }

        // Skype
        if(Crawler::isCrawler('Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5')) {
            $crawl = new CrawlStatus();
            $crawl->screenshot_id = $request->path();
            $crawl->platform = 'skype';
            $crawl->save();
        }

        // Slack
        if(Crawler::isCrawler('Slack-ImgProxy 0.19 (+https://api.slack.com/robots)')) {
            $crawl = new CrawlStatus();
            $crawl->screenshot_id = $request->path();
            $crawl->platform = 'slack';
            $crawl->save();
        }

        return $next($request);
    }
}
