public function boot(): void
    {
        Gate::define('manage-schedules', function (User $user) {
            return $user->role !== 'member';
        });
    }