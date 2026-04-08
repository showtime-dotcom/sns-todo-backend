@extends('layouts.app')

@section('content')

<body class="container mt-4">
  <h1 class="mb-4">タスク新規登録</h1>

  <div class="card p-4">
    <form method="POST" action="{{ route('todos.store') }}">
      @csrf

      <div class="mb-3">
        <label class="form-label">タイトル <span class="badge bg-danger">必須</span></label>
        <input type="text" name="title" class="form-control" placeholder="例：牛乳を買う" required>
      </div>

      <div class="mb-3">
        <label class="form-label">内容 <span class="badge bg-danger">必須</span></label>
        <textarea name="description" class="form-control" rows="3" placeholder="詳細があれば入力してください"></textarea>
      </div>

      <div class="mb-3">
        <label class="form-label">期限</label>
        <input type="date" name="due_date" class="form-control">
      </div>

      <div class="d-flex justify-content-between">
        <a href="{{ route('todos.index') }}" class="btn btn-secondary">戻る</a>
        <button type="submit" class="btn btn-success">登録する</button>
      </div>
    </form>

  </div>

  @endsection
