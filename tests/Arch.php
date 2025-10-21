<?php

declare(strict_types=1);

arch('models')
    ->expect('App\Models')
    ->toBeClasses()
    ->toExtend('Illuminate\Database\Eloquent\Model')
    ->toOnlyBeUsedIn([
        'App\Models',
        'App\Http\Controllers',
        'App\Http\Requests',
        'App\Http\Resources',
        'App\Policies',
        'App\Actions',
        'Database\Factories',
        'Database\Seeders',
    ]);

arch('controllers')
    ->expect('App\Http\Controllers')
    ->toBeClasses()
    ->toHaveSuffix('Controller')
    ->toOnlyBeUsedIn('App\Http\Controllers');

arch('form requests')
    ->expect('App\Http\Requests')
    ->toBeClasses()
    ->toExtend('Illuminate\Foundation\Http\FormRequest');

arch('jobs')
    ->expect('App\Jobs')
    ->toBeClasses()
    ->toHaveMethod('handle');

arch('events')
    ->expect('App\Events')
    ->toBeClasses()
    ->toOnlyBeUsedIn([
        'App\Listeners',
        'App\Providers',
    ]);

arch('actions')
    ->expect('App\Actions')
    ->toBeClasses()
    ->toHaveSuffix('Action');

arch('no debugging functions')
    ->expect(['dd', 'dump', 'ray', 'var_dump', 'die', 'print_r'])
    ->not->toBeUsed();

arch('no env helpers outside config')
    ->expect('env')
    ->not->toBeUsedIn('App');

arch('security')
    ->expect('App')
    ->not->toUse([
        'eval',
        'exec',
        'shell_exec',
        'system',
        'passthru',
    ]);

arch('facades')
    ->expect('Illuminate\Support\Facades')
    ->toOnlyBeUsedIn([
        'App\Http\Controllers',
        'App\Console\Commands',
        'App\Jobs',
        'App\Listeners',
        'App\Providers',
        'App\Actions',
        'Database\Seeders',
    ]);
