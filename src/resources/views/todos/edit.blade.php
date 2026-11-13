@extends('layouts.app')

@section('content')
    <div class="mx-auto max-w-2xl px-4 py-8 sm:px-6 lg:px-8">
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm sm:p-8">
            <h1 class="mb-6 text-2xl font-bold text-slate-800">TODO編集</h1>

            <form action="{{ route('todos.update', $todo) }}" method="POST" class="space-y-5">
                @csrf
                @method('PATCH')

                <div>
                    <label for="task" class="mb-1 block text-sm font-medium text-slate-700">内容</label>
                    <input
                        type="text"
                        id="task"
                        name="task"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        value="{{ old('task', $todo->task) }}"
                        maxlength="255"
                        required
                    >
                </div>

                <div>
                    <label for="due_date" class="mb-1 block text-sm font-medium text-slate-700">期限</label>
                    <input
                        type="date"
                        id="due_date"
                        name="due_date"
                        class="w-full rounded-lg border border-slate-300 bg-white px-3 py-2.5 text-slate-700 shadow-sm transition focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                        value="{{ old('due_date', $todo->due_date?->format('Y-m-d')) }}"
                    >
                </div>

                <div class="flex flex-wrap items-center gap-3 pt-2">
                    <button type="submit" class="rounded-md bg-indigo-600 px-4 py-2.5 font-medium text-white shadow-sm transition hover:bg-indigo-500">
                        更新
                    </button>
                    <a href="{{ route('todos.index') }}" class="rounded-md border border-slate-300 bg-white px-4 py-2.5 font-medium text-slate-700 transition hover:bg-slate-50">
                        キャンセル
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection