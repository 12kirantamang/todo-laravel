@extends('layouts.app')

@php
    $filter = $filter ?? 'all';
@endphp

@section('content')
    <div class="mx-auto max-w-4xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="mb-6 flex items-center justify-between gap-3">
            <h1 class="text-3xl font-bold text-slate-800">TODOリスト</h1>
        </div>

        @if ($errors->any())
            <div class="mb-4 rounded-lg border border-red-200 bg-red-50 p-4 text-sm text-red-700">
                <ul class="list-disc space-y-1 pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('todos.store') }}" method="POST" class="mb-6 flex flex-col gap-3 md:flex-row">
            @csrf
            <input
                type="text"
                name="task"
                class="w-full rounded-md border border-slate-300 bg-white px-3 py-2 text-slate-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                placeholder="やることを入力"
                value="{{ old('task') }}"
                maxlength="255"
                required
            >
            <input
                type="date"
                name="due_date"
                class="rounded-md border border-slate-300 bg-white px-3 py-2 text-slate-700 shadow-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200 md:w-48"
                value="{{ old('due_date') }}"
            >
            <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2 font-medium text-white shadow-sm transition hover:bg-indigo-500">
                追加
            </button>
        </form>

        <h2 class="mb-4 text-xl font-semibold text-slate-800">やること一覧</h2>

        <ul class="mb-6 flex flex-wrap gap-2">
            <li>
                <a class="rounded-full px-3 py-1.5 text-sm font-medium {{ $filter === 'all' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}"
                   href="{{ route('todos.index') }}">すべて</a>
            </li>
            <li>
                <a class="rounded-full px-3 py-1.5 text-sm font-medium {{ $filter === 'active' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}"
                   href="{{ route('todos.index', ['filter' => 'active']) }}">未完了</a>
            </li>
            <li>
                <a class="rounded-full px-3 py-1.5 text-sm font-medium {{ $filter === 'completed' ? 'bg-indigo-600 text-white' : 'bg-slate-200 text-slate-700 hover:bg-slate-300' }}"
                   href="{{ route('todos.index', ['filter' => 'completed']) }}">完了済み</a>
            </li>
        </ul>

        <ul class="space-y-3">
            @forelse ($todos as $todo)
                <li class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-white p-4 shadow-sm sm:flex-row sm:items-center sm:justify-between">
                    <span class="{{ $todo->is_completed ? 'text-decoration-line-through text-slate-400' : 'text-slate-700' }} text-base font-medium">
                        {{ $todo->task }}
                        @if ($todo->due_date)
                            <small class="ml-2 text-sm text-slate-500">（期限：{{ $todo->due_date->format('Y/m/d') }}）</small>
                        @endif
                    </span>

                    <div class="flex flex-wrap gap-2">
                        <form action="{{ route('todos.toggle', $todo) }}" method="POST">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-md px-3 py-1.5 text-sm font-medium {{ $todo->is_completed ? 'bg-slate-200 text-slate-700 hover:bg-slate-300' : 'bg-emerald-500 text-white hover:bg-emerald-400' }}">
                                {{ $todo->is_completed ? '未完了に戻す' : '完了' }}
                            </button>
                        </form>

                        <a href="{{ route('todos.edit', $todo) }}" class="rounded-md border border-slate-300 bg-white px-3 py-1.5 text-sm font-medium text-slate-700 hover:bg-slate-100">
                            編集
                        </a>

                        <form action="{{ route('todos.destroy', $todo) }}" method="POST" onsubmit="return confirm('本当に削除しますか？');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-md border border-red-300 bg-red-50 px-3 py-1.5 text-sm font-medium text-red-600 hover:bg-red-100">
                                削除
                            </button>
                        </form>
                    </div>
                </li>
            @empty
                <li class="rounded-xl border border-dashed border-slate-300 bg-slate-50 p-6 text-center text-slate-500">
                    該当するTODOはありません。
                </li>
            @endforelse
        </ul>
    </div>
@endsection