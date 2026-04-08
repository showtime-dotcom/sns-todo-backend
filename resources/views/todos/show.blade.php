@extends('layouts.app')

@section('content')

<div class="card shadow-sm">
  <div class="card-header bg-dark text-white d-flex justify-content-between align-items-center">
    <span>ID: {{ $todo->id }} の詳細</span>
    <span class="badge bg-warning text-dark">{{ $todo->status }}</span>
  </div>
  <div class="card-body">
    <h2 class="card-title mb-3">{{ $todo->title }}</h2>

    <p class="text-muted">期限: {{ $todo->due_date }}</p>

    <hr>

    <h5 class="mt-4">内容</h5>
    <p class="card-text" style="white-space: pre-wrap;">{{ $todo->description }}</p>
  </div>
  <div class="card-footer">
    <a href="{{ route('todos.index') }}" class="btn btn-secondary">戻る</a>
    <a href="{{ route('todos.edit', $todo->id) }}" class="btn btn-warning ms-2">編集する</a>
  </div>
</div>

@endsection
