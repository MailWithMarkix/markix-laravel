<?php

namespace Markix\Laravel;

use Illuminate\Support\Facades\Mail;
use Illuminate\Support\ServiceProvider;
use Markix\Laravel\Exceptions\TokenMissing;
use Markix\Laravel\Transport\MarkixTransportFactory;
use Markix\MarkixClient;

class MarkixServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Mail::extend('markix', function (array $config = []) {
            return new MarkixTransportFactory($this->app['markix'], $config['options'] ?? []);
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->bindMarkixClient();
    }

    /**
     * Bind the Markix Client.
     */
    protected function bindMarkixClient(): void
    {
        $this->app->singleton(MarkixClient::class, static function (): MarkixClient {
            $token = config('services.markix.token');

            if (! is_string($token)) {
                throw TokenMissing::create();
            }

            return new MarkixClient($token);
        });

        $this->app->alias(MarkixClient::class, 'markix');
    }

    /**
     * Get the services provided by the provider.
     */
    public function provides(): array
    {
        return [
            MarkixClient::class,
        ];
    }
}
