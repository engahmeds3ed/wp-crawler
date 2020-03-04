# The Problem
1. For SEO purposes we want to know how our site internal links are linked together so that we can build and enhance our SEO strategy.

2. Also we want to view such site map to site visitors so that they can reach our site's main pages easily.

# The Solution
Mainly the solution could be one of two methods as follows:-
1. Manual method : to create a page and manually add links for internal pages on it.
    - Pros: Easy from technical perspective as we won't need to implement any code to do that.
    - Cons: 
        1. Hard to manually do it, imagine that we have huge site with many many internal links.
        2. If we added a link into the website, we need to update it manually.
2. Automatic method: to make a code which can crawl site pages and extract internal links from it and save it in cache for such 1 hour and make a page for visitors to view these links from the cache.

## Technical Specifications
1. Custom plugin used to make the admin page which used to trigger crawling specific pages.
    1. The plugin is using modern OOP through making classes with standard implementation.
    2. We are using autoloader in code which facilitate require classes when needed only.
    3. We don't add wordpress hooks through class constructor to help us in unit testing.
    4. Code passed PHP code sniffing and wordpress coding standards.
    5. The plugin is using composer for development process like run tests, check code quality and matching the standard.
    6. The plugin is using Travis CI for continuous integration and sends building status on slack channel.
2. We used transients as a cache layer which can save the crawled links for specific period of time.
3. We made a shortcode to facilitate showing links at any place (page, post, widget or any other place under the umbrella of wordpress).

## Challenges
1. I thought about using composer for autoloader but finally didn't do that to make it easy for developers / site owners not to run `composer install`.
2. I used abstract class for request and implemented the current request URL to open the extendability for example if we will get the data from any other source, there we will need to extend this class and build some functions to make it ready.
3. Applying the concept of separation of concepts, I added a new actions and attached implementation on their own classes (`rocket_crawler_save_settings` to initial crawling AND `rocket_crawler_before_settings_form` to view the links table for admin).

# Todos
1. Tests (Unit / Integration)
2. Cache separation: make new interface for caching to be implemented at any cache adapter.
3. Use Queues to make the crawling easy and to solve big sites problems ([Check this plugin](https://github.com/deliciousbrains/wp-background-processing)).
4. Add more settings.
