@extends('layouts.app')

@section('content')

<h1 class="mb-4">タスク編集</h1>

<div class="card p-4 shadow-sm">
  <form method="POST" action="{{ route('todos.update', $todo->id) }}">
    @csrf
    @method('PUT') <div class="mb-3">
      <label class="form-label">タイトル <span class="badge bg-danger">必須</span></label>
      <input type="text" name="title" class="form-control" value="{{ $todo->title }}" required>
    </div>

    <div class="mb-3">
      <label class="form-label">内容</label>
      <textarea name="description" class="form-control" rows="3">{{ $todo->description }}</textarea>
    </div>

    <div class="mb-3">
      <label class="form-label">期限</label>
      <input type="date" name="due_date" class="form-control" value="{{ $todo->due_date }}">
    </div>

    <div class="mb-3">
      <label class="form-label">ステータス</label>
      <select name="status" class="form-select">
        <option value="未着手" {{ $todo->status == '未着手' ? 'selected' : '' }}>未着手</option>
        <option value="進行中" {{ $todo->status == '進行中' ? 'selected' : '' }}>進行中</option>
        <option value="完了" {{ $todo->status == '完了' ? 'selected' : '' }}>完了</option>
      </select>
    </div>

    <div class="d-flex justify-content-between">
      <a href="{{ route('todos.index') }}" class="btn btn-secondary">キャンセル</a> <button type="submit" class="btn btn-primary">更新する</button>
    </div>
  </form>
</div>

@endsection
