<?php

namespace App\Http\Middleware;

use App\Models\CrawlStatus;
use Closure;

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
        $user_agent = $request->header('User-Agent');

        switch($user_agent) {
            case 'Mozilla/5.0 (compatible; Discordbot/2.0; +https://discordapp.com)':
                // Discord
                $crawl = new CrawlStatus();
                $crawl->screenshot_id = $request->path();
                $crawl->platform = 'discord';
                $crawl->save();
                break;
            case 'Mozilla/5.0 (Windows NT 6.1; WOW64) SkypeUriPreview Preview/0.5':
                // SkypeUriPreview
                $crawl = new CrawlStatus();
                $crawl->screenshot_id = $request->path();
                $crawl->platform = 'skype';
                $crawl->save();
                break;
            case 'Slack-ImgProxy 0.19 (+https://api.slack.com/robots)':
                // Slack
                $crawl = new CrawlStatus();
                $crawl->screenshot_id = $request->path();
                $crawl->platform = 'slack';
                $crawl->save();
                break;
            default:
                // Do nothing
                break;
        }

        return $next($request);
    }
}
