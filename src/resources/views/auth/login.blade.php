<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'TaskFlow') }} - 認証</title>

        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            .glass-panel {
                background: rgba(255, 255, 255, 0.85);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
            }
            .dark .glass-panel {
                background: rgba(15, 23, 42, 0.85);
            }
        </style>
    </head>
    <body class="h-full bg-slate-50 text-slate-800 font-sans antialiased selection:bg-indigo-500 selection:text-white overflow-x-hidden">
        <div class="fixed inset-0 overflow-hidden pointer-events-none z-0">
            <div class="absolute -top-40 -left-40 w-96 h-96 bg-indigo-500/20 rounded-full blur-[100px] animate-pulse"></div>
            <div class="absolute top-1/3 -right-40 w-96 h-96 bg-purple-500/20 rounded-full blur-[100px] animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-40 left-1/3 w-96 h-96 bg-cyan-500/20 rounded-full blur-[100px] animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="relative z-10 min-h-screen flex flex-col">
            <header class="w-full border-b border-slate-200/80 glass-panel sticky top-0 z-30">
                <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 h-16 flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl bg-gradient-to-tr from-indigo-600 to-indigo-500 flex items-center justify-center text-white shadow-lg shadow-indigo-500/30">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xl font-bold tracking-tight bg-gradient-to-r from-slate-900 via-indigo-950 to-indigo-700 bg-clip-text text-transparent">TODO-LIST</span>
                        </div>
                    </div>

                    <div class="flex items-center gap-2">
                        <a href="{{ route('register') }}" class="px-3.5 py-1.5 text-sm font-medium text-slate-700 hover:text-indigo-600 transition-colors">
                            アカウント作成 <span class="sr-only">Create account</span>
                        </a>
                        <a href="{{ route('login') }}" class="px-4 py-1.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-500 rounded-xl shadow-md shadow-indigo-500/20 transition-all">
                            ログイン
                        </a>
                    </div>
                </div>
            </header>

            <main class="flex-1 flex items-center justify-center p-4 sm:p-6 lg:p-8">
                <div class="w-full max-w-md mx-auto">
                    <div class="glass-panel rounded-3xl shadow-2xl border border-slate-200/80 p-6 sm:p-8 relative overflow-hidden">
                        <div class="absolute top-0 left-0 right-0 h-1.5 bg-gradient-to-r from-indigo-500 via-purple-500 to-indigo-600"></div>

                        <div class="text-center mb-8">
                            <h1 class="text-2xl sm:text-3xl font-extrabold tracking-tight text-slate-900">おかえりなさい</h1>
                            <p class="mt-2 text-sm text-slate-500">タスクを効率的に管理し、生産性を向上させましょう。</p>
                        </div>

                        <div class="relative bg-slate-100 p-1 rounded-2xl flex items-center mb-8 border border-slate-200/60">
                            <div class="absolute top-1 bottom-1 w-[calc(50%-4px)] bg-white rounded-xl shadow-md transition-all left-1"></div>
                            <button type="button" class="relative z-10 w-1/2 py-2 text-sm font-semibold text-slate-900">ログイン</button>
                            <a href="{{ route('register') }}" class="relative z-10 w-1/2 py-2 text-sm font-semibold text-slate-500 text-center">アカウント作成</a>
                        </div>

                        <form method="POST" action="{{ route('login') }}" class="space-y-5">
                            @csrf

                            <div>
                                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1.5">ユーザー名</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                        </svg>
                                    </div>
                                    <input id="username" type="text" name="username" value="{{ old('username') }}" required autofocus autocomplete="username" placeholder="山田 太郎" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all" />
                                </div>
                                @error('username')
                                    <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div>
                                <div class="flex items-center justify-between mb-1.5">
                                    <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600">パスワード</label>
                                    @if (Route::has('password.request'))
                                        <a href="{{ route('password.request') }}" class="text-xs font-semibold text-indigo-600 hover:text-indigo-500 transition-colors">パスワードをお忘れですか？</a>
                                    @endif
                                </div>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                        </svg>
                                    </div>
                                    <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••" class="w-full pl-10 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 placeholder-slate-400 text-sm focus:outline-none focus:ring-2 focus:ring-indigo-500/50 focus:border-indigo-500 transition-all" />
                                </div>
                                @error('password')
                                    <p class="mt-1.5 text-xs text-rose-500 font-medium">{{ $message }}</p>
                                @enderror
                            </div>

                            <div class="flex items-center">
                                <input id="remember_me" type="checkbox" name="remember" class="w-4 h-4 text-indigo-600 bg-slate-100 border-slate-300 rounded focus:ring-indigo-500">
                                <label for="remember_me" class="ml-2.5 text-sm text-slate-600 select-none">ログイン状態を30日間保存する</label>
                            </div>

                            <button type="submit" class="w-full py-3.5 px-4 bg-gradient-to-r from-indigo-600 to-indigo-500 hover:from-indigo-500 hover:to-indigo-400 text-white font-semibold rounded-xl shadow-lg shadow-indigo-500/25 transition-all duration-200 flex items-center justify-center gap-2">
                                <span>ログインしてダッシュボードへ</span>
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                </svg>
                            </button>

                            <a href="{{ route('register') }}" class="block w-full py-2.5 px-4 bg-slate-100 hover:bg-slate-200 text-slate-700 font-medium text-xs rounded-xl border border-slate-200 transition-all text-center">
                                新しいアカウントを作成する <span class="sr-only">Create account</span>
                            </a>
                        </form>
                    </div>
                </div>
            </main>
        </div>
    </body>
</html>
