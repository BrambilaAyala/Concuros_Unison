<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Illuminate\Support\Facades\View::composer(['layouts.app_admin', 'includes.admin.navbar', 'revisor.*'], function ($view) {
            try {
                $conteoEspera = \Illuminate\Support\Facades\DB::table('validaciones')
                    ->whereIn('id', function($q) {
                        $q->selectRaw('MAX(id)')->from('validaciones')->groupBy('id_documento');
                    })
                    ->where('estado', 'Espera')
                    ->count();
                $view->with('conteoEsperaGlobal', $conteoEspera);
            } catch (\Throwable $e) {
                $view->with('conteoEsperaGlobal', 0);
            }
        });

        \Illuminate\Support\Facades\View::composer('*', function ($view) {
            try {
                $eventoGlobal = \App\Evento::first();
                $view->with('eventoGlobal', $eventoGlobal);
            } catch (\Throwable $e) {
                $view->with('eventoGlobal', null);
            }
        });
    }
}
